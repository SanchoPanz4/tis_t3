<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $table = 'receta';
    protected $primaryKey = 'cod_receta';
    public $timestamps = false;

    protected $fillable = [
        'nombre_receta', 'descripcion', 'instrucciones',
        'cantidad_personas', 'categoria', 'regimen_alimenticio', 'id_usuario',
    ];

    public function autor()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function ingredientes()
    {
        return $this->belongsToMany(
            Ingrediente::class, 'contiene', 'cod_receta', 'cod_ingrediente'
        )->withPivot('cantidad_ingrediente', 'unidad_medida');
    }

    public function valoraciones()
    {
        return $this->belongsToMany(
            User::class, 'clasifica', 'cod_receta', 'id_usuario'
        )->withPivot('valoracion_receta');
    }
}
