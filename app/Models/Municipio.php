<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'municipio';

    protected $primaryKey = 'id_municipio';

    public $timestamps = false; 

    public function datosGenerales()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
