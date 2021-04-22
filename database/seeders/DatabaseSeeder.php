<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            CountrySeeder::class,
            GenderSeeder::class,
            RoleSeeder::class,
            OccupationSeeder::class,
            ReferrerSeeder::class,
            UserSeeder::class,
            
            AuthorSeeder::class,
            TopicSeeder::class,
            LanguageSeeder::class,
            BookSeeder::class,
            // PodcastSeeder::class,
        ]);
    }
}
