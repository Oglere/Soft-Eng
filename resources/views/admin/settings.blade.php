@extends('layout.admin')
<link rel="stylesheet" href="{{ asset('admin/ctrl.css') }}">
<style>
    .right h1 {
        text-align: center;
    }
    .login-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: auto;
    }
    .login-box {
        background: #e9e9e9;
        padding: 40px;
        border-radius: 20px;
        text-align: center;
        width: 400px;
    }
    .login-box h2 {
        color: #0a0099;
        margin-bottom: 20px;
        font-weight: 800;
    }
    .login-box label {
        display: block;
        text-align: left;
        font-weight: bold;
        margin-bottom: 8px;
    }
    .login-box input {
        width: 100%;
        padding: 10px;
        margin-bottom: 18px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
    }
    .login-box button {
        background: #0a0099;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
    }
    .login-box button:hover {
        background: #05005c;
    }
    .error {
        color: red;
        margin-bottom: 15px;
        font-size: 14px;
    }
    .register-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: auto;
    }
    .register-box {
        background: #e9e9e9;
        padding: 40px;
        border-radius: 20px;
        width: 450px;
    }
    .register-box h2 {
        color: #0a0099;
        margin-bottom: 20px;
        font-weight: 800;
        text-align: center;
    }
    .register-box label {
        display: block;
        font-weight: bold;
        margin-top: 12px;
        margin-bottom: 5px;
    }
    .register-box input {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 6px;
        font-size: 15px;
        margin-bottom: 10px;
    }
    .register-box a, button {
        background: #0a0099;
        color: white;
        border: none;
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        font-size: 16px;
        margin-top: 15px;
        cursor: pointer;
        text-align: center
    }
    .register-box button:hover {
        background: #05005c;
    }
    .error {
        color: red;
        font-size: 14px;
        margin-bottom: 8px;
    }
</style>

