<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Left side with logo and background -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-r from-blue-800 to-indigo-900 justify-center items-center p-12">
                <div class="text-center">
                    <a href="/">
                        <x-login-logo class="w-auto h-32 mx-auto mb-8" />
                    </a>
                    <h1 class="text-4xl font-bold text-white mb-4">Syncore HR Management</h1>
                    <p class="text-white text-lg opacity-80">Sistem Manajemen Sumber Daya Manusia Terpadu</p>
                </div>
            </div>
            
            <!-- Right side with login form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 bg-gray-50">
                <!-- Logo for mobile view -->
                <div class="lg:hidden mb-8">
                    <a href="/">
                        <x-application-logo class="w-auto h-16" />
                    </a>
                </div>
                
                <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
