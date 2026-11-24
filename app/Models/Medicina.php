<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Medicina
 * 
 * Gestiona el catálogo de fármacos, precios, umbrales de stock y relaciones de inventario.
 */
class Medicina extends Model
{
    use HasFactory;

    protected $table = 'medicinas';

    protected $fillable = [
        'categoria_id',
        'codigo',
        'nombre',
        'principio_activo',
        'presentacion',
        'laboratorio',
        'precio_unitario',
        'stock_minimo',
        'stock_total',
        'requiere_recipe'
    ];

    /**
     * Relación inversa de uno a muchos: Una medicina pertenece a una categoría.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Relación de uno a muchos: Una medicina posee múltiples lotes de vencimiento.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lotes()
    {
        return $this->hasMany(Lote::class, 'medicina_id');
    }
}