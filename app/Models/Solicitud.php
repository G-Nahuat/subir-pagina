<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    public $timestamps = false;

    protected $fillable = [
        'id_users',
        'fecha_solicitud',
        'estatus',
        'motivo_rechazo',
    ];

    public function user()
    {

    return $this->belongsTo(User::class, 'user_id');

    }

    public function usuario()
{
    return $this->belongsTo(User::class, 'id_users');
}

}

