<?php

namespace App\Http\Controllers;

use App\Models\Casa;
use App\Models\Dominio;
use Illuminate\View\View;

class CasaController extends Controller
{
    /**
     * Muestra todas las casas académicas.
     */
    public function index(): View
    {
        $casas = Casa::query()
            ->with('dominio')
            ->orderBy('dominio_id')
            ->orderBy('id')
            ->get();

        $dominios = Dominio::query()
            ->orderBy('id')
            ->get();

        return view('casas.index', compact('casas', 'dominios'));
    }
}