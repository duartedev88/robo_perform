<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Minha Aplicação')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Tailwind CSS -->
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

<!-- Header -->
<header class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-indigo-600">Minha Aplicação</h1>
        <nav class="space-x-4">
            <a href="{{ route('privacidade') }}" class="text-gray-700 hover:text-indigo-600">Privacidade</a>
            <a href="{{ route('excluir-dados') }}" class="text-gray-700 hover:text-indigo-600">Excluir Dados</a>
        </nav>
    </div>
</header>

<!-- Conteúdo principal -->
<main class="container mx-auto px-4 py-8">
    @yield('content')
</main>

<!-- Rodapé -->
<footer class="bg-white border-t py-4 mt-10">
    <div class="container mx-auto px-4 text-sm text-gray-500 text-center">
        &copy; {{ date('Y') }} Minha Aplicação. Todos os direitos reservados.
    </div>
</footer>

</body>
</html>
