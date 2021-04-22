<?php

namespace Database\Seeders;

use App\Models\Occupation;
use Illuminate\Database\Seeder;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Occupation::Create(['name' => 'Estudiante']);
        Occupation::Create(['name' => 'Consultor/a de EF']);
        Occupation::Create(['name' => 'Empresa Familiar']);
        Occupation::Create(['name' => 'Investigador/a']);
        Occupation::Create(['name' => 'Profesional']);
        Occupation::Create(['name' => 'Otros']);
    }
}
