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

        @include('layouts.prezet')

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/prezet.css'])
        @fluxAppearance
    </head>
    <body class="min-h-screen">
        <livewire:navigation />

        <!-- Page Content -->
        <flux:main container>
            <div class="relative mx-auto flex w-full max-w-8xl flex-auto justify-center sm:px-2 lg:px-8 xl:px-12">
                <div class="min-w-0 max-w-2xl flex-auto px-4 py-4 lg:max-w-none lg:pl-8 lg:pr-0 xl:px-16">
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
                        
                        <flux:separator />
                    @endif

                    {{ $slot }}
                </div>
            </div>
        </flux:main>

        @persist('toast')
            <flux:toast />
        @endpersist

        @fluxScripts
    </body>
</html>
