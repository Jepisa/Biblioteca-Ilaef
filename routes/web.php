<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\Content\BookController;
use App\Http\Controllers\Content\PodcastController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

require __DIR__.'/auth.php';
require __DIR__.'/programmer.php';
require __DIR__.'/admin.php';



Route::get('/', HomeController::class)->name('home')->middleware('auth');

Route::get('aboutUs', function () {
    return 'Proximamente';
})->name('aboutUs')->middleware('auth');
Route::get('contact', function () {
    return 'Proximamente';
})->name('contact')->middleware('auth');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['verified','auth'])->name('dashboard'); //->middleware(['verified','auth'])

//Books
Route::get('books', [BookController::class, 'index'])->name('books.index')->middleware('auth');
Route::get('book/create', [BookController::class, 'create'])->name('book.create')->middleware(['auth']);
Route::get('book/{slug}', [BookController::class, 'show'])->name('book.show');
Route::post('book',[BookController::class, 'store'])->name('book.store')->middleware('auth');
Route::get('book/{slug}/edit', [BookController::class, 'edit'])->name('book.edit');
Route::put('book/{slug}', [BookController::class, 'update'])->name('book.update');
Route::delete('book/{slug}', [BookController::class, 'destroy'])->name('book.destroy');

//Podcast
Route::get('podcasts', [PodcastController::class, 'index'])->name('podcasts.index')->middleware('auth');
Route::get('podcast/create', [PodcastController::class, 'create'])->name('podcast.create')->middleware(['auth']);
Route::get('podcast/{slug}', [PodcastController::class, 'show'])->name('podcast.show');
Route::post('podcast',[PodcastController::class, 'store'])->name('podcast.store')->middleware('auth');
Route::get('podcast/{slug}/edit', [PodcastController::class, 'edit'])->name('podcast.edit');
Route::put('podcast/{slug}', [PodcastController::class, 'update'])->name('podcast.update');
Route::delete('podcast/{slug}', [PodcastController::class, 'destroy'])->name('podcast.destroy');




Route::get('author/create', [AuthorController::class, 'create'])->name('author.create');
Route::post('author', [AuthorController::class, 'store'])->name('authore.store');
Route::get('author/{name}/edit', [AuthorController::class, 'edit'])->name('author.edit');
Route::put('author{name}', [AuthorController::class, 'update'])->name('author.update');
Route::delete('author{name}', [AuthorController::class, 'destroy'])->name('author.destroy');

