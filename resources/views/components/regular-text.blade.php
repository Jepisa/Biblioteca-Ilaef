@props([
    'textContent' => 'Lorem ipsum dolor'])


<p {{ $attributes->merge(['class' => 'text_responsive']) }}>
    {{ $textContent }}
</p>
