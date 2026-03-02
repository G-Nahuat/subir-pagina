<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsistenciaDiaria extends Model
{
    protected $table = 'asistencias_diarias';

    protected $fillable = [
        'id_asistente',
        'fecha',
        'asistio',
    ];

    public $timestamps = false;
}
