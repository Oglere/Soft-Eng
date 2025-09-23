        function validateForm() {
            const Username = document.getElementById("Uname").value;
            const EditFname = document.getElementById("EFname").value;
            const EditLname = document.getElementById("ELname").value;
            const email = document.getElementById("email").value;
            const pass = document.getElementById("password").value;

            const UsernameErr = document.getElementById("uname-error");
            const ednameErr = document.getElementById("EFname-error");
            const edLnameErr = document.getElementById("ELname-error");
            const emailErr = document.getElementById("email-error");
            const passErr = document.getElementById("password-error");

            UsernameErr.textContent = "";
            ednameErr.textContent = "";
            edLnameErr.textContent = "";
            emailErr.textContent = "";
            passErr.textContent = "";

            let isValid = true;
            if (Username === "" || /\d/.test(Username)) {
                UsernameErr.textContent = "Please enter your Username properly.";
                isValid = false;
            }
            if (EditFname === "") {
                ednameErr.textContent = "Please enter your First Name.";
                isValid = false;
            }
            if (EditLname === "") {
                edLnameErr.textContent = "Please enter your Last Name.";
                isValid = false;
            }
            if (email === "" || !email.includes("@") || !email.includes(".")) {
                emailErr.textContent = "Please enter a valid email address.";
                isValid = false;
            }
            if (pass === "" || pass.length < 6) {
                passErr.textContent = "Please enter a password with at least 6 characters.";
                isValid = false;
            }
            if (isValid) {
                alert("Form submitted successfully!");
                return true;
            } else {
                return false; 
            }
        }

        function resetErrors() {
            document.getElementById("uname-error").textContent = "";
            document.getElementById("EFname-error").textContent = "";
            document.getElementById("ELname-error").textContent = "";
            document.getElementById("email-error").textContent = "";
            document.getElementById("password-error").textContent = "";
        }