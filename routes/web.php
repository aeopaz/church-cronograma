<?php

use App\Http\Controllers\BackupToExcelController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IglesiaController;
use App\Http\Controllers\MinisterioController;
use App\Http\Controllers\ProgramacionController;
use App\Http\Controllers\RecursoController;
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
    return view('auth.login');
})->middleware('guest');

Route::post('/users/register', [UserController::class, 'registro'])->name('users.registro');
Auth::routes();

//Middleware para validar que el usuario este autenticado
Route::middleware('auth')->group(function () {
    Route::middleware('error.estado.usuario')->group(function () {
        //Home
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::post('/file', [App\Http\Controllers\HomeController::class, 'store'])->name('file.store');
        Route::post('/home/marcar_notificacion_leida\{notificacion}', [HomeController::class, 'marcarNotificacionLeida'])->name('home.marcarNotificacionLeida');
        //Usuario
        Route::get('/usuario/index', function () {
            return view('usuario.index');
        })->name('usuario.index')->middleware('perfil:admin|lider');

        Route::get('/usuario/perfil', function () {
            return view('usuario.perfil');
        })->name('usuario.perfil');
        Route::post('/users/subir_foto', [UserController::class, 'subirFoto'])->name('users.subirFoto');
        //Iglesia
        Route::get('/iglesia/index', [IglesiaController::class, 'index'])->name('iglesia.index')->middleware('can:admin');
        //Ministerio
        Route::get('/ministerio/index', [MinisterioController::class, 'index'])->name('ministerio.index')->middleware('can:admin');
        //Parametrizaciones
        Route::get('/parametrizacion/roles/index', [RolController::class, 'index'])->name('rol.index')->middleware('can:admin');

        Route::get('/parametrizacion/tipos-programas/index', function () {
            return view('parametrizacion.tipos-programas.index');
        })->name('tipo-programa.index')->middleware('can:admin');
        //Programación
        Route::get('/programacion/index/{tipoAgenda}', function ($tipoAgenda) {
            return view('programacion.index', compact('tipoAgenda'));
        })->name('programacion.index');
        Route::get('/programacion/index/{tipoAgenda}/{tipoPrograma}', function ($tipoAgenda,$tipoPrograma) {
            return view('programacion.index', compact('tipoAgenda','tipoPrograma'));
        });
        Route::get('/programacion/index/{tipoAgenda}/{tipoPrograma}/{lugar}', function ($tipoAgenda,$tipoPrograma,$lugar) {
            return view('programacion.index', compact('tipoAgenda','tipoPrograma','lugar'));
        });


        Route::get('eventos/{tipoAgenda}', [ProgramacionController::class, 'eventos']);
        Route::get('eventos/{tipoAgenda}/{tipoPrograma}', [ProgramacionController::class, 'eventos']);
        Route::get('eventos/{tipoAgenda}/{tipoPrograma}/{lugar}', [ProgramacionController::class, 'eventos']);

        Route::get('/programacion/compromisos', function () {
            return view('programacion.compromisos');
        })->name('programacion.compromisos');
        //Panel
        Route::get('/panel/index', function () {
            return view('panel.index');
        })->name('panel.index');
        //Recursos
        Route::get('/recurso/index', function () {
            return view('recurso.index');
        })->name('recurso.index');
        Route::post('/recurso/subir_foto/{idRecurso}', [RecursoController::class, 'subirFoto'])->name('recurso.subirFoto');
        //membrecía
        Route::get('/membrecia/index', function () {
            return view('membrecia.index');
        })->name('membrecia.index')->middleware('perfil:admin|lider');

        Route::get('/reportes/index', function () {
            return view('reportes.index');
        })->name('reportes.index')->middleware('perfil:admin|lider');

        //Reportes PDF
        Route::get('reporte/pdf/{tipo}/{fecha1}/{fecha2}/{ministerio}', [ExportController::class, 'reportePdf'])->middleware('perfil:admin|lider');
        Route::get('reporte/pdf/{tipo}/{fecha1}/{fecha2}', [ExportController::class, 'reportePdf'])->middleware('perfil:admin|lider');
        Route::get('reporte/pdf/{tipo}', [ExportController::class, 'reportePdf'])->middleware('perfil:admin|lider');

        //Reporte Programa Específico
        Route::get('reporte/programa/pdf/{idPrograma}/{fecha1}/{fecha2}', [ExportController::class, 'reportePdfPrograma'])->middleware('perfil:admin|lider');

        //Reportes Excel
        Route::get('reporte/excel/{tipo}/{fecha1}/{fecha2}/{ministerio}', [ExportController::class, 'reporteExcel'])->middleware('perfil:admin|lider');
        Route::get('reporte/excel/{tipo}/{fecha1}/{fecha2}', [ExportController::class, 'reporteExcel'])->middleware('perfil:admin|lider');
        Route::get('reporte/excel/{tipo}', [ExportController::class, 'reporteExcel'])->middleware('perfil:admin|lider');

        //Backup Excel
        Route::get('backup/excel/index', [BackupToExcelController::class, 'index'])->name('backup.index')->middleware('can:admin');
        Route::get('backup/excel/exportar', [BackupToExcelController::class, 'exportar'])->name('backup.exportar')->middleware('can:admin');


        Route::get('/mensaje/index', function () {
            return view('mensaje.index');
        })->name('mensaje.index')->middleware('perfil:admin|lider');
    }); //Cierra middleware de estado usuario
    Route::get('/error/error', function () {
        return view('error.error');
    })->name('error.error');
});//Cierra middleware de auth
