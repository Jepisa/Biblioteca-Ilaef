<x-app-layout>
    <x-auth-card>
        <x-auth-card_body class="p-4 sm:p-10 2xl:px-20 2xl:py-10 mx-4 sm:mx-10 xl:mx-8 xl:p-8 2xl:mx-14 xl:bg-transparent bg-white">
            <div class="sm:rounded-lg p-5 xl:p-8 2xl:p-10 h-fit 2xl:w-5/12 xl:w-6/12 w-full">
                <div class="contact_container">
                    <div class="background_color"></div>
                    <div class="background_contact"></div>
                    <form method="POST" action="">
                        @csrf
                        <div class="color_azuloscuro letterSpace-20 form_contact grid grid-cols-4 gap-5">

                            {{-- NOMBRE Y APELLIDO --}}
                            <div class="col-span-4 flex items-center grid grid-cols-2 gap-5">
                                <div class="col-span-1">
                                    <x-input id="email" class="block  w-full" type="email" name="email"
                                        :value="old('email')" required />
                                    <x-label for="email" :value="__('Name')" class="mt-2" />
                                </div>
                                <div class="col-span-1">
                                    <x-input id="email" class="block  w-full" type="email" name="email"
                                        :value="old('email')" required />
                                    <x-label for="email" :value="__('Last Name')" class="mt-2" />
                                </div>
                            </div>

                            {{-- EMAIL --}}
                            <div class="col-span-4 flex items-center grid grid-cols-2 gap-5">
                                <div class="col-span-2">
                                    <x-input id="email" class="block  w-full" type="email" name="email"
                                        :value="old('email')" required />
                                    <x-label for="email" :value="__('Email')" class="mt-2" />
                                </div>
                            </div>

                            {{-- ASUNTO --}}
                            <div class="col-span-4 flex items-center grid grid-cols-2 gap-5">
                                <div class="col-span-2">
                                    <x-input id="email" class="block  w-full" type="email" name="email"
                                        :value="old('email')" required />
                                    <x-label for="email" :value="__('Subject')" class="mt-2" />
                                </div>
                            </div>

                            {{-- TEXT AREA --}}
                            <div class="col-span-4 flex items-center grid grid-cols-2 gap-5">
                                <div class="col-span-2">
                                    <x-text-area id="email" class="block  w-full" type="text" name="email"
                                        :value="old('email')" required placeholder="Escriba aquí..." />
                                    <x-label for="email" :value="__('Mensaje')" class="mt-2" />
                                </div>
                            </div>

                            {{-- BUTTON --}}
                            <div class="col-span-4 flex items-center grid grid-cols-2 gap-5">
                                <div class="col-span-1">
                                    <x-button
                                        class="w-full background_azuloscuro redhat_bold flex justify-center letterSpace-20 m-0" style="margin-bottom: 0px">
                                        {{ __('Send') }}
                                    </x-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </x-auth-card_body>
        <a href="/" class="mb-4 sm:mb-0 2xl:w-32 w-20">
            <x-button-back class="mx-auto mt-8 text-white w-full" />
        </a>
    </x-auth-card>
</x-app-layout>
