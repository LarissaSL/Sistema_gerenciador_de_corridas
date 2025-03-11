@extends('template.temporaryLoginTemplate')

@section('content')
    <form action="{{ route('login.auth') }}" method="POST" id="">
        @csrf

        <div class="text-center mt-3">
            <p class="text-danger font-16">{{ Session::get('status') }}</p>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{session('error')}}
            </div>
        @endif

        <!-- Exibir alerta de sucesso ou erro -->
        {!! session('alerta') !!}

        {{-- Alertas Relacionados ao Request --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            {{-- Componente Livewire que checa se o Email é de um Administrador --}}
            <livewire:login.check-email>
        </div>

        {{-- Customizavel , só não alterar os ID´s e se trocar o Icon, trocar no JS --}}
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" name="password" class="form-control"
                    placeholder="Entre com sua senha">
                <div class="input-group-text" id="togglePassword" style="cursor: pointer;">
                    <ion-icon id="eyeIcon" name="eye-outline"></ion-icon>
                </div>
            </div>
        </div>
        
        <div class="text-center d-grid">
            <button class="btn btn-primary" type="submit">Acessar</button>
        </div>
        
    </form>
@endsection

@section('scripts')
    <script src="{{ URL::asset('assets/js/js-show-password.js') }}"></script>
@endsection