@section('content')
<h2>Account Setting</h2>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#0a0099'
            });
        </script>
    @endif

    @if (session('cancel_message'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Canceled',
                text: '{{ session('cancel_message') }}',
                confirmButtonColor: '#b30000'
            });
        </script>
    @endif

    @php
        $attempts = session('login_attempts', 0);
        $locked_until = session('locked_until', null);
    @endphp

    {{-- If account is not verified, show verify form --}}
    @if (!session('account_verified'))
        <div class="verify-wrapper">
            <form class="verify-form" id="verifyForm" method="POST" action="{{ route('admin.verify_identity') }}">
                @csrf
                <div class="verify-card">
                    <h1>Verify Your Identity</h1>

                    {{-- Error Message --}}
                    @if ($errors->has('login_error'))
                        <div class="error">{{ $errors->first('login_error') }}</div>
                    @endif

                    {{-- Lockout Message --}}
                    @if ($locked_until && now()->lt($locked_until))
                        <div class="error" id="lockout-message">
                            Too many failed attempts.<br>
                            Please wait <span id="countdown">60</span> seconds before trying again.
                        </div>
                    @endif

                    <div class="input-group">
                        <label for="password">Enter your password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            @if ($locked_until && now()->lt($locked_until)) disabled @endif
                        >
                        <div id="passwordError" class="error-message"></div>
                    </div>

                    <button type="submit"
                        @if ($locked_until && now()->lt($locked_until)) disabled @endif>
                        Verify
                    </button>
                </div>
            </form>
        </div>

        {{-- Countdown Script --}}
        @if ($locked_until && now()->lt($locked_until))
            <script>
                const countdownElement = document.getElementById('countdown');

                if (!localStorage.getItem('lockoutEndTime')) {
                    const endTime = Date.now() + 60000;
                    localStorage.setItem('lockoutEndTime', endTime);
                }

                const endTime = parseInt(localStorage.getItem('lockoutEndTime'));

                const timer = setInterval(() => {
                    const now = Date.now();
                    const remaining = Math.max(0, Math.floor((endTime - now) / 1000));
                    countdownElement.textContent = remaining;

                    if (remaining <= 0) {
                        clearInterval(timer);
                        localStorage.removeItem('lockoutEndTime');
                        location.reload();
                    }
                }, 1000);
            </script>
        @endif
    @else
        {{-- If verified, show edit account form --}}
        <div class="edit-account-wrapper">
            <div class="edit-account-card">
                @if ($errors->any())
                    <div class="error" style="color: red;margin-top:5px">
                        <ul style="list-style: none; padding: 0; text-align: center;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('student.update_account') }}">
                    @csrf
                    <h2 style="color: #0a0099; font-weight: 800; text-align: center; margin-bottom: 10px;">
                        Edit Your Account
                    </h2>

                    <!-- Username -->
                    <label for="usn">Username</label>
                    <input
                        type="text"
                        name="usn"
                        id="usn"
                        value="{{ old('usn', Auth::user()->usn ?? '') }}"
                        disabled
                    >

                    <!-- First + Last Name -->
                    <div style="display: flex; gap: 40px; margin-bottom: 15px;">
                        <div style="flex: 1;">
                            <label for="first_name">First Name</label>
                            <input
                                type="text"
                                name="first_name"
                                id="first_name"
                                value="{{ old('first_name', Auth::user()->first_name ?? '') }}"
                                maxlength="30"
                            >
                        </div>
                        <div style="flex: 1;">
                            <label for="last_name">Last Name</label>
                            <input
                                type="text"
                                name="last_name"
                                id="last_name"
                                value="{{ old('last_name', Auth::user()->last_name ?? '') }}"
                                maxlength="30"
                            >
                        </div>
                    </div>

                    <!-- Email -->
                    <label style="margin-top:-15px" for="email">Email Address</label>
                    <input type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', Auth::user()->email ?? '') }}"
                        pattern="^[A-Za-z0-9._%+-]{1,15}@gmail\.com$"
                        title="Email must be Gmail and max 15 characters before @">

                    <!-- Phone Number -->
                    <label for="phone_number">Phone Number</label>
                    <input
                        type="text"
                        name="phone_number"
                        id="phone_number"
                        value="{{ old('phone_number', Auth::user()->phone_number ?? '') }}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                        maxlength="10"
                        placeholder="9XXXXXXXXX"
                    >

                    <!-- Password -->
                    <label for="password">
                        New Password
                        <span style="font-weight: normal; font-size: 13px; color: #333;">
                            (leave blank to keep current password)
                        </span>
                    </label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        minlength="6"
                        pattern="^(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{6,}$"
                        title="Password must be at least 6 characters long and include at least one number and one special character (!@#$%^&*)."
                        placeholder="Enter new password"
                    >

                    <!-- Buttons -->
                    <div style="display: flex; justify-content: center; align-items: center; gap: 15px; margin-top: 15px;">
                        <form method="POST" action="{{ route('student.update_account') }}">
                            @csrf
                            <button type="submit"
                                style="background-color: #0a0099; color: white; border: none;
                                padding: 12px 30px; border-radius: 8px; font-size: 16px;
                                font-weight: bold; cursor: pointer; transition: 0.3s;">
                                Update Account
                            </button>
                        </form>

                        <form method="POST" action="{{ route('student.cancel_update') }}">
                            @csrf
                            <button type="submit"
                                style="background-color: #b30000; color: white; border: none;
                                padding: 12px 30px; border-radius: 8px; font-size: 16px;
                                font-weight: bold; cursor: pointer; transition: 0.3s;">
                                Cancel
                            </button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Home icon redirect
        const homeIcon = document.querySelector(".home-icon");
        if (homeIcon) {
            homeIcon.addEventListener("click", function () {
                window.location.href = "/admin/dashboard";
            });
        }

        // Logout confirmation
        const logoutIcon = document.querySelector(".feather-log-in");
        if (logoutIcon) {
            logoutIcon.addEventListener("click", function () {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You will be logged out of your account.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, log me out"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("logout-form").submit();
                    }
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            // ✅ Success alert after updating account
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#0a0099'
                });
            @endif

            // ❌ Do nothing for cancel_message (normal redirect only)
            // @if(session('cancel_message'))
            //     console.log("Cancel: {{ session('cancel_message') }}");
            // @endif
        });
    });
</script>

<script src="{{ asset('') }}"></script>
