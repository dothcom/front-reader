<?php

use Illuminate\Support\Facades\Route;
use DothNews\FrontReader\Http\Controllers\IndexController;

Route::get('/', [IndexController::class, 'index']);