<?php

namespace DothNews\FrontReader;

use Illuminate\Support\ServiceProvider;
use DothNews\FrontReader\Services\PostService;
use DothNews\FrontReader\Services\MenuService;

class FrontReaderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/Http/Routes/web.php');

        $this->publishes([
            __DIR__.'/config/front-reader.php' => config_path('front-reader.php'),
        ], 'front-reader-config');
    }

    public function register()
    {
        // $this->app->singleton(PostService::class, function ($app) {
        //     return new PostService();
        // });

        // $this->app->singleton(MenuService::class, function ($app) {
        //     return new MenuService();
        // });


    }
}
