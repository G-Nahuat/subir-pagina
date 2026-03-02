<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroTemporal extends Model
{
    protected $table = 'registro_temporal';

    protected $fillable = [
        'id_users',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'curp',
        'telefono',
        'email',
        'edad',
        'ine', 
        'id_municipio',
        'id_ultimo_grado',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    

public function municipio()
{
    return $this->belongsTo(\App\Models\Municipio::class, 'id_municipio');
}
    

    public function gradoEstudios()
    {
        return $this->belongsTo(CatalogoGradoEstudios::class, 'id_ultimo_grado');
    }
}
