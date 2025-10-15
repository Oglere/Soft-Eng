<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    public function dashboard_page() {
        return view ('admin.dashboard');
    }

    public function user_control_page() {
        return view ('admin.manage_users');
    }

    public function user_recovery_page() {
        return view ('admin.recovery');
    }

    public function storage_page() {
        return view ('admin.storage');
    }

    public function account_setting_page() {
        return view ('admin.accountsetting');
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

        return redirect()->route('admin.account_setting');
    }

    public function update_account(Request $request)
    {
        $user = Auth::user();

        if (!session('account_verified')) {
            return redirect()->route('admin.account_setting')
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
