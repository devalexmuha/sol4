<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\ImagePostController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TextPostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ImagePostController::class, 'index']);
Route::get('/echoes', [TextPostController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/sol/create', [ImagePostController::class, 'create']);
    Route::post('/sol', [ImagePostController::class, 'store']);
    Route::get('/sol/{imagePost}', [ImagePostController::class, 'show']); // check how variable here will be bound
    Route::get('/sol/{imagePost}/edit', [ImagePostController::class, 'edit']);
    Route::patch('/sol/{imagePost}', [ImagePostController::class, 'update']);
    Route::delete('/sol/{imagePost}', [ImagePostController::class, 'destroy']);

    Route::get('/echoes/create', [TextPostController::class, 'create']);
    Route::post('/echoes', [TextPostController::class, 'store']);
    Route::get('/echoes/{textPost}', [TextPostController::class, 'show']); // check how variable here will be bound
    Route::get('/echoes/{textPost}/edit', [TextPostController::class, 'edit']);
    Route::patch('/echoes/{textPost}', [TextPostController::class, 'update']);
    Route::delete('/echoes/{textPost}', [TextPostController::class, 'destroy']);

    Route::delete('/logout', [SessionController::class, 'destroy']);

    Route::get('/profile', [UserProfileController::class, 'show']);
    Route::get('/profile/{userProfile}/edit', [UserProfileController::class, 'edit']);
    Route::patch('/profile/{userProfile}', [UserProfileController::class, 'update']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
});

//write policies
// fix: header missing user image
// work with users (profiles, edit profile, policy..., show listing of other users)
// work over posts
// add at main index / avalible tags in one line, filter by them with get param
// add a sprincle of js for likes, comments and subscriptions
// seed db with more realistic data
// enable db cashing (reset on create update new post or every 15 minutes)
// create custom 404 page
// play with automated testing
// try to apply something from this: Service Pattern, SOLID, KISS, DRY
// return view('image-posts.show', $imagePost); vs return view('image-posts.show', compact('imagePost'));
