<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // No FirebaseService registration needed anymore
    }

    public function boot()
    {
        //
    }
}
