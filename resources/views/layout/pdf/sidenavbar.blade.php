<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DARA - Edit Account</title>
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
                    <h2> Name </h2>
                </div>
                <nav class="nav-links">
                    <div class="dropdown">
                        <a href="/admin" class="trigger">
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


                    <a href="user-control">
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

                    <a href="/admin/storage">
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

                    <a href="" class="unq" style="color: #8e0404; font-weight: normal;">Edit Account</a>
                    <a href="recovery" class="unq">Recovery</a>

                    <div class="asd2" style=" width: 100%; display: flex; justify-content: center;">
                        <div class="asd3" style="border-bottom: 1px solid rgb(0, 0, 0, 0.2); width: 150px;"></div>
                    </div>

                    <a href="/layouts">
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

                        Go Back
                    </a>
            </div>
            <div class="right">
                <h2>Code Reference</h2>

                <!-- Tab Buttons -->
                <div class="tab-buttons">
                    <button class="tab-btn active" onclick="showCode('html')">HTML</button>
                    <button class="tab-btn" onclick="showCode('css')">CSS</button>
                </div>

                <!-- Code Blocks -->
                <div id="html" class="code-block active">
                    <button class="copy-btn" onclick="copyCode(this)">Copy</button>
                    <pre><code>
&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;DARA - Edit Account&lt;/title&gt;
    &lt;link rel="stylesheet" href="{{ asset('css/sidenav.css') }}"&gt;
&lt;/head&gt;
&lt;body style="overflow: hidden; height: calc(100% - 61px)"&gt;
    &lt;main&gt;
        &lt;header&gt;
            &lt;div class="ahh"&gt;
                &lt;img src="../../Imgs/DARA.png" alt="DARA Logo" class="ahh"&gt;
            &lt;/div&gt;
        &lt;/header&gt;

        &lt;div class="main" style="height: 100%;"&gt;
            &lt;div class="left" &gt;
                &lt;div class="profile"&gt;
                    &lt;h2&gt; Name &lt;/h2&gt;
                &lt;/div&gt;
                &lt;nav class="nav-links"&gt;
                    &lt;div class="dropdown"&gt;
                        &lt;a href="/admin" class="trigger"&gt;
                            &lt;svg
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
                                &gt;
                                &lt;path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" /&gt;
                                &lt;polyline points="9 22 9 12 15 12 15 22" /&gt;
                            &lt;/svg&gt;

                            Dashboard
                        &lt;/a&gt;
                        &lt;a href="/" class="unq uou"&gt;Search Studies&lt;/a&gt;
                    &lt;/div&gt;


                    &lt;a href="user-control"&gt;
                        &lt;svg
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
                            &gt;
                            &lt;path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" /&gt;
                            &lt;circle cx="9" cy="7" r="4" /&gt;
                            &lt;path d="M23 21v-2a4 4 0 0 0-3-3.87" /&gt;
                            &lt;path d="M16 3.13a4 4 0 0 1 0 7.75" /&gt;
                        &lt;/svg&gt;

                        Manage Users
                    &lt;/a&gt;

                    &lt;a href="/admin/storage"&gt;
                        &lt;svg xmlns="http://www.w3.org/2000/svg"&gt;
                        &gt;width="24"&gt;
                        &gt;height="24"&gt;
                        &gt;viewBox="0 0 24 24"&gt;
                        &gt;fill="none"&gt;
                        &gt;stroke="currentColor"&gt;
                        &gt;stroke-width="2"&gt;
                        &gt;stroke-linecap="round"&gt;
                        &gt;stroke-linejoin="round"&gt;
                        &gt;class="feather&gt;
                        &gt;feather-database"&gt;
                            &lt;ellipse cx="12" cy="5" rx="9" ry="3"/&gt;
                            &lt;path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/&gt;
                            &lt;path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/&gt;
                        &lt;/svg&gt;

                        Storage
                    &lt;/a&gt;

                    &lt;div class="asd2" style=" width: 100%; margin-top: 10px; display: flex; justify-content: center;"&gt;
                        &lt;div class="asd3" style="border-bottom: 1px solid rgb(0, 0, 0, 0.2); width: 150px;"&gt;&lt;/div&gt;
                    &lt;/div&gt;

                    &lt;a href="" class="unq" style="color: #8e0404; font-weight: normal;"&gt;Edit Account&lt;/a&gt;
                    &lt;a href="recovery" class="unq"&gt;Recovery&lt;/a&gt;

                    &lt;div class="asd2" style=" width: 100%; display: flex; justify-content: center;"&gt;
                        &lt;div class="asd3" style="border-bottom: 1px solid rgb(0, 0, 0, 0.2); width: 150px;"&gt;&lt;/div&gt;
                    &lt;/div&gt;

                    &lt;form action="/out" method="POST"&gt;
                        @csrf
                        &lt;button class="lgt"&gt;
                            &lt;svg
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
                                &gt;
                                &lt;path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" /&gt;
                                &lt;polyline points="10 17 15 12 10 7" /&gt;
                                &lt;line x1="15" y1="12" x2="3" y2="12" /&gt;
                            &lt;/svg&gt;

                            Logout
                        &lt;/button&gt;
                    &lt;/form&gt;
                &lt;/nav&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;footer&gt;
        &lt;/footer&gt;
    &lt;/main&gt;
&lt;/body&gt;
&lt;/html&gt;
                        </code></pre>
                </div>

                <div id="css" class="code-block">
                    <button class="copy-btn" onclick="copyCode(this)">Copy</button>
                    <pre><code>
@import url("https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap");

html {
  display: flex;
  justify-content: center;
  padding: 0;
  margin: 0;

  body {
    background-color: rgb(186, 218, 255);
    overflow: hidden;
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
        padding-left: 20px;
        padding-right: 10px;
        padding-bottom: 10px;
        padding-top: 10px;
        display: flex;
        flex-direction: row-reverse;
        align-items: center;
      }

    }
  }
}

.ahh {
  height: 40px;
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

      a {
        font-weight: lighter;
        display: flex;
        align-items: center;
        text-align: left;
        padding: 10px 10px;
        color: black;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.1s ease;

      }

      .unq {
        color: grey;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .unq:hover {
        background-color: transparent;
        color: #8e0404;
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
        font-weight: normal;
      }
    }
  }

  .right {
    background-color: rgb(202, 234, 255);
    border-top-left-radius: 50px;
    border-top-right-radius: 50px;
    border-top: 1px #1e1e1e6e solid;
    border-left: 1px #1e1e1e6e solid;
    border-right: 1px #1e1e1e6e solid;
    width: calc(100% - 40px);
    padding-left: 20px;
    padding-right: 20px;
  }
}

.lgt {
  font-size: 16px;
    width: 100%;
    border: none;
    display: flex;
    align-items: center;
    text-align: left;
    padding: 10px 10px;
    color: black;
    border-radius: 5px;
    transition: all 0.1s ease;
    justify-content: left;
    background-color: rgba(255, 255, 255, 0);
    transition: all 0.3s ease;
}

.lgt:hover {
    cursor: pointer;
    background-color: #00000011;
    font-weight: normal;
    color: #8e0404;
}

svg {
    margin-right: 0.5rem;
}

                    </code></pre>
                </div>
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
