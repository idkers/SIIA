<?php

namespace App\Http\Controllers;

use App\Models\Dominio;
use Illuminate\View\View;

class DominioController extends Controller
{
    /**
     * Muestra los dominios académicos con sus casas.
     */
    public function index(): View
    {
        $dominios = Dominio::query()
            ->with([
                'casas' => function ($query) {
                    $query->orderBy('nombre');
                },
            ])
            ->orderBy('id')
            ->get();

        return view('dominios', compact('dominios'));
    }
}