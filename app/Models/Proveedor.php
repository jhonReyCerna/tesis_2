<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';
    protected $primaryKey = 'id_proveedor';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'ruc',
        'activo' // Nuevo campo agregado
    ];

    public $timestamps = true;

    /**
     * Scope para filtrar proveedores activos.
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Método para desactivar un proveedor.
     */
    public function desactivar()
    {
        $this->activo = false;
        $this->save();
    }

    /**
     * Método para activar un proveedor.
     */
    public function activar()
    {
        $this->activo = true;
        $this->save();
    }
}
