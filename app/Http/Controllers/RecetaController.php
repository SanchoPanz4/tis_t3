<?php

namespace App\Http\Controllers;

use App\Models\Receta;

class RecetaController extends Controller
{
    // GET /api/recetas/populares
    public function populares()
    {
        $puntaje = "case clasifica.valoracion_receta::text
            when 'Me gusta mucho' then 5
            when 'Me gusta' then 4
            when 'Indiferente' then 3
            when 'No me gusta' then 2
            when 'No gusta para nada' then 1
        end";

        $recetas = Receta::query()
            ->join('clasifica', 'clasifica.cod_receta', '=', 'receta.cod_receta')
            ->select('receta.*')
            ->selectRaw("round(avg($puntaje), 2) as promedio")
            ->selectRaw('count(*) as total_votos')
            ->groupBy('receta.cod_receta')
            ->orderByDesc('promedio')
            ->orderByDesc('total_votos')
            ->limit(10)
            ->get();

        return response()->json($recetas);
    }
}