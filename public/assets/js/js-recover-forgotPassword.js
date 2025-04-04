document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("password");
    const passwordConfirmation = document.getElementById(
        "password_confirmation"
    );
    const submitBtn = document.getElementById("submitBtn");
    const passwordMatchFeedback = document.getElementById(
        "password-match-feedback"
    );

    // Toggle para mostrar/esconder senha
    function setupPasswordToggle(toggleId, inputId, iconId) {
        const toggle = document.getElementById(toggleId);
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        toggle.addEventListener("click", function () {
            const type =
                input.getAttribute("type") === "password" ? "text" : "password";
            input.setAttribute("type", type);
            icon.setAttribute(
                "name",
                type === "password" ? "eye-outline" : "eye-off-outline"
            );
        });
    }

    // Configura os toggles para ambos campos de senha
    setupPasswordToggle("togglePassword", "password", "eyeIcon");
    setupPasswordToggle(
        "togglePasswordConfirmation",
        "password_confirmation",
        "eyeIconConfirmation"
    );

    // Validação em tempo real da senha
    passwordInput.addEventListener("input", function () {
        const password = this.value;
        const rules = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[^A-Za-z0-9]/.test(password),
        };

        // Conta quantas regras foram atendidas
        const rulesMet = Object.values(rules).filter((rule) => rule).length;
        const totalRules = Object.keys(rules).length;

        // Atualiza regras visuais
        Object.keys(rules).forEach((rule) => {
            const ruleElement = document.getElementById(`rule-${rule}`);
            const isCurrentlyValid = ruleElement.classList.contains("text-success");
            const currentText = ruleElement.textContent.replace(/[✅×]/g, "").trim();
            
            if (rules[rule]) {
                // Só atualiza se não estiver marcado como válido ainda
                if (!isCurrentlyValid) {
                    ruleElement.classList.remove("text-danger");
                    ruleElement.classList.add("text-success");
                    ruleElement.innerHTML = `<small>✅ ${currentText}</small>`;
                }
            } else {
                // Só atualiza se não estiver marcado como inválido ainda
                if (isCurrentlyValid) {
                    ruleElement.classList.remove("text-success");
                    ruleElement.classList.add("text-danger");
                    ruleElement.innerHTML = `<small><span class="bi bi-x-circle-fill"></span> ${currentText}</small>`;
                }
            }
        });

        // Calcula quantos segmentos devem ser preenchidos (4 segmentos para 5 regras)
        const segmentsToFill = Math.floor((rulesMet / totalRules) * 4);

        // Atualiza a barra segmentada
        for (let i = 1; i <= 4; i++) {
            const segment = document.getElementById(`strength-segment-${i}`);

            if (i <= segmentsToFill) {
                // Define a cor baseada no progresso
                const progressPercentage = (rulesMet / totalRules) * 100;

                if (progressPercentage < 25) {
                    segment.style.backgroundColor = "#dc3545"; // Vermelho
                } else if (progressPercentage < 50) {
                    segment.style.backgroundColor = "#fd7e14"; // Laranja
                } else if (progressPercentage < 75) {
                    segment.style.backgroundColor = "#ffc107"; // Amarelo
                } else if (progressPercentage < 100) {
                    segment.style.backgroundColor = "#20c997"; // Verde claro (não está completo)
                } else {
                    segment.style.backgroundColor = "#28a745"; // Verde (completo)
                }
            } else {
                segment.style.backgroundColor = "#e9ecef"; // Cinza (não preenchido)
            }
        }

        const allRulesMet = rulesMet === totalRules;

        // Verifica se as senhas coincidem (se o campo de confirmação não estiver vazio)
        const passwordsMatch =
            passwordConfirmation.value === password ||
            password === passwordConfirmation.value;

        // Habilita/desabilita o botão de envio
        submitBtn.disabled = !(allRulesMet && passwordsMatch);
    });

    // Validação de confirmação de senha
    passwordConfirmation.addEventListener("input", function () {
        if (this.value !== passwordInput.value) {
            passwordMatchFeedback.style.display = "block";
            submitBtn.disabled = true;
        } else {
            passwordMatchFeedback.style.display = "none";

            const password = passwordInput.value;
            const rules = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[^A-Za-z0-9]/.test(password),
            };
            const allRulesMet = Object.values(rules).every((rule) => rule);
            submitBtn.disabled = !allRulesMet;
        }
    });
});
