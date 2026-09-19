<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImagePostCommentController;
use App\Http\Controllers\ImagePostController;
use App\Http\Controllers\ImagePostLikeController;
use App\Http\Controllers\Profile\SubscriberController;
use App\Http\Controllers\Profile\SubscriptionController;
use App\Http\Controllers\TextPostCommentController;
use App\Http\Controllers\TextPostController;
use App\Http\Controllers\TextPostLikeController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ImagePostController::class, 'index']);
Route::get('/sol/{imagePost}', [ImagePostController::class, 'show']);
Route::get('/sol/{imagePost}/comments', [ImagePostCommentController::class, 'index']);

Route::get('/echoes', [TextPostController::class, 'index']);
Route::get('/echoes/{textPost}', [TextPostController::class, 'show']);
Route::get('/echoes/{textPost}/comments', [TextPostCommentController::class, 'index']);


Route::get('/profiles', [UserProfileController::class, 'index']);
Route::get('/profiles/{userProfile}', [UserProfileController::class, 'show']);
Route::get('/profiles/{userProfile}/subscriptions', [SubscriptionController::class, 'index']);
Route::get('/profiles/{userProfile}/subscribers', [SubscriberController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/sol/create', [ImagePostController::class, 'create']);
    Route::post('/sol', [ImagePostController::class, 'store']);
    Route::get('/sol/{imagePost}/edit', [ImagePostController::class, 'edit']);
    Route::patch('/sol/{imagePost}', [ImagePostController::class, 'update']);
    Route::delete('/sol/{imagePost}', [ImagePostController::class, 'destroy']);

    Route::get('/echoes/create', [TextPostController::class, 'create']);
    Route::post('/echoes', [TextPostController::class, 'store']);
    Route::get('/echoes/{textPost}/edit', [TextPostController::class, 'edit']);
    Route::patch('/echoes/{textPost}', [TextPostController::class, 'update']);
    Route::delete('/echoes/{textPost}', [TextPostController::class, 'destroy']);

    Route::delete('/logout', [SessionController::class, 'destroy']);

    Route::get('/profiles/{userProfile}/edit', [UserProfileController::class, 'edit']);
    Route::patch('/profiles/{userProfile}', [UserProfileController::class, 'update']);
    Route::delete('/profiles/{userProfile}', [UserProfileController::class, 'destroy']);

    Route::post('/profiles/{userProfile}/subscribers', [SubscriberController::class, 'store']);
    Route::delete('/profiles/{userProfile}/subscribers', [SubscriberController::class, 'destroy']);

    Route::post('/echoes/{textPost}/likes', [TextPostLikeController::class, 'store']);
    Route::delete('/echoes/{textPost}/likes', [TextPostLikeController::class, 'destroy']);

    Route::post('/sol/{imagePost}/likes', [ImagePostLikeController::class, 'store']);
    Route::delete('/sol/{imagePost}/likes', [ImagePostLikeController::class, 'destroy']);

    Route::post('/sol/{imagePost}/comments',    [ImagePostCommentController::class, 'store']);
    Route::post('/echoes/{textPost}/comments',  [TextPostCommentController::class, 'store']);

    Route::patch('/comments/{comment}',  [CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);



});

Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
});

// fix /post/create
// add at main index / available tags in one line, filter by them with get param do it cross site with route /search/
// add a sprinkle of js for likes, comments and subscriptions
// build restriction for guests: you need login to click likes comments and subscribe
// fix why not all images I can publish
// seed db with more realistic data
// enable db cashing (reset on create update new post or every 15 minutes)
// create custom 404 page
// play with automated testing
// try to apply something from this: Service Pattern, SOLID, KISS, DRY
// return view('image-posts.show', $imagePost); vs return view('image-posts.show', compact('imagePost'));
