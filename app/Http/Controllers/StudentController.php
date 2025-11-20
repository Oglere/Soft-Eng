<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DocumentRepository;
use App\Models\User;


class StudentController extends Controller
{
    /**
     * Display the student dashboard page.
     */
    public function dashboard_page()
    {
        $studentId = Auth::id(); // get the actual logged-in student id

        // Fetch counts dynamically
        $submittedStudies = DocumentRepository::where('student_id', $studentId)->count();

        $approvedStudies = DocumentRepository::where('student_id', $studentId)
                            ->where('status', 'approved')
                            ->count();

        $pendingStudies = DocumentRepository::where('student_id', $studentId)
                            ->where('status', 'pending')
                            ->count();

        $revisionsToDo = DocumentRepository::where('student_id', $studentId)
                            ->where('status', 'revision')
                            ->count();

        $rejectedStudies = DocumentRepository::where('student_id', $studentId)
                            ->where('status', 'rejected')
                            ->count();

        return view('student.dashboard', compact(
            'submittedStudies',
            'approvedStudies',
            'pendingStudies',
            'revisionsToDo',
            'rejectedStudies'
        ));
    }

    /**
     * Display the student submission page.
     */
    public function submission()
    {
        // Fetch all teachers (assuming role field = 'teacher')
        $teachers = \App\Models\User::where('role', 'teacher')->get();

        return view('student.submission', compact('teachers'));
    }


