<div class="background_container lg:fixed lg:h-screen fixed overflow-hidden flex fade-in-1_2">
    <div class="background_profile h-full w-full xl:w-1/2"></div>
    <div class="bg-white xl:w-7/12 h-full xl:block hidden"></div>
</div>
<x-guest-layout>
    <x-auth-card logoJustify="justify-start" class="lg:pt-80 lg:-mb-20 xl:pt-10 xl:-mb-0 pt-72">
        <div class="w-full hidden xl:flex items-center justify-between text_responsive color_azuloscuro">
            <div class="xl:w-4/12 2xl:w-7/12">
            </div>
            <div class="flex justify-end items-center w-7/12 color_azuloscuro">
                <div class="2xl:ml-10 xl:ml-5 my-2">
                    <a href="/">
                        <x-application-logo class="w-20 md:w-40 fill-current text-gray-500" />
                    </a>
                </div>
            </div>
        </div>


        <x-auth-card_body
            class="p-4 sm:p-10 2xl:p-20 mx-4 sm:mx-10 xl:p-14 2xl:mx-20 xl:mx-14 bg-white xl:bg-transparent">
            <div class="sm:rounded-lg px-5  h-fit 2xl:w-6/12 xl:w-6/12 w-full">
                {{-- LOGO --}}
                <div class="flex items-center justify-center w-full text_responsive xl:hidden mt-5">
                    <a href="/" class="flex justify-center">
                        <x-application-logo class="w-20 w-32 fill-current text-gray-500" />
                    </a>
                </div>

                {{-- FORM --}}
                <div class="color_azuloscuro letterSpace-20">
                    @livewire('edit-user', [])
                </div>
                {{-- END FORM --}}

                {{-- ARROW BACK --}}
                <div class="w-full items-center justify-center flex mb-2 mt-8 flex flex xl:hidden">
                    <div class="w-1/2 mx-auto hidden xl:block"></div>
                    <a href="{{ url()->previous() }}" class="w-full xl:w-1/2 block 2xl:pr-0 xl:pr-40">
                        <x-button-back class="mx-auto text-white md:w-20 w-16" color="#91091E" />
                    </a>
                </div>
            </div>

        </x-auth-card_body>
    </x-auth-card>

    <div class="w-full items-center justify-center flex mb-8 hidden xl:flex">
        <div class="w-1/2 mx-auto hidden xl:block"></div>
        <a href="{{ url()->previous() }}" class="w-full xl:w-1/2 block 2xl:pr-40 xl:pr-32">
            <x-button-back class="mx-auto text-white w-20" color="#91091E" />
        </a>
    </div>

    {{-- SUCCESS MODAL --}}
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
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="w-20 h-20 mt-2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <p class="font-bold text-base md:text-center">
                            Perfil modificado con éxito.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    @endif

</x-guest-layout>
