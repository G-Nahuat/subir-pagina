<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos'; 

    protected $primaryKey = 'id_evento';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'lugar',
        'fecha',
        'horario',
        'id_programa',
        'delegacion',
        'tipo',
        'estado',
        'constancia',
        'reconocimiento',
        'fotos',
        'latitude',     
        'longitude'     
    ];
}


