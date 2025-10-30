@if (Auth::check())
    <script>window.location.href = "{{ url('/') }}";</script>
    <?php exit(); ?>
@endif

@extends('layout.header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/guest/login.css') }}">

@section('content')
    <div class="login-wrapper">
        <div class="login-card">
            <h2 class="login-title">Welcome to DARA</h2>
            <p class="login-subtitle"></p>

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                {{-- Username field --}}
                <div class="input-wrapper">
                    <div class="input-group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="25" height="20" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-user">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <input type="text"
                            name="usn_login"
                            value="{{ old('usn_login') }}"
                            placeholder="Username">
                    </div>
                    @error('usn_login')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password field --}}
                <div class="input-wrapper">
                    <div class="input-group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="25" height="20" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-lock">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password"
                            name="password_hash_login"
                            placeholder="Password">
                    </div>
                    @error('password_hash_login')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- General error --}}
                @if ($errors->has('general'))
                    <div class="general-error">
                        {{ $errors->first('general') }}
                    </div>

                    {{-- ⏳ Dynamic countdown message --}}
                    @if (session('retry_after'))
                        <div id="lock-countdown" class="countdown-timer"></div>

                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                let remaining = {{ (int) session('retry_after') }};
                                const countdownElement = document.getElementById('lock-countdown');
                                const loginButton = document.querySelector('.login-btn');


                                function formatTime(seconds) {
                                    const m = Math.floor(seconds / 60);
                                    const s = seconds % 60;
                                    return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                                }

                                function updateCountdown() {
                                    if (remaining <= 0) {
                                        countdownElement.textContent = "You can now try logging in again.";
                                        if (loginButton) {
                                            loginButton.style.opacity = 1;
                                            loginButton.textContent = "Login";
                                        }
                                        return;
                                    }

                                    countdownElement.textContent = `You can login again in ${formatTime(remaining)}`;
                                    remaining--;
                                    setTimeout(updateCountdown, 1000);
                                }

                                updateCountdown();
                            });
                        </script>
                    @endif
                @endif
                {{-- Role selection (styled radio buttons as cards) --}}
                <div class="input-wrapper role-selection">
                    <p class="role-title">Please Select a Role :</p>
                    <div class="role-options">
                        <label class="role-card">
                            <input type="radio" name="role" value="admin" {{ old('role') == 'admin' ? 'checked' : '' }}>
                            <div class="role-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <span>Admin</span>
                        </label>
                        <label class="role-card">
                            <input type="radio" name="role" value="student" {{ old('role') == 'student' ? 'checked' : '' }}>
                            <div class="role-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <span>Student</span>
                        </label>
                        <label class="role-card">
                            <input type="radio" name="role" value="teacher" {{ old('role') == 'teacher' ? 'checked' : '' }}>
                            <div class="role-icon">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <span>Teacher</span>
                        </label>
                    </div>
                    @error('role')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit button --}}
                <button name="submitlogin" type="submit" class="login-btn">Login</button>

                <div class="form-footer">
                    <a href="{{ route('password.recover') }}">Forgot Password?</a>
                </div>
            </form>

        </div>
    </div>
@endsection

<script src="{{ asset('js/guest/login.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const editForm = document.getElementById('editUserForm');

    if (editForm) {
        editForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            // Clear old errors
            document.querySelectorAll('.error-text').forEach(el => el.remove());
            let isValid = true;

            function showError(input, message) {
                const error = document.createElement('div');
                error.className = 'error-text';
                error.textContent = message;
                error.style.color = '#e74c3c';
                error.style.fontSize = '0.85rem';
                error.style.marginTop = '6px';
                input.insertAdjacentElement('afterend', error);
            }

            // Fields
            const first = document.getElementById('edit_first_name');
            const last = document.getElementById('edit_last_name');
            const usn = document.getElementById('edit_usn');
            const email = document.getElementById('edit_email');
            const password = document.getElementById('edit_password');
            const role = document.getElementById('edit_role');
            const status = document.getElementById('edit_status');
            const currentEmail = email.getAttribute('data-original-email'); // store original email

            // Validation
            if (first.value.trim() === '') { showError(first, 'First name is required.'); isValid = false; }
            if (last.value.trim() === '') { showError(last, 'Last name is required.'); isValid = false; }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email.value.trim() === '') {
                showError(email, 'Email is required.');
                isValid = false;
            } else if (!emailPattern.test(email.value.trim())) {
                showError(email, 'Please enter a valid email address.');
                isValid = false;
            }

            if (password.value.trim() !== '' && password.value.trim().length < 6) {
                showError(password, 'Password must be at least 6 characters.');
                isValid = false;
            }

            if (role.value === '') { showError(role, 'Please select a role.'); isValid = false; }
            if (status.value === '') { showError(status, 'Please select a status.'); isValid = false; }

            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Form Error',
                    text: 'Please correct the highlighted fields before submitting.',
                    confirmButtonColor: '#e74c3c'
                });
                return;
            }

            editForm.submit();
        });
    }

    // --- SweetAlert after redirect ---
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2500
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#e74c3c'
        });
    @endif

    @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Notice',
            text: "{{ session('info') }}",
            confirmButtonColor: '#3085d6'
        });
    @endif
});
</script>
