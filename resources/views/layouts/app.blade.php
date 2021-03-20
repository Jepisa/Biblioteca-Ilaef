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
        <link rel="stylesheet" href="{{ asset('css/carousel.css') }}">
        <link rel="stylesheet" href="{{ asset('css/glide.core.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/glide.theme.min.css') }}">

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/layout-app.css') }}">

        <!-- Scripts -->
        {{ $scripts }}
        
        <script src="{{ asset('js/app.js') }}" defer></script>


    </head>
    <body class="">
        <div class="min-h-screen">
            <div class="py-2">
                @include('layouts.navigation')
            </div>

            <!-- Page Heading -->
                {{-- <header class="bg-white shadow mt-20">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header> --}}

            <!-- Page Content -->
            <main style="min-height:calc(100vh - 72px - 60px)">
                {{ $slot }}
            </main>
            <footer class="">
                {{-- <div class="flex m-auto h-full" style="width:79.5%">
                    <div class="w-6/12 h-full flex justify-start items-center">
                        <div class="flex mr-3">
                            <div class="mr-1">\*/</div><!-- Icono de ubicación -->
                            <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro.</div>
                        </div>
                        <div class="flex">
                            <div class="mr-1">\*/</div><!-- Icono de ubicación -->
                            <div>+54 9 11 5745-0850</div>
                        </div>
                    </div>
                    <div class="w-3/12 h-full flex justify-center items-center">
                        <a href="{{ route('home') }}"></a>
                    </div>
                    <div class="redes-sociales w-3/12 h-full"></div>
                </div> --}}
            </footer>
        </div>
        {{ $scriptsDown }}
    </body>
</html>
