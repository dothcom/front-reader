<?php

use Dothcom\FrontReader\Http\Controllers\IndexController;
use Dothcom\FrontReader\Http\Controllers\Post\DetailPostController;
use Dothcom\FrontReader\Http\Controllers\SearchController;
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

// ROUTE FOR PAGES
Route::get('{permalink}', [DetailPostController::class, 'index'])
    ->where('permalink', '^(?:[a-z0-9-]+\/){0,5}noticia\/\d{4}\/\d{2}\/\d{2}\/[a-z0-9-]+\.html$')
    ->name('posts.detail');

// ROUTES FROM PAGES ARE REGISTERED DYNAMICALLY IN THE SERVICE PROVIDER - FrontReaderServiceProvider.php
