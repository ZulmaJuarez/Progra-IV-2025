<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\MatriculaController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Materias
Route::get('/materias', [MateriaController::class, 'index']);
Route::get('/materias/{codigo}', [MateriaController::class, 'show']);
Route::post('/materias', [MateriaController::class, 'store']);
Route::put('/materias/{codigo}', [MateriaController::class, 'update']); // ← FALTA ESTA
Route::delete('/materias/{codigo}', [MateriaController::class, 'destroy']);

// Matrículas
Route::get('/matriculas', [MatriculaController::class, 'index']);
Route::post('/matriculas', [MatriculaController::class, 'store']);
