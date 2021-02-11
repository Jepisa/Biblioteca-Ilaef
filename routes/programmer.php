<?php

use App\Models\City;
use App\Models\Country;
use App\Models\Gender;
use App\Models\Occupation;
use App\Models\Referrer;
use App\Models\User;
use App\Models\Role;
use App\Models\State;
use Illuminate\Support\Facades\Route;

// Temporal Routes
Route::get('/', function () {
    return view('welcome');
})->name('home')->middleware(['auth']);



Route::get('crearCuentaDeProgramador', function () {

    if( !Role::firstWhere('name', 'Programador') or !User::firstWhere('email', 'javierjeanpieres@gmail.com'))
    {
        // Creación de los Roles
        Role::updateOrCreate(['name'=> 'Usuario'],[ 'visibility' => true]);
        Role::updateOrCreate(['name'=> 'Administrador'], ['visibility' => true]);
        Role::updateOrCreate(['name'=> 'Administrador Principal']);
        $roleProgrammer = Role::updateOrCreate(['name'=> 'Programador']);

        // Creación de los Genders
        Gender::updateOrCreate(['name'=> 'Mujer']);
        Gender::updateOrCreate(['name'=> 'Hombre']);
        $genderSinEspecificar = Gender::updateOrCreate(['name'=> 'Sin Especificar']);

        // Crear/buscar Country - State -City
        $argentina = Country::updateOrCreate(['name' => 'Argentina']);
        $buenosAiresProvince = State::updateOrCreate(['name' => 'Buenos Aires Province']);
        $escobar = City::Create(
                                ['name' => 'Escobar',
                                'state_id'=> $buenosAiresProvince->id,
                                // 'state_code'=> 'X', 
                                'country_id'=> 11, 
                                'country_code'=> 'AR', 
                                // 'latitude'=> '-31.67890000', 
                                // 'longitude'=> '-63.87964000', 
                                'created_at'=> now(), 
                                'updated_at'=> now(), 
                                // 'flag'=> 1, 
                                // 'wikiDataId'=> 'Q7193761'
                                ]);

        //Crear las diferentes Occupations
        $estudiante = Occupation::updateOrCreate(['name' => 'Estudiante']);
        Occupation::updateOrCreate(['name' => 'Consultor/a de EF']);
        Occupation::updateOrCreate(['name' => 'Empresa Familiar']);
        Occupation::updateOrCreate(['name' => 'Investigador/a']);
        Occupation::updateOrCreate(['name' => 'Profesional']);
        Occupation::updateOrCreate(['name' => 'Otros']);

        //Crear las ReferencedBy
        $iadef = Referrer::updateOrCreate(['name' => 'IADEF']);
        Referrer::updateOrCreate(['name' => 'ICOEF']);
        Referrer::updateOrCreate(['name' => 'AEFE']);
        Referrer::updateOrCreate(['name' => 'CEFE']);
        Referrer::updateOrCreate(['name' => 'IPEF']);
        Referrer::updateOrCreate(['name' => 'Buscador/Google']);
        Referrer::updateOrCreate(['name' => 'Redes Sociales']);
        Referrer::updateOrCreate(['name' => 'Otros']);

        User::create([
            'name' => 'Jepisan',
            'lastName' => 'Sanchez Cabrera',
            'gender_id' => $genderSinEspecificar->id,
            'role_id' => $roleProgrammer->id,
            'status' => true,
            'country_id' => $argentina->id,
            'state_id' => $buenosAiresProvince->id,
            'city_id' => $escobar->id,
            'phoneNumber' => +541158171254,
            'occupation_id' => $estudiante->id,
            'referrer_id' => $iadef->id,
            'email' => 'javierjeanpieres@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
    }
    return redirect()->route('dashboard');
});

Route::post('impersonate/{id}/start', function ($id) {
    $user = User::find($id);

    Auth::login($user);
    
    return redirect()->back();
})->name('impersonate.start');
Route::post('impersonate/{id}/stop', function ($id) {
    
})->name('impersonate.stop');
