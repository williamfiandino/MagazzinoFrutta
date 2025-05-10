<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Doctrine\DBAL\Types\Type;

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
        // Registra il tipo ENUM in Doctrine
        if (!Type::hasType('enum')) {
            Type::addType('enum', 'Doctrine\DBAL\Types\StringType');
        }
    }
}
