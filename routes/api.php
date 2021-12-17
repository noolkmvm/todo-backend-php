<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\ListItemController;
use App\Http\Controllers\Auth\AuthController;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('user', [AuthController::class, 'user']);
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::apiResource('lists', TodoListController::class);
    Route::apiResource('lists.items', ListItemController::class);
});
