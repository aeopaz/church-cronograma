<?php

use App\Http\Controllers\IglesiaController;
use App\Http\Controllers\MinisterioController;
use App\Http\Controllers\RolController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/usuario/index', function () {
    return view('usuario.index');
})->name('usuario.index');

Route::get('/usuario/perfil', function () {
    return view('usuario.perfil');
})->name('usuario.perfil');

Route::get('/iglesia/index', [IglesiaController::class, 'index'])->name('iglesia.index');
Route::get('/ministerio/index', [MinisterioController::class, 'index'])->name('ministerio.index');
Route::get('/parametrizacion/roles/index', [RolController::class, 'index'])->name('rol.index');
Route::get('/programacion/index', function () {
    return view('programacion.index');
})->name('programacion.index');
Route::get('/programacion/general', function () {
    return view('programacion.general');
})->name('programacion.general');
Route::get('/recurso/index', function () {
    return view('recurso.index');
})->name('recurso.index');
Route::get('/membrecia/index', function () {
    return view('membrecia.index');
})->name('membrecia.index');

