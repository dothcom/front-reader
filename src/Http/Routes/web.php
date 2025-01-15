<?php

use DothNews\FrontReader\Http\Controllers\IndexController;
use DothNews\FrontReader\Http\Controllers\Page\IndexPageController;
use DothNews\FrontReader\Http\Controllers\Post\DetailPostController;
use DothNews\FrontReader\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/busca', [SearchController::class, 'index'])->name('search.index');
Route::get('/posts/{slug}', [DetailPostController::class, 'index'])->name('posts.detail');
Route::get('/ultimas-noticias', [IndexPageController::class, 'index'])->name('pages.index');
Route::get('/{slug}', [IndexPageController::class, 'listByPage'])->name('pages.show');
