@props([
    'tags' => ['Libro', 
    'Ciencia Ficcion',
    'Familia', 
    'Empresa',
    'Mejorar', 
    'E-Book', 
    'Latinoamérica',
    'Libro', 
    'Ciencia Ficcion',
    'Familia', 
    'Empresa',
    'Mejorar', 
    'E-Book', ]
])

@foreach ($tags as $tag)
    <a class="flex items-center cursor-pointer mr-2 mt-2 ">
        <div class="rounded-xs bg-black text-white flex px-2 md:px-4 py-0.5 text_responsive_results tag_results">
            <p>{{ $tag }}</p>
        </div>
        <div class="transform rotate-45 h-2 w-2 bg-black relative -left-1"></div>
    </a>
@endforeach
