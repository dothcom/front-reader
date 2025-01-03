<?php

namespace DothNews\FrontReader;

use DothNews\FrontReader\Services\MenuService;
use DothNews\FrontReader\Services\PostService;
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

    public function register()
    {
        // $this->app->singleton(PostService::class, function ($app) {
        //     return new PostService();
        // });

        // $this->app->singleton(MenuService::class, function ($app) {
        //     return new MenuService();
        // });
        $this->loadHelpers();
    }

    protected function loadHelpers()
    {
        $helpers = __DIR__.'/helpers.php';
        if (file_exists($helpers)) {
            require_once $helpers;
        }
    }
}
