@extends('layout.header')
<link rel="stylesheet" href="{{ asset('css/guest/login.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@section('content')
    <div class="login-wrapper">
        <div class="login-card">
            <h2 class="login-title">Forgot Password?</h2>
            <p class="login-subtitle">Enter your email and we’ll send you a 6-digit OTP.</p>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Validation Errors --}}
            {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}

            <form method="POST" action="{{ route('password.recover.send') }}" class="login-form">
                @csrf

                {{-- Email field --}}
                <div class="input-wrapper">
                    <div class="input-group">
                        <i class="fas fa-envelope" style="margin-right: 10px"></i>
                        <input type="email"
                               name="email"
                               placeholder="Enter your email"
                               value="{{ old('email') }}"
                               required>
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit button --}}
                <button type="submit" class="login-btn">Send OTP</button>

                <div class="form-footer">
                    <a href="{{ route('login.page') }}">Back to Login</a>
                </div>
            </form>
        </div>
    </div>

@endsection

<style>
    .error-message{
        color: red;
    font-size: 13px;
    margin-top: 5px;
    min-height: 16px;
    text-align: left;
    }

</style>
