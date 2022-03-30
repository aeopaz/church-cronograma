<?php

use App\Http\Controllers\IglesiaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users/register', [UserController::class, 'register']);
Route::post('/users/login', [UserController::class, 'authenticate']);

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('/users/user', [UserController::class, 'getAuthenticatedUser']);
    Route::post('/users/logout', [UserController::class, 'logout']);
    Route::get('/iglesias/index', [IglesiaController::class, 'index']);
});
