<div>
    {{-- Verificando se tem email e se ele não é fechavel --}}
    @if ($existsEmail() && !$dismissible)
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <p>O código de verificação foi enviado para o email <strong>{{ $email }}</strong>.</p>
            <p>Caso não veja o email na sua caixa de entrada, verifique a pasta de spam ou lixo eletrônico.</p>
            <p>Se não receber o email em até 30 segundos, clique abaixo para reenviar o código.</p>

            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-dark mt-2" id="sendEmail" onclick="sendEmailLink('{{ route('twoFactorAuth.send') }}')">
                    <span id="timerText">30 segundos restantes...</span>
                </button>
            </div>
        </div>

    {{-- Se a notificação é fechavel --}}
    @elseif($dismissible)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    {{-- Notificação fechavel --}}
    @else
        <div class="alert alert-success" role="alert">
            <strong>{{ $message }}</strong>
        </div>
    @endif
</div>
