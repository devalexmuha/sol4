<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\ImagePostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TextPostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ImagePostController::class, 'index']);
Route::get('/sol/create', [ImagePostController::class, 'create']);
Route::post('/sol', [ImagePostController::class, 'store']);
Route::get('/sol/{sol}', [ImagePostController::class, 'show']); // check how variable here will be bound
Route::get('/sol/{sol}/edit', [ImagePostController::class, 'edit']);
Route::patch('/sol/{sol}', [ImagePostController::class, 'store']);
Route::delete('/sol/{sol}', [ImagePostController::class, 'destroy']);

Route::get('/echoes', [TextPostController::class, 'index']);
Route::get('/eches/create', [TextPostController::class, 'create']);
Route::post('/eches', [ImagePostController::class, 'store']);
Route::get('/eches/{echo}', [ImagePostController::class, 'show']); // check how variable here will be bound
Route::get('/eches/{echo}/edit', [ImagePostController::class, 'edit']);
Route::patch('/eches/{echo}', [ImagePostController::class, 'store']);
Route::delete('/eches/{echo}', [ImagePostController::class, 'destroy']);

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::get('/logout', [SessionController::class, 'destroy']);

Route::get('/register', [RegisterController::class, 'create']);
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/profile', [ProfileController::class, 'show']);
Route::get('/profile/edit', [ProfileController::class, 'edit']);
Route::patch('/profile', [ProfileController::class, 'update']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);


// done authentification
// work with users (profiles, edit profile, policy..., show listing of other users)
// work over posts
// add a sprincle of js for likes, comments and subscriptions
// seed db with more realistic data
// enable db cashing (reset on create update new post or every 15 minutes)
// play with automated testing
// try to apply something from this: Service Pattern, SOLID, KISS, DRY

