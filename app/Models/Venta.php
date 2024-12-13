<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';

    protected $fillable = [
        'id_cliente',
        'totalPagar',
        'fecha_venta',
        'estado',
    ];

    // Establecer la hora de inicio cuando se crea la venta
    public static function boot()
    {
        parent::boot();

        // Evento para establecer la hora de inicio al crear una venta
        self::creating(function ($venta) {
            $venta->inicio_registro = now(); // Hora de inicio
        });
    }

    // Relación con los detalles de la venta
    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class, 'id_venta');
    }

    // Relación con el cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
