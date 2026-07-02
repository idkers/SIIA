@extends('layouts.app')
@section('title', 'Dominios — NOVA')

@section('content')

{{-- ═══ ESTILOS GLOBALES ═══════════════════════════════════════════════════ --}}
<style>
    *, *::before, *::after { box-sizing: border-box; }

    /* ── Navbar ── */
    .nav-links { display:flex; gap:2rem; }
    .nav-auth  { display:flex; align-items:center; gap:.75rem; }
    .hamburger { display:none; background:none; border:none; cursor:pointer;
                 padding:.25rem; flex-direction:column; gap:5px; }
    .hamburger span { display:block; width:22px; height:2px;
                      background:#C8A84B; border-radius:2px; }
    .mobile-menu { display:none; flex-direction:column;
                   background:rgba(6,6,15,0.97); padding:.5rem 0; }
    .mobile-menu a { display:block; padding:.75rem 2rem; font-size:.85rem;
                     color:#B0A898; text-decoration:none; letter-spacing:.08em;
                     text-transform:uppercase;
                     border-bottom:1px solid rgba(43,31,61,0.4); }
    .mobile-menu a:last-child { border-bottom:none; }
    .mobile-menu.open { display:flex; }

    /* ── Page layout: footer siempre al fondo ── */
    .page-wrap {
        display: flex;
        flex-direction: column;
        min-height: calc(100vh - 54px);
    }
    .page-content { flex: 1; }

    /* ── Encabezado hero ── */
    .hero-section {
        padding: 5rem 2rem;
        text-align: center;
        background: linear-gradient(180deg, #06060F, #0D0D1A);
        border-bottom: 1px solid rgba(200,168,75,.15);
    }
    .hero-title { font-size: 3rem; }

    /* ── Explicación ── */
    .explicacion-wrap {
        max-width: 1200px;
        margin: 3rem auto;
        padding: 0 2rem;
    }

    /* ── Grid de dominios ── */
    .dominios-wrap {
        max-width: 1400px;
        margin: auto;
        padding: 0 2rem 4rem;
    }
    .dominios-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
    }

    /* ── Card ── */
    .dominio-card {
        background: #14141F;
        border: 1px solid rgba(200,168,75,.15);
        border-radius: 18px;
        overflow: hidden;
        transition: .3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .dominio-card:hover {
        border-color: rgba(200,168,75,.85);
        box-shadow: 0 0 0 1px rgba(200,168,75,.4),
                    0 0 18px rgba(200,168,75,.18);
    }

    /* ── CTA ── */
    .cta-section {
        padding: 5rem 2rem;
        text-align: center;
        background: rgba(6,6,15,.45);
        border-top: 1px solid rgba(200,168,75,.12);
        border-bottom: 1px solid rgba(200,168,75,.12);
    }
    .cta-title { margin-bottom: 1rem; }
    .cta-desc  { max-width: 650px; margin: auto auto 2rem; line-height: 1.8; }

    /* ── Footer ── */
    .footer-grid {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 3rem;
    }

    /* ══════════════════════════════
       RESPONSIVE — TABLET ≤ 900px
       ══════════════════════════════ */
    @media (max-width: 900px) {
        .dominios-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* ══════════════════════════════
       RESPONSIVE — MÓVIL ≤ 600px
       ══════════════════════════════ */
    @media (max-width: 600px) {
        /* navbar */
        .nav-links { display:none !important; }
        .nav-auth  { display:none !important; }
        .hamburger { display:flex !important; }

        /* hero */
        .hero-section { padding: 3rem 1.25rem; }
        .hero-title   { font-size: 2rem !important; }

        /* explicación */
        .explicacion-wrap { margin: 2rem auto; padding: 0 1.25rem; }

        /* dominios */
        .dominios-wrap  { padding: 0 1.25rem 3rem; }
        .dominios-grid  { grid-template-columns: 1fr; }

        /* cta */
        .cta-section { padding: 3rem 1.25rem; }
        .cta-title   { font-size: 1.4rem !important; }
        .cta-desc    { font-size: .9rem; }
        .cta-btn     { width: 100%; text-align: center; }

        /* footer */
        footer         { padding: 2.5rem 1.25rem !important; }
        .footer-grid   { flex-direction: column; gap: 2rem; }
        .footer-grid > div { max-width: 100% !important; }
        .footer-grid h3 { font-size: 1.1rem !important; }
    }
</style>


{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<style>
  .nav-links{
    flex:1;
    display:flex;
    justify-content:center;
    gap:3rem;
}

.nav-links a{
    color:#B0A898;
    text-decoration:none;
    font-size:.88rem;
    letter-spacing:.08em;
    text-transform:uppercase;
    transition:.25s;
}

.nav-links a:hover{
    color:#E8C96A;
}
    .nav-auth  { display:flex; align-items:center; gap:.75rem; }
    .hamburger { display:none; background:none; border:none; cursor:pointer;
                 padding:.25rem; flex-direction:column; gap:5px; }
    .hamburger span { display:block; width:22px; height:2px; background:#C8A84B; border-radius:2px; }
    .mobile-menu { display:none; flex-direction:column; gap:0;
                   background:rgba(6,6,15,0.97); padding:.5rem 0; }
    .mobile-menu a { display:block; padding:.75rem 2rem;
                     font-size:.85rem; color:#B0A898; text-decoration:none;
                     letter-spacing:.08em; text-transform:uppercase;
                     border-bottom:1px solid rgba(43,31,61,0.4); }
    .mobile-menu a:last-child { border-bottom:none; }
    .mobile-menu.open { display:flex; }

    @media (max-width: 768px) {
        .nav-links { display:none !important; }
        .nav-auth  { display:none !important; }
        .hamburger { display:flex !important; }
    }
</style>
<nav style="
    display:flex;
    align-items:center;
    padding:1.6rem 2rem;
    background:rgba(6,6,15,.6);
    backdrop-filter:blur(12px);
    -webkit-backdrop-filter:blur(12px);
    position:sticky;
    top:0;
    z-index:100;
">

    <img src="{{ asset('imagenes/isotipo_dorado.webp') }}"
         alt="UTL"
         style="height:2.6rem;">

    <div class="nav-links" style="
        flex:1;
        display:flex;
        justify-content:center;
        gap:3rem;
    ">
        <a href="{{ route('welcome') }}">Inicio</a>
        <a href="{{ route('quiz') }}">Quiz</a>
        <a href="{{ route('recorrido') }}">Recorrido</a>
        <a href="{{ route('dominios') }}">Dominios</a>
        <a href="{{ route('casas') }}">Casas</a>
        <a href="{{ route('ingresar') }}">Ingresar</a>
    </div>

    <button class="hamburger"
            id="hamburgerBtn"
            aria-label="Abrir menú">
        <span></span>
        <span></span>
        <span></span>
    </button>

</nav>

<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('welcome') }}">Inicio</a>
    <a href="{{ route('quiz') }}">Quiz</a>
    <a href="{{ route('recorrido') }}">Recorrido</a>
    <a href="{{ route('dominios') }}" style="color:#E8C96A;">Dominios</a>
    <a href="{{ route('casas') }}">Casas</a>
    <a href="{{ route('ingresar') }}">Ingresar</a>
</div>
{{-- ═══ CONTENIDO + FOOTER ════════════════════════════════════════════════ --}}
<div class="page-wrap">
<div class="page-content">

    {{-- ── Encabezado ── --}}
    <section class="hero-section">
        <p style="color:#E8C96A;text-transform:uppercase;
                  letter-spacing:.2em;font-size:.75rem;margin-bottom:.8rem;">
            Navegador de Orientación Vocacional y Aptitudes
        </p>
        <h1 class="hero-title"
            style="color:#FFFFFF;font-family:'Headland One',serif;margin-bottom:1rem;">
            Dominios Académicos
        </h1>
        <p style="max-width:750px;margin:auto;color:#F0EAD8;line-height:1.9;font-size:1rem;">
            Los dominios representan grandes áreas del conocimiento dentro de la
            Universidad Tecnológica de León. Cada uno reúne carreras con intereses,
            habilidades y enfoques profesionales afines.
        </p>
    </section>

    @php
    $dominios = [
        [
            'nombre'  => 'Ingenierías',
            'color'   => '#075E56',
            'desc'    => 'Carreras enfocadas en la optimización de sistemas, procesos industriales y sostenibilidad.',
            'carreras'=> ['Ingeniería en Logística','Ingeniería en Mantenimiento Industrial','Ingeniería Ambiental y Sustentabilidad'],
            'nombrecasa'=> 'AURELION',
        ],
        [
            'nombre'  => 'Tecnologías de la Información',
            'color'   => '#420FDB',
            'desc'    => 'Carreras enfocadas en el desarrollo tecnológico y la innovación digital.',
            'carreras'=> ['Entornos Virtuales','Ciencia de Datos','Desarrollo de Software','Infraestructura de Redes','Inteligencia Artificial'],
            'nombrecasa'=> 'NEXORIA',
        ],
        [
            'nombre'  => 'Ingenierías Industriales',
            'color'   => '#CC7135',
            'desc'    => 'Carreras orientadas a la mejora de procesos productivos.',
            'carreras'=> ['Automotriz','Procesos Productivos','Moldeo de Plásticos','Calzado'],
            'nombrecasa'=> 'VALTORIS',
        ],
        [
            'nombre'  => 'Mecatrónicas',
            'color'   => '#A81E1E',
            'desc'    => 'Integración de automatización, robótica y sistemas inteligentes.',
            'carreras'=> ['Manufactura Flexible','Optomecatrónica','Automatización'],
            'nombrecasa'=> 'MECHARIS',
        ],
        [
            'nombre'  => 'Licenciaturas',
            'color'   => '#B89A10',
            'desc'    => 'Formación profesional enfocada en servicios, negocios y gestión.',
            'carreras'=> ['Gastronomía','Administración','Turismo','Innovación de Negocios y Mercadotecnia'],
            'nombrecasa'=> 'ELYRIA',
        ],
    ];
    @endphp

    {{-- ── ¿Qué es un dominio? ── --}}
    <div class="explicacion-wrap">
        <div style="background: rgba(6,6,15,.75);border:1px solid rgba(200,168,45,.15);
                    border-radius:16px;padding:2rem;">
            <h2 style="color:#C8A84B;font-family:'Headland One',serif;margin-bottom:1rem;">
                ¿Qué es un dominio?
            </h2>
            <p style="color:#F0EAD8;line-height:1.9;margin:0;">
                Los dominios agrupan carreras que comparten intereses,
                competencias y áreas de conocimiento similares.
                Dentro de NOVA representan los grandes caminos académicos
                que estructuran la identidad universitaria de cada estudiante.
            </p>
        </div>
    </div>

    {{-- ── Grid de dominios ── --}}
    <div class="dominios-wrap">
        <div class="dominios-grid">
            @foreach($dominios as $dom)
            <div class="dominio-card">

                {{-- Franja de color del dominio --}}
                <div style="height:8px;background:{{ $dom['color'] }};flex-shrink:0;"></div>

                <div style="padding:1.5rem;display:flex;flex-direction:column;flex:1;">

                    {{-- Espacio para logo / ícono --}}
                    <div style="width:100%;aspect-ratio:1;
                                background:#1D1D2B;
                                border:1px dashed rgba(255,255,255,.15);
                                border-radius:12px;
                                display:flex;align-items:center;justify-content:center;
                                margin-bottom:1.5rem;">
                        {{ $dom['icono'] ?? '' }}
                    </div>

                    <h4 style="color:#C8A84B;font-size:1.15rem;margin-bottom:.3rem;
                                                font-family:'Headland One',serif;">
                                            {{ $dom['nombrecasa'] }}
                                        </h4>

                    <h3 style="color:#FFFFFF;font-size:1.15rem;margin-bottom:.8rem;
                               font-family:'Headland One',serif;">
                        {{ $dom['nombre'] }}
                    </h3>

                    <p style="color:#B0A898;line-height:1.7;margin-bottom:1.5rem;flex:1;">
                        {{ $dom['desc'] }}
                    </p>

                    <div style="display:flex;flex-wrap:wrap;gap:.5rem;">
                        @foreach($dom['carreras'] as $c)
                        <span style="background:rgba(255,255,255,.04);
                                     border:1px solid rgba(255,255,255,.08);
                                     color:#F0EAD8;padding:.4rem .75rem;
                                     border-radius:50px;font-size:.72rem;">
                            {{ $c }}
                        </span>
                        @endforeach
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── CTA ── --}}
    <section class="cta-section">
        <h2 class="cta-title"
            style="color:#FFFFFF;font-family:'Headland One',serif;">
            Descubre tu camino académico
        </h2>
        <p class="cta-desc" style="color:#F0EAD8;">
            Realiza el cuestionario NOVA y descubre qué dominio y qué casa
            representan mejor tus intereses, habilidades y forma de aprender.
        </p>
        <a href="{{ route('quiz') }}"
           class="cta-btn"
           style="display:inline-block;background:#C6A050;color:#06060F;
                  text-decoration:none;padding:.9rem 2rem;
                  border-radius:8px;font-weight:700;">
            Realizar Test
        </a>
    </section>

</div>{{-- /page-content --}}

{{-- ═══ FOOTER ════════════════════════════════════════════════════════════ --}}
<style>
    #footer-casas {
        padding: 3rem 4rem;
        background: #06060F;
        border-top: 1px solid #2B1F3D;
        position: relative;
        z-index: 10;
        isolation: isolate;
    }
    #footer-casas-grid {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 3rem;
    }

    @media (max-width: 600px) {
        #footer-casas { padding: 2.5rem 1.25rem; }
        #footer-casas-grid { flex-direction: column; gap: 2rem; }
        #footer-casas-grid > div { max-width: 100% !important; }
        #footer-casas-grid h3 { font-size: 1.1rem !important; }
    }
