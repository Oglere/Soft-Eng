<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\DocumentRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{

    public function __construct()
{
    $this->middleware(function ($request, $next) {
        $user = auth()->user();

        if ($user) {
            $pending = \App\Models\DocumentRepository::where('teacher_id', $user->user_id)
                ->where('status', 'pending')
                ->count();

            $pendingList = \App\Models\DocumentRepository::where('teacher_id', $user->user_id)
                ->where('status', 'pending')
                ->orderBy('date_submitted', 'desc')
                ->take(5)
                ->get();

            view()->share([
                'pending' => $pending,
                'pendingList' => $pendingList,
            ]);
        }

        return $next($request);
    });
}


public function dashboard_page() {
    $user = User::where("user_id", auth()->id())->first();

    $pending = DocumentRepository::where('teacher_id', $user->user_id)
        ->where('status', 'pending')->count();

    $approved = DocumentRepository::where('teacher_id', $user->user_id)
        ->where('status', 'approved')->count();

    $rejected = DocumentRepository::where('teacher_id', $user->user_id)
        ->where('status', 'rejected')->count();

    $pendingList = DocumentRepository::where('teacher_id', $user->user_id)
        ->where('status', 'pending')
        ->orderBy('date_submitted', 'desc')
        ->take(5)
        ->get();

    return view('teacher.dashboard', compact('user', 'pending', 'approved', 'rejected', 'pendingList'));
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
        return view('teacher.view_submitted', compact('document'));

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
        return view('teacher.account_setting');

    }

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

        return redirect()->route('teacher.account_setting')->with('success', 'Identity verified successfully.');
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

        return redirect()->route('teacher.account_setting')
            ->with('success', 'Account updated successfully!');
    }


    public function cancel_update(Request $request)
    {
    // Just redirect back to account settings without triggering success SweetAlert
    return redirect()->route('teacher.account_setting')
        ->with('cancel_message', 'Account update canceled.');
    }

    public function markNotifSeen()
{
    $teacherId = auth()->id();

    DB::table('document_repository')
        ->where('teacher_id', $teacherId)
        ->where('status', 'pending')
        ->update(['archived' => 1]); // or create a 'seen' column if you prefer

    return response()->json(['success' => true]);
}

}
