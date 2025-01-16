<?php

use Dothcom\FrontReader\Http\Controllers\IndexController;
use Dothcom\FrontReader\Http\Controllers\Page\IndexPageController;
use Dothcom\FrontReader\Http\Controllers\Post\DetailPostController;
use Dothcom\FrontReader\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/busca', [SearchController::class, 'index'])->name('search.index');
Route::get('/posts/{slug}', [DetailPostController::class, 'index'])->name('posts.detail');
Route::get('/ultimas-noticias', [IndexPageController::class, 'index'])->name('pages.index');
Route::get('/{slug}', [IndexPageController::class, 'listByPage'])->name('pages.show');
