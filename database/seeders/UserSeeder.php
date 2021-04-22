<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Jean Piere',
            'role_id' => Role::firstWhere('name', 'Programador')->id,
            'email' => 'javierjeanpieres@gmail.com',
        ]);
        User::factory()->create([
            'name' => 'Admin',
            'role_id' => Role::firstWhere('name', 'Administrador')->id,
            'email' => 'admin@admin.com',
        ]);
        User::factory()->count(20)->create();
    }
}

