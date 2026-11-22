<?php

use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserMediaController;
use Illuminate\Support\Facades\Route;

Route::apiResource('media', MediaController::class)->parameters(['media' => 'media']);

Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::get('users/{user}/media', [UserMediaController::class, 'index']);
Route::post('users/{user}/media/{media}', [UserMediaController::class, 'store']);
Route::delete('users/{user}/media/{media}', [UserMediaController::class, 'destroy']);
