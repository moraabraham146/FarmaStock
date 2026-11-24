<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Categoria
 * 
 * Gestiona la clasificación de las medicinas en el inventario.
 */
class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    /**
     * Relación de uno a muchos: Una categoría agrupa múltiples medicinas.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medicinas()
    {
        return $this->hasMany(Medicina::class, 'categoria_id');
    }
}