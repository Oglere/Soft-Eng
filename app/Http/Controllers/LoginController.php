<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function Login_page()
    {
        if (auth()->check()) {
            return redirect('/');
        }

        return view('guest.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'usn_login' => 'required',
            'password_hash_login' => 'required',
            'role' => 'required|in:admin,student,teacher',
        ], [
            'usn_login.required' => 'Please enter your username.',
            'password_hash_login.required' => 'Please enter your password.',
            'role.required' => '⚠ Please select your role before logging in.',
            'role.in' => 'Invalid role selected.',
        ]);

        $user = User::where('usn', $request->usn_login)->first();

        if (!$user) {
            return back()->withErrors(['usn_login' => 'Incorrect username.'])->onlyInput('usn_login');
        }

        $maxAttempts = $user->role === 'admin' ? 3 : 5;
        $lockMinutes = $user->role === 'admin' ? 15 : 5;

        // 🔒 If account is locked, check remaining time
        if ($user->locked_until && now()->lessThan($user->locked_until)) {
            $retryAfter = now()->diffInSeconds(\Carbon\Carbon::parse($user->locked_until));
            return back()
                ->withErrors(['general' => 'Your account is locked due to too many failed attempts.'])
                ->with('retry_after', $retryAfter);
        }

        // ✅ Reset lock if time has passed
        if ($user->locked_until && now()->greaterThanOrEqualTo($user->locked_until)) {
            $user->update(['locked_until' => null, 'attempts' => 0]);
        }

        // ❌ Incorrect password
        if (!password_verify($request->password_hash_login, $user->password_hash)) {
            $user->attempts = ($user->attempts ?? 0) + 1;

            if ($user->attempts >= $maxAttempts) {
                $user->locked_until = now()->addMinutes($lockMinutes);
            }

            $user->save();

            return back()->withErrors([
                'password_hash_login' => $user->locked_until
                    ? "Too many failed attempts. Account locked for {$lockMinutes} minutes."
                    : "Incorrect password. Attempt {$user->attempts}/{$maxAttempts}.",
            ])->onlyInput('usn_login');
        }

        // ❌ Role mismatch
        if ($user->role !== $request->role) {
            return back()->withErrors(['role' => 'Selected role does not match your account.']);
        }

        // ✅ Successful login
        $user->update([
            'attempts' => 0,
            'locked_until' => null,
            'last_login' => now(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            default => redirect()->route('landing'),
        };
    }

    public function logout(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $user->last_login = now();
            $user->save();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.page');
    }
}
