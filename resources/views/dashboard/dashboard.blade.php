@extends('template.temporaryLoginTemplate')

@section('content')
    <a href="{{ route('login.home') }}">
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


    <h3>Seja bem-vindo(a) {{ $userName }}</h3>

@endsection

@section('scripts')

@endsection
