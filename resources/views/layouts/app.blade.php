<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de Productos</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    @auth
        <span>{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button>Salir</button>
        </form>
    @endauth

    {{ $slot }}
</body>
</html>
