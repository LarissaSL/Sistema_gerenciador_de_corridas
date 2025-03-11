<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Meu Site')</title>
    
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- Ionicons --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    @yield('imports')
    <style>
        {{-- Footer sempre no fim da página --}}
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .container {
            flex: 1;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <div class="container mt-4">
        @yield('content')
    </div>
    
    <footer class="bg-dark text-white text-center py-3 mt-5">
        &copy; 2025 Meu Site - Todos os direitos reservados.
    </footer>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    @yield('scripts')

</body>
</html>
