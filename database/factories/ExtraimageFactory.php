<?php

namespace Database\Factories;

use App\Models\Extraimage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExtraimageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Extraimage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image' => 'content/books/libro-1/descarga-2-copia.jpg',
        ];
    }
}
