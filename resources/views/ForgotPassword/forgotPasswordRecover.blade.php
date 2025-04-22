@extends('template.forgotPasswordTemplate')


@section('title')
    {{ $title }}
@endsection

@section('styles')
<style>
    .strength-segments {
        height: 5px;
    }

    .strength-segment {
        transition: background-color 0.6s ease;
        border-radius: 2px;
    }

</style>

@endsection

@section('content')
    <a href="{{ route('login.home') }}">
        <ion-icon name="arrow-back-outline"></ion-icon>
    </a>

    <h1>Crie uma nova senha</h1>

    {{-- Alertas Relacionados ao Request --}}
    @if($errors->any())
        @foreach($errors->all() as $error)
        <x-notify.error-notify :message="$error" :dismissible="true" />
        @endforeach
    @endif

    @if (session('error'))
        <x-notify.error-notify :message="session('message')" :dismissible="true" />
    @endif

    <form action="{{ route('forgetPassword.updatePassword' , ['token' => $token]) }}" method="post">
        @csrf

        <div class="mb-3">
            <label for="password" class="form-label">Nova Senha</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" name="password" class="form-control" placeholder="Digite sua nova senha" autocomplete="new-password">
                <div class="input-group-text" id="togglePassword" style="cursor: pointer;">
                    <ion-icon id="eyeIcon" name="eye-outline"></ion-icon>
                </div>
            </div>

            <!-- Regras da senha -->
            <div id="password-rules" class="mt-3">
                <p class="mb-1"><small>Senha deve conter:</small></p>
                <ul class="list-unstyled">
                    <li id="rule-length" class="text-danger">
                        <small><span class="bi bi-x-circle-fill"></span> 8 caracteres ou mais</small>
                    </li>
                    <li id="rule-uppercase" class="text-danger">
                        <small><span class="bi bi-x-circle-fill"></span> Letras maiúsculas</small>
                    </li>
                    <li id="rule-lowercase" class="text-danger">
                        <small><span class="bi bi-x-circle-fill"></span> Letras minúsculas</small>
                    </li>
                    <li id="rule-number" class="text-danger">
                        <small><span class="bi bi-x-circle-fill"></span> Números</small>
                    </li>
                    <li id="rule-special" class="text-danger">
                        <small><span class="bi bi-x-circle-fill"></span> Caracteres especiais</small>
                    </li>
                </ul>
            </div>

            <!-- Barra de progresso segmentada -->
            <div class="password-strength-container mt-2">
                <div class="strength-segments d-flex gap-1">
                    <div id="strength-segment-1" class="strength-segment flex-fill" style="height: 5px; background-color: #e9ecef;"></div>
                    <div id="strength-segment-2" class="strength-segment flex-fill" style="height: 5px; background-color: #e9ecef;"></div>
                    <div id="strength-segment-3" class="strength-segment flex-fill" style="height: 5px; background-color: #e9ecef;"></div>
                    <div id="strength-segment-4" class="strength-segment flex-fill" style="height: 5px; background-color: #e9ecef;"></div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Repetir Nova Senha</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Repita sua nova senha">
                <div class="input-group-text" id="togglePasswordConfirmation" style="cursor: pointer;">
                    <ion-icon id="eyeIconConfirmation" name="eye-outline"></ion-icon>
                </div>
            </div>
            <div id="password-match-feedback" class="mt-1" style="display: none;">
                <small class="text-danger"><span class="bi bi-x-circle-fill"></span> As senhas não coincidem</small>
            </div>
        </div>

        <div class="text-center d-grid">
            <button type="submit" id="submitBtn" class="btn btn-primary" disabled>
                Redefinir Senha
            </button>
        </div>
    </form>

    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">

    @section('scripts')
        <script src="{{ URL::asset('assets/js/js-recover-forgotPassword.js') }}"></script>
    @endsection
@endsection
