<x-guest-layout navbar_display="0">
    <div class="background_container lg:fixed lg:h-screen fixed overflow-hidden flex xl:flex-row flex-col">
        <div class="background_contact h-full w-full 2xl:w-1/2 xl:w-5/12 fade-in-1_2 block"></div>
        <div class="bg-white 2xl:w-1/2 xl:w-7/12 h-full xl:block hidden"></div>
    </div>


    <x-auth-card class="mt-0">
        {{-- TEST LIST VARIABLES --}}
        @php

            $editorial = 'Nombre Editorial';
            $pubYear = 'Año de publicación XXXX';
            $pubLoc =  'Buenos Aires';
            $pubCountry = 'Argentina';
            $lang = 'Español';
            $isbn = '1234-58678';
            $format = 'Epub';

            $product1 = new StdClass();
            $product1->id = '01';
            $product1->name = 'Titulo de Producto 1';
            $product1->editorial = $editorial;
            $product1->pubYear = $pubYear;
            $product1->pubLoc =  $pubLoc;
            $product1->pubCountry = $pubCountry;
            $product1->lang = $lang;
            $product1->isbn = $isbn;
            $product1->format = $format;

            $product2 = new StdClass();
            $product2->id = '02';
            $product2->name = 'Producto 2';
            $product2->editorial = $editorial;
            $product2->pubYear = $pubYear;
            $product2->pubLoc =  $pubLoc;
            $product2->pubCountry = $pubCountry;
            $product2->lang = $lang;
            $product2->isbn = $isbn;
            $product2->format = $format;
            
            $product3 = new StdClass();
            $product3->id = '03';
            $product3->name = 'Titulo Tres';
            $product3->editorial = $editorial;
            $product3->pubYear = $pubYear;
            $product3->pubLoc =  $pubLoc;
            $product3->pubCountry = $pubCountry;
            $product3->lang = $lang;
            $product3->isbn = $isbn;
            $product3->format = $format;

            $product4 = new StdClass();
            $product4->id = '04';
            $product4->name = 'Titulo 4 Largo Realmente Largo Y sigue';
            $product4->editorial = $editorial;
            $product4->pubYear = $pubYear;
            $product4->pubLoc =  $pubLoc;
            $product4->pubCountry = $pubCountry;
            $product4->lang = $lang;
            $product4->isbn = $isbn;
            $product4->format = $format;

            $product5 = new StdClass();
            $product5->id = '05';
            $product5->name = 'Cinco Titulo';
            $product5->editorial = $editorial;
            $product5->pubYear = $pubYear;
            $product5->pubLoc =  $pubLoc;
            $product5->pubCountry = $pubCountry;
            $product5->lang = $lang;
            $product5->isbn = $isbn;
            $product5->format = $format;

            
            $productList = [$product1,$product2,$product3,$product4,$product5];
            
        @endphp
        <x-favorites.main 
        :productList="$productList" 
        />
    </x-auth-card>



    <div class="w-full items-center justify-center flex mb-8 hidden xl:flex">
        <div class="w-1/2 mx-auto hidden xl:block"></div>
        <a href="/" class="w-full xl:w-1/2 block 2xl:pr-0 xl:pr-40">
            <x-button-back class="mx-auto text-white w-20" color="#91091E" />
        </a>
    </div>
</x-guest-layout>
