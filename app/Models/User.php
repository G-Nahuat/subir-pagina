<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\DatosGenerales;
use App\Models\Producto;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_users';
    public $timestamps = true;

    protected $fillable = [
        'email',
        'password',
        'tipo',
        'email_verified_at',
        'remember_token',
    ];

    public function getKeyName()
    {
        return 'id_users';
    }

    public function datosGenerales()
    {
        return $this->hasOne(DatosGenerales::class, 'id_users', 'id_users');
    }

    public function solicitud()
    {
        return $this->hasOne(Solicitud::class, 'id_users', 'id_users');
    }

    public function products()
    {
        return $this->hasMany(Producto::class, 'id_users', 'id_users');
    }

    public function emprendimientos()
    {
        return $this->hasMany(Emprendimiento::class, 'id_users', 'id_users');
    }

    public function registroTemporal()
    {
        return $this->hasOne(RegistroTemporal::class, 'id_users', 'id_users');
    }

    protected $casts = [
        'tipo' => 'string',
	'email_verified_at'=>'datetime'
    ];
}
