<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">@yield('title')</h1>
    @if(session('success'))
        <div class="bg-green-200 text-green-900 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @yield('content')
</div>
</body>
</html>
