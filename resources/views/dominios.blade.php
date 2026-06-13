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
<section style="
    padding:5rem 2rem;
    text-align:center;
    background:linear-gradient(180deg,#06060F,#0D0D1A);
    border-bottom:1px solid rgba(200,168,75,.15);
">

    <p style="
        color:#E8C96A;
        text-transform:uppercase;
        letter-spacing:.2em;
        font-size:.75rem;
        margin-bottom:.8rem;
    ">
        Sistema Integral de Identidad Académica
    </p>

    <h1 style="
        color:#FFFFFF;
        font-size:3rem;
        font-family:'Headland One',serif;
        margin-bottom:1rem;
    ">
        Dominios Académicos
    </h1>

    <p style="
        max-width:750px;
        margin:auto;
        color:#F0EAD8;
        line-height:1.9;
        font-size:1rem;
    ">
        Los dominios representan grandes áreas del conocimiento dentro de la
        Universidad Tecnológica de León. Cada uno reúne carreras con intereses,
        habilidades y enfoques profesionales afines.
    </p>

</section>

@php
$dominios = [

    [
        'nombre' => 'Ingenierías',
        'color' => '#075E56',
        'desc' => 'Carreras enfocadas en la optimización de sistemas, procesos industriales y sostenibilidad.',
        'carreras' => [
            'Ingeniería en Logística',
            'Ingeniería en Mantenimiento Industrial',
            'Ingeniería Ambiental y Sustentabilidad',
        ],
    ],

    [
        'nombre' => 'Tecnologías de la Información',
        'color' => '#420FDB',
        'desc' => 'Carreras enfocadas en el desarrollo tecnológico y la innovación digital.',
        'carreras' => [
            'Entornos Virtuales',
            'Ciencia de Datos',
            'Desarrollo de Software',
            'Infraestructura de Redes',
            'Inteligencia Artificial',
        ],
    ],

    [
        'nombre' => 'Ingenierías Industriales',
        'color' => '#CC7135',
        'desc' => 'Carreras orientadas a la mejora de procesos productivos.',
        'carreras' => [
            'Automotriz',
            'Procesos Productivos',
            'Moldeo de Plásticos',
            'Calzado',
        ],
    ],

    [
        'nombre' => 'Mecatrónicas',
        'color' => '#A81E1E',
        'desc' => 'Integración de automatización, robótica y sistemas inteligentes.',
        'carreras' => [
            'Manufactura Flexible',
            'Optomecatrónica',
            'Automatización',
        ],
    ],

    [
        'nombre' => 'Licenciaturas',
        'color' => '#FAE469',
        'desc' => 'Formación profesional enfocada en servicios, negocios y gestión.',
        'carreras' => [
            'Gastronomía',
            'Administración',
            'Turismo',
            'Innovación de Negocios y Mercadotecnia',
        ],
    ],

];
@endphp

{{-- ═══ EXPLICACIÓN ═══════════════════════════════════════════════════════ --}}
<section style="
    max-width:1200px;
    margin:3rem auto;
    padding:0 2rem;
">

    <div style="
        background:#14141F;
        border:1px solid rgba(200,168,75,.15);
        border-radius:16px;
        padding:2rem;
    ">

        <h2 style="
            color:#C8A84B;
            font-family:'Headland One',serif;
            margin-bottom:1rem;
        ">
            ¿Qué es un dominio?
        </h2>

        <p style="
            color:#F0EAD8;
            line-height:1.9;
            margin:0;
        ">
            Los dominios agrupan carreras que comparten intereses,
            competencias y áreas de conocimiento similares.
            Dentro de SIIA representan los grandes caminos académicos
            que estructuran la identidad universitaria de cada estudiante.
        </p>

    </div>

</section>

{{-- ═══ DOMINIOS ══════════════════════════════════════════════════════════ --}}
<style>
    .dominio-card {
        background:#14141F;
        border:1px solid rgba(200,168,75,.15);
        border-radius:18px;
        overflow:hidden;
        transition: border-color .35s ease, box-shadow .35s ease;
        display:flex;
        flex-direction:column;
    }
    .dominio-card:hover {
        border-color: rgba(200,168,75,.85);
        box-shadow: 0 0 0 1px rgba(200,168,75,.4), 0 0 18px rgba(200,168,75,.18);
    }
    .dominios-fila-top {
        display:grid;
        grid-template-columns:repeat(3,1fr);
        gap:1.5rem;
        margin-bottom:1.5rem;
        align-items:start;
    }
    .dominios-fila-bottom {
        display:grid;
        grid-template-columns:repeat(2,1fr);
        gap:1.5rem;
        align-items:start;
    }
    @media(max-width:900px){
        .dominios-fila-top,
        .dominios-fila-bottom { grid-template-columns:repeat(2,1fr); }
    }
    @media(max-width:560px){
        .dominios-fila-top,
        .dominios-fila-bottom { grid-template-columns:1fr; }
    }
</style>

<section style="max-width:1400px;margin:auto;padding:0 2rem 4rem;">

    @php
        $top    = array_slice($dominios, 0, 3);
        $bottom = array_slice($dominios, 3);
    @endphp

    @foreach([['dominios-fila-top',$top],['dominios-fila-bottom',$bottom]] as [$clase,$grupo])
    <div class="{{ $clase }}">
        @foreach($grupo as $dom)
        <div class="dominio-card">

            <div style="height:6px;background:{{ $dom['color'] }};"></div>

            <div style="padding:1.25rem;display:flex;flex-direction:column;">

                {{-- NO MODIFICAR (AQUÍ VA EL LOGO) --}}
                <div style="
                    width:100%;
                    aspect-ratio:16/7;
                    background:#1D1D2B;
                    border:1px dashed rgba(255,255,255,.15);
                    border-radius:10px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    margin-bottom:1.25rem;
                ">
                    {{ $dom['icono'] ?? '' }}
                </div>

                <h3 style="
                    color:#FFFFFF;
                    font-size:1.05rem;
                    margin-bottom:.6rem;
                    font-family:'Headland One',serif;
                ">{{ $dom['nombre'] }}</h3>

                <p style="
                    color:#B0A898;
                    line-height:1.6;
                    font-size:.88rem;
                    margin-bottom:1.25rem;
                ">{{ $dom['desc'] }}</p>

                <div style="display:flex;flex-wrap:wrap;gap:.4rem;">
                    @foreach($dom['carreras'] as $c)
                    <span style="
                        background:rgba(255,255,255,.04);
                        border:1px solid rgba(255,255,255,.08);
                        color:#F0EAD8;
                        padding:.3rem .65rem;
                        border-radius:50px;
                        font-size:.7rem;
                    ">{{ $c }}</span>
                    @endforeach
                </div>

            </div>

        </div>
        @endforeach
    </div>
    @endforeach

</section>

{{-- ═══ CTA ═══════════════════════════════════════════════════════════════ --}}
<section style="
    padding:5rem 2rem;
    text-align:center;
    background:#0D0D1A;
    border-top:1px solid rgba(200,168,75,.12);
    border-bottom:1px solid rgba(200,168,75,.12);
">

    <h2 style="
        color:#FFFFFF;
        font-family:'Headland One',serif;
        margin-bottom:1rem;
    ">
        Descubre tu camino académico
    </h2>

    <p style="
        max-width:650px;
        margin:auto auto 2rem;
        color:#F0EAD8;
        line-height:1.8;
    ">
        Realiza el cuestionario SIIA y descubre qué dominio y qué casa
        representan mejor tus intereses, habilidades y forma de aprender.
    </p>

    <a href="{{ route('quiz') }}"
       style="
            display:inline-block;
            background:#C6A050;
            color:#06060F;
            text-decoration:none;
            padding:.9rem 2rem;
            border-radius:8px;
            font-weight:700;
       ">
        Realizar Test
    </a>

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