<div class="orderBy_container text_responsive_results" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <div @click="open = ! open" class="cursor-pointer">
        <div class="orderBy_button flex rounded-md background_grisoscuro relative z-40 color_grisclaro py-2 px-2 md:px-4 pr-4 md:pr-8 shadow-md">
            Ordenar por
        </div>
    </div>

    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95" class="absolute items-right md:items-left w-40 md:w-52 lg:w-56 z-30 orderby_menu" style="display: none;"
        {{-- @click="open = false" --}}
        >
        <div class="bg-white color_azuloscuro rounded-sm shadow-lg pt-4">
            <ul class="p-2">
                <li class="py-1 px-4 cursor-pointer hover:bg-gray-200 rounded-sm">
                    <a>Fecha (el más reciente)</a>
                </li>
                <li class="py-1 px-4 cursor-pointer hover:bg-gray-200 rounded-sm">
                    <a class="py-2">Fecha (el más antiguo)</a>
                </li>
                <li class="py-1 px-4 cursor-pointer hover:bg-gray-200 rounded-sm">
                    <a class="py-2">Titulo (de la A a la Z)</a>
                </li>
                <li class="py-1 px-4 cursor-pointer hover:bg-gray-200 rounded-sm">
                    <a class="py-2">Autor (de la A a la Z)</a>
                </li>
                <li class="py-1 px-4 cursor-pointer hover:bg-gray-200 rounded-sm">
                    <a class="py-2">Por relevancia</a>
                </li>
                <li class="py-1 px-4 cursor-pointer hover:bg-gray-200 rounded-sm">
                    <a class="py-2">Por formato</a>
                </li>
            </ul>
        </div>
    </div>
</div>
