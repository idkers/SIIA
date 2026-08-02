<?php

namespace App\Http\Controllers;

use App\Models\Casa;
use App\Models\Dominio;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless(
            $request->user() && $request->user()->rol === 'admin',
            403,
            'No tienes permiso para acceder al panel administrativo.'
        );

        $casas = Casa::query()
            ->with('dominio')
            ->withCount('resultados')
            ->orderByDesc('resultados_count')
            ->orderBy('nombre_casa')
            ->get();

        $dominios = Dominio::query()
            ->withCount([
                'casas',
                'resultados',
            ])
            ->orderByDesc('resultados_count')
            ->orderBy('nombre')
            ->get();

        $casaMasElegida = $casas
            ->filter(fn (Casa $casa) => $casa->resultados_count > 0)
            ->first();

        $casaMenosElegida = $casas
            ->sortBy('resultados_count')
            ->first();

        $dominioMasElegido = $dominios
            ->filter(fn (Dominio $dominio) => $dominio->resultados_count > 0)
            ->first();

        $dominioMenosElegido = $dominios
            ->sortBy('resultados_count')
            ->first();

        $totalResultados = $casas->sum('resultados_count');

        return view('admin', [
            'casas' => $casas,
            'dominios' => $dominios,
            'casaMasElegida' => $casaMasElegida,
            'casaMenosElegida' => $casaMenosElegida,
            'dominioMasElegido' => $dominioMasElegido,
            'dominioMenosElegido' => $dominioMenosElegido,
            'totalResultados' => $totalResultados,
        ]);
    }
}