</style>

<footer id="footer-casas">
    <div id="footer-casas-grid">
        <div style="text-align:left;max-width:400px;">
            <h3 style="font-family:'Headland One',serif;color:#C8A84B;
                       margin-bottom:1rem;font-size:1.4rem;">
                Universidad Tecnológica de León
            </h3>
            <p style="color:#F0EAD8;line-height:1.8;margin:0;">
                Blvd. Universidad Tecnológica #225 Col. San Carlos<br>
                C.P. 37670 León, Gto. México<br><br>
                comunicacionutl@utleon.edu.mx<br><br>
                (477) 7 10 00 20
            </p>
        </div>
        <div style="text-align:left;max-width:450px;">
            <h3 style="font-family:'Headland One',serif;color:#C8A84B;
                       margin-bottom:1rem;font-size:1.4rem;">
                Desarrolladores del Proyecto
            </h3>
            <p style="color:#F0EAD8;line-height:2;margin:0;">
                <strong>Citlalli Méndez</strong><br>Documentadora y Administradora de Base de Datos<br>citlallialejandrams@gmail.com<br><br>
                <strong>Miryam Muñoz</strong><br>Diseñadora<br>miryammunoz26@gmail.com<br><br>
                <strong>Carlo Flores</strong><br>Programador<br>carlofernandoflores2006@gmail.com
            </p>
        </div>
    </div>
    <div style="margin-top:2.5rem;border-top:1px solid rgba(200,168,75,.15);
                padding-top:1.5rem;text-align:center;color:#707085;
                font-size:.8rem;letter-spacing:.08em;">
        © {{ date('Y') }} NOVA · Navegador de Orientación Vocacional y Aptitudes
    </div>
</footer>

@endsection