<?php

namespace App\Http\Controllers;

use App\Models\Casa;
use App\Models\Dominio;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    /**
     * Descarga en CSV (compatible con Excel) los resultados por casa.
     */
    public function exportarCasas(Request $request): StreamedResponse
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

        $totalResultados = $casas->sum('resultados_count');

        $filas = $casas->map(function (Casa $casa) use ($totalResultados) {
            $porcentaje = $totalResultados > 0
                ? round(($casa->resultados_count / $totalResultados) * 100, 1)
                : 0;

            return [
                'Casa'        => $casa->nombre_casa,
                'Carrera'     => $casa->nombre,
                'Dominio'     => $casa->dominio?->nombre ?? 'Sin dominio',
                'Resultados'  => $casa->resultados_count,
                'Porcentaje'  => $porcentaje . '%',
            ];
        })->all();

        return $this->descargarCsv($filas, 'estadisticas-casas-nova.csv');
    }

    /**
     * Descarga en CSV (compatible con Excel) los resultados por dominio.
     */
    public function exportarDominios(Request $request): StreamedResponse
    {
        abort_unless(
            $request->user() && $request->user()->rol === 'admin',
            403,
            'No tienes permiso para acceder al panel administrativo.'
        );

        $dominios = Dominio::query()
            ->withCount([
                'casas',
                'resultados',
            ])
            ->orderByDesc('resultados_count')
            ->orderBy('nombre')
            ->get();

        $totalResultados = $dominios->sum('resultados_count');

        $filas = $dominios->map(function (Dominio $dominio) use ($totalResultados) {
            $porcentaje = $totalResultados > 0
                ? round(($dominio->resultados_count / $totalResultados) * 100, 1)
                : 0;

            return [
                'Dominio'            => $dominio->nombre,
                'Nombre simbólico'   => $dominio->nombre_casa ?: '—',
                'Casas'              => $dominio->casas_count,
                'Resultados'         => $dominio->resultados_count,
                'Porcentaje'         => $porcentaje . '%',
            ];
        })->all();

        return $this->descargarCsv($filas, 'estadisticas-dominios-nova.csv');
    }

    /**
     * Genera una respuesta CSV descargable a partir de un arreglo de filas
     * (cada fila es un arreglo asociativo columna => valor). Usa BOM UTF-8
     * para que Excel muestre correctamente acentos y ñ.
     */
  private function descargarCsv(array $filas, string $nombreArchivo): StreamedResponse
    {
        $columnas = ! empty($filas) ? array_keys($filas[0]) : [];

        $callback = function () use ($filas, $columnas) {
            $salida = fopen('php://output', 'w');

            // BOM para que Excel detecte UTF-8 correctamente
            fwrite($salida, "\xEF\xBB\xBF");

            fputcsv($salida, $columnas, ';');

            foreach ($filas as $fila) {
                fputcsv($salida, $fila, ';');
            }

            fclose($salida);
        };

        return response()->streamDownload($callback, $nombreArchivo, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}