<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and will be assigned to
| the "api" middleware group. Now create something great!
|
*/

Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->middleware('api');

Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->middleware('web');

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout',[LoginController::class,'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
