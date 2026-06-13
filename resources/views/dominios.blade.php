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
        <a href="{{ route('dominios') }}"      style="font-size:.82rem;color:#E8C96A;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Dominios</a>
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
        'nombre'   => 'Ingenierías Industriales',
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
        'nombre'   => 'Mecatrónicas',
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
{{-- ═══ DOMINIOS ══════════════════════════════════════════════════════════ --}}
<section style="
    max-width:1400px;
    margin:auto;
    padding:0 2rem 4rem;
">

    <style>

        .dominios-grid{
            display:grid;
            grid-template-columns:repeat(3, minmax(320px,1fr));
            gap:2rem;
        }

        .dominio-card{
            background:#14141F;
            border:1px solid rgba(200,168,75,.15);
            border-radius:18px;
            overflow:hidden;
            transition:.35s ease;
            min-height:620px;
            display:flex;
            flex-direction:column;
            position:relative;
        }

        .dominio-card:hover{
            transform:translateY(-6px);
        }

        .dominio-card:has(.icono-dominio:hover){
            border-color:#E8C96A;

            box-shadow:
                0 0 12px rgba(232,201,106,.35),
                0 0 24px rgba(232,201,106,.25),
                0 0 48px rgba(232,201,106,.15);
        }

        .dominio-card:has(.icono-dominio:hover)::after{
            content:'';
            position:absolute;
            inset:0;
            pointer-events:none;
            border-radius:18px;

            background:
                radial-gradient(
                    circle at center,
                    rgba(232,201,106,.08),
                    transparent 70%
                );
        }

        /* Centrar los dos dominios de abajo */
        .dominio-card:nth-child(4){
            grid-column:1 / 2;
        }

        .dominio-card:nth-child(5){
            grid-column:3 / 4;
        }

        @media (max-width:1100px){

            .dominios-grid{
                grid-template-columns:repeat(2,1fr);
            }

            .dominio-card:nth-child(4),
            .dominio-card:nth-child(5){
                grid-column:auto;
            }
        }

        @media (max-width:768px){

            .dominios-grid{
                grid-template-columns:1fr;
            }
        }

    </style>

    <div class="dominios-grid">

        @foreach($dominios as $dom)

        <div class="dominio-card">

            <div style="
                height:8px;
                background:{{ $dom['color'] }};
            "></div>

            <div style="
                padding:1.75rem;
                display:flex;
                flex-direction:column;
                height:100%;
            ">

                {{-- AQUÍ VA EL LOGO --}}
                <div class="icono-dominio" style="
                    width:100%;
                    aspect-ratio:1;
                    background:#1D1D2B;
                    border:1px dashed rgba(255,255,255,.15);
                    border-radius:12px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    margin-bottom:1.5rem;
                    cursor:pointer;
                ">
                    {{ $dom['icono'] ?? '' }}
                </div>

                <h3 style="
                    color:#FFFFFF;
                    font-size:1.3rem;
                    margin-bottom:.8rem;
                    font-family:'Headland One',serif;
                ">
                    {{ $dom['nombre'] }}
                </h3>

                <p style="
                    color:#B0A898;
                    line-height:1.7;
                    margin-bottom:1.5rem;
                ">
                    {{ $dom['desc'] }}
                </p>

                <div style="
                    display:flex;
                    flex-wrap:wrap;
                    gap:.5rem;
                    margin-top:auto;
                ">

                    @foreach($dom['carreras'] as $c)

                    <span style="
                        background:rgba(255,255,255,.04);
                        border:1px solid rgba(255,255,255,.08);
                        color:#F0EAD8;
                        padding:.45rem .8rem;
                        border-radius:50px;
                        font-size:.72rem;
                    ">
                        {{ $c }}
                    </span>

                    @endforeach

                </div>

            </div>

        </div>

        @endforeach

    </div>

</section>

{{-- ═══ FOOTER PLACEHOLDER ════════════════════════════════════════════════ --}}
<footer style="
    padding:3rem 4rem;
    background:#06060F;
    border-top:1px solid #2B1F3D;
">

    <div style="
        display:flex;
        justify-content:space-around;
        flex-wrap:wrap;
        gap:3rem;
    ">

        <!-- Información UTL -->
        <div style="
            text-align:left;
            max-width:400px;
        ">

            <h3 style="
                font-family:'Headland One', serif;
                color:#C8A84B;
                margin-bottom:1rem;
                font-size:1.4rem;
            ">
                Universidad Tecnológica de León
            </h3>

            <p style="
                color:#F0EAD8;
                line-height:1.8;
                margin:0;
            ">
                Blvd. Universidad Tecnológica #225 Col. San Carlos<br>
                C.P. 37670 León, Gto. México<br><br>

                difusion@utleon.edu.mx<br><br>

                (477) 7 10 00 20
            </p>

        </div>

        <!-- Información del proyecto -->
        <div style="
            text-align:left;
            max-width:450px;
        ">

            <h3 style="
                font-family:'Headland One', serif;
                color:#C8A84B;
                margin-bottom:1rem;
                font-size:1.4rem;
            ">
                Desarrolladores del Proyecto
            </h3>

            <p style="
                color:#F0EAD8;
                line-height:2;
                margin:0;
            ">
                <strong>Citlalli Méndez</strong><br>
                citlallialejandrams@gmail.com
                <br><br>

                <strong>Miryam Muñoz</strong><br>
                miryammunoz26@gmail.com
                <br><br>

                <strong>Carlo Flores</strong><br>
                carlofernandoflores2006@gmail.com
            </p>

        </div>

    </div>

    <div style="
        margin-top:2.5rem;
        border-top:1px solid rgba(200,168,75,.15);
        padding-top:1.5rem;
        text-align:center;
        color:#707085;
        font-size:.8rem;
        letter-spacing:.08em;
    ">
        © {{ date('Y') }} SIIA · Sistema Integral de Identidad Académica
    </div>

</footer>

@endsection