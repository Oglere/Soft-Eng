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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>D.A.R.A Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
  <link rel="stylesheet" href="{{ asset('css/student/std_control.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
  <div class="navbar">
    <h1>D.A.R.A</h1>

 <div class="navbar-right">
  <div class="notification-wrapper">
    <button id="notifBtn" class="notif-btn">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
      <span id="notifBadge" class="notif-badge">0</span>
    </button>

    <div id="notifDropdown" class="notif-dropdown hidden">
      <h4>Notifications</h4>
      <ul id="notifList"></ul>
    </div>
  </div>

  <div class="profile">
    <div class="profile-info">
      <p>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</p>
      <p>Student</p>
    </div>
  </div>
</div>
@if (session('success'))
<script>
  // Ensure success SweetAlert shows after redirect (fires on full load)
  window.addEventListener('load', function () {
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: @json(session('success')),
        confirmButtonColor: '#0a0099'
      });
    }
  });
</script>
@endif
  </div>



  <div class="layout">
     <!-- Sidebar -->
    <aside class="sidebar">
      <div>
        <div class="menu-section">
          <p class="menu-title">Menu</p>
          <div class="menu">
            <a href="<?php echo e(url('/student/dashboard')); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 10h4v11H3zM10 3h4v18h-4zM17 6h4v15h-4z" />
              </svg>
              Dashboard
            </a>
            <a href="<?php echo e(url('/')); ?>">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-4.35-4.35m1.1-5.4a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
    </svg>
    Search Studies
  </a>
            <a href="<?php echo e(url('/student/submission')); ?>" > 
              <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4" />
              </svg>
              Submit Studies
            </a>
            <a href="<?php echo e(url('/student/submitted')); ?>">
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
            <a href="<?php echo e(url('/student/account_setting')); ?>" class="active">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5.121 17.804A1 1 0 015 17V7a1 1 0 011-1h3.382a1 1 0 01.894.553l1.382 2.764a1 1 0 00.894.553H19a1 1 0 011 1v6a1 1 0 01-.121.496l-2.382 4.764a1 1 0 01-.894.553H6a1 1 0 01-.879-.496z" />
              </svg>
              Account
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
              <div class="errors">{{ $errors->first('login_error') }}</div>
          @endif

          {{-- Lockout Message --}}
          @if ($locked_until && now()->lt($locked_until))
<script>
document.addEventListener('DOMContentLoaded', () => {
  const lockoutSeconds = 60; // Adjust as needed
  const lockoutEndTime = localStorage.getItem('lockoutEndTime') 
    ? parseInt(localStorage.getItem('lockoutEndTime')) 
    : Date.now() + lockoutSeconds * 1000;

  localStorage.setItem('lockoutEndTime', lockoutEndTime);

  let remaining = Math.floor((lockoutEndTime - Date.now()) / 1000);

  const modal = Swal.fire({
    title: 'Account Locked 🔒',
    html: `
      <div >
        Too many failed attempts.<br>
        Please wait <b><span id="countdown">${remaining}</span></b> seconds before trying again.
      </div>
    `,
    icon: 'error',
    allowOutsideClick: false,
    showConfirmButton: false,
    didOpen: () => {
      const countdownEl = Swal.getHtmlContainer().querySelector('#countdown');
      const timer = setInterval(() => {
        remaining = Math.max(0, Math.floor((lockoutEndTime - Date.now()) / 1000));
        countdownEl.textContent = remaining;
        if (remaining <= 0) {
          clearInterval(timer);
          localStorage.removeItem('lockoutEndTime');
          Swal.close();
          location.reload();
        }
      }, 1000);
    }
  });
});
</script>
@endif


          <div class="input-group">
              <label for="password">Enter your password</label>
              <input
                  type="password"
                  id="password"
                  name="password"
                  @if ($locked_until && now()->lt($locked_until)) disabled @endif
              >
              <!-- Custom error message placeholder -->
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
        const endTime = Date.now() + 60000; // 60 seconds
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

                
                <!-- @if ($errors->any())
                    <div class="error" style="color: red;">
                        <ul style="list-style: none; padding: 0; text-align: center;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                 -->

        <form id="mainEditForm" method="POST" action="{{ route('student.update_account') }}">
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
<div style="display: flex; gap: 40px; ">
    <!-- First Name -->
    <div style="flex: 1; display: flex; flex-direction: column;">
        <label for="first_name">First Name</label>
        <input 
            type="text" 
            name="first_name" 
            id="first_name"
            value="{{ old('first_name', Auth::user()->first_name ?? '') }}"
            maxlength="30"
        >
        @if ($errors->has('first_name'))
            <span class="text-danger" style="font-size: 0.9rem; margin-top: -15px; color: red;">
                {{ $errors->first('first_name') }}
            </span>
        @endif
    </div>

    <!-- Last Name -->
    <div style="flex: 1; display: flex; flex-direction: column;">
        <label for="last_name">Last Name</label>
        <input 
            type="text" 
            name="last_name" 
            id="last_name"
            value="{{ old('last_name', Auth::user()->last_name ?? '') }}"
            maxlength="30"
        >
        @if ($errors->has('last_name'))
            <span class="text-danger" style="font-size: 0.9rem; margin-top: -15px; color: red">
                {{ $errors->first('last_name') }}
            </span>
        @endif
    </div>
