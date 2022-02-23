<x-app-layout>
    <x-slot name="css">
        {{-- <link rel="stylesheet" href="{{ asset('css/carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/glide.core.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/glide.theme.min.css') }}"> --}}
    <style>
        .links{
            width: 65%;
        }
        .links-white p{
            color: white !important;
        }
    </style>
    </x-slot>

    <x-slot name="scripts">
        <script src="{{ asset('js/glide.min.js') }}"></script>
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.dotdotdot/4.1.0/dotdotdot.js"
                integrity="sha512-y3NiupaD6wK/lVGW0sAoDJ0IR2f3+BWegGT20zcCVB+uPbJOsNO2PVi09pCXEiAj4rMZlEJpCGu6oDz0PvXxeg=="
                crossorigin="anonymous"></script>
    </x-slot>

    <div class="background_color_main"></div>

    <div class="w-full flex items-center justify-center">
        <x-search-bar.searcher :search="$search" />
    </div>


    <div class="flex flex-col w-full items-center 2xl:px-20 xl:px-20 sm:px-10 sm:py-8 px-4 pt-4 color_grisclaro redhat_regular text_responsive">
        <div class="border_gris rounded-lg flex flex-col justify-center items-center 2xl:p-20 xl:pt-20 lg:pt-16 md:pt-16 sm:p-8 p-4 resultsSearch_Main md:mb-0 mb-8">
            <x-max-results.main :contents="$contents" :search="$search" :typesContent="$types_content"/>
            <div class="links links-white mt-10">{{ $contents->links() }}</div>
        </div>
        <a href="{{ url()->previous() }}" class="mb-8 sm:mb-0 2xl:w-20 w-16">
            <x-button-back class="mx-auto text-white w-full" />
        </a>
    </div>







    {{-- <x-slot name="scriptsDown">
        
    </x-slot> --}}
</x-app-layout>
