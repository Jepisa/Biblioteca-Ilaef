<?php

return [
    // Index
    'index' => [
        'title' => 'E-Books',
        'table' => [
            'header' => [
                'title' => 'Título',
                'synopsis' => 'Sinopsis',
                'authors' => 'Autor/s',
                'topics' => 'Tema/s',
                'downloadable'=> 'Archivo descargable',
                'extraimages' => 'Imágenes extras',
            ],
        ],
    ],

    // Create
    'create' => [
        'title' => 'Agregar un nuevo E-Book',
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
        ],
        'buttons' => [
            'submit' => 'Crear E-Book',
        ],
        'notification' => [
            'title' => 'Felicidades',
            'body' => 'El E-Book ":title" fue creado con éxito.'
        ],
    ],

    // Show
    'show' => [
        'fields' => [
            'title' => 'Título',
            'authors' => 'Autores',
            'topics' => 'Temas',
            'synopsis' => 'Sinopsis',
            'notes' => 'Notas',
            'year' => 'Año',
            'collection' => 'Colección',
            'edition' => 'Edición',
            'editorial' => 'Editorial',
            'language' => 'Idioma',
            'city' => 'Ciudad',
            'country' => 'País',
            'pages' => 'Páginas',
            'isbn' => 'ISBN',
            'url' => 'URL',
            'downloadable' => 'Archivo descargable',
            'cover' => 'Imagen de tapa',
            'backcover' => 'Imagen de contratapa',
            'extraimages' => 'Imágenes extras',
        ],
    ],

    // Edit
    'edit' => [
        'title' => 'Actualizar un E-Book',
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
        ],
        'buttons' => [
            'submit' => 'Actualizar E-Book',
        ],
        'notification' => [
            'title' => 'Felicidades',
            'body' => 'El E-Book ":title" fue actualizado con éxito.'
        ],
    ],

    // Delete
    'delete' => [
        'notification' => [
            'title' => 'Atención!',
            'body' => 'El E-Book ":title" fue eliminado con éxito.'
        ],
    ],
];
