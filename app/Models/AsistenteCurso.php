<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsistenteCurso extends Model
{
    
    protected $table = 'asistentes_cursos';
    
    public $timestamps = false; // si tu tabla no tiene created_at y updated_at

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }
  
public function diasAsistidos()
{
    return $this->hasMany(\App\Models\AsistenciaDiaria::class, 'id_asistente');
}

}
