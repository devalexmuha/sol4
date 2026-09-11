<?php

use App\Http\Controllers\ImagePostController;
use App\Http\Controllers\TextPostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ImagePostController::class, 'index']);
Route::get('/sol/create', [ImagePostController::class, 'create']);
Route::post('/sol', [ImagePostController::class, 'store']);

Route::get('/echoes', [TextPostController::class, 'index']);
Route::get('/echo/create', [TextPostController::class, 'create']);



// build echoes index
// build / and echoes show
// work on auth or user register












// db cashing (reset on create update new post or every 15 minutes)
// introduce myself into automated testing
// Service Pattern, SOLID, KISS, DRY (find out how to use)
