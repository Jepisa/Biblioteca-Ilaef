@props([
    'productList' => [],
])

{{-- TEST LIST VARIABLES --}}
@php

$product1 = new StdClass();
$product1->name = 'Titulo de Producto 1';
$product1->id = '01';

$product2 = new StdClass();
$product2->name = 'Producto 2';
$product2->id = '01';

$product3 = new StdClass();
$product3->name = 'Titulo Tres';
$product3->id = '03';

$product4 = new StdClass();
$product4->name = 'Titulo 4 Largo Realmente Largo Y sigue';
$product4->id = '04';

$product5 = new StdClass();
$product5->name = 'Titulo CincoPegadoLargo ';
$product5->id = '05';

$product6 = new StdClass();
$product6->name = 'Titulo Seis 666 ';
$product6->id = '06';

$product7 = new StdClass();
$product7->name = 'Titulo Siete ';
$product7->id = '07';

$product8 = new StdClass();
$product8->name = 'Titulo Ocho brocho ';
$product8->id = '08';

$product9 = new StdClass();
$product9->name = 'Titulo Nueveeeee ';
$product9->id = '09';

$product10 = new StdClass();
$product10->name = 'Titulo Diez 10 ';
$product10->id = '10';

$product11 = new StdClass();
$product11->name = 'Titulo Once ';
$product11->id = '11';

$product12 = new StdClass();
$product12->name = 'Titulo Doce ';
$product12->id = '12';

$productList = [$product1, $product2, $product3, $product4, $product5, $product6, $product7, $product8, $product9, $product10, $product11, $product12];

@endphp

<div class="flex flex-wrap items-center justify-center mt-10 xl:mt-0 sm:mx-0 lg:mx-20 xl:mx-0 -mx-4">

    @foreach ($productList as $item)
        <div class="background_grisclaro p-1 rounded-lg mb-4 xl:mx-3 2xl:mx-8 md:mt-2 xl:mt-0 md:mx-4 lg:mx-5 mx-2">
            <div
                class="-mt-3 ml-14 md:-mt-4 md:ml-24 absolute border-gray-600 background_grisoscuro rounded-md border  flex items-center justify-center hover:bg-gray-800 cursor-pointer z-50 ">
                <i class="fas fa-times text-white text-md open_close_modalDelete p-1 px-2" id="{{ $item->id}}" product_name="{{ $item->name }}"></i>
            </div>
            <div
                class="background_grisclaro p-2 rounded-xl border border-dashed border-gray-600 flex justify-center w-max md:w-full">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('img/content/2.jpg') }}" alt=""
                        class="zoomContent rounded-lg cursor-pointer h-20 md:h-36 ml-0">
                </div>
            </div>
            <div class="text-center mt-2">
                <p id="product_name"
                    class="color_azuloscuro text-xs md:text-sm font-bold title_favorite w-16 md:w-28 content_title_result md:h-10 h-8  ">
                    {{ $item->name }}
                </p>
            </div>
        </div>
    @endforeach
</div>
