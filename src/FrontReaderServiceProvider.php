<?php

namespace DothNews\FrontReader;

use Illuminate\Support\ServiceProvider;

class FrontReaderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/Http/Routes/web.php');

        $this->publishes([
            __DIR__.'/config/front-reader.php' => config_path('front-reader.php'),
        ], 'front-reader-config');
    }

    public function register() {}
}
