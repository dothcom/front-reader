<?php

use DothNews\FrontReader\Http\Controllers\IndexController;
use DothNews\FrontReader\Http\Controllers\Post\IndexPostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('/posts', [IndexPostController::class, 'index'])->name('posts.index');
