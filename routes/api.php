<?php

use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\IglesiaController;
use App\Http\Controllers\ProgramacionController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\UserController;
use App\Models\Iglesia;
use App\Models\Ministerio;
use App\Models\ParticipantesProgramacionMinisterio;
use App\Models\Programacion;
use App\Models\Recurso;
use App\Models\Rol;
use App\Models\TipoProgramacion;
use App\Models\TipoRecurso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::post('/users/register', [UserController::class, 'register'])->name('register');
Route::post('/users/login', [UserController::class, 'authenticate']);

Route::post('/addimage', [ArchivoController::class,'addimage']);  

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('/users/user', [UserController::class, 'getAuthenticatedUser']);
    Route::put('/users/update', [UserController::class, 'update']);
    Route::post('/users/change_avatar', [UserController::class, 'change_avatar']);
    Route::put('/users/change_password', [UserController::class, 'change_password']);
    Route::post('/users/logout', [UserController::class, 'logout']);
    Route::get('/iglesias/index', [IglesiaController::class, 'index']);

    Route::get('/recursos/index', [RecursoController::class,'index']);
    Route::post('/recursos/store', [RecursoController::class,'store']);   
    Route::get('/recursos/show/{recuros_id}', [RecursoController::class,'index']);  
    


    Route::post('/program/store', [ProgramacionController::class,'store']);
    Route::get('/program/show/{programa_id}', [ProgramacionController::class,'show']);
    Route::put('/program/update/{programa_id}', [ProgramacionController::class,'update']);
    Route::get('/program/user_program', [ProgramacionController::class,'user_program']);
    Route::get('/program/participantes_program/{programa_id}', [ProgramacionController::class,'participantes_program']);
    Route::get('/program/recursos_program/{programa_id}', [ProgramacionController::class,'recursos_program']);
    Route::get('/program/own_program', [ProgramacionController::class,'own_program']);
    Route::post('/program/add_users/{programa_id}', [ProgramacionController::class,'add_users']);
    Route::post('/program/add_resource/{programa_id}', [ProgramacionController::class,'add_resource']);
    Route::delete('/program/delete_recurso/{programa_id}', [ProgramacionController::class,'delete_recurso']);
    Route::delete('/program/delete_participante/{programa_id}', [ProgramacionController::class,'delete_participante']);


    Route::get('/tipo_program/index', function(){
        $data=TipoProgramacion::all(['id','nombre']);
        return response()->json(compact('data'));
    });

    //Listas para agregar participantes a programas
    Route::get('/listas1/index', function(){
        $ministerios=Ministerio::orderBy('nombre','asc')->get(['id','nombre']);
        $usuarios=User::orderBy('name','asc')->get(['id','name']);
        $roles=Rol::orderBy('nombre','asc')->get(['id','nombre']);
        return response()->json(compact('ministerios','usuarios','roles'));
    });
    //Listas para agregar recuros a programa
    Route::get('/listas2/index', function(){
        $ministerios=Ministerio::orderBy('nombre','asc')->get(['id','nombre']);
        $recursos=Recurso::orderBy('nombre','asc')->get(['id','nombre']);
        return response()->json(compact('ministerios','recursos'));
    });
     //Listas para crear nuevos recursos
     Route::get('/listas3/index', function(){
        $ministerios=Ministerio::orderBy('nombre','asc')->get(['id','nombre']);
        $tipoRecursos=TipoRecurso::orderBy('nombre','asc')->get(['id','nombre']);
        return response()->json(compact('ministerios','tipoRecursos'));
    });
});



