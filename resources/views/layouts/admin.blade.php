<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <title>{!! get_option('title_site') !!} </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-50">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="md:w-64 bg-white border-r hidden md:block" id="sidebar">
            <div class="p-4 flex items-center">
                <img src="{{ asset('storage' . get_option('logo_site')) }}" alt="Logo" class="h-8 px-2">
                <san>{!! get_option('title_site') !!}</san>
            </div>
            <livewire:layout.admin-navigation />
        </aside>
        <div class="flex-1 flex flex-col">
            {{-- Header --}}
            <header class="h-16 bg-white border-b flex items-center justify-between px-6">
                <button class="md:hidden" id="btn-menu"><i class="fa-solid fa-bars"></i></button>               
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-bell"></i>
                    <div class="w-10 h-10 bg-black text-white flex items-center justify-center rounded-full">A</div>
                </div>
            </header>
            {{-- Conteúdo --}}
            <main class="p-8 flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
    @vite(['resources/js/app.js'])    
</body>

</html>
