<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="margin: 0; padding: 0;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Heladería Santa Rosa') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Reset CSS -->
        <link rel="stylesheet" href="{{ asset('css/reset.css') }}">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/heladeria.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="background-color: #ECCFD8; padding-top: 180px; margin: 0;">
        <div class="min-h-screen" style="width: 100%; overflow-x: hidden;">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header style="width: 100%; margin: 0;">
                    <div class="w-full">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
