{{-- <x-guest-layout>
    <style>
        .w-input-form{
            width: 49%;
        }
    </style>
@auth
    @programmer
        @include('layouts.navigation')
    @endprogrammer
@endauth

    <div class="min-h-screen flex justify-center items-center pt-6 sm:pt-0 bg-gray-100 ">
        <div class="flex flex-col w-full md:w-10/12 lg:w-8/12 my-4">
            <div class="flex justify-between mx-1">
                <div>
                    <a href="/">
                        <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 fill-current text-gray-500">
                            <path d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.71 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.485C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.38 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.89 81.495 305.8 81.125ZM144.2 227.205L100.57 202.515L146.39 176.135L196.66 147.195L240.33 172.335L208.29 190.625L144.2 227.205ZM244.75 114.995V164.795L226.39 154.225L201.03 139.625V89.825L219.39 100.395L244.75 114.995ZM249.12 57.105L292.81 82.265L249.12 107.425L205.43 82.265L249.12 57.105ZM114.49 184.425L96.13 194.995V85.305L121.49 70.705L139.85 60.135V169.815L114.49 184.425ZM91.76 27.425L135.45 52.585L91.76 77.745L48.07 52.585L91.76 27.425ZM43.67 60.135L62.03 70.705L87.39 85.305V202.545V202.555V202.565C87.39 202.735 87.44 202.895 87.46 203.055C87.49 203.265 87.49 203.485 87.55 203.695V203.705C87.6 203.875 87.69 204.035 87.76 204.195C87.84 204.375 87.89 204.575 87.99 204.745C87.99 204.745 87.99 204.755 88 204.755C88.09 204.905 88.22 205.035 88.33 205.175C88.45 205.335 88.55 205.495 88.69 205.635L88.7 205.645C88.82 205.765 88.98 205.855 89.12 205.965C89.28 206.085 89.42 206.225 89.59 206.325C89.6 206.325 89.6 206.325 89.61 206.335C89.62 206.335 89.62 206.345 89.63 206.345L139.87 234.775V285.065L43.67 229.705V60.135ZM244.75 229.705L148.58 285.075V234.775L219.8 194.115L244.75 179.875V229.705ZM297.2 139.625L253.49 164.795V114.995L278.85 100.395L297.21 89.825V139.625H297.2Z"/>
                        </svg>
                    </a>
                </div>
                <div class="flex items-center">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}"> {{ __('¿Ya tienes una cuenta?') }} </a>
                </div>
            </div>
        
            <div class="flex w-full mt-4  shadow-md overflow-hidden sm:rounded-lg">
                <div class=" bg-gradient-to-r from-green-400 to-blue-500  hidden md:w-6/12 md:flex md:items-center">
                    <div class="">
                        
                    </div>
                </div>

                <div class="w-full md:w-6/12 px-6 py-4 bg-white  ">
                    @livewire('register', ['countries' => $countries, 'occupations' => $occupations, 'referrers' => $referrers, 'roles' => (isset($roles))? $roles : ''])
                </div>
            </div>
        </div>
    </div>

    @if (Session()->exists('notification'))
        <div id="notification" class="flex bg-green-200 max-w-sm md:max-w-md mb-4" style="display:none; cursor:pointer; right: -150vw; top:5px; position:fixed; transition: right 2s;">
            <div class="w-16 bg-green-400">
                <div class="p-4">
                    <svg class="h-8 w-8 text-white fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M468.907 214.604c-11.423 0-20.682 9.26-20.682 20.682v20.831c-.031 54.338-21.221 105.412-59.666 143.812-38.417 38.372-89.467 59.5-143.761 59.5h-.12C132.506 459.365 41.3 368.056 41.364 255.883c.031-54.337 21.221-105.411 59.667-143.813 38.417-38.372 89.468-59.5 143.761-59.5h.12c28.672.016 56.49 5.942 82.68 17.611 10.436 4.65 22.659-.041 27.309-10.474 4.648-10.433-.04-22.659-10.474-27.309-31.516-14.043-64.989-21.173-99.492-21.192h-.144c-65.329 0-126.767 25.428-172.993 71.6C25.536 129.014.038 190.473 0 255.861c-.037 65.386 25.389 126.874 71.599 173.136 46.21 46.262 107.668 71.76 173.055 71.798h.144c65.329 0 126.767-25.427 172.993-71.6 46.262-46.209 71.76-107.668 71.798-173.066v-20.842c0-11.423-9.259-20.683-20.682-20.683z"/><path d="M505.942 39.803c-8.077-8.076-21.172-8.076-29.249 0L244.794 271.701l-52.609-52.609c-8.076-8.077-21.172-8.077-29.248 0-8.077 8.077-8.077 21.172 0 29.249l67.234 67.234a20.616 20.616 0 0 0 14.625 6.058 20.618 20.618 0 0 0 14.625-6.058L505.942 69.052c8.077-8.077 8.077-21.172 0-29.249z"/></svg>
                </div>
            </div>
            <div class="w-auto text-gray-500 items-center p-4">
                <span class="text-lg font-bold pb-4">
                    {{ __('Felicidades') }}
                </span>
                <p class="leading-tight">
                    {{ Session()->get('notification') }}
                </p>
            </div>
        </div>
    @endif
</x-guest-layout> --}}
<div class="background_container lg:fixed lg:h-screen fixed overflow-hidden flex fade-in-1_2">
    <div class="background_register h-full w-full xl:w-1/2"></div>
    {{-- <div class="xl:w-1/2"></div>
    <div class="xl:w-1/2"></div>
        <img src="{{ asset('img/assets/register/register_desktop.jpg') }}" class="hidden xl:block object-cover h-full w-full">
        <img src="{{ asset('img/assets/register/register_tablet.jpg') }}" class="hidden md:block xl:hidden object-cover h-full w-full">
        <img src="{{ asset('img/assets/register/register_mobile.jpg') }}" class="hidden md:hidden object-cover h-full w-full">
    </div> --}}
    <div class="bg-white xl:w-7/12 h-full xl:block hidden"></div>
