<?php

use App\Http\Controllers\ImagePostController;
use App\Http\Controllers\TextPostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ImagePostController::class, 'index']);
Route::get('/echoes', [TextPostController::class, 'index']);
















// db cashing (reset on create update new post or every 15 minutes)
// introduce myself into automated testing
// Service Pattern, SOLID, KISS, DRY (find out how to use)
