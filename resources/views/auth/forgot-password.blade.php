<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ route('home') }}">
                <x-application-logo class="w-20 md:w-56 w-32 xl:w-40 2xl:w-48 fill-current text-gray-500" />
            </a>
        </x-slot>

        <x-auth-card_body class="p-4 sm:p-10 xl:p-14 2xl:p-20 mx-4 sm:mx-10 xl:p-14 xl:p-14 2xl:mx-20 xl:mx-14">
            <div class="sm:rounded-lg p-5 xl:p-8 2xl:p-10 h-fit 2xl:w-5/12 xl:w-6/12 w-full">
                <div class="color_azuloscuro letterSpace-20">
                    <div class="mb-4 text-sm text-gray-600">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required autofocus />
                        </div>

                        <div class="flex mt-8 md:mt-8 ">
                            <x-button
                                class="w-full background_azuloscuro redhat_bold flex justify-center letterSpace-20 mb-0">
                                {{ __('Email Password Reset Link') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </x-auth-card_body>
    </x-auth-card>
</x-guest-layout>
