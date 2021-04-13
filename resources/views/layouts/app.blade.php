<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Text:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/layout-app.css') }}">

        {{ $css ?? '' }}


        <!-- Scripts -->
        <script src="https://kit.fontawesome.com/93ee6606b0.js" crossorigin="anonymous"></script>
        {{ $scripts ?? '' }}
        
        <script src="{{ asset('js/app.js') }}" defer></script>


    </head>
    <body class="">
        <div class="min-h-screen">
            @include('layouts.navigation')
       
            <!-- Page Heading -->
                {{-- <header class="bg-white shadow mt-20">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header> --}}

            <!-- Page Content -->
            <main class="content-main">
                {{ $slot }}
            </main>
            <x-footer-principal />
        </div>
        {{ $scriptsDown ?? ''}}
    </body>
</html>
