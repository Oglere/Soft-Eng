<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DocumentRepository;
use App\Models\User;

class StudentController extends Controller{

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

    public function search_page()
    {
        // Assuming there is an account-setting.blade.php view file.
        return view('student.search');
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
            'abstract' => 'required|string',
            'teacher_id' => 'required|exists:users,user_id',
            'publication_date' => 'nullable|date',
            'document_types' => 'required|array',
            'document_types.*' => 'string',
            'file' => 'required|mimes:pdf|max:25600', // 25MB
        ]);

        // Upload file
        $filePath = $request->file('file')->store('documents', 'public');

        // Save document
        DocumentRepository::create([
            'title' => $request->title,
            'student_id' => auth::id(),
            'teacher_id' => $request->teacher_id,
            'authors' => $request->co_authors,
            'citation' => $request->citations,
            'metadata' => json_encode([
                'keywords' => $request->keywords,
                'document_types' => $request->document_types
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
     * Display the student document status page.
     */
    public function doc_status_page()
    {
    $studentId = Auth::id();
    // Fetch all documents for the logged-in student
    $submissions = DocumentRepository::where('student_id', $studentId)
                    ->latest('date_submitted')
                    ->get();

    return view('student.doc_status', compact('submissions'));
    }

    /**
     * Display the Pending Document.
     * @param int $id The PDF ID.
     */
    public function viewStatus($id)
    {
        $document = DocumentRepository::findOrFail($id);

        // Decode metadata (abstract, keywords, document_types)
        $metadata = json_decode($document->metadata, true) ?? [];

        // Merge decoded fields for easy access in Blade
        $document->abstract = $metadata['abstract'] ?? null;
        $document->document_types = $metadata['document_types'] ?? [];
        $document->keywords = $metadata['keywords'] ?? [];

        return view('student.view_status', compact('document'));
    }

    public function abandon($id)
    {
        $document = DocumentRepository::findOrFail($id);
        
        // Option 1: delete completely
        $document->delete();

        // Option 2: mark as abandoned (safer)
        // $document->status = 'abandoned';
        // $document->save();

        return redirect()->route('student.submission')->with('success', 'Document abandoned successfully.');
    }
    
    /**
     * Display the PDF reader page for a specific ID.
     * @param int $id The PDF ID.
     */
    public function pdf_reader_page($id)
    {
        // You can use the $id variable to fetch the correct PDF.
        // For example, return view('pdf-reader', ['pdfId' => $id]);
        return view('student.pdf-reader');
    }

    /**
     * Display the student account setting page.
     */
    public function account_setting_page()
    {
        // Assuming there is an account_setting.blade.php view file.
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

        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password_hash)) {
            return back()->withErrors(['login_error' => 'Incorrect password. Please try again.']);
        }

        // Store in session that user has verified identity
        session(['account_verified' => true]);

        return redirect()->route('student.account_setting');
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

        $request->validate([
            'usn' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $user->usn = $request->usn;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password_hash = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        // Remove verification session after update
        session()->forget('account_verified');

        return redirect()->route('student.account_setting')
            ->with('success', 'Account updated successfully!');
    }

    public function cancel_update(Request $request)
    {
    // Just redirect back to account settings without triggering success SweetAlert
    return redirect()->route('student.account_setting_page')
        ->with('cancel_message', 'Account update canceled.');
    }
}
