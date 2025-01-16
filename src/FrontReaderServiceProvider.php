<?php

namespace Dothcom\FrontReader;

use Illuminate\Support\ServiceProvider;

class FrontReaderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // The loadRoutesFrom method is used to load routes from a file within your package.
        $this->loadRoutesFrom(__DIR__.'/Http/Routes/web.php');

        // THE publishes METHOD is used to publish the configuration file to the application's config directory,
        // using command php artisan vendor:publish --tag=front-reader-config
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
