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
        <script src="https://kit.fontawesome.com/93ee6606b0.js" crossorigin="anonymous"></script>
        {{ $scripts }}
        
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
            <main style="min-height:calc(100vh - 72px - 60px)">
                {{ $slot }}
            </main>
            <footer class="">
                <div class="foot flex m-auto h-full w-full" >
                    <div class="direction-contact w-6/12 h-full flex justify-center items-center">
                        <div class="direction flex mr-10">
                            <div class="mr-1"><i class="fas fa-map-marker-alt"></i></div><!-- Icono de ubicación -->
                            <div>201 Ahambra Circle Suite 1205 Coral Gables, FL33134</div>
                        </div>
                        <div class="telephone flex">
                            <div class="mr-1"><i class="fas fa-phone-alt"></i></div><!-- Icono de ubicación -->
                            <div>+54 9 11 5745-0850</div>
                        </div>
                    </div>
                    <div class="logo-footer w-3/12 h-full flex justify-center items-center">
                        <a style="width: 155px; padding-top: 10px;" href="{{ route('home') }}"><img src="{{ asset('img/logo-letras-blancas.png') }}"></a>
                    </div>
                    <div class="redes-sociales w-3/12 h-full flex justify-center items-center">
                        <a href=""><i class="fab fa-facebook-square"></i></a>
                        <a href=""><i class="fab fa-twitter-square"></i></a>
                        <a href=""><i class="fab fa-instagram-square"></i></a>
                        <a href=""><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </footer>
        </div>
        {{ $scriptsDown }}
    </body>
</html>
