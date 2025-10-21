<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        DARA -
        @if (request()->is('teacher/dashboard'))
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
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap");

html {
  display: flex;
  justify-content: center;
  padding: 0;
  margin: 0;

    body {
        background-color:#fffce1;
        max-width: 100%;
        width: 1400px;
        height: 100%;
        position: absolute;
        font-family: "rubik";
        display: flex;
        padding: 0;
        margin: 0;
        justify-content: center;

        main {
        max-width: 100%;
        width: 1400px;
        display: flex;
        flex-direction: column;

            header {
                height: 50px;
                padding-left: 30px;
                padding-right: 10px;
                padding-bottom: 10px;
                padding-top: 10px;
                display: flex;
                justify-content: space-between;
                align-items: center;

                .ahhh {
                    width: 125px;
                    text-align: center;
                    font-size: 25px;
                    color: #000000;
                    letter-spacing: 3px;
                    text-decoration: none;
                }
                
                .ahh {
                    height: 40px;
                }
            }
        }
    }
}


input[type="text"]:focus {
  outline: none;
}

.main {
  max-width: 100%;
  width: 1400px;
  display: flex;

  .left {
    height: 100vh;
    overflow: auto;
    width: 210px;
    display: flex;
    flex-direction: column;
    align-items: center;

    .profile {
      text-align: center;
      margin-bottom: 30px;

      h2 {
        margin-bottom: 10px;
        color: #000000;
      }

      .logout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px 15px;
        text-decoration: none;
        border-radius: 5px;
      }

      .logout-btn:hover {
        background-color: #d8c5c5;
      }
    }

    .nav-links {
      display: flex;
      flex-direction: column;
      width: 100%;
      color: #000000;

      a {
        font-size: small;
        /* font-weight: light; */
        display: flex;
        align-items: center;
        text-align: left;
        padding: 10px 10px;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.1s ease;
        color: #000000;

      }

      .active-link {
        font-weight: bold;
        color: #0c1c43 !important;
        font-weight: normal;

      }

      .active-sublink {
        display: flex;
        justify-content: center;
        color: #e4480a !important;
        font-weight: normal;
      }

      .dropdown:has(.active-sublink)  {
        height: 80px;
      }

      .unq {
        color: #242424;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .unq:hover {
        background-color: transparent;
        color: #0c1c43;
        font-weight: normal;
      }

      .trigger {
        width: 100%;
      }

      .uou {
        display: flex;
        position: absolute;
        top: -100px;
        transition: all 0.3s ease;
        opacity: 0;
      }

      .dropdown {
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        height: 45px;
      }

      .dropdown:hover .uou {
        position: inherit;
        opacity: 1;
        transform: translateY(0);
      }

      .dropdown:hover {
        height: 80px;
      }

      a:hover {
        font-weight: bold;
        color: #0c1c43;
      }
    }
  }

    .right {
        background-color: #fffce1 !important;
        border-top-left-radius: 20px;
        border-top-right-radius: 10px;
        border-top: 3px #0c1c43 solid;
        border-left: 3px #0c1c43 solid;
        border-right: 3px #0c1c43 solid;
        width: calc(100% - 40px);
        padding: 20px;
        overflow-y: auto;
    }

    .tab-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .tab-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        background: rgb(186, 218, 255);
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .tab-btn:hover {
        background: rgb(150, 190, 250);
    }

    .tab-btn.active {
        background: #1e1e1e;
        color: white;
    }

    .code-block {
        height: calc(100% - 150px);
        position: relative;
        background: #1e1e1e;
        color: #f8f8f2;
        padding: 15px;
        border-radius: 10px;
        font-family: "Fira Code", monospace;
        font-size: 14px;
        line-height: 1.4;
        overflow-x: auto;
        overflow-y: auto;
        display: none;
    }

    .code-block.active {
    display: block;
    }

    .copy-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgb(186, 218, 255);
        border: none;
        padding: 6px 10px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .copy-btn:hover {
    background: rgb(150, 190, 250);
  }

}

