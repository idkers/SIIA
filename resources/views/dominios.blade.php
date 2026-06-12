@extends('layouts.app')
@section('title', 'Dominios — SIIA')

@section('content')

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<nav style="display:flex;align-items:center;justify-content:space-between;
            padding:.75rem 2rem;
            background:#06060F;
            border-bottom:1px solid #2B1F3D;
            margin-bottom:0;">
    <span style="font-weight:700;font-size:1rem;color:#C8A84B;
                 letter-spacing:.12em;font-family:'Headland One',serif;">
        UTL
    </span>
    <div style="display:flex;gap:2rem;">
        <a href="{{ route('welcome') }}"      style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Inicio</a>
        <a href="{{ route('quiz') }}"          style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Quiz</a>
        <a href="{{ route('recorrido') }}"     style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Recorrido</a>
        <a href="{{ route('dominios') }}"      style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Dominios</a>
        <a href="{{ route('casas') }}"         style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Casas</a>
    </div>
    <div style="display:flex;align-items:center;gap:.75rem;">
        <a href="#"
           style="font-size:.82rem;color:#B0A898;text-decoration:none;
                  letter-spacing:.08em;text-transform:uppercase;">
            Ingresar
        </a>
        <div style="width:32px;height:32px;border-radius:50%;
                    background:#2B1F3D;border:1px solid #6B5020;"></div>
    </div>
</nav>

{{-- ═══ ENCABEZADO ════════════════════════════════════════════════════════ --}}
<section style="border:1px solid #ccc;border-radius:6px;
                padding:2rem;margin-bottom:1.5rem;background:#fff;text-align:center;">
    <p style="font-size:.7rem;text-transform:uppercase;letter-spacing:.1em;color:#999;margin-bottom:.3rem;">
        Universidad Tecnológica de León
    </p>
    <h1 style="font-size:1.5rem;font-weight:700;color:#222;margin-bottom:.6rem;">
        Dominios Académicos
    </h1>
    <p style="font-size:.85rem;color:#666;max-width:440px;margin:0 auto;line-height:1.6;">
        Cada dominio agrupa carreras con filosofía y competencias afines.
        Explora los ejes que estructuran la identidad académica de la UTL.
    </p>
</section>

@php
$dominios = [

    [
        'icono'    => '',
        'nombre'   => 'Ingenierías',
        'desc'     => 'Carreras enfocadas en la optimización de sistemas, procesos industriales y sostenibilidad.',
        'carreras' => [
            'Ingeniería en Logística',
            'Ingeniería en Mantenimiento Industrial',
            'Ingeniería Ambiental y Sustentabilidad',
        ],
    ],

    [
        'icono'    => '',
        'nombre'   => 'Tecnologías de la Información',
        'desc'     => 'Carreras enfocadas en el desarrollo tecnológico y la innovación digital.',
        'carreras' => [
            'Entornos Virtuales',
            'Ciencia de Datos',
            'Desarrollo de Software',
            'Infraestructura de Redes',
            'Inteligencia Artificial',
        ],
    ],

    [
        'icono'    => '',
        'nombre'   => 'Ingeniería Industrial',
        'desc'     => 'Carreras orientadas a la mejora de procesos productivos.',
        'carreras' => [
            'Automotriz',
            'Procesos Productivos',
            'Moldeo de Plásticos',
            'Calzado',
        ],
    ],

    [
        'icono'    => '',
        'nombre'   => 'Mecatrónica',
        'desc'     => 'Integración de automatización, robótica y sistemas inteligentes.',
        'carreras' => [
            'Manufactura Flexible',
            'Optomecatrónica',
            'Automatización',
        ],
    ],

    [
        'icono'    => '',
        'nombre'   => 'Licenciaturas',
        'desc'     => 'Formación profesional enfocada en servicios, negocios y gestión.',
        'carreras' => [
            'Gastronomía',
            'Administración',
            'Turismo',
            'Innovación de Negocios y Mercadotecnia',
        ],
    ],

];
@endphp

{{-- ═══ GRID DE DOMINIOS ══════════════════════════════════════════════════ --}}
<section style="border:1px solid #ccc;border-radius:6px;
                padding:1.5rem;margin-bottom:1.5rem;background:#fff;">

    <p style="font-size:.7rem;text-transform:uppercase;letter-spacing:.1em;
              color:#999;margin-bottom:1rem;">
        Los 5 dominios
    </p>

    <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:.75rem;">
        @foreach($dominios as $dom)
        <div style="border:1px solid #ccc;border-radius:6px;
                    padding:.75rem;background:#f9f9f9;
                    display:flex;flex-direction:column;gap:.5rem;">

            <div style="width:100%;aspect-ratio:1;background:#e0e0e0;
                        border:1px dashed #bbb;border-radius:4px;
                        display:flex;align-items:center;justify-content:center;
                        font-size:2rem;">
                {{ $dom['icono'] }}
            </div>

            <p style="font-size:.82rem;font-weight:700;color:#222;margin:0;">
                {{ $dom['nombre'] }}
            </p>

            <p style="font-size:.72rem;color:#666;line-height:1.5;margin:0;">
                {{ $dom['desc'] }}
            </p>

            <div style="display:flex;flex-wrap:wrap;gap:3px;margin-top:auto;">
                @foreach($dom['carreras'] as $c)
                <span style="font-size:.65rem;padding:2px 7px;
                             border:1px solid #ccc;border-radius:20px;color:#666;">
                    {{ $c }}
                </span>
                @endforeach
            </div>

        </div>
        @endforeach
    </div>

</section>

{{-- ═══ FOOTER PLACEHOLDER ════════════════════════════════════════════════ --}}
<footer style="border:1px solid #ccc;border-radius:6px;
               padding:2rem;background:#f0f0f0;text-align:center;
               color:#aaa;font-size:.85rem;letter-spacing:.08em;">
    [ FOOTER ]
</footer>

@endsection