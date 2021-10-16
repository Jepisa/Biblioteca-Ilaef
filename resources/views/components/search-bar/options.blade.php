<form method="GET" action="" id="advanceSearch_form">
    @csrf
    <div {{ $attributes->merge(['class' => 'bg-white border_dashed m-4 p-4 px-4 sm:px-8']) }}>

        <div class="w-2/3 w-full flex justify-between items-center color_azuloscuro">
            <x-title textContent="Búsqueda avanzada" class="font-medium text-base md:text-lg text-left" id="advanceSearch_title"/>
            <div class="border cursor-pointer flex justify-between items-center modal_close" @click="open = false;$dispatch('overflow')">
                <i class="fas fa-times p-2"></i>
            </div>
        </div>
        <div class="mt-4 -mb-6">
            <div class="color_azuloscuro grid grid-cols-4 gap-5">
                <div class="col-span-4 flex items-center grid grid-cols-2 gap-2 sm:gap-4" id="advanceSearch_container">

                    {{-- Autor --}}
                    <div class="col-span-2 sm:col-span-1 text-left" id="campo_autor">
                        <x-input id="author" class="block w-full mb-2 color_azuloscuro" type="text" name="author"
                            autocomplete="off" />
                        <x-label for="author" value="Autor" class="ml-2 color_azuloscuro" />
                    </div>

                    {{-- Editorial --}}

                    <div class="col-span-2 sm:col-span-1 text-left" id="campo_editorial">
                        <x-input id="editorial" class="block w-full mb-2 color_azuloscuro" type="text"
                            name="editorial" autocomplete="off" />
                        <x-label for="editorial" value="Editorial" class="ml-2 color_azuloscuro" />
                    </div>

                    {{-- Titulo --}}

                    <div class="col-span-2 sm:col-span-1 text-left" id="campo_titulo">
                        <x-input id="title_search" class="block w-full mb-2 color_azuloscuro" type="text"
                            name="title_search" autocomplete="off" />
                        <x-label for="title_search" value="Titulo" class="ml-2 color_azuloscuro" />
                    </div>

                    {{-- ISBN --}}

                    <div class="col-span-2 sm:col-span-1 text-left" id="campo_isbn">
                        <x-input id="isbn" class="block w-full mb-2 color_azuloscuro" type="text" name="isbn"
                            autocomplete="off" />
                        <x-label for="isbn" value="ISBN" class="ml-2 color_azuloscuro" />
                    </div>

                    {{-- Duracion --}}

                    <div class="col-span-2 sm:col-span-1 text-left" id="campo_duracion">
                        <x-input id="duracion" class="block w-full mb-2 color_azuloscuro" type="number" name="duracion"
                            autocomplete="off" />
                        <x-label for="duracion" value="Duracion (en minutos)" class="ml-2 color_azuloscuro" />
                    </div>

                    {{-- Tema --}}

                    <div class="col-span-2 sm:col-span-1 text-left" id="campo_tema">
                        <x-input id="theme" class="block w-full mb-2 color_azuloscuro" type="text" name="theme"
                            autocomplete="off" />
                        <x-label for="theme" value="Tema" class="ml-2 color_azuloscuro" />
                    </div>

                    {{-- Pais --}}

                    <div class="col-span-2 sm:col-span-1 text-left" id="campo_pais">
                        <x-input id="country" class="block w-full mb-2 color_azuloscuro" type="text" name="country"
                            autocomplete="off" />
                        <x-label for="country" value="Pais" class="ml-2 color_azuloscuro" />
                    </div>
                </div>

            </div>

        </div>
        {{-- BUTTON --}}
        <div class="px-4 flex items-center advance_search_button_container">
            <x-button @click="open = false;$dispatch('overflow')" class="px-8 py-3 background_rojooscuro text-white text-md redhat_bold flex justify-center letterSpace-20 m-0 uppercase rounded-xl advance_search_button
                hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring-none modal_close"
                style="margin-bottom: 0px">
                Buscar
            </x-button>
        </div>
    </div>
</form>

@section('scripts')
    
@endsection