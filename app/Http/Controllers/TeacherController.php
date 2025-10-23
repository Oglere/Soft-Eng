<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\DocumentRepository;
use App\Models\User;

class TeacherController extends Controller
{
    public function dashboard_page()
    {
        $user = User::where("user_id", auth()->id())->first();

        $pending = DocumentRepository::where('teacher_id', $user->user_id)
            ->where('status', 'pending')->count();

        $approved = DocumentRepository::where('teacher_id', $user->user_id)
            ->where('status', 'approved')->count();

        $rejected = DocumentRepository::where('teacher_id', $user->user_id)
            ->where('status', 'rejected')->count();

        return view('teacher.dashboard', compact('user', 'pending', 'approved', 'rejected'));
    }

    public function submitted_page(Request $request)
    {
        $teacher = Auth::id();
        $query = DocumentRepository::where('teacher_id', $teacher);

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->keyword) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('study_type', 'like', '%' . $request->keyword . '%');
            });
        }

        $documents = $query->orderBy('date_submitted', 'desc')->paginate(10);

        return view('teacher.submitted', compact('documents'));
    }

    public function view_submitted_page($id)
    {
        $document = DocumentRepository::with('student')->find($id);

        if (!$document) {
            return redirect()->route('teacher.submitted.list')
                ->withErrors(['error' => 'Document not found.']);
        }

        return view('teacher.view_submitted', compact('document'));
    }

    
    public function pdf_approve($id)
    {
        $teacherId = auth()->id();
        $document = DocumentRepository::findOrFail($id);

        $document->status = 'Approved';
        $document->approved_by = $teacherId;
        $document->save();

        return redirect()->back()->with('success', 'Document approved successfully.');
    }

    public function pdf_revise($id)
    {
        $document = DocumentRepository::findOrFail($id);
        $document->status = 'Needs Revision';
        $document->save();

        return redirect()->back()->with('success', 'Document marked for revision.');
    }

    public function pdf_reject($id)
    {
        $document = DocumentRepository::findOrFail($id);
        $document->status = 'Rejected';
        $document->save();

        return redirect()->back()->with('success', 'Document rejected successfully.');
    }

    public function pdf_revert($id)
    {
        $document = DocumentRepository::findOrFail($id);
        $document->status = 'Pending';
        $document->save();

        return redirect()->back()->with('success', 'Document reverted successfully.');
    }

    public function account_setting_page()
    {
        return view('teacher.account_setting');
    }

    public function verify_identity(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();
        $attempts = session('login_attempts', 0);
        $locked_until = session('locked_until');

        if ($locked_until && now()->lt($locked_until)) {
            return back()->withErrors([
                'login_error' => 'Please wait a few seconds before trying again.'
            ]);
        }

        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password_hash)) {
            $attempts++;

            if ($attempts >= 3) {
                session([
                    'locked_until' => now()->addSeconds(60),
                    'login_attempts' => 0
                ]);

                return back()->withErrors(['login_error' => '']);
            }

            session(['login_attempts' => $attempts]);

            return back()->withErrors([
                'login_error' => "Incorrect password. Attempt $attempts of 3."
            ]);
        }

        session(['account_verified' => true]);
        session()->forget(['login_attempts', 'locked_until']);

        return redirect()->route('teacher.account_setting')->with('success', 'Identity verified successfully.');
    }

    public function update_account(Request $request)
    {
        $user = Auth::user();

        if (!session('account_verified')) {
            return redirect()->route('teacher.account_setting')
                ->withErrors(['login_error' => 'You must verify your identity before updating your account.']);
        }

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

        $noChanges =
            $user->first_name === $request->first_name &&
            $user->last_name === $request->last_name &&
            $user->email === $request->email &&
            $user->phone_number === $request->phone_number &&
            !$request->filled('password');

        if ($noChanges) {
            return back()->withErrors(['no_changes' => 'No changes detected. Please update at least one field.']);
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        if ($request->filled('password')) {
            $user->password_hash = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();
        session()->forget('account_verified');

        return redirect()->route('teacher.account_setting')
            ->with('success', 'Account updated successfully!');
    }

    public function cancel_update(Request $request)
    {
        session()->forget('account_verified');
        return redirect()->route('teacher.account_setting')
            ->with('cancel_message', 'Account update canceled.');
    }

    // ✅ FIXED AND CLEANED UP NOTIFICATIONS FUNCTION
    public function get_notifications()
    {
        $teacherId = Auth::id();

        // Get recently submitted or updated documents for this teacher
        $submissions = DocumentRepository::with('student')
            ->where('teacher_id', $teacherId)
            ->whereIn('status', ['pending', 'approved', 'needs revision', 'rejected'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        $notifications = [];

        foreach ($submissions as $doc) {
            $student = $doc->student;
            $studentName = $student ? "{$student->first_name} {$student->last_name}" : "Unknown Student";

            $route = route('teacher.submitted.list', [
                'status' => strtolower($doc->status ?? 'pending'),
                'doc_id' => $doc->document_id,
            ]);

            switch (strtolower($doc->status)) {
                case 'pending':
                    $notifications[] = [
                        'message' => "<b>{$studentName}</b> submitted a new study titled <b>{$doc->title}</b> for your review.",
                        'icon' => '📥',
                        'time' => $doc->created_at->diffForHumans(),
                        'link' => $route,
                    ];
                    break;

                case 'needs revision':
                    $notifications[] = [
                        'message' => "<b>{$studentName}</b> resubmitted <b>{$doc->title}</b> for revision.",
                        'icon' => '✏️',
                        'time' => $doc->updated_at->diffForHumans(),
                        'link' => $route,
                    ];
                    break;

                case 'approved':
                    $notifications[] = [
                        'message' => "You approved <b>{$studentName}'s</b> study <b>{$doc->title}</b>.",
                        'icon' => '✅',
                        'time' => $doc->updated_at->diffForHumans(),
                        'link' => $route,
                    ];
                    break;

                case 'rejected':
                    $notifications[] = [
                        'message' => "You rejected <b>{$studentName}'s</b> study <b>{$doc->title}</b>.",
                        'icon' => '❌',
                        'time' => $doc->updated_at->diffForHumans(),
                        'link' => $route,
                    ];
                    break;

                default:
                    $notifications[] = [
                        'message' => "<b>{$studentName}</b> submitted <b>{$doc->title}</b>.",
                        'icon' => '📄',
                        'time' => $doc->created_at->diffForHumans(),
                        'link' => $route,
                    ];
                    break;
            }
        }

        return response()->json($notifications);
    }
}
