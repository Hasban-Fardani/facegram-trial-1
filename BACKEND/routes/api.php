<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function (){
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/register', [AuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::apiResource('posts', PostController::class)
            ->except(['show', 'update']);

        Route::prefix('/users')->group(function () {
            Route::post('/{user:username}/follow', [FollowController::class, 'follow']);
            Route::put('/{user:username}/accept', [FollowController::class, 'accept']);
            Route::delete('/{user:username}/unfollow', [FollowController::class, 'unfollow']);
            Route::get('/{user:username}/following', [FollowController::class, 'following']);
            Route::get('/{user:username}/followers', [FollowController::class, 'followers']);
        });
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{user:username}', [UserController::class, 'show']);
        // Route::apiResource('users', UserController::class)
        //     ->only(['index', 'show']);
    });
});