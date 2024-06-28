<?php

namespace DothNews\FrontReader;

use Illuminate\Support\ServiceProvider;

class FrontReaderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Http/Routes/web.php');
    }

    public function register()
    {

    }
}
