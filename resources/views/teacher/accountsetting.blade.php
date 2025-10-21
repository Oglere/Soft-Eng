@extends('layout.teacher')
<link rel="stylesheet" href="{{ asset('') }}">
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

@section('right')

   <h1 style="font-weight: bold; color: black; font-size: 40px;">
        ACCOUNT SETTINGS
    </h1>

    <!-- Login Form -->
    @if (!session('account_verified'))
        <div class="login-container">
            <div class="login-box" style="box-shadow: 5px 5px 1px #04128e;">
                <h2>VERIFY YOUR IDENTITY</h2>

                @if ($errors->has('login_error'))
                    <div class="error">{{ $errors->first('login_error') }}</div>
                @endif

                <form method="POST" action="{{ route('teacher.verify_identity') }}">
                    @csrf
                    <label for="password">Enter your password</label>
                    <input type="password" name="password" id="password" required>
                    <button type="submit">Verify</button>
                </form>
            </div>
        </div>
    @else
        <div class="register-container">
            <div class="register-box" style="box-shadow: 5px 5px 1px #04128e;">
                <h2 style="color: #0a0099; font-weight: 800; text-align: center; margin-bottom: 25px;">
                    Edit Your Account
                </h2>

                @if ($errors->any())
                    <div class="error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('teacher.update_account') }}">
                    @csrf

                <!-- Username -->
                <label for="usn">Username</label>
                <input type="text" name="usn" id="usn" value="{{ old('usn', Auth::user()->usn ?? '') }}">

                <!-- First + Last Name (side by side) -->
                <div style="display: flex; gap: 40px; margin-bottom: 15px;">
                    <div style="flex: 1;">
                        <label for="first_name">Edit First Name</label>
                        <input type="text" name="first_name" id="first_name"
                            value="{{ old('first_name', Auth::user()->first_name ?? '') }}">
                    </div>
                    <div style="flex: 1;">
                        <label for="last_name">Edit Last Name</label>
                        <input type="text" name="last_name" id="last_name"
                            value="{{ old('last_name', Auth::user()->last_name ?? '') }}">
                    </div>
                </div>

                <!-- Email -->
                <label for="email">Edit Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email ?? '') }}">

                <!-- Password -->
                <label for="password">
                    New Password <span style="font-weight: normal; font-size: 13px; color: #333;">
                        (leave blank to keep current password)
                    </span>
                </label>
                <input type="password" name="password" id="password">

                <!-- Buttons Row -->
                <div style="display: flex; justify-content: center; gap: 15px; margin-top: 20px;">
                    <!-- Update Account (inside main form) -->
                    <button type="submit"
                        style="background-color: #0a0099; color: white; border: none;
                            padding: 12px 20px; border-radius: 8px; font-size: 16px;
                            font-weight: bold; cursor: pointer;">
                        Update Account
                    </button>

                    <!-- Cancel (separate form but inline with flex) -->
                    <form method="POST" action="{{ route('teacher.cancel_update') }}">
                        @csrf
                        <button type="submit"
                            style="background-color: #b30000; color: white; border: none;
                                padding: 12px 20px; border-radius: 8px; font-size: 16px;
                                font-weight: bold; cursor: pointer;">
                            Cancel
                        </button>
                    </form>
                </div>
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
                window.location.href = "/teacher/dashboard";
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
