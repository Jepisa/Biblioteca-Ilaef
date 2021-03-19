<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('programmer', function () {
            return (auth()->user()->role->name == "Programador");
        });

        Blade::if('minAdmin', function () {
            return (auth()->user()->role->name == "Administrador" or auth()->user()->role->name == "Administrador Principal" or auth()->user()->role->name == "Programador");
        });
    }
}