</div>

<!-- Email -->
<div style="display: flex; flex-direction: column; margin-top: 3px;">
  <label for="email">Email Address</label>
  <input 
    type="email" 
    name="email" 
    id="email"
    value="{{ old('email', Auth::user()->email ?? '') }}"
    placeholder="example@gmail.com"
    maxlength="30"
   
  >
  @if ($errors->has('email'))
            <span class="text-danger" style="font-size: 0.9rem; margin-top: -15px; color: red">
                {{ $errors->first('email') }}
            </span>
        @endif
</div>


<!-- Phone Number -->
<div style="display: flex; flex-direction: column; ">
  <label for="phone_number">Phone Number</label>
  <input 
    type="text" 
    name="phone_number" 
    id="phone_number" 
    maxlength="13" 
    placeholder="9XX-XXX-XXXX"
    value="{{ old('phone_number', isset(Auth::user()->phone_number) ? preg_replace('/^\+63\s?/', '', Auth::user()->phone_number) : '') }}"
  >
  @if ($errors->has('phone_number'))
    <span class="text-danger" style="font-size: 0.9rem; margin-top: -15px; color: red;">
      {{ $errors->first('phone_number') }}
    </span>
  @endif
</div>

<!-- New Password -->
<div style="display: flex; flex-direction: column; margin-bottom: 10px;">
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
    placeholder="Enter new password"
  />
  <span id="passwordError" style="font-size: 0.9rem;color:red; margin-top: -10px; "></span>
  @if ($errors->has('password'))
      <span >
        {{ $errors->first('password') }}
      </span>
  @endif
</div>

<!-- Confirm Password -->
<div style="display: flex; flex-direction: column;">
  <label for="password_confirmation">Confirm Password</label>
  <input 
    type="password" 
    name="password_confirmation" 
    id="password_confirmation" 
    minlength="6"
    placeholder="Re-enter new password"
  />
  <span id="confirmPasswordError"  style="font-size: 0.9rem; color: red; margin-top: -10px;"></span>
  @if ($errors->has('password_confirmation'))
      <span >
        {{ $errors->first('password_confirmation') }}
      </span>
  @endif
</div>



                    <!-- Buttons -->
                    <!-- Wrap both forms in a flex container -->
<div class="update-btn">

  <!-- Update & Cancel buttons: Update button will submit the outer edit form -->
    <button id="updateBtn" type="button"
        style="background-color: #0a0099; color: white; border: none;
             padding: 12px 30px; border-radius: 8px; font-size: 16px;
             font-weight: bold; cursor: pointer; transition: 0.3s;margin-top:-10px">
      Update Account
    </button>

