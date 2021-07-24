<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 md:w-56 w-32 xl:w-48 2xl:w-48 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <div class="color_azuloscuro letterSpace-20 form_login">

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    
                    <x-input id="email" class="block w-full" type="email" name="email"
                    :value="old('email', $request->email)" required autofocus />
                    <x-label for="email" :value="__('Email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                    <x-label for="password" :value="__('Password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
                    <x-label for="password_confirmation" :value="__('Confirm Password')" class="mt-2" />
                </div>

                <div class="flex mt-8 ">
                    <x-button class="w-full background_azuloscuro redhat_bold flex justify-center letterSpace-20 mb-0">
                        {{ __('Reset Password') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
