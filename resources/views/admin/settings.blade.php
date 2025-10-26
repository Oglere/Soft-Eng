@extends('layout.admin')
<link rel="stylesheet" href="{{ asset('admin/ctrl.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


@section('content')
<div class="page-header">
    <h2>Account Settings</h2>
</div>
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
                    <div class="verify-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <h1>Verify Your Identity</h1>

                    {{-- Error Message --}}
                    @if ($errors->has('login_error'))
                        <div class="error">{{ $errors->first('login_error') }}</div>
                    @endif

                    {{-- Lockout Message --}}
                    @if ($locked_until && now()->lt($locked_until))
                        <div class="error" id="lockout-message">
                            <i class="bi bi-exclamation-triangle"></i>
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

            <button type="submit" @if ($locked_until && now()->lt($locked_until)) disabled @endif>
                <i class="bi bi-check-circle"></i> Verify
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
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('student.update_account') }}">
            @csrf
            <h2>
                <i class="fas fa-user-cog"></i> Edit Your Account
            </h2>

            <!-- Username -->
            <div class="input-group">
                <label for="usn"><i class="fas fa-user"></i> Username</label>
                <input
                    type="text"
                    name="usn"
                    id="usn"
                    value="{{ old('usn', Auth::user()->usn ?? '') }}"
                    disabled
                >
            </div>

            <!-- First + Last Name -->
            <div class="name-group">
                <div class="input-group">
                    <label for="first_name"><i class="fas fa-id-badge"></i> First Name</label>
                    <input
                        type="text"
                        name="first_name"
                        id="first_name"
                        value="{{ old('first_name', Auth::user()->first_name ?? '') }}"
                        maxlength="30"
                    >
                </div>
                <div class="input-group">
                    <label for="last_name"><i class="fas fa-id-badge"></i> Last Name</label>
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
            <div class="input-group">
                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', Auth::user()->email ?? '') }}"
                    pattern="^[A-Za-z0-9._%+-]{1,15}@gmail\.com$"
                    title="Email must be Gmail and max 15 characters before @">
            </div>

            <!-- Phone Number -->
            <div class="input-group">
                <label for="phone_number"><i class="fas fa-phone"></i> Phone Number</label>
                <input
                    type="text"
                    name="phone_number"
                    id="phone_number"
                    value="{{ old('phone_number', Auth::user()->phone_number ?? '') }}"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                    maxlength="10"
                    placeholder="9XXXXXXXXX"
                >
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password">
                    <i class="fas fa-lock"></i> New Password
                    <span>(leave blank to keep current)</span>
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    minlength="6"
                    pattern="^(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{6,}$"
                    title="Must include at least one number and special character (!@#$%^&*)."
                    placeholder="Enter new password"
                >
            </div>

            <!-- Buttons -->
<div class="button-group">
    <button type="submit"><i class="fas fa-save"></i> Update Account</button>

    <form method="POST" action="{{ route('student.cancel_update') }}">
        @csrf
        <button type="submit" class="cancel-btn">
            <i class="fas fa-times"></i> Cancel
        </button>
    </form>
</div>

        </form>
    </div>
</div>
    @endif
@endsection
<script src="https://kit.fontawesome.com/a2e0b5c56f.js" crossorigin="anonymous"></script>
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
