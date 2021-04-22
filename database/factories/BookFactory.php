<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(255);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'synopsis' => $this->faker->text(400),
            'note' => $this->faker->text(200),
            'year' => $this->faker->year(),
            'collection' => $this->faker->word,
            'edition' => $this->faker->numberBetween(0,50),
            'editorial' => $this->faker->name(),
            'language_id' => Language::all()->random()->id,
            'city' => $this->faker->city,
            'country_id' => Country::all()->random()->id,
            'pages' => $this->faker->numberBetween(0, 500),
            'isbn' => $this->faker->isbn13,
            'downloadable' => 'content/books/libro-1/infoleg-ministerio-de-economia-y-finanzas-publicas-argentina.pdf',
            'url' => $this->faker->url,
            'coverImage' => 'content/books/default.jpg',
            'backCoverImage' => null,
            'audiobook' => null,
            'format' => null,
        ];
    }
}
