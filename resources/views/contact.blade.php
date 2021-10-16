<x-guest-layout navbar_display="0">
    <div class="background_container lg:fixed lg:h-screen fixed overflow-hidden flex xl:flex-row flex-col">
        <div class="background_contact h-full w-full 2xl:w-1/2 xl:w-5/12 fade-in-1_2 block"></div>
        <div class="bg-white 2xl:w-1/2 xl:w-7/12 h-full xl:block hidden"></div>
    </div>
        <x-auth-card class="lg:mt-96 xl:mt-0">
            <x-slot name="logo">
                <a href="{{ route('home') }}">
                    <x-application-logo class="w-20 md:w-40 w-32 xl:w-40 2xl:w-40 fill-current text-gray-500" />
                </a>
            </x-slot>
            <x-auth-card_body
                class="p-4 sm:p-10 2xl:px-20 2xl:py-10 mx-4 sm:mx-10 xl:mx-8 xl:p-8 2xl:mx-14 xl:bg-transparent bg-white">
                <div class="sm:rounded-lg p-5 xl:p-8 2xl:p-10 h-fit 2xl:w-5/12 xl:w-6/12 w-full xl:pr-24 2xl:pr-10">
                    <div class="contact_container">
                        <form method="POST" action="" autocomplete="off">
                            @csrf
                            <div class="color_azuloscuro letterSpace-20 form_contact grid grid-cols-4 gap-5">

                                {{-- NOMBRE Y APELLIDO --}}
                                <div class="col-span-4 flex items-center grid grid-cols-2 gap-5">
                                    <div class="col-span-1">
                                        <x-input id="name" class="block  w-full" type="text" name="name"
                                            :value="old('name')" required />
                                        <x-label for="name" :value="__('Name')" class="mt-2" />
                                    </div>
                                    <div class="col-span-1">
                                        <x-input id="last_name" class="block  w-full" type="text" name="last_name"
                                            :value="old('last_name')" required />
                                        <x-label for="last_name" :value="__('Last Name')" class="mt-2" />
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
                                        <x-input id="subject" class="block  w-full" type="text" name="subject"
                                            :value="old('subject')" required />
                                        <x-label for="subject" :value="__('Subject')" class="mt-2" />
                                    </div>
                                </div>

                                {{-- TEXT AREA --}}
                                <div class="col-span-4 flex items-center grid grid-cols-2 gap-5">
                                    <div class="col-span-2">
                                        <x-text-area id="message" class="block  w-full" type="text" name="message"
                                            :value="old('message')" required placeholder="Escriba aquí..." />
                                        <x-label for="message" :value="__('Mensaje')" class="mt-2" />
                                    </div>
                                </div>

                                {{-- BUTTON --}}
                                <div class="col-span-4 flex items-center grid grid-cols-2 gap-5">
                                    <div class="col-span-2 w-full flex justify-center">
                                        <x-button
                                            class="background_azuloscuro redhat_bold flex justify-center letterSpace-20 m-0 w-full lg:w-40"
                                            style="margin-bottom: 0px">
                                            {{ __('Send') }}
                                        </x-button>
                                    </div>
                                </div>
                                <div class="col-span-4 items-center justify-center flex mb-8 xl:hidden relative md:top-10 top-5">
                                    <a href="{{ route('home') }}" class="w-full block">
                                        <x-button-back class="mx-auto text-white md:w-20 w-16" color="#91091E" />
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </x-auth-card_body>
        </x-auth-card>
        <div class="w-full items-center justify-center flex mb-8 hidden xl:flex">
            <div class="w-1/2 mx-auto hidden xl:block"></div>
            <a href="{{ route('home') }}" class="w-full xl:w-1/2 block 2xl:pr-0 xl:pr-40">
                <x-button-back class="mx-auto text-white w-20" color="#91091E" />
            </a>
        </div>
</x-guest-layout>
