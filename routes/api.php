<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserLogActivityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::group([
    'middleware' => ['auth:sanctum']
    // 'middleware' => ['auth:sanctum', 'throttle:3,10']
], function () {
    Route::apiResource('/posts', PostController::class);
    Route::get('/user-posts', [PostController::class, 'userPosts']);

    Route::get('/activity-log', [UserLogActivityController::class, 'index']);

    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    });
});

require __DIR__ . '/auth.php';
