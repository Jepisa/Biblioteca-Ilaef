@props([
    'logoPx' => 'px-4',
    'logoPxSm' => 'sm:px-10',
    'logoJustifyLg' => 'lg:justify-start',
    'logoJustify' => 'justify-center',
])


<div
    {{ $attributes->merge(['class' => 'flex h-full flex-col justify-center items-center lg:px-20 sm:px-10 sm:py-10 px-4 py-4']) }}>
    @isset($logo)
        <div class="mb-4 w-full {{$logoPx}} {{$logoPxSm}} flex {{$logoJustify}} {{$logoJustifyLg}}">
            {{ $logo }}
        </div>
    @endisset

    {{ $slot }}

</div>
