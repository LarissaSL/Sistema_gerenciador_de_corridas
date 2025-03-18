@extends('template.temporaryLoginTemplate')

<style>
    .code-container {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .code-input {
        flex: 1;
        width: 40px !important;
        font-weight: bold !important;
        text-align: center !important;
    }

</style>

@section('content')

    {{-- Notificações para o Usuário --}}
    @if (session('success'))
        <x-notify.sucess-notify :message="session('message')" :email="session('email')" :dismissible="session('dismissible')" />

    
    @elseif (session('error'))
        <x-notify.error-notify :message="session('message')" :dismissible="session('dismissible')"/>
    @endif

    <form action="{{ route('twoFactorAuth.verify') }}" method="GET">
        @csrf
        <div class="mb-3">
            <div class="d-flex w-100 code-container justify-content-space-between flex-1">
                @for ($i = 1; $i <= $sizeToken; $i++)
                    <input class="form-control code-input" type="text" maxlength="1" required>
                @endfor
            </div>


            <!-- Campo oculto que armazenará o código completo -->
            <input type="hidden" name="2fa_code" id="2fa_code_hidden">

            <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
        </div>

        <div class="mb-3" id="sendEmailContainer">
            <a id="resendTokenLink" href="{{ route('twoFactorAuth.send') }}" class="text" style="display: none;">Reenviar token</a>
        </div>

        <div class="text-center d-grid">
            <button class="btn btn-primary" type="submit">Verificar Código</button>
        </div>
    </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('assets/js/js-two-auth-login.js') }}"></script>
@endsection
