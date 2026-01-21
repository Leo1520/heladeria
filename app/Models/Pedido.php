<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'estado',
        'total',
        'direccion_entrega',
        'referencia_direccion',
        'telefono_contacto',
        'notas',
        'fecha_entrega',
        'metodo_pago',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total' => 'decimal:2',
        'fecha_entrega' => 'datetime',
    ];

    /**
     * Relación: Un pedido pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Un pedido tiene muchos detalles
     */
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }

    /**
     * Obtener el estado del pedido en formato legible
     */
    public function getEstadoFormateadoAttribute(): string
    {
        return match($this->estado) {
            'pendiente' => 'Pendiente',
            'en_preparacion' => 'En Preparación',
            'entregado' => 'Entregado',
            'cancelado' => 'Cancelado',
            default => $this->estado,
        };
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para pedidos pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }
}
