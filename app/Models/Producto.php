<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'imagen',
        'stock',
        'disponible',
        'categoria',
        'sabor',
        'tamano',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'precio' => 'decimal:2',
        'disponible' => 'boolean',
        'stock' => 'integer',
    ];

    /**
     * Relación: Un producto puede estar en muchos detalles de pedidos
     */
    public function detallesPedidos()
    {
        return $this->hasMany(DetallePedido::class);
    }

    /**
     * Scope para productos disponibles
     */
    public function scopeDisponibles($query)
    {
        return $query->where('disponible', true)->where('stock', '>', 0);
    }

    /**
     * Scope para filtrar por categoría
     */
    public function scopeCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    /**
     * Obtener la URL de la imagen del producto
     */
    public function getImagenUrlAttribute(): string
    {
        if ($this->imagen) {
            return asset('storage/productos/' . $this->imagen);
        }
        return asset('images/placeholder.png');
    }
}
