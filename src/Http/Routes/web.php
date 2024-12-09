<?php

use DothNews\FrontReader\Http\Controllers\IndexController;
use DothNews\FrontReader\Http\Controllers\Post\DetailPostController;
use DothNews\FrontReader\Http\Controllers\Category\IndexCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('/posts/{slug}', [DetailPostController::class, 'index'])->name('posts.detail');

Route::get('/ultimas-noticias', [IndexCategoryController::class, 'index'])->name('categories.index');
Route::get('/{slug}', [IndexCategoryController::class, 'listByCategory'])->name('categories.show');
