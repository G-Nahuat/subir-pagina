<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DatosGenerales extends Model
{
    protected $table = 'datos_generales';
    protected $primaryKey = 'id_datos';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'curp',
        'telefono',
        'email',
        'documentos',
        'constancias',
        'cursos',
        'programas',
        'delegacion',
        'edad',
        'ine',
        'rfc',
        'id_users',
        'id_ultimo_grado',
        'id_municipio',
        'id_localidad',
    ];

    // Relación al usuario (tabla users)
    public function user()
    {

        return $this->belongsTo(\App\Models\User::class, 'id_users');
    }

    // Relación extra (si la usas)
    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio', 'id_municipio');
    }
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }


    public function gradoEstudios()
    {
        return $this->belongsTo(CatalogoGradoEstudios::class, 'id_ultimo_grado');
    }
}
