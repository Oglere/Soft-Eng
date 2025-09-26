<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        DARA -
        @if (request()->is('student'))
            Student
        @elseif (request()->is('student/submission*'))
            Student | Submission
        @elseif (request()->is('student/doc-status*'))
            Student | Documen Status
        @elseif (request()->is('student/pdf-reader*'))
            Student | Read
        @elseif (request()->is('student/account-setting*'))
            Student | Account Setting
        @else
            Student | Page
        @endif
    </title>

    <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
</head>
<body style="overflow: hidden; height: calc(100% - 61px)">
    <main>
        <header>
            <div class="ahh">
                <img src="../../Imgs/DARA.png" alt="DARA Logo" class="ahh">
            </div>
        </header>

        <div class="main" style="height: 100%;">
            <div class="left" >
                <div class="profile">
                    <h2>{{ auth()->user()->first_name }}</h2>
                </div>
                <nav class="nav-links">
                    <div class="dropdown">
                        <a href="{{ url('/student') }}" class="{{ request()->is('student') ? 'active-link' : '' }}">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-home"
                                >
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <polyline points="9 22 9 12 15 12 15 22" />
                            </svg>

                            Dashboard

                            <svg
                                style="margin-left: auto; opacity: 50%;"
                                xmlns="http://www.w3.org/2000/svg"
                                width="12"
                                height="12"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather
                                feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </a>
                        <a href="/" class="unq uou">Search Studies</a>
                    </div>

                    <a href="{{ url('/student/submission') }}" class="{{ request()->is('student/submission') ? 'active-link' : '' }}">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-file-plus"
                            >
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="12" y1="18" x2="12" y2="12" />
                            <line x1="9" y1="15" x2="15" y2="15" />
                        </svg>

                        Submit Studies
                    </a>

                    <a href="{{ url('/student/doc-status') }}" class="{{ request()->is('student/doc-status') ? 'active-link' : '' }}">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-eye"
                            >
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>

                        Document Status
                    </a>

                    <div class="asd2" style=" width: 100%; margin-top: 10px; display: flex; justify-content: center;">
                        <div class="asd3" style="border-bottom: 1px solid rgb(0, 0, 0, 0.2); width: 150px;"></div>
                    </div>

                    <a href="{{ url('/student/account-setting') }}" class=" {{ request()->is('student/account-setting') ? 'active-sublink' : 'unq' }}">Edit Account</a>

                    <div class="asd2" style=" width: 100%; display: flex; justify-content: center;">
                        <div class="asd3" style="border-bottom: 1px solid rgb(0, 0, 0, 0.2); width: 150px;"></div>
                    </div>

                    <form action="/logout" method="POST">
                        @csrf
                        <button class="lgt">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-log-in"
                                >
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                <polyline points="10 17 15 12 10 7" />
                                <line x1="15" y1="12" x2="3" y2="12" />
                            </svg>

                            Logout
                        </button>
                    </form>
                </nav>
            </div>

            <div class="right">
                @yield('right')
            </div>

        </div>

        <footer>
        </footer>
    </main>
</body>
</html>

<script>
    function showCode(type) {
    // Hide all blocks
    document.querySelectorAll(".code-block").forEach(el => el.classList.remove("active"));
    // Deactivate all buttons
    document.querySelectorAll(".tab-btn").forEach(btn => btn.classList.remove("active"));
    // Show selected
    document.getElementById(type).classList.add("active");
    event.target.classList.add("active");
    }

    function copyCode(button) {
    const code = button.nextElementSibling.innerText;
    navigator.clipboard.writeText(code).then(() => {
        button.innerText = "Copied!";
        setTimeout(() => button.innerText = "Copy", 2000);
    });
    }
</script>
