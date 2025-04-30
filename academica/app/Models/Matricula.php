<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno',     // ID del alumno
        'fecha',
        'periodo'
    ];

    public function alumnoData()
    {
        return $this->belongsTo(Alumno::class, 'alumno');
    }
}
