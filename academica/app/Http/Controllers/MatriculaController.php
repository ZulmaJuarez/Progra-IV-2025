<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matricula;
use App\Models\Alumno;

class MatriculaController extends Controller
{
    public function index()
    {
        // Retorna todas las matrículas con información del alumno
        return Matricula::with('alumnoData')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno' => 'required|exists:alumnos,id',
            'fecha' => 'required|date',
            'periodo' => 'required|string|max:100'
        ]);

        $matricula = Matricula::create([
            'alumno' => $request->alumno,
            'fecha' => $request->fecha,
            'periodo' => $request->periodo
        ]);

        return response()->json([
            'message' => 'Matrícula guardada exitosamente',
            'matricula' => $matricula
        ], 201);
    }
}
