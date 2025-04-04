document.addEventListener('DOMContentLoaded', () => {
    const sendEmailBtn = document.getElementById('sendEmailBtn');
    const emailInput = document.getElementById('email');
    const btnText = document.getElementById('btnText');
    const btnLoading = document.getElementById('btnLoading');
    const csrfToken = document.querySelector('input[name="csrf_token"]').value;
    const alertsContainer = document.querySelector('div.alerts-container');

    const showAlert = (type, message, isDismissible = false) => {
        alertsContainer.innerHTML = '';
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} ${isDismissible ? 'alert-dismissible fade show' : ''}`;
        alertDiv.role = 'alert';
        
        if (isDismissible) {
            alertDiv.innerHTML = `
                <p>${message}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
        } else {
            alertDiv.innerHTML = `<strong>${message}</strong>`;
        }
        
        alertsContainer.appendChild(alertDiv);
    };

    const toggleButtonState = (isLoading, text = null) => {
        sendEmailBtn.disabled = isLoading;
        if (isLoading) {
            btnText.classList.add('d-none');
            btnLoading.classList.remove('d-none');

            if (text) {
                btnLoading.innerHTML = `
                    <span class="spinner-border spinner-border-sm" role="status"></span>
                    ${text}
                `;
            }
        } else {
            btnText.classList.remove('d-none');
            btnLoading.classList.add('d-none');
            if (text) btnText.textContent = text;
        }
    };

    const handleResponse = async (response) => {
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Erro no servidor');
        }
        return data;
    };

    sendEmailBtn.addEventListener('click', async () => {
        const email = emailInput.value.trim();

        if (!email || !email.includes('@')) {
            showAlert('danger', 'Por favor, insira um e-mail válido.', true);
            return;
        }

        try {
            toggleButtonState(true, 'Enviando...');
            
            const response = await fetch(sendEmailBtn.dataset.url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email })
            });

            const data = await handleResponse(response);

            if (data.success) {
                showAlert('success', data.message || 'E-mail enviado com sucesso');
                
                // Ativa estado de espera
                toggleButtonState(true, 'Aguarde 60s para reenviar o e-mail');
                
                let secondsLeft = 60;
                const timerInterval = setInterval(() => {
                    secondsLeft--;
                    btnLoading.innerHTML = `
                        <span class="spinner-border spinner-border-sm" role="status"></span>
                        Aguarde ${secondsLeft}s para reenviar o e-mail
                    `;
                    
                    if (secondsLeft <= 0) {
                        clearInterval(timerInterval);
                        toggleButtonState(false, 'Reenviar e-mail');
                    }
                }, 1000);
                
            } else {
                showAlert('danger', data.message || 'Erro desconhecido', true);
                toggleButtonState(false, 'Enviar e-mail');
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            showAlert('danger', error.message || 'Ocorreu um erro inesperado', true);
            toggleButtonState(false, 'Enviar e-mail');
        }
    });
});