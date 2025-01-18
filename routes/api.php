<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::prefix('post')->group(function(){
    Route::apiResource('/post', PostController::class);
})->middleware(['auth', 'signed', 'throttle:6,1']);

require __DIR__ . '/auth.php';