    public function submit_document(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string|max:10000',
            'teacher_id' => 'required|exists:users,user_id',
            'document_types' => 'required|array',
            'document_types.*' => 'string',
            'file' => 'required|mimes:pdf|max:25600',
        ]);

        $baseTitle = $request->title;
        $existing = DocumentRepository::where('title', $baseTitle)->where('student_id', Auth::id())->count();

        // If duplicate exists, create numbered version automatically (Title (2), etc.)
        $finalTitle = $existing > 0 ? $baseTitle . ' (' . ($existing + 1) . ')' : $baseTitle;

        $filePath = $request->file('file')->store('documents', 'public');

        DocumentRepository::create([
            'title' => $finalTitle,
            'abstract' => $request->abstract,
            'student_id' => Auth::id(),
            'teacher_id' => $request->teacher_id,
            'citation' => $request->citations,
            'metadata' => json_encode([
                'abstract' => $request->abstract,
                'keywords' => $request->keywords,
                'document_types' => $request->document_types,
            ]),
            'file' => $filePath,
            'status' => 'pending',
            'date_submitted' => now(),
            'study_type' => implode(', ', $request->document_types),
        ]);

        return redirect()->route('student.submission')
            ->with('success', 'Document submitted successfully!');
    }

    /**
     * Confirmation if a duplicate title exists.
     */
    public function checkTitle(Request $request)
    {
        $title = trim($request->input('title'));

        if (!$title) {
            return response()->json(['exists' => false]);
        }

        $count = \App\Models\DocumentRepository::where('title', 'like', $title . '%')->count();

        if ($count > 0) {
            return response()->json([
                'exists' => true,
                'next_title' => $title . ' (' . ($count + 1) . ')'
            ]);
        }

        return response()->json(['exists' => false]);
    }

    /**
     * Display the student document status page.
     * ✅ Updated to support filtering from dashboard (approved, pending, etc.)
     */
    public function submitted_studies_page(Request $request)
    {
        $studentId = Auth::id();
        $filter = $request->query('status', 'all');
        $highlightId = $request->query('doc_id'); // ✅ new line

        $query = DocumentRepository::where('student_id', $studentId);

    // If filter is not 'all', apply status filter
    if ($filter !== 'all') {
        $query->where('status', $filter);
    }

    // Include abandoned if you want to show them separately or as "all"
    $submissions = $query->latest('date_submitted')->paginate(8);
    

        // ✅ Pass highlightId to view
        return view('student.submitted', compact('submissions', 'filter', 'highlightId'));
    }

    /**
     * Display the individual document view (PDF, metadata, etc.)
     */
    public function view_submitted_page($id)
    {
        $document = DocumentRepository::findOrFail($id);

        // Decode metadata (abstract, keywords, document_types)
        $metadata = json_decode($document->metadata, true) ?? [];

        // Merge decoded fields for easy access in Blade
        $document->abstract = $metadata['abstract'] ?? null;
        $document->document_types = $metadata['document_types'] ?? [];
        $document->keywords = $metadata['keywords'] ?? [];

        return view('student.view_submitted', compact('document'));
    }

    public function abandon($id)
    {
        $document = DocumentRepository::findOrFail($id);

        // Option 1: delete completely
        $document->delete();

        return redirect()->route('student.submission')->with('success', 'Document abandoned successfully.');
    }

    public function toggleAbandon($id)
    {
        $document = DocumentRepository::findOrFail($id);

        // If document is already abandoned, revert it to previous status
        if ($document->status === 'abandoned') {
            $previousStatus = $document->previous_status ?? 'pending'; // fallback to pending
            $document->status = $previousStatus;
            $document->previous_status = null;
            $document->save();

            return response()->json([
                'success' => true,
                'message' => 'Document has been reverted.',
                'status' => $document->status
            ]);
        }

        // Otherwise, mark as abandoned and store previous status
        $document->previous_status = $document->status;
        $document->status = 'abandoned';
        $document->save();

        return response()->json([
            'success' => true,
            'message' => 'Document has been abandoned.',
            'status' => 'abandoned'
        ]);
    }


    /**
     * Display the student account setting page.
     */
    public function account_setting_page()
    {
        return view('student.account_setting');
    }

    /**
     * Verify student identity (password check before editing).
     */
    public function verify_identity(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        // Get session-based attempt tracking
        $attempts = session('login_attempts', 0);
        $locked_until = session('locked_until');

        // 🔒 Check if user is temporarily locked out
        if ($locked_until && now()->lt($locked_until)) {
            return back()->withErrors([
                'login_error' => 'Please wait a few seconds before trying again.'
            ]);
        }

        // ❌ Incorrect password handling
        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password_hash)) {
            $attempts++;

        if ($attempts >= 3) {
            // Lock user for 1 minute (60 seconds)
            session([
                'locked_until' => now()->addSeconds(60),
                'login_attempts' => 0
            ]);

            return back()->withErrors([
                'login_error' => ''
            ]);
        }

        // Save current attempt count
        session(['login_attempts' => $attempts]);

        return back()->withErrors([
            'login_error' => "Incorrect password. Attempt $attempts of 3."
        ]);
    }

        // ✅ Correct password
        session(['account_verified' => true]);
        session()->forget(['login_attempts', 'locked_until']);

        return redirect()->route('student.account_setting')->with('success', 'Identity verified successfully.');
    }


    /**
     * Update student account after verification.
     */
    public function update_account(Request $request)
    {
        $user = Auth::user();

        if (!session('account_verified')) {
            return redirect()->route('student.account_setting')
                ->withErrors(['login_error' => 'You must verify your identity before updating your account.']);
        }

        // Validate input
        $validator = \Validator::make($request->all(), [
            'email' => [
            'nullable',
            'string',
            'email',
            'max:255',
            function ($attribute, $value, $fail) {
                if ($value && !preg_match('/^[A-Za-z0-9._%+-]{1,15}@gmail\.com$/', $value)) {
                    $fail('Email must be a Gmail address and max 15 characters before @.');
                }
            },
        ],
        'phone_number' => 'nullable|string|max:20',
        'password' => 'nullable|string|min:6',
    ]);

    $validator->after(function ($validator) use ($request) {
        $missing = [];
        if (empty($request->first_name)) $missing[] = 'first name';
        if (empty($request->last_name)) $missing[] = 'last name';
        if (empty($request->email)) $missing[] = 'email';
        if (empty($request->phone_number)) $missing[] = 'phone number';

        if (!empty($missing)) {
            $last = array_pop($missing);
            $message = 'The ' . (empty($missing) ? $last : implode(', ', $missing) . ' and ' . $last) . ' fields are required.';
            $validator->errors()->add('required', $message);
        }
    });

    $validator->validate();

    // ✅ Check if user changed anything
    $noChanges =
        $user->first_name === $request->first_name &&
        $user->last_name === $request->last_name &&
        $user->email === $request->email &&
        $user->phone_number === $request->phone_number &&
        !$request->filled('password');

    if ($noChanges) {
        return back()->withErrors(['no_changes' => 'No changes detected. Please update at least one field.']);
    }

    // ✅ Apply updates
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->email = $request->email;
    $user->phone_number = $request->phone_number;

    if ($request->filled('password')) {
        $user->password_hash = \Illuminate\Support\Facades\Hash::make($request->password);
    }

    $user->save();

    session()->forget('account_verified');

    return redirect()->route('student.account_setting')
        ->with('success', 'Account updated successfully!');
}


    public function cancel_update(Request $request)
    {
        // Forget verification session to go back to verify form
        session()->forget('account_verified');

        // Redirect with a SweetAlert message
        return redirect()->route('student.account_setting')
            ->with('cancel_message', 'Account update canceled.');
    }

    public function get_notifications()
    {
        $studentId = Auth::id();

        $documents = DocumentRepository::where('student_id', $studentId)
            ->latest('updated_at')
            ->take(5)
            ->get();

        $notifications = [];

        foreach ($documents as $doc) {
            // Base route by status
            $route = route('student.submitted', ['status' => $doc->status, 'doc_id' => $doc->document_id]);


            switch ($doc->status) {
                case 'pending':
                    $notifications[] = [
                        'message' => "Your study <b>{$doc->title}</b> is under review.",
                        'icon' => '🕓',
                        'time' => $doc->updated_at->diffForHumans(),
                        'link' => $route,
                    ];
                    break;

                case 'approved':
                    $notifications[] = [
                        'message' => "Your study <b>{$doc->title}</b> has been <b>approved</b>! 🎉",
                        'icon' => '✅',
                        'time' => $doc->updated_at->diffForHumans(),
                        'link' => $route,
                    ];
                    break;

                case 'revision':
                    $notifications[] = [
                        'message' => "Your study <b>{$doc->title}</b> requires <b>revisions</b>.",
                        'icon' => '✏️',
                        'time' => $doc->updated_at->diffForHumans(),
                        'link' => $route,
                    ];
                    break;

                case 'rejected':
                    $notifications[] = [
                        'message' => "Your study <b>{$doc->title}</b> was <b>rejected</b>.",
                        'icon' => '❌',
                        'time' => $doc->updated_at->diffForHumans(),
                        'link' => $route,
                    ];
                    break;

                default:
                    $notifications[] = [
                        'message' => "Your study <b>{$doc->title}</b> has been submitted successfully.",
                        'icon' => '📄',
                        'time' => $doc->created_at->diffForHumans(),
                        'link' => route('student.dashboard'), // fallback
                    ];
                    break;
            }
        }

        return response()->json($notifications);
    }
}
