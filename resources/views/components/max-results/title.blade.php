@props([
    'search' => $search,
    'amount' => $contents->total(),
])

<div class="block md:flex justify-center color_grisclaro text_responsive_results mr-4 md:mr-10">
    <h3 class="h3-personalizado mr-1.5">De <span class="font-bold">"{{$search}}"</span></h3>
    <h3>se encontraron <span class="">{{$amount}} resultados.</span></h3>
</div>