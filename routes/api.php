<?php

use App\Http\Controllers\IglesiaController;
use App\Http\Controllers\ProgramacionController;
use App\Http\Controllers\UserController;
use App\Models\Iglesia;
use App\Models\ParticipantesProgramacionMinisterio;
use App\Models\Programacion;
use App\Models\TipoProgramacion;
use App\Models\User;
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

    Route::get('/program/user_program', [ProgramacionController::class,'user_program']);
    Route::get('/program/participantes_program/{ministerio_id}', [ProgramacionController::class,'participantes_program']);
});