</div>
</form>

                    <!-- Cancel form placed outside the edit form to avoid nested forms -->
                    <div class="cancel-btn">
                    <form id="cancelUpdateForm" method="POST" action="{{ route('student.cancel_update') }}" style="display:inline-block;">
                        @csrf
                        <button id="cancelBtn" type="button"
                            style="background-color: #b30000; color: white; border: none;
                                padding: 12px 30px; border-radius: 8px; font-size: 16px;
                                font-weight: bold; cursor: pointer; transition: 0.3s;">
                        Cancel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</main>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const form = document.querySelector('form[action="{{ route("student.update_account") }}"]');
        if (form) {
        form.addEventListener('submit', function(event) {
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            const passwordError = document.getElementById('passwordError');
            const confirmError = document.getElementById('confirmPasswordError');

            // Clear previous errors
            passwordError.textContent = '';
            confirmError.textContent = '';
            passwordInput.style.borderColor = '#ccc';
            confirmInput.style.borderColor = '#ccc';

            const password = passwordInput.value.trim();
            const confirmPassword = confirmInput.value.trim();

            // Skip validation if no password is being changed
            if (password === '' && confirmPassword === '') return;

            // Check if passwords match
            if (password !== confirmPassword) {
            event.preventDefault();
            confirmError.textContent = 'The password field confirmation does not match.';
            confirmInput.style.borderColor = '#dc2626';
            return;
            }

            // Check password strength (must contain number + special char)
            const strongPattern = /^(?=.*[0-9])(?=.*[!@#$%^&*]).{6,}$/;
            if (!strongPattern.test(password)) {
            event.preventDefault();
            passwordError.textContent = 'Password must be strong: include at least one number and one special character.';
            passwordInput.style.borderColor = '#dc2626';
            return;
            }
        });
    }

    const phoneInput = document.getElementById('phone_number');

    // ✅ Format phone number while typing
    phoneInput.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');

        // Automatically add 9 if not yet typed
            if (!value.startsWith('9')) {
            value = '9' + value;
        }

        // Limit total digits to 10
        value = value.substring(0, 10);

        // Format as 9XX-XXX-XXXX
        const formatted = value.replace(/^(\d{1,3})(\d{0,3})(\d{0,4}).*/, function (_, a, b, c) {
            let res = a;
            if (b) res += '-' + b;
            if (c) res += '-' + c;
            return res;
        });

        e.target.value = formatted;
    });

    // ✅ Prevent multiple "+63" when submitting
    const updateForm = document.querySelector('form[action="{{ route("student.update_account") }}"]');
        updateForm.addEventListener('submit', function (e) {
            const phoneInput = document.getElementById('phone_number');
            let currentValue = phoneInput.value.trim();

            // Only prepend if not yet starting with +63
            if (!currentValue.startsWith('+63')) {
            phoneInput.value = '+63 ' + currentValue.replace(/^\+63\s?/, '');
            }
        });
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');

    emailInput.addEventListener('input', function () {
        let value = emailInput.value.trim();

        // 🧹 Prevent typing anything after "@gmail.com"
        if (value.includes('@gmail.com')) {
            const parts = value.split('@gmail.com');
            value = parts[0] + '@gmail.com'; // cut off anything after
        }

        // 🔄 Update input value to clean version
        emailInput.value = value;

        // ✅ Validation: must match pattern like "abc123@gmail.com"
        const gmailPattern = /^[A-Za-z0-9._%+-]{1,6}@gmail\.com$/;

        if (value !== '' && !gmailPattern.test(value)) {
            emailError.textContent = 'Email must be a valid Gmail address (e.g., name@gmail.com, min 6 chars before @).';
            emailInput.style.borderColor = '#dc2626'; // red border
        } else {
            // Clear error only if it was from JS, not from server
            if (!@json($errors->has('email'))) {
                emailError.textContent = '';
            }
            emailInput.style.borderColor = '#ccc'; // reset border
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Only run timer if the user is on the Edit Account page (means verified)
        @if (session('account_verified'))
        let inactivityTime = 0;
        const maxInactivity = 60; // 1 minute

        // Reset timer when user interacts
        const resetTimer = () => inactivityTime = 0;
            ['mousemove', 'keydown', 'click', 'scroll'].forEach(evt => {
                document.addEventListener(evt, resetTimer);
        });

    // Timer checker (run once). Store interval id so we can clear it on expiry
    let inactivityTimerId = setInterval(() => {
    inactivityTime++;
        if (inactivityTime >= maxInactivity) {
        // prevent multiple executions
            clearInterval(inactivityTimerId);
                if (window._accountExpiredHandled) return;
                window._accountExpiredHandled = true;

                // Time’s up → call Laravel route to cancel update
                fetch("{{ route('student.cancel_update') }}", {
                    method: 'POST',
                    headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(() => {
                    Swal.fire({
                    icon: 'info',
                    title: 'Session Expired',
                    text: 'You’ve been inactive for a while. Please verify your identity again.',
                    confirmButtonColor: '#0a0099',
                    }).then(() => {
                    window.location.href = "{{ route('student.account_setting') }}";
                    });
                }).catch(() => {
                    // On error still redirect once
                    Swal.fire({
                    icon: 'info',
                    title: 'Session Expired',
                    text: 'You’ve been inactive for a while. Please verify your identity again.',
                    confirmButtonColor: '#0a0099',
                    }).then(() => {
                    window.location.href = "{{ route('student.account_setting') }}";
                    });
                });
            }
        }, 1000);
        @endif
    });

    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->has('no_changes'))
            Swal.fire({
                icon: 'error',
                title: 'No Changes Detected',
                text: '{{ $errors->first('no_changes') }}',
                confirmButtonColor: '#0a0099',
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#0a0099',
            });
        @endif

        @if (session('cancel_message'))
            Swal.fire({
                icon: 'info',
                title: 'Update Canceled',
                text: '{{ session('cancel_message') }}',
                confirmButtonColor: '#0a0099',
            });
        @endif
    });
