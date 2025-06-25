<?php

use Dothcom\FrontReader\Http\Controllers\IndexController;
use Dothcom\FrontReader\Http\Controllers\Page\IndexPageController;
use Dothcom\FrontReader\Http\Controllers\Post\DetailPostController;
use Dothcom\FrontReader\Http\Controllers\SearchController;
use Dothcom\FrontReader\Services\PageService;
use Dothcom\FrontReader\Services\PostService;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

// debug env vars inline
Route::get('/_debug', function () {
    // print env DOTHNEWS_API_BASE_URL
    echo 'DOTHNEWS_API_BASE_URL: '.env('DOTHNEWS_API_BASE_URL').'<br>';
    echo 'DOTHNEWS_API_VERSION: '.env('DOTHNEWS_API_VERSION').'<br>';
});

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/busca', [SearchController::class, 'index'])->name('search.index');
Route::get('/ultimas-noticias', [IndexPageController::class, 'index'])->name('pages.index');

Route::get('/post/{slug?}', function ($slug) {
    if (str_contains($slug, '/')) {
        $segments = array_filter(explode('/', $slug));
        $slug = end($segments);
    }
    try {
        $postService = new PostService();
        $post = $postService->getPostBySlug($slug);

        if (isset($post->data->id)) {
            return app(DetailPostController::class)->index($slug);
        }
    } catch (\Exception $e) {
        abort(404, $e->getMessage());
    }
})->where('slug', '^[a-zA-Z0-9-_\/]*$')->name('posts.detail');
