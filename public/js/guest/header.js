document.addEventListener("DOMContentLoaded", () => {
    const usernameInput = document.querySelector("input[name='usn_login']");
    const passwordInput = document.querySelector("input[name='password_hash_login']");

    // Username: allow only letters and numbers
    if (usernameInput) {
        usernameInput.addEventListener("keydown", (e) => {
            // Allow control keys
            if (
                e.key === "Backspace" ||
                e.key === "Delete" ||
                e.key === "Tab" ||
                e.key.startsWith("Arrow")
            ) {
                return;
            }

            // ✅ Allow only a-z, A-Z, 0-9
            if (!/^[a-zA-Z0-9]$/.test(e.key)) {
                e.preventDefault();
            }
        });

        // ✅ Clean pasted input (only letters & numbers remain)
        usernameInput.addEventListener("input", () => {
            usernameInput.value = usernameInput.value.replace(/[^a-zA-Z0-9]/g, "");
        });
    }

    // Password: allow everything except spaces
    if (passwordInput) {
        passwordInput.addEventListener("keydown", (e) => {
            if (e.key === " ") {
                e.preventDefault();
            }
        });

        passwordInput.addEventListener("input", () => {
            passwordInput.value = passwordInput.value.replace(/\s/g, "");
        });
    }
});
