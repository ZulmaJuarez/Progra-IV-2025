<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MateriaController extends Controller
{
    // Listar todas las materias
    public function index()
    {
        return Materia::all();
    }

    // Guardar o actualizar materia
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:10',
            'nombre' => 'required|string|max:150',
            'uv'     => 'required|integer|min:1|max:10',
        ]);

        $materia = Materia::updateOrCreate(
            ['codigo' => $request->codigo],
            [
                'nombre' => $request->nombre,
                'uv' => $request->uv,
                'codigo_transaccion' => $request->codigo_transaccion ?? Str::uuid()
            ]
        );

        return response()->json(['success' => true, 'materia' => $materia]);
    }

    // Obtener una sola materia
    public function show($codigo)
    {
        $materia = Materia::findOrFail($codigo);
        return response()->json($materia);
    }

    // Eliminar una materia
    public function destroy($codigo)
    {
        $materia = Materia::findOrFail($codigo);
        $materia->delete();

        return response()->json(['success' => true]);
    }
}
