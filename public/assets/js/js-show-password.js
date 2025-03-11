document.getElementById("togglePassword").addEventListener("click", function () {
        let passwordInput = document.getElementById("password");
        let eyeIcon = document.getElementById("eyeIcon");
    
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.setAttribute("name", "eye-off-outline");
        } else {
            passwordInput.type = "password";
            eyeIcon.setAttribute("name", "eye-outline"); 
        }
    });
    