</script>

<script>
    async function loadNotifications(saveToStorage = true) {
        const notifBadge = document.getElementById('notifBadge');
        const notifList = document.getElementById('notifList');

        try {
            const res = await fetch('{{ route("student.notifications") }}');
            const data = await res.json();

            notifList.innerHTML = '';

            if (data.length === 0) {
            notifBadge.style.display = 'none';
            notifList.innerHTML = '<li>No new notifications.</li>';
            if (saveToStorage) localStorage.setItem('notifCount', 0);
            return;
            }

            // Get read notifications from localStorage
            const readNotifs = JSON.parse(localStorage.getItem('readNotifs') || '[]');

            // Filter unread notifications for badge
            const unreadCount = data.filter(n => !readNotifs.includes(n.message)).length;

            notifBadge.style.display = unreadCount > 0 ? 'inline-block' : 'none';
            notifBadge.textContent = unreadCount;

            // store count so it persists across pages
            if (saveToStorage) localStorage.setItem('notifCount', unreadCount);

        data.forEach(n => {
        const li = document.createElement('li');

        // If notification has been read, bg is white; else yellow
        const isRead = readNotifs.includes(n.message);
            li.style.backgroundColor = isRead ? '#fff' : '#fef9c3';
            li.style.cursor = 'pointer';
            li.innerHTML = `
                ${n.icon}
                <a href="${n.link}" class="notif-link">${n.message}</a>
                <br>
                <small>${n.time}</small>
            `;

        // On click: mark as read, set bg white, update badge
        li.addEventListener('click', () => {
            if (!readNotifs.includes(n.message)) {
            readNotifs.push(n.message);
            localStorage.setItem('readNotifs', JSON.stringify(readNotifs));

            li.style.backgroundColor = '#fff';

            // update badge
            const currentBadge = parseInt(notifBadge.textContent) || 0;
            const newBadge = Math.max(currentBadge - 1, 0);
            notifBadge.textContent = newBadge;
            if (newBadge === 0) notifBadge.style.display = 'none';
            }
        });

            notifList.appendChild(li);
            });
        } catch (error) {
            console.error('Error loading notifications:', error);
        }
    }

    // --- INITIALIZATION ---
    document.addEventListener('DOMContentLoaded', () => {
        const notifBadge = document.getElementById('notifBadge');

    // Load saved count from localStorage (keep number after page change)
    const savedCount = localStorage.getItem('notifCount');
        if (savedCount && parseInt(savedCount) > 0) {
            notifBadge.textContent = savedCount;
            notifBadge.style.display = 'inline-block';
        } else {
            notifBadge.style.display = 'none';
    }

        // Fetch new notifications immediately
        loadNotifications();

        // Refresh notifications every 10 seconds
        setInterval(() => {
            loadNotifications();
        }, 10000); // 10 seconds
    });

        // Toggle dropdown on bell click
        document.getElementById('notifBtn').addEventListener('click', async () => {
        const dropdown = document.getElementById('notifDropdown');
        dropdown.classList.toggle('hidden');
        if (!dropdown.classList.contains('hidden')) {
            await loadNotifications(false); // don’t overwrite saved count every click
        }
    });
