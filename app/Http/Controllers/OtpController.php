<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class OtpController extends Controller
{
    public function recovery_page()
    {
        return view('guest.forgot'); // forgot.blade.php
    }

    public function sendRecovery(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $email = $request->email;
        $otp   = rand(100000, 999999); // 6-digit OTP

        // Store OTP in password_resets table
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            ['token' => $otp, 'created_at' => now()]
        );

        // Send OTP via PHPMailer
        if (! $this->sendOtpMail($email, $otp)) {
            return back()->with('error', 'Failed to send OTP. Please try again.');
        }

        // Save email in session for next steps
        $request->session()->put('recovery_email', $email);

        return redirect()
            ->route('password.verify.form')
            ->with('success', 'OTP sent to your email.');
    }

    public function showVerifyOtpForm(Request $request)
    {
        return view('guest.verify_otp', [
            'email' => $request->session()->get('recovery_email')
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $email = $request->session()->get('recovery_email');
        if (! $email) {
            return redirect()->route('password.recover')
                ->withErrors(['email' => 'Session expired. Please request a new recovery code.']);
        }

        $record = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $request->otp)
            ->first();

        if (! $record) {
            return back()->withErrors(['otp' => 'Invalid OTP']);
        }

        // Check expiry (15 minutes)
        if (now()->diffInMinutes($record->created_at) > 5) {
            return back()->withErrors(['otp' => 'OTP expired. Please request again.']);
        }

        return redirect()
            ->route('password.reset.form')
            ->with('success', 'OTP verified. You may now reset your password.');
    }


    public function showResetForm() {
        return view('guest.reset_password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $email = $request->session()->get('recovery_email');
        if (! $email) {
            return redirect()->route('password.recover')
                ->withErrors(['email' => 'Session expired. Please start over.']);
        }

        // Update user password (use password_hash column)
        DB::table('users')
            ->where('email', $email)
            ->update(['password_hash' => Hash::make($request->password)]);

        // Delete OTP after use
        DB::table('password_resets')
            ->where('email', $email)
            ->delete();

        // Clear session
        $request->session()->forget('recovery_email');

        return redirect()
            ->route('login.page')
            ->with('success', 'Password reset successful. Please login.');
    }

    public function resendOtp(Request $request)
    {
        $email = $request->session()->get('recovery_email');

        if (! $email) {
            return redirect()->route('password.recover')
                ->withErrors(['email' => 'Session expired. Please request a new recovery code.']);
        }

        // Generate new OTP
        $otp = rand(100000, 999999);

        // Store OTP in DB
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            ['token' => $otp, 'created_at' => now()]
        );

        // Send OTP
        $this->sendOtpMail($email, $otp);

        return back()->with('status', 'A new OTP has been sent to your email.');
    }

    private function sendOtpMail($email, $otp)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = '
                <html>
                <head>
                <style>
                    body {
                    font-family: "Segoe UI", Arial, sans-serif;
                    background-color: #f4f6f8;
                    margin: 0;
                    padding: 0;
                    }
                    .container {
                    background-color: #ffffff;
                    max-width: 480px;
                    margin: 30px auto;
                    border-radius: 10px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                    overflow: hidden;
                    }
                    .header {
                    background-color: #0b1b4a;
                    color: #ffffff;
                    text-align: center;
                    padding: 25px 10px;
                    font-size: 22px;
                    font-weight: 600;
                    letter-spacing: 1px;
                    }
                    .content {
                    padding: 30px;
                    text-align: center;
                    color: #333333;
                    }
                    .otp {
                    display: inline-block;
                    background-color: #e9f1ff;
                    color: #0b1b4a;
                    font-size: 28px;
                    letter-spacing: 4px;
                    font-weight: bold;
                    border-radius: 8px;
                    padding: 12px 20px;
                    margin: 20px 0;
                    }
                    .footer {
                    text-align: center;
                    font-size: 12px;
                    color: #888888;
                    padding: 20px;
                    background-color: #f9fafb;
                    }
                    a {
                    color: #0b1b4a;
                    text-decoration: none;
                    }
                </style>
                </head>
                <body>
                <div class="container">
                    <div class="header">Digital Academic Repository and Archive</div>
                    <div class="content">
                    <p>Hello,</p>
                    <p>We received a request to verify your account. Use the OTP code below to continue:</p>
                    <div class="otp">' . $otp . '</div>
                    <p>This code will expire in <b>15 minutes</b>.</p>
                    <p>If you did not request this, please ignore this email.</p>
                    </div>
                    <div class="footer">
                    © ' . date('Y') . ' Digital Academic Repository and Archive (DARA). All rights reserved.
                    </div>
                </div>
                </body>
                </html>
            ';


            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
