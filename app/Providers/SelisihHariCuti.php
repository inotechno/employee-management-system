<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SelisihHariCuti extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helpers/SelisihHariCuti.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
