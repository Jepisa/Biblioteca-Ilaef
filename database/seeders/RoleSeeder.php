<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::Create(['name'=> 'Usuario', 'visibility' => true]);
        Role::Create(['name'=> 'Administrador', 'visibility' => true]);
        Role::Create(['name'=> 'Administrador Principal']);
        Role::Create(['name'=> 'Programador']);
    }
}
