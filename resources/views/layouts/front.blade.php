<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Clinica Focal</title>

    <!-- Styles -->
    @vite(['resources/css/app.css'])
</head>

<body class="font-sans text-gray-700 bg-gray-50 overflow-x-hidden">
    <!-- Botão WhatsApp -->
    <a href="https://api.whatsapp.com/send?phone=55{{ whatsapp_link() }}" class="whatsapp-button" target="_blank">
        <i class="fab fa-whatsapp"></i>
        <div class="tooltip">Fale conosco!</div>
    </a>
    <!-- Header -->
    <livewire:front.components.header />

    {{ $slot }}
    <!-- Footer -->
    <livewire:front.components.footer />

    @vite(['resources/js/app.js'])   
</body>

</html>
