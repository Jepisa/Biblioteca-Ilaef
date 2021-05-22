<?php

return [
    // Index
    'index' => [
        'title' => 'Libros',
        'table' => [
            'header' => [
                'title' => 'Título',
                'synopsis' => 'Sinopsis',
                'authors' => 'Autor/s',
                'topics' => 'Tema/s',
                'audiobook' => 'Audio Libro',
                'downloadable'=> 'Archivo descargable',
                'extraimages' => 'Imágenes extras',
            ],
        ],
    ],

    // Create
    'create' => [
        'title' => 'Agregar un nuevo Libro',
        'fields' => [
            'title' => [
                'label' => 'Título',
                'placeholder' => '',
                'description' => '',
            ],
            'authors' => [
                'label' => 'Autores',
                'placeholder' => '',
                'description' => '',
            ],
            'topics' => [
                'label' => 'Temas',
                'placeholder' => '',
                'description' => '',
            ],
            'synopsis' => [
                'label' => 'Sinopsis',
                'placeholder' => '',
                'description' => '',
            ],
            'notes' => [
                'label' => 'Notas',
                'placeholder' => '',
                'description' => '',
            ],
            'year' => [
                'label' => 'Año',
                'placeholder' => '',
                'description' => '',
            ],
            'collection' => [
                'label' => 'Colección',
                'placeholder' => '',
                'description' => '',
            ],
            'edition' => [
                'label' => 'Edición',
                'placeholder' => '',
                'description' => '',
            ],
            'editorial' => [
                'label' => 'Editorial',
                'placeholder' => '',
                'description' => '',
            ],
            'language' => [
                'label' => 'Idioma',
                'placeholder' => '',
                'description' => '',
            ],
            'city' => [
                'label' => 'Ciudad',
                'placeholder' => '',
                'description' => '',
            ],
            'country' => [
                'label' => 'País',
                'placeholder' => '',
                'description' => '',
            ],
            'pages' => [
                'label' => 'Páginas',
                'placeholder' => '',
                'description' => '',
            ],
            'isbn' => [
                'label' => 'ISBN',
                'placeholder' => 'XXX-XX-XXX-XX',
                'description' => '',
            ],
            'url' => [
                'label' => 'URL',
                'placeholder' => '',
                'description' => '',
            ],
            'downloadable' => [
                'label' => 'Archivo descargable',
                'placeholder' => '',
                'description' => '',
            ],
            'cover' => [
                'label' => 'Imagen de tapa',
                'placeholder' => '',
                'description' => '',
            ],
            'backcover' => [
                'label' => 'Imagen de contratapa',
                'placeholder' => '',
                'description' => '',
            ],
            'extraimages' => [
                'label' => 'Imágenes extras',
                'placeholder' => '',
                'description' => '',
            ],
            'audiobook' => [
                'label' => 'Audiolibro',
                'placeholder' => '',
                'description' => '',
            ],
        ],
        'buttons' => [
            'submit' => 'Crear libro',
        ],
    ],

    // Edit
    'edit' => [
    ],
];

{{ __('books.create.fields.topics.label') }}
{{ __('books.create.fields.synopsis.label') }}
{{ __('books.create.fields.notes.label') }}
{{ __('books.create.fields.year.label') }}
{{ __('books.create.fields.collection.label') }}
{{ __('books.create.fields.edition.label') }}
{{ __('books.create.fields.editorial.label') }}
{{ __('books.create.fields.language.label') }}
{{ __('books.create.fields.city.label') }}
{{ __('books.create.fields.country.label') }}
{{ __('books.create.fields.pages.label') }}
{{ __('books.create.fields.isbn.label') }}
{{ __('books.create.fields.isbn.placeholder') }}
{{ __('books.create.fields.url.label') }}
{{ __('books.create.fields.downloadable.label') }}
{{ __('books.create.fields.cover.label') }}
{{ __('books.create.fields.backcover.label') }}
{{ __('books.create.fields.extraimages.label') }}
{{ __('books.create.fields.audiobook.label') }}
