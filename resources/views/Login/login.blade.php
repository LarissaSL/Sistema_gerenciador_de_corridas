@extends('template.temporaryLoginTemplate')

@section('content')
    <form action="{{ route('login.auth') }}" method="POST" id="">
        @csrf

        @if (session('error') || Session::get('status'))
            <x-notify.error-notify :message="session('error')" :dismissible="true" />
        @endif

        {{-- Alertas Relacionados ao Request --}}
        @if($errors->any())
            @foreach($errors->all() as $error)
                <x-notify.error-notify :message="$error" :dismissible="true" />
            @endforeach
        @endif

        <div class="mb-3">
            {{-- Componente Livewire que checa se o Email é de um Administrador / Aqui fica o Label de Login --}}
            <livewire:login.check-email>
        </div>

        {{-- Customizavel , só não alterar os ID´s e se trocar o Icon, trocar no JS --}}
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" name="password" class="form-control" placeholder="Entre com sua senha">
                <div class="input-group-text" id="togglePassword" style="cursor: pointer;">
                    <ion-icon id="eyeIcon" name="eye-outline"></ion-icon>
                </div>
            </div>
        </div>

        <a href="{{ route('forgetPassword') }}">Esqueceu sua senha?</a>

        <div class="text-center d-grid">
            <button class="btn btn-primary" type="submit">Acessar</button>
        </div>

        <a href="{{ route('register') }}">Ainda não possui uma conta? <strong>Cadastre-se agora</strong></a>

    </form>
@endsection

@section('scripts')
    <script src="{{ URL::asset('assets/js/js-show-password.js') }}"></script>
@endsection

