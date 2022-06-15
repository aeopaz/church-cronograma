<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IglesiaController;
use App\Http\Controllers\MinisterioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Ministerio\MinisterioIndex;
use App\Models\Rol;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/users/register', [UserController::class, 'register'])->name('users.register');
Auth::routes();

//Middleware para validar que el usuario este autenticado
Route::middleware('auth')->group(function () {
    Route::middleware('error.estado.usuario')->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::post('/home/marcar_notificacion_leida\{notificacion}', [HomeController::class, 'marcarNotificacionLeida'])->name('home.marcarNotificacionLeida');
        Route::get('/usuario/index', function () {
            return view('usuario.index');
        })->name('usuario.index')->middleware('perfil:admin|lider');

        Route::get('/usuario/perfil', function () {
            return view('usuario.perfil');
        })->name('usuario.perfil');

        Route::get('/iglesia/index', [IglesiaController::class, 'index'])->name('iglesia.index')->middleware('can:admin');
        Route::get('/ministerio/index', [MinisterioController::class, 'index'])->name('ministerio.index')->middleware('can:admin');
        Route::get('/parametrizacion/roles/index', [RolController::class, 'index'])->name('rol.index')->middleware('can:admin');

        Route::get('/programacion/index', function () {
            return view('programacion.index');
        })->name('programacion.index');

        Route::get('/programacion/compromisos', function () {
            return view('programacion.compromisos');
        })->name('programacion.compromisos');

        Route::get('/panel/index', function () {
            return view('panel.index');
        })->name('panel.index');

        Route::get('/recurso/index', function () {
            return view('recurso.index');
        })->name('recurso.index');

        Route::get('/membrecia/index', function () {
            return view('membrecia.index');
        })->name('membrecia.index')->middleware('perfil:admin|lider');

        Route::get('/reportes/index', function () {
            return view('reportes.index');
        })->name('reportes.index')->middleware('perfil:admin|lider');

        //Reportes PDF
        Route::get('reporte/pdf/{tipo}/{fecha1}/{fecha2}/{ministerio}',[ExportController::class,'reportePdf'])->middleware('perfil:admin|lider');
        Route::get('reporte/pdf/{tipo}/{fecha1}/{fecha2}',[ExportController::class,'reportePdf'])->middleware('perfil:admin|lider');
        Route::get('reporte/pdf/{tipo}',[ExportController::class,'reportePdf'])->middleware('perfil:admin|lider');
       
        //Reportes Excel
        Route::get('reporte/excel/{tipo}/{fecha1}/{fecha2}/{ministerio}',[ExportController::class,'reporteExcel'])->middleware('perfil:admin|lider');
        Route::get('reporte/excel/{tipo}/{fecha1}/{fecha2}',[ExportController::class,'reporteExcel'])->middleware('perfil:admin|lider');
        Route::get('reporte/excel/{tipo}',[ExportController::class,'reporteExcel'])->middleware('perfil:admin|lider');

        Route::get('/mensaje/index', function () {
            return view('mensaje.index');
        })->name('mensaje.index')->middleware('perfil:admin|lider');
    }); //Cierra middleware de estado usuario
    Route::get('/error/error', function () {
        return view('error.error');
    })->name('error.error');
});//Cierra middleware de auth
