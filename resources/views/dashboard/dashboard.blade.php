@extends('template.appTemplate')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <a href="">
        <ion-icon name="arrow-back-outline"></ion-icon>
    </a>

    <h1>Dashboard</h1>

    @if (session('error'))
        <x-notify.error-notify :message="session('error')" :dismissible="true" />
    @endif

    @if (session('success'))
        <x-notify.sucess-notify :message="session('success')" :dismissible="true" />
    @endif

    {{-- Alertas Relacionados ao Request --}}
    @if($errors->any())
        @foreach($errors->all() as $error)
            <x-notify.error-notify :message="$error" :dismissible="true" />
        @endforeach
    @endif

    <h3>Bem-vindo de volta!</h3>
    
    <a href="">Consultar lista de pilotos cadastrados</a>
    <a href="">Cadastrar uma nova corrida</a>
    <a href="">Cadastrar um novo campeonato</a>

@endsection


@section('scripts')

    <script>
       window.evolutionAnnualRoute = "{{ route('dashboard.evolution.annual', ['year' => 2025, 'month' => '']) }}";
       window.financeDataRoute = "{{ route('dashboard.finance.data') }}";
       window.racesDataRoute = "{{ route('dashboard.races.data') }}";
    </script>

    <script src={{ URL::asset('assets/js/js-evolutionAnnual.js') }}></script>
    <script src={{ URL::asset('assets/js/js-financeData.js') }}></script>
    <script src={{ URL::asset('assets/js/js-racesData.js') }}></script>
@endsection
