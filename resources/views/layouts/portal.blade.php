<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal do Paciente - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased">
    <nav class="bg-white shadow">
        <div class="container mx-auto px-5 py-4 flex items-center justify-between">
            <a href="/" class="font-montserrat font-bold text-lg text-primary">
                {{ config('app.name') }}
            </a>
            <span class="text-sm text-gray-500 hidden sm:inline">Portal do Paciente</span>
        </div>
    </nav>

    <main class="container mx-auto px-5 py-8">
        {{ $slot }}
    </main>
</body>

</html>
