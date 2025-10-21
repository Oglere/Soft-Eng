@extends('layout.header')

@section('content')

<div class="recovery-wrapper">
    <div class="recovery-container">
        <div class="recovery-header">
            <svg xmlns="http://www.w3.org/2000/svg"
                width="40" height="40" viewBox="0 0 24 24"
                fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-lock">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <h2>Verify OTP</h2>
            <p class="instructions">
                Enter the 6-digit OTP sent to your email address ({{ $email }}).
                This helps us verify your identity.
            </p>
        </div>


        <form action="{{ url('auth/verify-otp') }}" method="POST" class="recovery-form" id="otpForm">
            @csrf

            <div class="otp-inputs">
                <input type="tel" maxlength="1" class="otp-box" required>
                <input type="tel" maxlength="1" class="otp-box" required>
                <input type="tel" maxlength="1" class="otp-box" required>
                <input type="tel" maxlength="1" class="otp-box" required>
                <input type="tel" maxlength="1" class="otp-box" required>
                <input type="tel" maxlength="1" class="otp-box" required>
            </div>

            <!-- Hidden input that holds the final 6-digit code -->
            <input type="hidden" name="otp" id="otpInput">

            <button type="submit" class="submit-btn">Verify</button>
        </form>

        <p class="resend">
            Didn’t receive the code?
            <form action="{{ route('password.otp.resend') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Resend OTP</button>
            </form>

            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </p>
    </div>
</div>

{{-- Styles --}}
<style>
    .recovery-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        min-height: 80vh;
    }
    .recovery-container {
        background: #fff;
        padding: 35px;
        border-radius: 15px;
        max-width: 420px;
        width: 100%;
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        text-align: center;
        border-top: 5px solid #0c1c43;
        animation: fadeIn 0.5s ease-in-out;
    }

    .recovery-header svg {
        color: #0c1c43;
        margin-bottom: 10px;
    }

    .recovery-container h2 {
        margin-bottom: 8px;
        color: #0c1c43;
        font-size: 1.6rem;
    }

    .instructions {
        font-size: 14px;
        color: #666;
        margin-bottom: 25px;
    }

    .otp-inputs {
        display: flex;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    .otp-box {
        width: 45px;
        height: 50px;
        font-size: 20px;
        text-align: center;
        border: 1.5px solid #ccc;
        border-radius: 8px;
        background: #fafafa;
        transition: all 0.3s ease;
    }

    .otp-box:focus {
        border-color: #0c1c43;
        outline: none;
        background: #fff;
    }

    .submit-btn {
        width: 100%;
        padding: 14px;
        background-color: #0c1c43;
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #142b66;
    }

    .resend {
        margin-top: 15px;
        font-size: 14px;
    }
    .resend a {
        color: #0c1c43;
        text-decoration: none;
        font-weight: 600;
    }
    .resend a:hover {
        text-decoration: underline;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .alert {
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 15px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const inputs = document.querySelectorAll(".otp-box");

    inputs.forEach((input, index) => {


        input.addEventListener("input", (e) => {
            e.target.value = e.target.value.replace(/[^0-9]/g, "");


            if (e.target.value && index < inputs.length - 1) {
                const allPrevFilled = [...inputs].slice(0, index + 1).every(inp => inp.value);
                if (allPrevFilled) {
                    inputs[index + 1].focus();
                }
            }
        });


        input.addEventListener("focus", () => {
            for (let i = 0; i < index; i++) {
                if (!inputs[i].value) {
                    inputs[i].focus();
                    break;
                }
            }
        });


        input.addEventListener("keydown", (e) => {
            if (e.key === "Tab") {
                const allPrevFilled = [...inputs].slice(0, index).every(inp => inp.value);
                if (!allPrevFilled) {
                    e.preventDefault();
                    for (let i = 0; i < index; i++) {
                        if (!inputs[i].value) {
                            inputs[i].focus();
                            break;
                        }
                    }
                }
            }

            if (e.key === "Backspace" && !e.target.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });
});
</script>

<script>
document.getElementById('otpForm').addEventListener('submit', function(e) {
    const digits = Array.from(document.querySelectorAll('.otp-box')).map(i => i.value).join('');
    document.getElementById('otpInput').value = digits;
});
</script>
@endsection
