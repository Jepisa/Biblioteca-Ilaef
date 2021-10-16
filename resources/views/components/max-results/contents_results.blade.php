@props([
    'results' => null,
    'results_count' => 20,
])

<div class="flex flex-wrap items-center justify-center">

@for ($i = 0; $i < $results_count; $i++)
    <div class='resultsCover_container mx-2 my-2 flex flex-col items-center justify-center text-center text_responsive_results'>
        <img src="{{ asset('img/content/2.jpg') }}" alt="" class="zoomContent  cursor-pointer">
        <p class="mt-2 content_title_result">{{ 'Lorem ipsum has been the Lorem ipsum has been theLorem ipsum has been the kytfiuyrouyfouyf' }}</p>
    </div>
@endfor
</div>
