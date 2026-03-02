<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Producto;

class TempProduct extends Model
{
    protected $table = 'temp_products';
    protected $primaryKey = 'id_temp';
    public $timestamps = true;

    protected $fillable = [
        'id_users',
        'id_emprendimiento',
        'id_producto',
        'nombreproducto',
        'descripcion',
        'precio',
        'fotosproduct',
        'estado',
    ];

    // Accesor para fotosproduct
    public function getFotosproductAttribute($value)
    {
        $decoded = json_decode($value, true);

        if (is_string($decoded)) {
            $decoded = json_decode($decoded, true);
        }

        return is_array($decoded) ? $decoded : [];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimiento::class, 'id_emprendimiento', 'id_emprendimiento');
    }
}
