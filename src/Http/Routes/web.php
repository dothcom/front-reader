<?php

use DothNews\FrontReader\Http\Controllers\IndexController;
use DothNews\FrontReader\Http\Controllers\Post\DetailPostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('/posts/{slug}', [DetailPostController::class, 'index'])->name('posts.detail');
