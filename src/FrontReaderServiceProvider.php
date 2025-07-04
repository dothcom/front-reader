<?php

namespace Dothcom\FrontReader;

use Dothcom\FrontReader\Http\Controllers\Page\IndexPageController;
use Dothcom\FrontReader\Services\PageService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FrontReaderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRoutes();

        $this->publishConfig();
    }

    public function register()
    {
    }

    /**
     * Register the routes/pages for the package.
     * This method will dynamically create routes based on the slugs
     *
     * @return void
     */
    private function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/Http/Routes/web.php');

        try {
            $slugs = Cache::remember('front-reader.slugs', 60, function () {
                $pageService = new PageService();
                return $pageService->getPermalinks();
            });

            Route::middleware('web')->group(function () use ($slugs) {
                foreach ($slugs as $slug) {
                    Route::get("/{$slug}", function () use ($slug) {
                        return app(IndexPageController::class)->listByPage($slug);
                    })->name("pages.show.{$slug}");
                }
            });
        } catch (\Throwable $e) {
            Log::error('Error registering dynamic routes: '.$e->getMessage());
        }
    }

    /**
     * Used to publish the configuration file to the application's config directory,
     * ex: php artisan vendor:publish --tag=front-reader-config
     *
     * @return void
     */
    private function publishConfig()
    {
        $this->publishes([
            __DIR__.'/config/front-reader.php' => config_path('front-reader.php'),
        ], 'front-reader-config');
    }
}
