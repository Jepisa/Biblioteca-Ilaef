<?php

use App\Http\Controllers\Content\BookController;
use App\Models\Author;
use Illuminate\Support\Facades\Route;


require __DIR__.'/auth.php';
require __DIR__.'/programmer.php';


// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['verified','auth'])->name('dashboard');

Route::get('books', [BookController::class, 'index'])->name('books.index')->middleware('auth');
Route::get('book/create', [BookController::class, 'create'])->name('book.create')->middleware(['auth']);
Route::post('book',[BookController::class, 'store'])->name('book.store')->middleware('auth');

Route::get('author/create', [Author::class, 'create'])->name('author.create');
Route::post('author', [Author::class, 'store'])->name('authore.store');
Route::put('author/edit', [Author::class, 'edit'])->name('author.edit');
Route::delete('author', [Author::class, 'update'])->name('author.update');
