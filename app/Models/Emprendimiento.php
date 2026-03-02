<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emprendimiento extends Model
{
    protected $table = 'emprendimiento';
    protected $primaryKey = 'id_emprendimiento';


    protected $fillable = [
        'id_users',
        'nombre',
        'emprendimiento',
        'descripcion',
        'telefono',
        'redes',
        'ubicacion',
        'logo',
   
    ];

    public function datosGenerales()
    {
        return $this->hasOne(DatosGenerales::class, 'id_users', 'id_users');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    public function productos()
{
    return $this->hasMany(Producto::class, 'id_emprendimiento', 'id_emprendimiento');
}
}
