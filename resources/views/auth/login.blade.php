<div class="background_container overflow-hidden">
    <div class="h-full">
        <img src="{{ asset('img/assets/login/login_desktop.jpg') }}" class="hidden xl:block object-cover h-full w-full">
        <img src="{{ asset('img/assets/login/tablet_login.jpg') }}" class="hidden md:block xl:hidden tablet_login object-cover h-full w-full">
        <img src="{{ asset('img/assets/login/celular_login.jpg') }}" class="block md:hidden object-cover h-full w-full">
    </div>
    {{-- <div class="bg-white"></div> --}}
</div>

<x-guest-layout>
    <x-auth-card class="mt-0 md:mt-auto lg:mt-0 md:-mb-72 -mb-0 xl:-mb-0 lg:mx-20 pt-24 sm:pt-4">
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 md:w-40 w-32 xl:w-40 2xl:w-40 fill-current text-gray-500" />
            </a>
        </x-slot>

        <x-auth-card_body class="p-4 sm:p-10 2xl:p-20 mx-4 sm:mx-10 xl:p-10 2xl:mx-20 xl:mx-14">
            <div class="sm:rounded-lg p-5 xl:p-8 2xl:p-10 h-fit 2xl:w-5/12 xl:w-6/12 w-full">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="color_azuloscuro letterSpace-20 form_login">
                        <!-- Email Address -->
                        <div>


                            <x-input id="email" class="block w-full" type="email" name="email" :value="old('email')"
                                required autofocus />
                            <x-label for="email" :value="__('Email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">


                            <x-input id="password" class="block  w-full" type="password" name="password" required
                                autocomplete="current-password" />
                            <x-label for="password" :value="__('Password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="mt-8 xl:mt-16 sm:flex lg:block xl:flex justify-between items-center letterSpace-20">
                            <div>
                                <label for="remember_me" class="items-center cursor-pointer flex">
                                    <input id="remember_me" type="checkbox"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        name="remember">
                                    <div class="ml-2 text-gray-600">{{ __('Remember me') }}</div>
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <div class="xl:mt-0 lg:mt-4 sm:mt-0 mt-4">
                                    <a class="underline text-gray-600 hover:text-gray-900 "
                                        href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="flex mt-8 md:mt-16 ">
                            <x-button
                                class="w-full background_azuloscuro redhat_bold flex justify-center letterSpace-20 mb-0">
                                {{ __('Login') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </x-auth-card_body>
        <div class="w-full items-center justify-center flex mt-8">
            <div class="w-1/2 mx-auto hidden xl:block"></div>
            <a href="/" class="w-full xl:w-1/2 block">
                <x-button-back class="mx-auto text-white 2xl:w-20 w-16" color="#91091E" />
            </a>
        </div>

    </x-auth-card>
</x-guest-layout>
