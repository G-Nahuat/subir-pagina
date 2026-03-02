<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InscripcionCurso extends Model
{
    protected $table = 'inscripciones_cursos';

    protected $fillable = [
        'curso_id',
        'nombre',
        'apellidos',
        'email',
        'telefono',
    ];
}
