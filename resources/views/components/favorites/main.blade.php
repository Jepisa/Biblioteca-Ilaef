@props([
    'productList' => [],
])

{{-- HEADER > IPAD --}}
<div class="w-full hidden xl:flex items-center justify-between text_responsive color_azuloscuro">
    <div class="xl:w-4/12 2xl:w-7/12">
    </div>
    <div class="flex justify-between items-center w-7/12 color_azuloscuro">
        <div class="2xl:ml-10 xl:ml-5 my-2">
            <a href="/">
                <x-application-logo class="w-20 md:w-40 fill-current text-gray-500" />
            </a>
        </div>
        <div class="flex items-center justify-center">
            <p class="mr-2 font-bold">Tus Favoritos</p>
            <i class="fas fa-heart text-lg"></i>
        </div>
        <div class="flex items-center justify-center">
            <div class="flex items-center justify-center mr-4">
                <i class="fas fa-user-circle text-xl"></i>
                <p class="ml-2">{{ Auth::user()->name }}</p>
            </div>
            <div class="flex items-center justify-center">
                <i class="fas fa-th text-xl p-3 bg-white border rounded-md mr-4 cursor-pointer hover:bg-gray-200"></i>
                <i class="fas fa-list-ul text-xl p-3 bg-white border rounded-md cursor-pointer hover:bg-gray-200"></i>
            </div>

        </div>
    </div>
</div>
{{-- END HEADER > IPAD --}}

<x-auth-card_body class="p-4 xl:p-10 xl:bg-transparent bg-white">
    <div class="block xl:w-7/12 2xl:w-6/12 w-full 2xl:pl-10 xl:pl-5">
        {{-- HEADER < IPAD --}}
        <div class="color_azuloscuro xl:hidden my-4 xl:mx-0 md:mx-8 lg:mx-24 mx-0">

            <div class="flex items-center justify-between w-full mb-4">
                <div class="flex items-center justify-between">
                    <a href="/">
                        <x-application-logo class="w-32 md:w-40 fill-current text-gray-500" />
                    </a>
                </div>
                <div class="flex items-center justify-center">
                    <p class="text-sm md:text-lg mr-2 font-bold">Tus Favoritos</p>
                    <i class="fas fa-heart text-lg"></i>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center justify-center mr-4">
                    <i class="fas fa-user-circle text-xl"></i>
                    <p class="ml-4">{{ Auth::user()->name }}</p>
                </div>
                <div class="flex items-center justify-center">
                    <i
                        class="fas fa-th text-md md:text-xl p-2 md:p-3 bg-white border rounded-md mr-4 cursor-pointer hover:bg-gray-200"></i>
                    <i
                        class="fas fa-list-ul text-md md:text-xl p-2 md:p-3 bg-white border rounded-md cursor-pointer hover:bg-gray-200"></i>
                </div>

            </div>
        </div>
        {{-- END HEADER < IPAD --}}

        <div class="sm:rounded-lg ">
            @if (count($productList) <= 0)
                <div class="text-center color_azuloscuro my-5 ">
                    <div class="w-full flex items-center justify-center">
                        <img src="{{ asset('img/assets/favorites/no_favorites.svg') }}" alt="" class="w-1/3">
                    </div>
                    <p class="font-bold mt-4">Aún no tienes favoritos</p>
                </div>
            @else
                {{-- IF LISTA --}}
                <x-favorites.list :productList="$productList" />
                {{-- END IF LISTA --}}
                {{-- IF SMALL THUMBNAIL --}}
                {{-- <x-favorites.thumbnail :productList="$productList" /> --}}
                {{-- END IF SMALL THUMBNAIL --}}
            @endif

            {{-- ARROW BACK --}}
            <div class="w-full items-center justify-center flex mb-2 mt-8 flex flex xl:hidden">
                <div class="w-1/2 mx-auto hidden xl:block"></div>
                <a href="{{ url()->previous() }}" class="w-full xl:w-1/2 block 2xl:pr-0 xl:pr-40">
                    <x-button-back class="mx-auto text-white md:w-20 w-16" color="#91091E" />
                </a>
            </div>

        </div>
    </div>
</x-auth-card_body>

{{-- MODAL DELETE --}}
<div x-data="{ open: false }" @click.away="open = false" @close.stop="open = false" id="modal_unfavorite">
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="flex items-center justify-center fixed left-0 bottom-0 w-full h-full z-50" style="display: none;">
        <div class="rounded-md shadow-lg bg-white color_azuloscuro modal_container flex justify-center items-center "
            @click.away="open = false">
            <div class="modal_inner flex flex-col items-center justify-center" style="padding: 20px;">
                <div class="flex items-center justify-center mb-4 w-full">
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('img/assets/favorites/remove_favorites.svg') }}" alt="" class="h-24 w-24">
                    </div>
                    <p class="text-base ml-5 text-center whitespace-normal max-w-xs">
                        Se eliminará <span id="modal_product_name" class="font-bold break-normal whitespace-normal">...</span> de tus
                        favoritos.
                    </p>
                </div>
                <div class="flex items-center justify-around w-full">
                    <p class="font-bold text-base md:text-center cursor-pointer" id="modal_confirmDelete_button"
                        product_id="">
                        Aceptar
                    </p>
                    <p class="text-md md:text-center cursor-pointer font-bold" @click="open = false">
                        Rechazar
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    window.onload = () => {

        Array.from(document.getElementsByClassName("open_close_modalDelete")).forEach(element => {
            element.addEventListener("click", function(e) {
                let product_id = e.target.attributes.id.value;
                let product_name = e.target.attributes.product_name.value;
                document.getElementById("modal_product_name").innerHTML = product_name;
                document.getElementById("modal_unfavorite").attributes[0].value = "{ open: true}";
                document.getElementById("modal_confirmDelete_button").attributes.product_id.value =
                    product_id;
            })
        });

        document.getElementById("modal_confirmDelete_button").addEventListener("click", function(e) {
            let product_id = e.srcElement.attributes.product_id.value;
            console.log(product_id)
            // AJAX CALL
        })
    }
</script>
