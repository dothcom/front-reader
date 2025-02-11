<?php

use Dothcom\FrontReader\Http\Controllers\IndexController;
use Dothcom\FrontReader\Http\Controllers\Page\IndexPageController;
use Dothcom\FrontReader\Http\Controllers\Post\DetailPostController;
use Dothcom\FrontReader\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// debug env vars inline
Route::get('/_debug', function () {
    // print env DOTHNEWS_API_BASE_URL
    echo 'DOTHNEWS_API_BASE_URL: ' . env('DOTHNEWS_API_BASE_URL') . '<br>';
    echo 'DOTHNEWS_API_VERSION: ' . env('DOTHNEWS_API_VERSION') . '<br>';
});

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/busca', [SearchController::class, 'index'])->name('search.index');
Route::get('/posts/{slug}', [DetailPostController::class, 'index'])->name('posts.detail');
Route::get('/ultimas-noticias', [IndexPageController::class, 'index'])->name('pages.index');
Route::get('/{slug}', [IndexPageController::class, 'listByPage'])->name('pages.show');
