<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    protected $table = 'ingrediente';
    protected $primaryKey = 'cod_ingrediente';
    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function recetas()
    {
        return $this->belongsToMany(
            Receta::class, 'contiene', 'cod_ingrediente', 'cod_receta'
        )->withPivot('cantidad_ingrediente', 'unidad_medida');
    }
}
