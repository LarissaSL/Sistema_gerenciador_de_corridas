@extends('template.forgotPasswordTemplate')

@section('content')
    <a href="{{ route('login.home') }}">
        <ion-icon name="arrow-back-outline"></ion-icon>
    </a>

    <h1>Recuperar Acesso</h1>
    <p>Preencha abaixo com seu email para receber as instruções necessárias para criar uma nova senha</p>

    <div class="alerts-container">
        @if (session('error') || Session::get('status'))
            <x-notify.error-notify :message="session('error')" :dismissible="true" />
        @endif

        {{-- Alertas Relacionados ao Request --}}
        @if($errors->any())
            @foreach($errors->all() as $error)
                <x-notify.error-notify :message="$error" :dismissible="true" />
            @endforeach
        @endif
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', isset($email) ? $email : '') }}" class="form-control" placeholder="Digite seu e-mail">
    </div>

    <div class="text-center d-grid">
        <button id="sendEmailBtn" class="btn btn-primary" data-url="{{ route('forgetPassword.sendEmail') }}">
            <span id="btnText">Enviar e-mail</span>
            <span id="btnLoading" class="d-none"></span>
        </button>
    </div>

    <a href="{{ route('login.home') }}">Lembrou da sua senha? <strong>Faça o login</strong></a>

    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">


    @section('scripts')
        <script src="{{ URL::asset('assets/js/js-send-forgotPassword.js') }}"></script>
    @endsection

@endsection
