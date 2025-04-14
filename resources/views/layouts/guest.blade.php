<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" type='text/css' href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css" />

        <!-- Meta Tags -->
        <x-prezet::meta />

        <!-- favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>
    <body class="min-h-screen">
        <livewire:navigation />

        <!-- Page Content -->
        <flux:main container class="px-8 mt-4">
            @if (isset($header))
                <div class="flex justify-between">
                    <div class="w-full sm:w-auto">
                        <h5 class="text-2xl lg:text-4xl font-bold">
                            {{ $header }}
                        </h5>
                    </div>
                    <div class="flex">
                        <x-socials />
                    </div>
                </div>  
                
                <flux:separator class="mt-2 mb-1" />
            @endif

            <div class="mt-2">
                {{ $slot }}
            </div>
        </flux:main>

        @persist('toast')
            <flux:toast />
        @endpersist

        @fluxScripts
    </body>
</html>
