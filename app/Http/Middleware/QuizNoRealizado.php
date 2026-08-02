<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizNoRealizado
{
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = $request->user();

        if ($usuario && $usuario->resultados()->exists()) {
            return redirect()
                ->route('welcome')
                ->with('info', 'Ya realizaste el Quiz y tu resultado ha sido guardado.');
        }

        return $next($request);
    }
}