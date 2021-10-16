
<div class="background_container lg:fixed lg:h-screen fixed overflow-hidden flex fade-in-1_2">
    <div class="background_register h-full w-full xl:w-1/2"></div>
    <div class="bg-white xl:w-7/12 h-full xl:block hidden"></div>
</div>
<x-guest-layout>
    <x-auth-card logoJustify="justify-start" class="lg:pt-80 lg:-mb-20 xl:pt-10 xl:-mb-0 pt-72">
        <div class="flex items-center justify-between w-full hidden lg:flex lg:mb-4 lg:mt-20">
            <a href="{{ route('home') }}">
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
                    <a href="{{ route('home') }}" class="flex justify-center">
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
        <a href="{{ route('home') }}" class="xl:w-1/2 xl:pr-20 xl:block">
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
