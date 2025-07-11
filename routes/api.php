<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\AlbumController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\AuthenticationController;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

// Authentication
Route::prefix('auth')->group(function() {
    Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
});

// Protected routes
Route::middleware('auth.api')->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/user', [AuthenticationController::class, 'userInfo']);

    // Users
    Route::prefix('users')->group(function() {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/paginate', [UserController::class, 'paginate']);
        Route::get('/{id}', [UserController::class, 'show']);
    });

    // Posts
    Route::prefix('posts')->group(function() {
        Route::get('/', [PostController::class, 'index']);
        Route::get('/paginate', [PostController::class, 'paginate']);
        Route::get('/{id}', [PostController::class, 'show']);
    });

    // Comments
    Route::prefix('comments')->group(function() {
        Route::get('/', [CommentController::class, 'index']);
        Route::get('/paginate', [CommentController::class, 'paginate']);
        Route::get('/{id}', [CommentController::class, 'show']);
    });

    // Albums
    Route::prefix('albums')->group(function() {
        Route::get('/', [AlbumController::class, 'index']);
        Route::get('/paginate', [AlbumController::class, 'paginate']);
        Route::get('/{id}', [AlbumController::class, 'show']);
    });

    // Photos
    Route::prefix('photos')->group(function() {
        Route::get('/', [PhotoController::class, 'index']);
        Route::get('/paginate', [PhotoController::class, 'paginate']);
        Route::get('/{id}', [PhotoController::class, 'show']);
    });

    // Todos
    Route::prefix('todos')->group(function() {
        Route::get('/', [TodoController::class, 'index']);
        Route::get('/paginate', [TodoController::class, 'paginate']);
        Route::get('/{id}', [TodoController::class, 'show']);
    });

});
