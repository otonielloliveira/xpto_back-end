<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Controllers
 */

use App\Http\Controllers\Auth\IndexController as AuthController;
use App\Http\Controllers\Url\IndexController as UrlController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('url', UrlController::class);
});
