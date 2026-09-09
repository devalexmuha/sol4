<?php

use App\Http\Controllers\ImagePostController;
use App\Http\Controllers\TextPostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ImagePostController::class, 'index']);
Route::get('/echoes', [TextPostController::class, 'index']);

// Service Pattern, SOLID, KISS, DRY (find out how to use)
// introduce myself into automated testing


// create seeders, factories, test your 500 queries with debugbar().
// debugbar()->enable();
