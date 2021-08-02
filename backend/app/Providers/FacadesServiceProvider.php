<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

/**
 * Class FacadesServiceProvider
 * @package App\Providers
 * @author Kostykevich Artyom <kstartfd@gmail.com>
 */
class FacadesServiceProvider  extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        App::bind('ApiHelper', function() {
            return new \App\Helpers\ApiHelper;
        });
    }
}