.lgt {
    font-weight: light;
    font-size: small;
    margin-top: 0 !important;
    width: 100%;
    border: none;
    display: flex;
    align-items: center;
    text-align: left;
    padding: 10px 10px;
    color: #000000;
    border-radius: 5px;
    transition: all 0.1s ease;
    justify-content: left;
    background-color: rgba(255, 255, 255, 0);
    transition: all 0.3s ease;
}

.lgt:hover {
    cursor: pointer;
    font-weight: bold;
    color: #0c1c43;
}

svg {
    margin-right: 0.5rem;
}


    </style>
</head>
<body style="overflow: hidden; height: calc(100% - 61px)">
    <main>
        <header>
            <div class="ahh">
                <img
                    src="{{ asset('images/DARA.png') }}"
                    alt="DARA Logo"
                    style=" width: 40px;
                            height: 40px;
                            border-radius: 50%;
                            object-fit: cover;
                            background: white;
                            border: 2px solid white;
                    ">
            </div>
            <div style="display: flex; align-items: center; gap: 20px;">
    <div class="ahh">
        <img
            src="{{ asset('images/DARA.png') }}"
            alt="DARA Logo"
            style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; background: white; border: 2px solid white;">
    </div>

    <!-- Notification Bell -->
    <div style="position: relative;">
        <svg id="notifBell" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"
            style="cursor: pointer;">
            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
        </svg>

        <!-- Notification Badge -->
        @if($pending > 0)
        <span id="notifBadge"
            style="position: absolute; top: -5px; right: -5px; background: red; color: white;
            font-size: 12px; padding: 2px 6px; border-radius: 50%;">
            {{ $pending }}
        </span>
        @endif

        <!-- Popup Notification Box -->
        <div id="notifPopup"
            style="display: none; position: absolute; top: 40px; right: 0;
            width: 300px; background: white; border: 1px solid #ccc;
            border-radius: 10px; box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
            padding: 10px; z-index: 1000;">

            <h4 style="margin: 0 0 10px 0; font-size: 16px;">Pending Studies</h4>
            @if($pendingList->count() > 0)
               @foreach($pendingList as $item)
    <a href="{{ url('/teacher/review-document') }}" 
       style="display: block; text-decoration: none; color: black; padding: 8px 5px; border-bottom: 1px solid #eee;">
        <p style="margin: 0; font-weight: bold;">{{ $item->title }}</p>
        <small style="color: gray;">{{ $item->date_submitted }}</small>
    </a>
@endforeach

            @else
                <p style="color: gray; text-align: center;">No new pending studies.</p>
            @endif
        </div>
    </div>
</div>

        </header>

        <div class="main" style="height: 100%;">
            <div class="left" >
                <div class="profile">
                    <h2>{{ auth()->user()->first_name }}</h2>
                </div>
                <nav class="nav-links">
                    <div class="dropdown">
                        <a href="{{ url('/teacher/dashboard') }}" class="{{ request()->is('teacher/dashboard') ? 'active-link' : '' }}">
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
  <script>
    const bell = document.getElementById('notifBell');
    const popup = document.getElementById('notifPopup');
    const notifBadge = document.getElementById('notifBadge'); // 👈 Get badge element

    bell.addEventListener('click', function() {
        // Toggle popup visibility
        popup.style.display = (popup.style.display === 'none' || popup.style.display === '') 
            ? 'block' : 'none';

        // 👇 Hide red badge when clicked
        if (notifBadge) {
            notifBadge.style.display = 'none';
        }

        // OPTIONAL: tell Laravel that notifications were seen
        fetch("{{ route('teacher.markNotifSeen') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
            },
            body: JSON.stringify({})
        });
    });

    // Close popup when clicking outside
    document.addEventListener('click', function(e) {
        if (!bell.contains(e.target) && !popup.contains(e.target)) {
            popup.style.display = 'none';
        }
    });
</script>


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
