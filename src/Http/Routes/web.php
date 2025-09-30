<?php

use Dothcom\FrontReader\Http\Controllers\IndexController;
use Dothcom\FrontReader\Http\Controllers\Post\DetailPostController;
use Dothcom\FrontReader\Http\Controllers\SearchController;
use Dothcom\FrontReader\Http\Controllers\Tag\IndexTagController;
use Dothcom\FrontReader\Http\Controllers\Tag\DetailTagController;
use Illuminate\Support\Facades\Route;

// debug env vars inline
Route::get('/_debug', function () {
    // print env DOTHNEWS_API_BASE_URL
    echo 'DOTHNEWS_API_BASE_URL: '.env('DOTHNEWS_API_BASE_URL').'<br>';
    echo 'DOTHNEWS_API_VERSION: '.env('DOTHNEWS_API_VERSION').'<br>';
});

// ROUTE FOR HOME PAGE
Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('/busca', [SearchController::class, 'index'])->name('search.index');

Route::get('/tags', [IndexTagController::class, 'index'])->name('tag.index');
Route::get('/tags/{slug}', [DetailTagController::class, 'index'])
    ->where('slug', '[a-z0-9-]+')
    ->name('tag.detail');

// ROUTE FOR POSTS DETAIL
Route::get('{permalink}', [DetailPostController::class, 'index'])
    ->where('permalink', '^(?:[a-z0-9-]+\/){0,5}\d{4}\/\d{2}\/\d{2}\/[a-z0-9-]+\.html$')
    ->name('posts.detail');

// ROUTES FROM PAGES ARE REGISTERED DYNAMICALLY IN THE SERVICE PROVIDER - FrontReaderServiceProvider.php
