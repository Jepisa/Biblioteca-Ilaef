<?php

use Illuminate\Support\Facades\Route;


require __DIR__.'/auth.php';
require __DIR__.'/programmer.php';


// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['verified','auth'])->name('dashboard');


