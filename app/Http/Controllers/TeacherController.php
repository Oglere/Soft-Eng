<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\DocumentRepository;
use App\Models\User;

class TeacherController extends Controller
{
    public function dashboard_page() {
        $user = User::where("user_id", auth()->id())->first();

        $pending = DocumentRepository::where('teacher_id', $user->user_id)
            ->where('status', 'pending')->count();

        $approved = DocumentRepository::where('teacher_id', $user->user_id)
            ->where('status', 'approved')->count();

        $rejected = DocumentRepository::where('teacher_id', $user->user_id)
            ->where('status', 'rejected')->count();

        return view('teacher.dashboard', compact('user', 'pending', 'approved', 'rejected'));
    }

    public function review_page(Request $request)
    {
        $teacher = Auth::id();
        // ✅ Corrected query start
        $query = DocumentRepository::where('teacher_id', $teacher);

        // Optional: Filter by status
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Optional: Keyword search
        if ($request->keyword) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('study_type', 'like', '%' . $request->keyword . '%');
            });
        }

        // Paginate
        $documents = $query->orderBy('date_submitted', 'desc')->paginate(10);

        return view('teacher.review', compact('documents'));
    }

    public function pdf_reader_page($id) {
        $document = DocumentRepository::findOrFail($id);
        return view('teacher.pdf_reader', compact('document'));

    }

    public function pdf_approve($id) {
        $teacherId = auth()->id(); // ID, not name
        $document = DocumentRepository::findOrFail($id);

        $document->status = 'Approved';
        $document->approved_by = $teacherId; // store ID
        $document->save();

        return redirect()->back()->with('success', 'Document approved successfully.');
    }


    public function pdf_revise($id) {
        $document = DocumentRepository::findOrFail($id);
        $document->status = 'Needs Revision';
        $document->save();

        return redirect()->back()->with('success', 'Document marked for revision.');
    }

    public function pdf_reject($id) {
        $document = DocumentRepository::findOrFail($id);
        $document->status = 'Rejected';
        $document->save();

        return redirect()->back()->with('success', 'Document rejected successfully.');
    }

    public function pdf_revert($id) {
        $document = DocumentRepository::findOrFail($id);
        $document->status = 'Pending';
        $document->save();

        return redirect()->back()->with('success', 'Document reverted successfully.');
    }


    public function account_setting_page() {
        return view('teacher.accountsetting');

    }

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

        return redirect()->route('teacher.account_setting');
    }


    /**
     * Update student account after verification.
     */
    public function update_account(Request $request)
    {
        $user = Auth::user();

        if (!session('account_verified')) {
            return redirect()->route('teacher.account_setting')
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

        return redirect()->route('teacher.account_setting')
            ->with('success', 'Account updated successfully!');
    }


    public function cancel_update(Request $request)
    {
    // Just redirect back to account settings without triggering success SweetAlert
    return redirect()->route('teacher.account_setting')
        ->with('cancel_message', 'Account update canceled.');
    }
}
