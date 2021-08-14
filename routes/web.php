<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\Content\BookController;
use App\Http\Controllers\Content\PodcastController;
use App\Http\Controllers\Content\EbookController;
use App\Http\Controllers\Content\InvestigationWorkController;
use App\Http\Controllers\SearchContentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

require __DIR__.'/auth.php';
require __DIR__.'/programmer.php';
require __DIR__.'/admin.php';



Route::get('/', HomeController::class)->name('home')->middleware('auth');


Route::get('favorites', function () {
    return view('favorites');
})->middleware(['verified','auth'])->name('favorites');

Route::get('aboutUs', function () {
    return view('aboutUs');
})->middleware(['verified','auth'])->name('aboutUs');
Route::get('contact', function () {
    return view('contact');
})->middleware(['verified','auth'])->name('contact');

Route::get('search', [SearchContentController::class, 'search'])->name('searchContent');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['verified','auth'])->name('dashboard'); //->middleware(['verified','auth'])

//Books

Route::get('book/{slug}', [BookController::class, 'show'])->name('book.show');

//Podcast
Route::get('podcasts', [PodcastController::class, 'index'])->name('podcasts.index')->middleware('auth');
Route::get('podcast/create', [PodcastController::class, 'create'])->name('podcast.create')->middleware(['auth']);
Route::get('podcast/{slug}', [PodcastController::class, 'show'])->name('podcast.show');
Route::post('podcast',[PodcastController::class, 'store'])->name('podcast.store')->middleware('auth');
Route::get('podcast/{slug}/edit', [PodcastController::class, 'edit'])->name('podcast.edit');
Route::put('podcast/{slug}', [PodcastController::class, 'update'])->name('podcast.update');
Route::delete('podcast/{slug}', [PodcastController::class, 'destroy'])->name('podcast.destroy');

//E-Books
Route::get('ebooks', [EbookController::class, 'index'])->name('ebooks.index')->middleware('auth');
Route::get('ebook/create', [EbookController::class, 'create'])->name('ebook.create')->middleware(['auth']);
Route::get('ebook/{slug}', [EbookController::class, 'show'])->name('ebook.show');
Route::post('ebook',[EbookController::class, 'store'])->name('ebook.store')->middleware('auth');
Route::get('ebook/{slug}/edit', [EbookController::class, 'edit'])->name('ebook.edit');
Route::put('ebook/{slug}', [EbookController::class, 'update'])->name('ebook.update');
Route::delete('ebook/{slug}', [EbookController::class, 'destroy'])->name('ebook.destroy');

//Investigation Work
Route::get('investigation-works', [InvestigationWorkController::class, 'index'])->name('investigationworks.index')->middleware('auth');
Route::get('investigation-work/create', [InvestigationWorkController::class, 'create'])->name('investigationwork.create')->middleware(['auth']);
Route::get('investigation-work/{slug}', [InvestigationWorkController::class, 'show'])->name('investigationwork.show');
Route::post('investigation-work',[InvestigationWorkController::class, 'store'])->name('investigationwork.store')->middleware('auth');
Route::get('investigation-work/{slug}/edit', [InvestigationWorkController::class, 'edit'])->name('investigationwork.edit');
Route::put('investigation-work/{slug}', [InvestigationWorkController::class, 'update'])->name('investigationwork.update');
Route::delete('investigation-work/{slug}', [InvestigationWorkController::class, 'destroy'])->name('investigationwork.destroy');




Route::get('author/create', [AuthorController::class, 'create'])->name('author.create');
Route::post('author', [AuthorController::class, 'store'])->name('authore.store');
Route::get('author/{name}/edit', [AuthorController::class, 'edit'])->name('author.edit');
Route::put('author{name}', [AuthorController::class, 'update'])->name('author.update');
Route::delete('author{name}', [AuthorController::class, 'destroy'])->name('author.destroy');



Route::view('results', 'results');
Route::view('max-results', 'max-results');