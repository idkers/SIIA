<?php

namespace App\Http\Controllers;

use App\Models\Casa;
use App\Models\Resultado;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultadoController extends Controller
{
    public function guardar(Request $request): JsonResponse
    {

        if ($request->user()->resultados()->exists()) {
            return response()->json([
                'message' => 'Este usuario ya realizó el Quiz.',
            ], 409);
        }

        $datos = $request->validate([
            'nombre_casa' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $casa = Casa::query()
            ->whereRaw(
                'LOWER(nombre_casa) = LOWER(?)',
                [$datos['nombre_casa']]
            )
            ->first();

        if (!$casa) {
            return response()->json([
                'message' => 'No se encontró la casa obtenida en el cuestionario.',
            ], 404);
        }

        $resultado = Resultado::create([
            'user_id' => Auth::id(),
            'dominio_id' => $casa->dominio_id,
            'casa_id' => $casa->id,
        ]);

        return response()->json([
            'message' => 'Resultado guardado correctamente.',
            'resultado_id' => $resultado->id,
        ], 201);
    }
}