<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\Content\BookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

require __DIR__.'/auth.php';
require __DIR__.'/programmer.php';

Route::get('pru', function () {
    dd(Storage::deleteDirectory('public/images/books/Primer Libro'));
});

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('aboutUs', [])->name('aboutUs')->middleware('auth');
Route::get('contact', [])->name('contact')->middleware('auth');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard'); //->middleware(['verified','auth'])

Route::get('books', [BookController::class, 'index'])->name('books.index')->middleware('auth');
Route::get('book/create', [BookController::class, 'create'])->name('book.create')->middleware(['auth']);
Route::get('book/{slug}', [BookController::class, 'show'])->name('book.show');
Route::post('book',[BookController::class, 'store'])->name('book.store')->middleware('auth');
Route::get('book/{slug}/edit', [BookController::class, 'edit'])->name('book.edit');
Route::put('book/{slug}', [BookController::class, 'update'])->name('book.update');
Route::delete('book/{slug}', [BookController::class, 'destroy'])->name('book.destroy');




Route::get('author/create', [AuthorController::class, 'create'])->name('author.create');
Route::post('author', [AuthorController::class, 'store'])->name('authore.store');
Route::get('author/{name}/edit', [AuthorController::class, 'edit'])->name('author.edit');
Route::put('author{name}', [AuthorController::class, 'update'])->name('author.update');
Route::delete('author{name}', [AuthorController::class, 'destroy'])->name('author.destroy');

