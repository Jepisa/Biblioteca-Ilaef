@props([
    'title' => 'Titulo Largo y recontra largo',
    'editorial' => 'Nombre Editorial',
    'pubYear' => 'Año de publicación XXXX',
    'pubLoc' => 'Buenos Aires',
    'pubCountry' => 'Argentina',
    'lang' => 'Español',
    'isbn' => '1234-58678',
    'format' => 'Epub',
])

<div {{ $attributes->merge(['class' => 'legalContainer']) }}>
    <div class="">
        <x-title class="sm:mb-10 mb-5 sm:text-2xl text-xl" textContent="{{ $title }}" />
        <x-regular-text textContent="{{ $editorial }}" />
        <x-regular-text textContent="{{ $pubYear }}" />
        <x-regular-text textContent="{{ $pubLoc }}" />
        <x-regular-text textContent="{{ $pubCountry }}" />
        <x-regular-text textContent="{{ $lang }}" />
        <x-regular-text textContent="{{ $isbn }}" />
        <x-regular-text textContent="{{ $format }}" />
    </div>
</div>
