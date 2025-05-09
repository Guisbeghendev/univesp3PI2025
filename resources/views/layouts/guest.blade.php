<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Responsivo -->
    <title>@yield('title', 'Bem-vindo')</title>

    <!-- Estilos e Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col w-full m-0 p-0">

{{-- Cabeçalho global --}}
@include('layouts.partials.header')

{{-- Navbar visitante --}}
@include('layouts.partials.navbar-guest')

{{-- Conteúdo principal --}}
<main class="flex-grow w-full">
    <div class="w-full max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">  <!-- Garantindo padding em telas menores -->
        @yield('content')
    </div>
</main>

{{-- Rodapé global --}}
@include('layouts.partials.footer')

</body>
</html>
