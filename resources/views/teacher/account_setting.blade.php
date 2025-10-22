<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D.A.R.A Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/teacher/std_controls.css') }}">
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
        <h1>D.A.R.A</h1>

        <div class="navbar-right">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>

            <div class="profile">

                <div class="profile-info">
                    <p>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</p>

                    <p>Teacher</p>
                </div>
            </div>
        </div>
  </div>

    <!-- Layout -->
    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div>
                <div class="menu-section">
                    <p class="menu-title">Menu</p>
                    <div class="menu">
                        <a href="<?php echo e(url('/teacher/dashboard')); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h4v11H3zM10 3h4v18h-4zM17 6h4v15h-4z" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="/">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" width="24" height="24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Search Studies
                        </a>
                        <a href="<?php echo e(url('/teacher/submitted')); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            Submitted Studies
                        </a>
                    </div>
                </div>

                <div class="menu-section">
                    <p class="menu-title">Settings</p>
                        <div class="menu">
                            <a href="<?php echo e(url('/teacher/account_setting')); ?>" class="active">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A1 1 0 015 17V7a1 1 0 011-1h3.382a1 1 0 01.894.553l1.382 2.764a1 1 0 00.894.553H19a1 1 0 011 1v6a1 1 0 01-.121.496l-2.382 4.764a1 1 0 01-.894.553H6a1 1 0 01-.879-.496z" />
                                </svg>
                                Account Settings
                            </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>

                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                            </svg>
                            Log out
                        </a>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <main class="main">
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
                    <form class="verify-form" id="verifyForm" method="POST" action="{{ route('student.verify_identity') }}">
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
        </main>
    </div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('verifyForm').addEventListener('submit', function(event) {
        const passwordInput = document.getElementById('password');
        const errorDiv = document.getElementById('passwordError');

        errorDiv.textContent = '';

        if (passwordInput.value.trim() === '') {
            event.preventDefault();
            errorDiv.textContent = 'Please enter your password.';
            passwordInput.style.borderColor = '#dc2626';
        } else {
            passwordInput.style.borderColor = '#0a1444';
        }
    });
</script>

<?php
    session_start();

    // Example password hash
    $stored_password_hash = password_hash("mypassword123", PASSWORD_DEFAULT);
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $entered_password = trim($_POST["password"] ?? "");
        if (password_verify($entered_password, $stored_password_hash)) {
            $message = "<p class='success'>Identity verified successfully.</p>";
        } else {
            $message = "<p class='error'>Incorrect password. Please try again.</p>";
        }
    }
?>
