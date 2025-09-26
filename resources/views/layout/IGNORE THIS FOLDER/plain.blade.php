

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('CSS/plain.css')}}">
    <title>DARA Main Page</title>
</head>
<body>
    <main>
        <header>
            <a class="death" href="/layouts">
                <div class="loginbutton">
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
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    <h4> &nbsp; Go Back</h4>
                </div>
            </a>
        </header>

        <div class="contents">
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
                        <pre><code>
&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;link rel="stylesheet" href="{{asset('CSS/plain.css')}}"&gt;
    &lt;title&gt;DARA Main Page&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;main&gt;
        &lt;header&gt;
            &lt;a class="death" href="{{ url('/go/login') }}"&gt;
                &lt;div class="loginbutton"&gt;
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
                        &lt;path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"&gt;&lt;/path&gt;
                        &lt;polyline points="10 17 15 12 10 7"&gt;&lt;/polyline&gt;
                        &lt;line x1="15" y1="12" x2="3" y2="12"&gt;&lt;/line&gt;
                    &lt;/svg&gt;
                    &lt;h4&gt; &amp;nbsp; Login&lt;/h4&gt;
                &lt;/div&gt;
            &lt;/a&gt;
        &lt;/header&gt;

        &lt;div class="contents"&gt;

        &lt;/div&gt;

        &lt;footer&gt;
        &lt;/footer&gt;
    &lt;/main&gt;
&lt;/body&gt;
&lt;/html&gt;
</code></pre>

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
    background-color: rgb(186, 218, 255);


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

        .loginbutton {
          display: flex;
          align-items: center;
        }

        a {
          display: flex;
          align-items: center;
          text-decoration: none;
          color: #1e1e1e;
          margin-right: 20px;
        }

        a:hover {
          text-decoration: none;
          color: #3b3b3b;
        }
      }

      .contents {
        border-top-left-radius: 50px;
        border-top-right-radius: 50px;
        border-top: 1px #1e1e1e6e solid;
        border-left: 1px #1e1e1e6e solid;
        border-right: 1px #1e1e1e6e solid;
        width: calc(100% - 20px);
        height: 100%;
        padding: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: rgb(202, 234, 255);

        p {
          color: #04128e !important;
          line-height: 80px;
          padding-right: 7px;
          font-size: 100px;
          font-weight: lighter;
          margin: 0;
        }

        h4 {
          color: #04128e !important;
          margin-top: 0;
        }

        .search {
          max-width: 100%;
          width: 742px;
          display: flex;
          height: 35px;

          button {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            border: none;
            display: flex;
            align-items: center;
            color: white;
            background-color: #8e0404;
            cursor: pointer;
          }

          button:hover {
            background-color: #ac0b0b;
          }

          input[type="text"] {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            border: 1px solid #8e0404;
            width: 100%;
            padding-left: 5px;
          }

          input[type="text"]:focus {
            outline: none;
          }
        }

        .tags {
          max-width: 100%;
          padding: 20px;
          padding-top: 0;
          margin-top: 20px;
          display: flex;
          flex-direction: column;

          .tag {
            display: flex;
            flex-direction: column;
          }

          .tagform {
            height: 100%;
            display: flex;
            flex-direction: column;

            .lefttag {
              margin-top: 15px;
              width: 100%;
              height: calc(100% - 40px);
              display: flex;
              flex-direction: column;
              align-items: center;

              .date {
                margin-left: 10px;
              }
            }

            .righttag {
              margin-top: 20px;
              display: flex;
              flex-wrap: wrap;
              margin-bottom: 20px;
              gap: 10px;
              justify-content: center;
              flex-direction: row;

              .chkbx {
                height: 45px;
                width: calc(48% - 10px);
                margin-bottom: 10px;
                display: flex;
                align-items: center;
                cursor: pointer;
                border: #8e0404 1px solid;
                border-radius: 5px;
                padding-left: 10px;

                input[type="checkbox"] {
                  margin-right: 10px;
                  cursor: pointer;
                  display: none;
                }

                label {
                  color: #8e0404;
                  cursor: pointer;
                }
              }
            }
          }
        }
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
        document.querySelectorAll(".code-block").forEach(el => el.classList.remove("active"));
        document.querySelectorAll(".tab-btn").forEach(btn => btn.classList.remove("active"));
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
