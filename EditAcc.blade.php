
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DARA - Edit Account</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/EditAcc.css') }}">
    <script src="./java.js"></script>
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
                    <h2> Name </h2>
                </div>
                <nav class="nav-links">
                    <div class="dropdown">
                        <a href="./Dashboard.html" class="trigger">
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
                        </a>
                        <a href="/" class="unq uou">Search Studies</a>
                    </div>


                    <a href="#">
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
                            class="feather feather-users"
                            >
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>

                        Manage Users
                    </a>

                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                            <ellipse cx="12" cy="5" rx="9" ry="3"/>
                            <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                        </svg>

                        Storage
                    </a>

                    <div class="asd2" style=" width: 100%; margin-top: 10px; display: flex; justify-content: center;">
                        <div class="asd3" style="border-bottom: 1px solid rgb(0, 0, 0, 0.2); width: 150px;"></div>
                    </div>

                    <a href="#" class="unq" style="color: #8e0404; font-weight: normal;">Edit Account</a>
                    <a href="recovery" class="unq">Recovery</a>

                    <div class="asd2" style=" width: 100%; display: flex; justify-content: center;">
                        <div class="asd3" style="border-bottom: 1px solid rgb(0, 0, 0, 0.2); width: 150px;"></div>
                    </div>

                    <form action="/out" method="POST">
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
            
        <div class="dash">

    <form class="Edit-form" name="RegForm" onsubmit="return validateForm()" onreset="resetErrors()">
        <h1>Edit Your Account</h1>
        <p>
            <label for="Username">Username</label>
            <input type="text" id="Uname" name="UsenName" placeholder="Enter your Username" />
            <span id="uname-error" class="error-message"></span>
        </p>
        <p>
            <label for="Fname">Edit First Name</label>
            <input type="text" id="EFname" name="Fname" placeholder="Enter your First Name" />
            <span id="EFname-error" class="error-message"></span>
        </p>
        <p>
            <label for="Lname">Edit Last Name</label>
            <input type="text" id="ELname" name="Lname" placeholder="Enter your Last Name" />
            <span id="ELname-error" class="error-message"></span>
        </p>
        <p>
            <label for="email">E-mail Address</label>
            <input type="text" id="email" name="EMail" placeholder="Enter your email" />
            <span id="email-error" class="error-message"></span>
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" id="password" name="Password" />
            <span id="password-error" class="error-message"></span>
        </p>
        <p>
            <input type="submit" value="Send" name="Submit" />
        </p>
    </form>

        </div>
        
        <footer>
        </footer>
    </main>
</body>
</html>

<script>
    function hawa() {
    window.location.href = "";
    }
</script>
                        