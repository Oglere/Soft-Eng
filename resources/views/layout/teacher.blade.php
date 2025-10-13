<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        DARA -
        @if (request()->is('teacher'))
            Teacher
        @elseif (request()->is('teacher/review-document*'))
            Teacher | To Review
        @elseif (request()->is('teacher/account-setting*'))
            Teacher | Account Setting
        @else
            Teacher | Page
        @endif
    </title>

    <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
</head>
<body style="overflow: hidden; height: calc(100% - 61px)">
    <main>
        <header>
            <div class="ahh">
                <img
                    src="{{ asset('storage/images/DARA.png') }}"
                    alt="DARA Logo"
                    style=" width: 40px;
                            height: 40px;
                            border-radius: 50%;
                            object-fit: cover;
                            background: white;
                            border: 2px solid white;
                    ">
            </div>
        </header>

        <div class="main" style="height: 100%;">
            <div class="left" >
                <div class="profile">
                    <h2>{{ auth()->user()->first_name }}</h2>
                </div>
                <nav class="nav-links">
                    <div class="dropdown">
                        <a href="{{ url('/teacher') }}" class="{{ request()->is('teacher') ? 'active-link' : '' }}">
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

                    <a href="{{ url('/teacher/review-document') }}" class="{{ request()->is('teacher/review-document') ? 'active-link' : '' }}">
                        <svg style="margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                        </svg>

                        Review Studies
                    </a>

                    <div class="asd2" style=" width: 100%; margin-top: 10px; display: flex; justify-content: center;">
                        <div class="asd3" style="border-bottom: 1px solid rgb(0, 0, 0, 0.2); width: 150px;"></div>
                    </div>

                    <a href="{{ url('/teacher/account-setting') }}" class=" {{ request()->is('teacher/account-setting') ? 'active-sublink' : 'unq' }}">Account Settings</a>

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
