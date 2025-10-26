<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use APP\Models\User;
use Rap2hpoutre\FastExcel\FastExcel;

class AdminController extends Controller
{
    public function dashboard_page(){
        // Total counts
        $totalUsers = \App\Models\User::count();
        $totalAdmins = \App\Models\User::where('role', 'admin')->count();

        $totalStorageBytes = \DB::table('document_repositories')
            ->selectRaw('SUM(LENGTH(file)) as total_size')
            ->value('total_size') ?? 0;

        // ✅ Convert bytes to human-readable unit
        if ($totalStorageBytes >= 1099511627776) {
            $totalStorageValue = round($totalStorageBytes / 1099511627776, 2);
            $totalStorageUnit = 'TB';
        } elseif ($totalStorageBytes >= 1073741824) {
            $totalStorageValue = round($totalStorageBytes / 1073741824, 2);
            $totalStorageUnit = 'GB';
        } elseif ($totalStorageBytes >= 1048576) {
            $totalStorageValue = round($totalStorageBytes / 1048576, 2);
            $totalStorageUnit = 'MB';
        } elseif ($totalStorageBytes >= 1024) {
            $totalStorageValue = round($totalStorageBytes / 1024, 2);
            $totalStorageUnit = 'KB';
        } else {
            $totalStorageValue = $totalStorageBytes;
            $totalStorageUnit = 'Bytes';
        }

        // ✅ Published (Approved)
        $publishedDocs = \App\Models\DocumentRepository::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('status', 'Approved')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // ✅ Unpublished (anything not Approved)
        $unpublishedDocs = \App\Models\DocumentRepository::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('status', '!=', 'Approved')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Pie chart (status breakdown)
        $docStatuses = \App\Models\DocumentRepository::select('status', \DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Recent users (example using last_login)
        $recentUsers = \App\Models\User::orderBy('last_login', 'desc')
            ->take(5)
            ->get(['last_name', 'first_name', 'last_login']);

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalStorageValue',
            'totalStorageUnit',
            'publishedDocs',
            'unpublishedDocs',
            'docStatuses',
            'recentUsers'
        ));
    }

    public function user_control_page(){
        $users = \App\Models\User::select('user_id', 'usn', 'first_name', 'last_name', 'email', 'role', 'is_active')
            ->where('is_deleted', '===', '0')
            ->orderBy('last_name')
            ->get();

        $toRecover = \App\Models\User::select('user_id', 'usn', 'first_name', 'last_name', 'email', 'role', 'is_active')
            ->where('is_deleted', '!=', '0')
            ->orderBy('last_name')
            ->get();

        return view('admin.manage_users', compact('users', 'toRecover'));
    }

    public function add_acc(Request $request){
        try {
            // ✅ Step 1: Validate inputs
            $validated = $request->validate([
                'first_name' => 'required|string|max:100',
                'last_name'  => 'required|string|max:100',
                'email'      => 'required|email|unique:users,email',
                'usn'        => 'required|numeric|unique:users,usn',
                'password'   => 'required|string|min:8',
                'role'       => 'required|in:admin,student,teacher',
                'is_active'  => 'required|boolean',
            ]);

            User::create([
                'first_name'    => $validated['first_name'],
                'last_name'     => $validated['last_name'],
                'email'         => $validated['email'],
                'usn'           => $validated['usn'],
                'password_hash' => Hash::make($validated['password']),
                'role'          => $validated['role'],
                'is_active'     => $validated['is_active'],
            ]);

            return redirect()->back()->with('success', 'User added successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Error adding user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add user. Please try again.');
        }
    }

    public function checkDuplicates(Request $request){
        $emailExists = \App\Models\User::where('email', $request->email)->exists();
        $usnExists = \App\Models\User::where('usn', $request->usn)->exists();

        return response()->json([
            'email_exists' => $emailExists,
            'usn_exists' => $usnExists,
        ]);
    }

    public function add_acc_xml(Request $request){
        $request->validate([
            'fileUpload' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('fileUpload');
        $path = $file->store('temp');

        try {
            $file = $request->file('fileUpload');
            $rows = (new FastExcel)->import($file);
            $imported = 0;
            $skipped = 0;

            foreach ($rows as $row) {
                $usn = trim($row['usn'] ?? '');
                $first = trim($row['first_name'] ?? '');
                $last = trim($row['last_name'] ?? '');
                $password = trim($row['password_hash'] ?? '');

                if (!$usn || !$first || !$last || !$password) {
                    $skipped++;
                    continue;
                }

                if (User::where('usn', $usn)->exists()) {
                    $skipped++;
                    continue;
                }

                User::create([
                    'usn' => $usn,
                    'first_name' => $first,
                    'last_name' => $last,
                    'password_hash' => Hash::make($password),
                    'role' => 'student',
                    'is_active' => 1,
                ]);

                $imported++;
            }

            return redirect()->back()->with('success', "Import completed: $imported users added, $skipped skipped.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to import users: ' . $e->getMessage());
        }
    }

    public function edit_acc(Request $request, $id) {
        // dd($request->all());
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|string',
            'is_active' => 'required|in:0,1',
            'password_hash' => 'nullable|min:6',
            'email' => 'required|email',
        ]);

        $emailChanged = $request->email !== $user->email;
        $roleChanged = $request->role !== $user->role;
        $statusChanged = (int)$request->is_active !== (int)$user->is_active;
        $passwordChanged = !empty($request->password_hash);

        if (!$emailChanged && !$roleChanged && !$statusChanged && !$passwordChanged) {
            return redirect()->back()->with('info', "Nothing has changed.");
        }

        if ($emailChanged) {
            $existing = User::where('email', $request->email)
                            ->where('user_id', '!=', $id)
                            ->first();

            if ($existing) {
                return redirect()->back()->with('error', 'Email already exists.');
            }

            $user->email = $request->email;
        }

        $user->role = $request->role;
        $user->is_active = $request->is_active;

        if ($passwordChanged) {
            $user->password_hash = Hash::make($request->password_hash);
        }

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function del_acc(Request $request, $id) {
        $user = User::findOrFail($id);

        // Update role to "deleted" instead of deleting
        $user->is_deleted = 1; // optionally deactivate the account
        $user->save();

        return redirect()->back()->with('success', "User {$user->first_name} {$user->last_name} has been marked as deleted.");
    }

    public function recover_acc(Request $request, $id) {
        $user = User::findOrFail($id);

        // Update role to "deleted" instead of deleting
        $user->is_deleted = 0; // optionally deactivate the account
        $user->save();

        return redirect()->back()->with('recovered', "User {$user->first_name} {$user->last_name} has been recovered.");
    }

    public function storage_page() {
        return view ('admin.storage');
    }

    public function account_setting_page() {
        return view ('admin.settings');
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

        return redirect()->route('admin.account_setting')->with('success', 'Identity verified successfully.');
    }

    public function update_account(Request $request)
    {
        $user = Auth::user();

        if (!session('account_verified')) {
            return redirect()->route('admin.account_setting')
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

        return redirect()->route('admin.account_setting')
            ->with('success', 'Account updated successfully!');
    }


    public function cancel_update(Request $request)
    {
    // Just redirect back to account settings without triggering success SweetAlert
    return redirect()->route('admin.account_setting')
        ->with('cancel_message', 'Account update canceled.');
    }

}
