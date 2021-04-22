<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::firstOrCreate(['name'=> 'Español']);
        Language::firstOrCreate(['name'=> 'Inglés']);
        Language::firstOrCreate(['name'=> 'Portugués']);
        Language::firstOrCreate(['name'=> 'Francés']);
        Language::firstOrCreate(['name'=> 'Italiano']);
        Language::firstOrCreate(['name'=> 'Alemán']);
    }
}
