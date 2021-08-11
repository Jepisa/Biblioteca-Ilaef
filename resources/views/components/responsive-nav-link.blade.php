@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block navlink_active navlink redhat_regular'
            : 'block navlink_inactive navlink redhat_regular';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
