<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $primaryKey = 'id_producto';

    public $timestamps = false;

    protected $fillable = [
        'id_users',
        'id_emprendimiento',
        'nombreproducto',
        'descripcion',
        'precio',
        'fotosproduct',
        'estado'
    ];

    protected $casts = [
        'fotosproduct' => 'array',
    ];

    // Forzar fotosproduct como array aunque venga mal desde la base
    public function getFotosproductAttribute($value)
    {
        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    // Relación con imágenes (opcional)
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'id_producto', 'id_producto');
    }

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users','id');
    }

    // Relación con el emprendimiento
    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimiento::class, 'id_emprendimiento', 'id_emprendimiento','id');
    }

}
