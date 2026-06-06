<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ArtiSync - Connexion</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
            <div class="text-center mb-8">
                @if(file_exists(public_path('LOGO.svg')))
                <img src="{{ asset('LOGO.svg') }}" alt="ArtiSync Logo" class="h-12 w-auto mx-auto">
                @else
                <h1 class="text-3xl font-bold" style="color: #95651A;">ArtiSync</h1>
                @endif
            </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <br>
                {{ $slot }}
                <br>
            </div>
        </div>
        <footer class="mt-auto text-center py-4 text-xs text-gray-400 border-t border-gray-200 bg-gray-100 w-full">
            2026 © ArtiSync - CMC CS
        </footer>
    </div>

</body>

</html>