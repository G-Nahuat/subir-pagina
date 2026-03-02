<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $primaryKey = 'id';
    public $timestamps = true;

   protected $fillable = [
    'nombre', 'fecha', 'hora', 'lugar', 'ciudad', 'tipo', 'facilitador',
    'duracion', 'descripcion', 'estado', 'temario', 'flyer',
    'num_grupos', 'horarios'
];

public function asistentes()
{
    return $this->hasMany(AsistenteCurso::class, 'id_curso');
}
}
