<?php

namespace Database\Seeders;

use App\Models\Referrer;
use Illuminate\Database\Seeder;

class ReferrerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Referrer::firstOrCreate(['name' => 'IADEF']);
        Referrer::firstOrCreate(['name' => 'ICOEF']);
        Referrer::firstOrCreate(['name' => 'AEFE']);
        Referrer::firstOrCreate(['name' => 'CEFE']);
        Referrer::firstOrCreate(['name' => 'IPEF']);
        Referrer::firstOrCreate(['name' => 'Buscador/Google']);
        Referrer::firstOrCreate(['name' => 'Redes Sociales']);
        Referrer::firstOrCreate(['name' => 'Otros']);
    }
}
