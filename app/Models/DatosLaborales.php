<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosLaborales extends Model
{
    protected $table = 'datos_laborales';

    protected $fillable = [
        'id_users',
        'nombre_negocio',
        'direccion_negocio',
        'actividad_economica',
        'redes_negocio',
        'tiempo_emprendimiento',
        'interes_capacitacion',
        'negocio_alta',
        'razon_no_alta',
        'interes_financiamiento',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
