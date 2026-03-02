<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class TempEmprendimiento extends Model
{
    
    protected $table = 'temp_emprendimientos';
    protected $primaryKey = 'id_temp';

    protected $fillable = [
        'id_users',
        'nombre_emprendimiento',
        'nombre_comercial',
        'descripcion',
        'telefono',
        'redes',
        'ubicacion',
        'logo',
        'estado',

    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }
}