</div>
<x-guest-layout>
    <x-auth-card logoJustify="justify-start" class="lg:pt-80 lg:-mb-20 xl:pt-10 xl:-mb-0 pt-72">
        <div class="flex items-center justify-between w-full hidden lg:flex lg:mb-4 lg:mt-20">
            <a href="/">
                <x-application-logo class="w-20 w-32 fill-current text-gray-500" />
            </a>
            <div class="color_azuloscuro flex items-center justify-between sm:mt-0 mt-4">
                {{ __('¿Ya tienes una cuenta?') }}
                <a href="/login"
                    class="btn py-1 px-2 ml-4 bg-white ra-md rounded-md border border-gray-500 hover:bg-gray-100">Iniciar
                    Sesión</a>
            </div>
        </div>


        <x-auth-card_body
            class="p-4 sm:p-10 2xl:p-20 mx-4 sm:mx-10 xl:p-14 2xl:mx-20 xl:mx-14 bg-white xl:bg-transparent">
            <div class="sm:rounded-lg px-5 xl:p-8 2xl:p-10 h-fit 2xl:w-6/12 xl:w-6/12 w-full">
                <div class="sm:flex block items-center justify-between w-full text_responsive lg:hidden">
                    <a href="/" class="flex justify-center">
                        <x-application-logo class="w-20 w-32 fill-current text-gray-500" />
                    </a>
                    <div class="color_azuloscuro flex items-center justify-between sm:mt-0 mt-4">
                        {{ __('¿Ya tienes una cuenta?') }}
                        <a href="/login"
                            class="btn py-1 px-2 ml-4 bg-white ra-md rounded-md border border-gray-500">Iniciar
                            Sesión</a>
                    </div>
                </div>
                <div class="color_azuloscuro letterSpace-20 mt-4 md:mt-10">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    @livewire('register', ['countries' => $countries, 'occupations' => $occupations, 'referrers' =>
                    $referrers, 'roles' => (isset($roles))? $roles : ''])

                </div>
            </div>
        </x-auth-card_body>
    </x-auth-card>

    <div class="w-full items-center justify-center flex mb-8">
        <div class="w-1/2 hidden xl:block"></div>
        <a href="/" class="xl:w-1/2 xl:pr-20 xl:block">
            <x-button-back class="mx-auto text-white md:w-20 w-16 " color="#91091e" />
        </a>
    </div>

    @if (Session()->exists('notification'))
        <div x-data="{ open: true }" @click.away="open = false" @close.stop="open = false" class="">
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="flex items-center justify-center fixed left-0 bottom-0 w-full h-full z-50"
                style="display: none;">
                <div class="rounded-md shadow-lg bg-white color_azuloscuro modal_container flex justify-center items-center "
                    @click.away="open = false">
                    <div class="modal_inner flex flex-col items-center justify-center">
                        <div class="flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" id='favorites' height="50" viewBox="0 0 24 24"
                                width="50">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" />
                            </svg>
                        </div>
                        <p class="font-bold text-base md:text-center">
                            Registro realizado con éxito.
                        </p>
                        <p class="text-md md:text-center">
                            Por favor revisa tu correo electrónico.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    @endif

</x-guest-layout>


<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        var notification = document.querySelector('#notification');

        if (notification) {

            notification.style.display = "flex";

            setTimeout(() => {
                notification.style.right = "10px";
            }, 500);
            setTimeout(() => {
                notification.style.transition = "right 0.5s";
                notification.style.right = "1px";
            }, 2500);

            setTimeout(() => {
                sacarLaNotificacion();
            }, 5000);

            notification.addEventListener('click', (event) => {
                sacarLaNotificacion();
            });


            function sacarLaNotificacion() {
                notification.style.pointerEvents = "none";
                setTimeout(() => {
                    notification.style.right = "10px";
                }, 500);
                setTimeout(() => {
                    notification.style.transition = "right 2s";
                    notification.style.right = "-150vw";
                }, 1000);
                setTimeout(() => {
                    notification.remove();
                }, 3500);
            }

        }
    });
</script>
