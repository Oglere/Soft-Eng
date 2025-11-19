@extends('layout.header')

@section('content')
<div class="reset-container">
    <div class="reset-box">
        <h2>Reset Password</h2>

        {{-- Success message --}}
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- Error message --}}
        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('password.reset') }}" method="POST" class="reset-form">
            @csrf

            <label for="password">New Password</label>
            <input type="password" id="password" name="password" placeholder="Enter new password" required>

            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter new password" required>

            <button type="submit" class="reset-btn">Update Password</button>
        </form>
    </div>
</div>

<style>
    /* Page Container */
    .reset-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 90vh;
        font-family: "Poppins", sans-serif;
    }

    /* Form Box */
    .reset-box {
        background: #fff;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        width: 350px;
        text-align: center;
    }

    .reset-box h2 {
        margin-bottom: 20px;
        color: #333;
    }

    /* Input Fields */
    .reset-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .reset-form label {
        text-align: left;
        font-size: 14px;
        color: #555;
    }

    .reset-form input {
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        outline: none;
        transition: 0.2s;
    }

    /* Submit Button */
    .reset-btn {
        background-color: #0c1c43;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 6px;
        font-size: 15px;
        cursor: pointer;
        transition: background 0.3s;
        margin-top: 5px;
    }

    /* Alerts */
    .alert-success {
        background: #e6ffed;
        border: 1px solid #28a745;
        color: #155724;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .alert-error {
        background: #ffe6e6;
        border: 1px solid #dc3545;
        color: #721c24;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 10px;
        font-size: 14px;
    }

    /* Error message under inputs */
    .error-message {
        color: #dc3545;
        font-size: 13px;
        margin-top: -8px;
        text-align: left;
    }

    body {
        height: 100VH;
    }
</style>
@endsection
