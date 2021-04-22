<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Counter;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::factory()
                ->count(200)
                ->state(new Sequence(
                    ['audiobook' => 'content/books/libro-1/noel-schajris-dime-ft-reik.mp3', 'format' => 'mp3'],
                    ['audiobook' => null],
                    ['audiobook' => null],
                ))
                ->hasAttached(Author::all()->random(3))
                ->hasAttached(Topic::all()->random(2))
                ->hasCounter(new Sequence(
                    ['views' => random_int(0, 200)],
                    ['views' =>  0],
                    ['views' => random_int(200, 9999)],
                ))
                ->create();


    }
}
