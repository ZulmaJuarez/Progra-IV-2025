<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;

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
Route::get('/bienvenida', function () {
    return 'Bienvenidos a Programacion Computacional IV.';
});
Route::get('/usuario/{id}/{nombre}/{apellido}', function ($id,$nombre,$apellido) {
    return 'User #: ' . $id. ' Nombre: ' . $nombre. ' Apellido: ' . $apellido;
})->where('id', '[0-9]+');
Route::controller(AlumnoController::class)->group(function () {
    Route::get('/alumno', 'index');
    Route::post('/alumno', 'store');
    Route::put('/alumno', 'update');
    Route::delete('/alumno', 'destroy');
});