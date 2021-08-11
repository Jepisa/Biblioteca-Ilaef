@props([
    'search' => "Search Field",
    'amount' => '0',
])

<div class="block md:flex justify-center color_grisclaro text_responsive_results mr-4 md:mr-10">
    <h3 class="mr-1.5">De <span class="font-bold">{{$search}}</span></h3>
    <h3>se encontraron <span class="">{{$amount}} resultados.</span></h3>
</div>