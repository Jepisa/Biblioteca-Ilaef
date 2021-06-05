<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NotificationsController;



Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.admin');
    });
    Route::get('advertisements', [AdvertisementController::class, 'index'])->name('advertisements.index');
    Route::get('advertisement/create', [AdvertisementController::class, 'create'])->name('advertisement.create');
    Route::post('advertisement', [AdvertisementController::class, 'store'])->name('advertisement.store');
    Route::get('advertisement/{id}/edit', [AdvertisementController::class, 'edit'])->name('advertisement.edit');
    Route::put('advertisement/{id}', [AdvertisementController::class, 'update'])->name('advertisement.update');
    Route::delete('advertisement/{id}', [AdvertisementController::class, 'destroy'])->name('advertisement.destroy');
    
    Route::match(
        ['get', 'post'],
        '/navbar/search',
        [SearchController::class, 'showNavbarSearchResults']
    );

    Route::get('notifications/get', [NotificationsController::class,'getNotificationsData'])->name('notifications.get');
});