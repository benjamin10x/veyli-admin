<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/images/logo.png'])
    @livewireStyles
</head>
<body>
    <main>
        @yield('content')
    </main>
    {{ $slot ?? '' }}

    @livewireScripts
</body>
</html>