</script>

<script>
    // SweetAlert confirmation for Update and Cancel buttons
    document.addEventListener('DOMContentLoaded', function () {
    const updateBtn = document.getElementById('updateBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const mainForm = document.getElementById('mainEditForm');
    const cancelForm = document.getElementById('cancelUpdateForm');

    if (updateBtn) {
        // Capture initial values so we can detect whether anything changed
        const snapshot = {
        first_name: document.getElementById('first_name') ? document.getElementById('first_name').value.trim() : '',
        last_name: document.getElementById('last_name') ? document.getElementById('last_name').value.trim() : '',
        email: document.getElementById('email') ? document.getElementById('email').value.trim() : '',
        phone_number: document.getElementById('phone_number') ? document.getElementById('phone_number').value.trim() : '',
        // password fields are considered changed only if user types something
        };

        function hasChanges() {
            const first_name = document.getElementById('first_name') ? document.getElementById('first_name').value.trim() : '';
            const last_name = document.getElementById('last_name') ? document.getElementById('last_name').value.trim() : '';
            const email = document.getElementById('email') ? document.getElementById('email').value.trim() : '';
            const phone_number = document.getElementById('phone_number') ? document.getElementById('phone_number').value.trim() : '';
            const password = document.getElementById('password') ? document.getElementById('password').value.trim() : '';
            const confirmPassword = document.getElementById('password_confirmation') ? document.getElementById('password_confirmation').value.trim() : '';

            // If password fields are filled, treat as change
            if (password !== '' || confirmPassword !== '') return true;

            return (
                first_name !== snapshot.first_name ||
                last_name !== snapshot.last_name ||
                email !== snapshot.email ||
                phone_number !== snapshot.phone_number
            );
        }

        updateBtn.addEventListener('click', function (e) {
            e.preventDefault();

            // If there are no changes, show a SweetAlert info and do not submit
            if (!hasChanges()) {
                Swal.fire({
                icon: 'info',
                title: 'No changes detected',
                text: 'Please update at least one field before submitting.',
                confirmButtonColor: '#0a0099'
                });
                return;
            }

            // Otherwise ask for confirmation and submit (this will trigger existing form submit handlers)
            Swal.fire({
                title: 'Confirm Update',
                text: 'Are you sure you want to update your account information?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update',
                cancelButtonText: 'No, keep editing',
                confirmButtonColor: '#0a0099'
            }).then((result) => {
                if (result.isConfirmed) {
                // Use requestSubmit if available to respect form validation/custom submit handlers
                if (typeof mainForm.requestSubmit === 'function') {
                    mainForm.requestSubmit();
                } else {
                    mainForm.submit();
                }
                }
            });
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Cancel Update',
                text: 'Are you sure you want to cancel? Any unsaved changes will be lost.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel',
                cancelButtonText: 'No, continue editing',
                confirmButtonColor: '#b30000'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the cancel form to server to clear session verification
                    if (typeof cancelForm.requestSubmit === 'function') {
                        cancelForm.requestSubmit();
                    } else {
                        cancelForm.submit();
                    }
                    }
                });
            });
        }
    });
</script>
</body>
</html>
