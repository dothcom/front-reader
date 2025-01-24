<?php

use Dothcom\FrontReader\Http\Controllers\IndexController;
use Dothcom\FrontReader\Http\Controllers\Page\IndexPageController;
use Dothcom\FrontReader\Http\Controllers\Post\DetailPostController;
use Dothcom\FrontReader\Http\Controllers\SearchController;
use Dothcom\FrontReader\Services\PageService;
use Dothcom\FrontReader\Services\PostService;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/busca', [SearchController::class, 'index'])->name('search.index');
Route::get('/ultimas-noticias', [IndexPageController::class, 'index'])->name('pages.index');

Route::get('/{slug?}', function ($slug) {
    if (str_contains($slug, '/')) {
        $segments = array_filter(explode('/', $slug));
        $slug = end($segments);
    }

    try {
        $pageService = new PageService;
        $page = $pageService->getPage($slug);
        if (isset($page->data->id)) {
            return app(IndexPageController::class)->listByPage($slug);
        }
    } catch (NotFoundHttpException $e) {
        $postService = new PostService;
        $post = $postService->getPostBySlug($slug);

        if (isset($post->data->id)) {
            return app(DetailPostController::class)->index($slug);
        }
    } catch (\Exception $e) {
        abort(404, $e->getMessage());
    }
})->where('slug', '^[a-zA-Z0-9-_\/]+$')->name('posts.detail');
