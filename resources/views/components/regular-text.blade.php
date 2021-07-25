@props([
    'textContent' => 'Lorem ipsum dolor'])


<p {{ $attributes->merge(['class' => 'xl:text-base sm:text-sm text-xs']) }}>
    {{ $textContent }}
</p>
