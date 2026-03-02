<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistente extends Model
{
    protected $table = 'asistentes';

    protected $primaryKey = 'id_asistente';

    public $timestamps = true;

    protected $fillable = [
        'id_evento',
        'id_users',
        'nombre_completo',
        'curp',
        'telefono',
        'email'
    ];

   // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relación con el evento
    public function evento() {
    return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
}


public function usuario()
{
    return $this->belongsTo(User::class, 'id_users');
}

    
}
