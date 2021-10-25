@props([
    'results' => null,
    'results_count' => $contents->count(),
    'contents' => $contents
])

<div class="flex flex-wrap items-center justify-center">
    @foreach ($contents as $content)
        <a href="{{ route($content->type . '.show', ['slug' => $content->slug]) }}">
            <div class='resultsCover_container mx-2 my-2 flex flex-col items-center justify-center text-center text_responsive_results'>
                <img src="{{ asset("storage/$content->coverImage") }}" alt="{{ $content->title }}" class="zoomContent  cursor-pointer">
                <p class="mt-2 content_title_result">{{ $content->title }}</p>
            </div>
        </a>
    @endforeach
</div>
