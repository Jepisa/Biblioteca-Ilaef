@props([
    'textContent' => 'Lorem ipsum dolor'])


<p {{ $attributes->merge(['class' => 'text-normal']) }}>
    {{ $textContent }}
</p>
