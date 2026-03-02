<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estado';
    public $timestamps = false;

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'estado_id');
    }
}