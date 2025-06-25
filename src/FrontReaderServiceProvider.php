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

    public function register() {}

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
            $pages = Cache::remember('front-reader.pages', 600, function () {
                $pageService = new PageService;

                return $pageService->getUrls();
            });

            if (empty($pages)) {
                return;
            }

            Route::middleware('web')->group(function () use ($pages) {
                foreach ($pages as $page) {
                    if (($page->is_external ?? false) || $page->url === '/') {
                        continue;
                    }

                    $url = trim($page->url, '/');
                    $routeName = "pages.show.{$page->slug}";

                    Log::debug("Registrando rota: {$url} => {$routeName}");

                    Route::get("/{$url}", function () use ($page) {
                        return app(IndexPageController::class)->listByPage($page->slug);
                    })->name($routeName);
                }
            });

            $allRoutes = Route::getRoutes()->getRoutes();
            $registeredPagesRoutes = [];

            foreach ($allRoutes as $route) {
                if (str_starts_with($route->getName() ?? '', 'pages.show.')) {
                    $registeredPagesRoutes[] = $route->getName();
                }
            }
        } catch (\Throwable $e) {
            Log::error('Error registering dynamic routes: '.$e->getMessage());
            throw $e;
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
