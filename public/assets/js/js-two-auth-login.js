const errorParagraph = document.querySelector(".alert-danger p");
const csrfToken = document.getElementById('csrf_token').value;

document.addEventListener("DOMContentLoaded", function () {
    const sendEmailElement = document.getElementById("sendEmail");
    const closeButton = document.querySelector(".btn-close");

    // Se fechar o botão de alerta, abre o reenviar
    if (closeButton) {
        closeButton.addEventListener("click", function () {
            displayLinkResendToken(true);
            setTimeout(() => {
                displayLinkResendToken(true);
            }, 0);
        });
    }

    // Verifica se tem o alerta de reenvio o e-mail
    if (sendEmailElement) {
        displayLinkResendToken(false);
        setupCodeInputHandlers();
        initializeCountdown();
    } else {
        if (errorParagraph && errorParagraph.textContent.includes("Usuário bloqueado")) {
            displayLinkResendToken(false);
            setupCodeInputHandlers();
        } else {
            displayLinkResendToken(false);
            setupCodeInputHandlers();
        }
        
        displayLinkResendToken(true);
        setupCodeInputHandlers();
    }
});

/**
 * Função que Inicializa o contador para reativar o botão de envio de email após 30 segundos.
 */
function initializeCountdown() {
    const button = document.getElementById("sendEmail");
    const timerText = document.getElementById("timerText");
    let countdown = 30;

    // Desabilita o botão e altera o texto inicial
    button.disabled = true;

    // Começa o intervalo de contagem regressiva
    const timerInterval = setInterval(() => {
        countdown--;

        if (countdown > 0) {
            button.textContent = `${countdown} segundos restantes...`;
        } else {
            clearInterval(timerInterval);
            enableResendButton(button, timerText);
        }
    }, 1000);
}

/**
 * Função que ativa o botão de reenviar código, altera o texto do timer e exibe o link de reenvio.
 */
function enableResendButton(button, timerText) {
    timerText.textContent = "Você pode clicar no botão agora.";
    button.disabled = false;
    button.textContent = "Clique aqui para reenviar";
}

/**
 * Função chamada quando o botão de reenviar email é clicado.
 */
function sendEmailLink(route) {
    window.location.href = route;
}

/**
 * Função que exibe o link "Solicitar Token" caso os elementos "sendEmail" e "timerText" não existam.
 */
function displayLinkResendToken(status) {
    const linkElement = document.getElementById("resendTokenLink");

    if (linkElement) {
        linkElement.style.display = status ? "block" : "none";
    }
}

// Função para enviar a solicitação de verificação do código
async function sendVerificationRequest(tokenValue, inputs) {
    try {
        const response = await fetch('/two-factor-auth/verify-json', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ '2fa_code': tokenValue })
        });

        const data = await response.json();

        // Se o status for false, pinta os inputs de vermelho
        if (data.status === false) {
            inputs.forEach(input => {
                input.style.borderColor = "red";
            });
        } else {
            inputs.forEach(input => {
                input.style.borderColor = "";
            });
        }

    } catch (error) {
        console.error('Erro ao verificar token.');
    }
}

/**
 * Função para configurar os eventos dos campos de input para o código 2FA.
 */
function setupCodeInputHandlers() {
    const hiddenInput = document.getElementById("2fa_code_hidden");
    const inputs = document.querySelectorAll(".code-input");

    inputs.forEach((input, index) => {
        // Adiciona evento de input para mover o foco e atualizar o campo oculto
        input.addEventListener("input", (e) => {
            handleInput(e, input, index, inputs);
            updateHiddenInput(inputs, hiddenInput);
        
            // Se o input atual estiver preenchido, move o foco para o próximo
            if (input.value.length === 1 && inputs[index + 1]) {
                inputs[index + 1].focus();
            }
        
            // Verifica o tokenValue e remove a borda vermelha se necessário
            const tokenValue = Array.from(inputs).map(input => input.value).join('');
        
            // Se o tokenValue for menor que o número de inputs, remove a borda vermelha
            if (tokenValue.length < inputs.length) {
                inputs.forEach(input => {
                    input.style.borderColor = "";
                });
            }
        
            // Envia a requisição de verificação quando todos os inputs estiverem preenchidos
            if (tokenValue.length === inputs.length) {
                sendVerificationRequest(tokenValue, inputs);
            }
        });

        // Adiciona evento de backspace para mover o foco
        input.addEventListener("keydown", (e) => handleBackspace(e, input, index, inputs));
    });

    // Adiciona evento de colar
    document.addEventListener("paste", (event) => {
        handlePaste(event, inputs, hiddenInput);

        // Envia a requisição de verificação após colar
        const tokenValue = Array.from(inputs).map(input => input.value).join('');
        if (tokenValue.length === inputs.length) {
            sendVerificationRequest(tokenValue, inputs);
        }
    });

    if (errorParagraph) {
        // Pintar os Inputs
        inputs.forEach((input) => {
            input.style.borderColor = "red";

            input.disabled = errorParagraph.textContent.includes("Usuário bloqueado") ? true : false;  
            input.style.backgroundColor = errorParagraph.textContent.includes("Usuário bloqueado") ? '#f8d7da' : '';  
        });
    }
}

/**
 * Função que atualiza o campo oculto com o código digitado.
 */
function updateHiddenInput(inputs, hiddenInput) {
    hiddenInput.value = Array.from(inputs)
        .map((input) => input.value)
        .join("");
}

/**
 * Função que manipula a entrada de dados nos inputs individuais.
 */
function handleInput(event, input, index, inputs) {
    if (event.inputType !== "deleteContentBackward") {
        if (input.value.length === 1 && inputs[index + 1]) {
            inputs[index + 1].focus();
        }
    }
}

/**
 * Função para apagar caracteres e mover o cursor para o input anterior.
 */
function handleBackspace(event, input, index, inputs) {
    if (event.key === "Backspace" && input.value === "" && inputs[index - 1]) {
        inputs[index - 1].focus();
        inputs[index - 1].value = "";
    }
}

/**
 * Função para colar o token inteiro de uma vez e distribuir os caracteres nos inputs.
 */
function handlePaste(event, inputs, hiddenInput) {
    event.preventDefault(); 
    let pastedText = (event.clipboardData || window.clipboardData).getData("text");
    pastedText = pastedText.replace(/\s+/g, "").slice(0, inputs.length);

    inputs.forEach((input, index) => {
        input.value = pastedText[index] || "";
    });

    updateHiddenInput(inputs, hiddenInput);

    const nextEmptyIndex =
        pastedText.length < inputs.length
            ? pastedText.length
            : inputs.length - 1;
    inputs[nextEmptyIndex]?.focus();
}