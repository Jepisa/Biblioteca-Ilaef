{{-- @props([
    'content' => $content,
    'authors' => $content->authors->pluck('name'),
    'editorial' => 'Nombre Editorial',
    'pubYear' => 'Año de publicación XXXX',
    'pubLoc' => 'Buenos Aires',
    'pubCountry' => 'Argentina',
    'lang' => 'Español',
    'isbn' => '1234-58678',
    'format' => 'Epub',
]) --}}

@php
    $authorsTitle = '';
    $authorsTooltip = '';
    $authors = $content->authors->pluck('name');
    $amount = count($authors);

    for ($i = 0; $i < $amount; $i++) {
        if ($i < 2) {// 1ero y seg
            if ($i == $amount - 1) {
                $authorsTitle = $authorsTitle . $authors[$i] . '.';
                $authorsTooltip = $authorsTooltip . $authors[$i] . '.';
            } else {
                $authorsTitle = $authorsTitle . $authors[$i] . ', ';
                $authorsTooltip = $authorsTooltip . $authors[$i] . ', ';
            }
        } else {
            if ($i == 2 && $amount > 3) {
                $authorsTitle = $authorsTitle . $authors[$i] . '...';
                $authorsTooltip = $authorsTooltip . $authors[$i] . ', ';
            }
            elseif ($i == 2 && $amount == 3) {
                $authorsTitle = $authorsTitle . $authors[$i] . '.';
            }
            else {
                if ($i == $amount - 1) {
                $authorsTooltip = $authorsTooltip . $authors[$i] . '.';
                } 
                else {
                    $authorsTooltip = $authorsTooltip . $authors[$i] . ', ';
                }
            }

        }
    }
@endphp

<div {{ $attributes->merge(['class' => 'legalContainer']) }}>
    <div class="">
        @if ($amount > 3)
        <x-title class="sm:mb-5 mb-5 sm:text-xl text-lg cursor-help" textContent="{{ $authorsTitle }}" title="{{ 'Autores: ' . $authorsTooltip}}" />
        @else
        <x-title class="sm:mb-5 mb-5 sm:text-xl text-lg" textContent="{{ $authorsTitle }}"/>
        @endif
        {{-- Datos del contenido --}}
            <x-regular-text textContent="{{ $content->editorial }}" />
            <x-regular-text textContent="{{ $content->year }}" />
            <x-regular-text textContent="{{ $content->city }}" />
            <x-regular-text textContent="{{ isset($content->country) ? $content->country->name : '' }}" />
            <x-regular-text textContent="{{ isset($content->language) ? $content->language->name : '' }}" />
            <x-regular-text textContent="{{ $content->isbn }}" />
        {{--  --}}
    
    </div>
</div>
