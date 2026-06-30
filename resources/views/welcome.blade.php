@extends('layouts.app')
@section('title', 'Inicio — SIIA')

@section('content')

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<style>
    .nav-links { display:flex; gap:2rem; }
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

<nav style="display:flex;align-items:center;justify-content:space-between;
            padding:1.6rem 1.75rem;
            background:rgba(6,6,15,0.6);
            backdrop-filter:blur(12px);
            -webkit-backdrop-filter:blur(12px);
            position:sticky;top:0;z-index:100;isolation:isolate;">

    <img src="{{ asset('imagenes/isotipo_dorado.webp') }}"
         alt="UTL"
         style="height:2.6rem;width:auto;display:block;">

    <div class="nav-links">
        <a href="{{ route('welcome') }}"   style="font-size:.88rem;color:#E8C96A;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Inicio</a>
        <a href="{{ route('quiz') }}"      style="font-size:.88rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Quiz</a>
        <a href="{{ route('recorrido') }}" style="font-size:.88rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Recorrido</a>
        <a href="{{ route('dominios') }}"  style="font-size:.88rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Dominios</a>
        <a href="{{ route('casas') }}"     style="font-size:.88rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Casas</a>
    </div>

    <div class="nav-auth">
        <a href="#" style="font-size:.88rem;color:#B0A898;text-decoration:none;
                           letter-spacing:.08em;text-transform:uppercase;">Ingresar</a>
    </div>

    <button class="hamburger" id="hamburgerBtn" aria-label="Abrir menú" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>
</nav>

<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('welcome') }}" style="color:#E8C96A;">Inicio</a>
    <a href="{{ route('quiz') }}">Quiz</a>
    <a href="{{ route('recorrido') }}">Recorrido</a>
    <a href="{{ route('dominios') }}">Dominios</a>
    <a href="{{ route('casas') }}">Casas</a>
    <a href="#">Ingresar</a>
</div>

{{-- ═══ HERO ═════════════════════════════════════════════════════════════════ --}}
<style>
    #hero-content { width:50%; padding:0 2rem; }
    #hero-title   { font-size:clamp(9rem,15vw,14rem); }
    #hero-desc    { font-size:1.03rem; max-width:480px; }
    #hero-btns a  { padding:.85rem 3rem; font-size:1rem; }

    @media (max-width: 768px) {
        #hero { height:100svh !important; }
        #hero-bg { background-position:center center !important; }
        #hero-overlay-left {
            background:linear-gradient(to bottom,
                rgba(6,6,15,0.55) 0%,rgba(6,6,15,0.30) 40%,
                rgba(6,6,15,0.70) 75%,rgba(6,6,15,1) 100%) !important;
        }
        #hero-content {
            width:100% !important; padding:0 1.5rem !important;
            justify-content:flex-end !important; padding-bottom:3.5rem !important;
        }
        #hero-title  { font-size:clamp(6rem,28vw,9rem) !important; }
        #hero-desc   { font-size:.92rem !important; max-width:100% !important; }
        #hero-btns   { flex-direction:column !important; align-items:stretch !important; width:100% !important; }
        #hero-btns a { padding:.85rem 1.5rem !important; font-size:.9rem !important; text-align:center !important; }
    }
</style>

<section id="hero" style="position:relative;height:calc(100vh - 50px);overflow:hidden;background:#06060F;">

    <div id="hero-bg"
         style="position:absolute;inset:0;
                background-image:url('{{ asset('imagenes/hero-leon.webp') }}');
                background-size:cover;background-position:right center;">
    </div>

    <div id="hero-overlay-left"
         style="position:absolute;inset:0;
                background:linear-gradient(to right,
                    rgba(15,10,3,0.95) 0%,rgba(12,8,2,0.90) 23%,
                    rgba(6,6,15,.7) 45%,rgba(6,6,15,.2) 65%,transparent 100%);">
    </div>

    <div style="position:absolute;bottom:0;left:0;right:0;height:35%;
                background:linear-gradient(to bottom,transparent 0%,rgba(6,6,15,.6) 50%,#06060F 100%);
                z-index:1;"></div>

    <div id="hero-content"
         style="position:relative;z-index:2;height:100%;
                display:flex;flex-direction:column;justify-content:center;
                align-items:center;gap:1.5rem;">

        <h1 id="hero-title"
            style="margin:0;padding:0;font-family:'Headland One',serif;
                   font-weight:700;line-height:0.85;letter-spacing:.02em;
                   background:linear-gradient(to bottom,
                       #E8C96A 0%,#C8A84B 20%,#C6A050 40%,
                       #8D6627 60%,#6B5020 80%,#8B6914 100%);
                   -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                   background-clip:text;">
            SIIA
        </h1>

        <p id="hero-desc"
           style="margin:0;letter-spacing:.10em;text-transform:uppercase;
                  line-height:2;color:#F0EAD8;text-align:center;">
            Forma parte de una casa que represente
            tus habilidades, valores y visión profesional.
        </p>

        <div id="hero-btns" style="display:flex;gap:1.5rem;margin-top:.5rem;">
            <a href="{{ route('quiz') }}"
               style="display:inline-block;
                      background:linear-gradient(135deg,#C6A050,#8D6627);
                      border:1px solid #C6A050;border-radius:3px;
                      font-weight:700;color:#1A1000;text-decoration:none;letter-spacing:.05em;">
                Iniciar
            </a>
            <a href="{{ route('casas') }}"
               style="display:inline-block;border:1px solid #7A6030;border-radius:3px;
                      color:#E8E0D0;text-decoration:none;background:transparent;letter-spacing:.05em;">
                Conocer las casas
            </a>
        </div>
    </div>

</section>

{{-- ═══ SECCIÓN: DESCUBRE TU IDENTIDAD ════════════════════════════════════ --}}
<style>
    #identidad-cards { display:flex;justify-content:center;gap:2rem;flex-wrap:wrap;margin-bottom:2rem; }
    .identidad-card  { width:220px;border:1px solid rgba(200,168,75,.18);border-radius:14px;
                       overflow:hidden;background:transparent;transition:all .35s ease; }
    .identidad-card:hover { transform:translateY(-8px);border-color:#C8A84B;
                            box-shadow:0 0 20px rgba(200,168,75,.18); }
    .identidad-img   { height:220px;display:flex;justify-content:center;align-items:center;
                       padding:18px;background:radial-gradient(circle at center,rgba(255,255,255,.03),transparent 70%); }
    .identidad-img img { width:100%;height:100%;object-fit:contain;transition:transform .35s ease; }
    .identidad-card:hover .identidad-img img { transform:scale(1.05); }
    .identidad-titulo { padding:1rem;text-align:center;color:#F0EAD8;
                        font-family:'Headland One',serif;font-size:1.15rem;
                        border-top:1px solid rgba(255,255,255,.06); }

    @media (max-width:768px) {
        #identidad-cards { gap:1rem; }
        .identidad-card  { width:170px; }
        .identidad-img   { height:170px; }
        .identidad-titulo{ font-size:.95rem; }
    }
    @media (max-width:480px) {
        .identidad-card  { width:140px; }
        .identidad-img   { height:140px; }
        .identidad-titulo{ font-size:.85rem; }
    }
</style>

<section id="identidad" style="background:rgba(6,6,15,0.15);padding:3rem 4rem;">

    <div style="display:flex;align-items:center;gap:1.5rem;justify-content:center;margin-bottom:.5rem;">
        <div class="section-rule" style="height:1px;width:200px;background:linear-gradient(to left,#8D6627,transparent);"></div>
        <p style="margin:0;font-size:.7rem;text-transform:uppercase;
                  letter-spacing:.14em;color:#707085;white-space:nowrap;">
            Descubre tu identidad académica
        </p>
        <div class="section-rule" style="height:1px;width:200px;background:linear-gradient(to right,#8D6627,transparent);"></div>
    </div>

    <h2 style="text-align:center;font-size:1.5rem;font-weight:700;color:#FFFFFF;
               margin-bottom:2rem;font-family:'Headland One',serif;
               letter-spacing:.10em;text-transform:uppercase;">
        ¿A qué casa de la UTL perteneces?
    </h2>

    @php
    $casasInicio = [
        ['nombre'=>'Ambiental',   'imagen'=>'imagenes/casas/ambiental.webp'],
        ['nombre'=>'Gastronomía', 'imagen'=>'imagenes/casas/gastronomia2.webp'],
        ['nombre'=>'Mecatrónica', 'imagen'=>'imagenes/casas/mecatronicaBaseSinTextura.webp'],
    ];
    @endphp

    <div id="identidad-cards">
        @foreach($casasInicio as $casa)
        <div class="identidad-card">
            <div class="identidad-img">
                <img src="{{ asset($casa['imagen']) }}" alt="{{ $casa['nombre'] }}">
            </div>
            <div class="identidad-titulo">{{ $casa['nombre'] }}</div>
        </div>
        @endforeach
    </div>

    <div style="text-align:center;">
        <a href="{{ route('quiz') }}"
           style="display:inline-block;padding:.55rem 2.2rem;
                  border:1px solid #8D6627;border-radius:4px;
                  font-size:.88rem;font-weight:600;color:#E8C96A;
                  text-decoration:none;background:transparent;letter-spacing:.08em;">
            ¡Descúbrelo ya!
        </a>
    </div>
</section>

{{-- ═══ SECCIÓN: DOMINIOS ACADÉMICOS ══════════════════════════════════════ --}}
<style>
    #dominios { padding:3rem 4rem; }

    .dom-track {
        display:flex; gap:.85rem;
        overflow-x:auto;
        scroll-snap-type:x mandatory;
        -webkit-overflow-scrolling:touch;
        scrollbar-width:none;
        padding-bottom:4px;
    }
    .dom-track::-webkit-scrollbar { display:none; }

    .dom-card {
        flex:0 0 calc(25% - .64rem);
        scroll-snap-align:start;
        border:1px solid #2B1F3D;
        border-radius:6px;
        background:#14141F;
        display:flex; flex-direction:column;
        overflow:hidden; min-width:200px;
    }
    .dom-track.cols-3 .dom-card { flex:0 0 calc(33.333% - .57rem); }

    .dom-nav { display:flex;justify-content:center;align-items:center;gap:1.5rem;margin-top:1.25rem; }
    .dom-nav-btn {
        width:38px;height:38px;border-radius:50%;
        border:1px solid #2B1F3D;background:#14141F;
        color:#C8A84B;font-size:1.3rem;cursor:pointer;
        display:flex;align-items:center;justify-content:center;
        transition:border-color .2s,background .2s;line-height:1;
    }
    .dom-nav-btn:hover { border-color:#C8A84B;background:#1e1a0e; }
    .dom-nav-label {
        font-family:'Headland One',serif;font-size:.88rem;
        color:#F0EAD8;letter-spacing:.06em;min-width:220px;text-align:center;
    }

    @media (max-width:900px) {
        #dominios { padding:2.5rem 1.25rem !important; }
        .dom-card { flex:0 0 calc(50% - .43rem) !important; }
    }
    @media (max-width:480px) {
        .dom-card { flex:0 0 90% !important; }
    }
</style>

@php
$dominiosHome = [
    [
        'nombre'  => 'Ingenierías',
        'color'   => '#075E56',
        'imagen'  => 'imagenes/dominios/Ingenierias.webp',
        'carreras'=> 'Logística · Mantenimiento Industrial · Ambiental y Sustentabilidad',
        'casas'   => [
            ['imagen'=>'imagenes/casas/logistica.webp',    'nombre'=>'Logística',                  'carrera'=>'Ingeniería en Logística',          'frase'=>'Toda ruta tiene un destino',             'valores'=>['Responsabilidad','Organización','Eficiencia'],      'desc'=>'Te gusta planear, coordinar recursos y optimizar procesos.'],
            ['imagen'=>'imagenes/casas/mantenimiento.webp','nombre'=>'Mantenimiento Industrial',    'carrera'=>'Ing. Mantenimiento Industrial',    'frase'=>'La excelencia se construye cada día',   'valores'=>['Compromiso','Precisión','Responsabilidad'],          'desc'=>'Diagnóstico y mantenimiento de maquinaria industrial.'],
            ['imagen'=>'imagenes/casas/ambiental.webp',   'nombre'=>'Ambiental y Sustentabilidad', 'carrera'=>'Ing. Ambiental y Sustentabilidad', 'frase'=>'Proteger hoy para transformar mañana',  'valores'=>['Ética','Compromiso','Responsabilidad Social'],       'desc'=>'Desarrollo de soluciones ambientales sostenibles.'],
        ],
    ],
    [
        'nombre'  => 'Tecnologías de la Información',
        'color'   => '#420FDB',
        'imagen'  => 'imagenes/dominios/Tecnologias_de_la_Informacion.webp',
        'carreras'=> 'Entornos Virtuales · Ciencia de Datos · Desarrollo de Software · Redes Digitales',
        'casas'   => [
            ['imagen'=>'imagenes/casas/entornos.webp', 'nombre'=>'Entornos Virtuales',    'carrera'=>'Entornos Virtuales y Negocios Digitales', 'frase'=>'Imaginar es crear',              'valores'=>['Creatividad','Innovación','Adaptación'],             'desc'=>'Desarrollo de productos digitales interactivos.'],
            ['imagen'=>'imagenes/casas/datos.webp',    'nombre'=>'Ciencia de Datos',      'carrera'=>'Ciencia de Datos',                       'frase'=>'Los datos cuentan historias',    'valores'=>['Objetividad','Precisión','Pensamiento Crítico'],     'desc'=>'Interpretación y análisis de datos.'],
            ['imagen'=>'imagenes/casas/software.webp', 'nombre'=>'Desarrollo de Software','carrera'=>'Desarrollo de Software',                  'frase'=>'Cada línea construye el futuro', 'valores'=>['Innovación','Perseverancia','Aprendizaje Continuo'], 'desc'=>'Creación de aplicaciones y sistemas.'],
            ['imagen'=>'imagenes/casas/redes.webp',    'nombre'=>'Redes Digitales',       'carrera'=>'Infraestructura de Redes Digitales',      'frase'=>'Conectar es avanzar',            'valores'=>['Responsabilidad','Orden','Seguridad'],               'desc'=>'Administración de redes y servidores.'],
        ],
    ],
    [
        'nombre'  => 'Ingeniería Industrial',
        'color'   => '#CC7135',
        'imagen'  => 'imagenes/dominios/Ingenieria_Industrial.webp',
        'carreras'=> 'Automotriz · Procesos Productivos · Moldeo de Plásticos · Calzado',
        'casas'   => [
            ['imagen'=>'imagenes/casas/automotriz.webp', 'nombre'=>'Automotriz',          'carrera'=>'Ingeniería Automotriz',              'frase'=>'Movimiento con propósito',       'valores'=>['Eficiencia','Liderazgo','Compromiso'],       'desc'=>'Mejora de procesos automotrices.'],
            ['imagen'=>'imagenes/casas/productivos.webp','nombre'=>'Procesos Productivos','carrera'=>'Ing. Procesos Productivos',          'frase'=>'La mejora nunca termina',        'valores'=>['Orden','Eficiencia','Mejora Continua'],      'desc'=>'Gestión de operaciones industriales.'],
            ['imagen'=>'imagenes/casas/plasticos.webp',  'nombre'=>'Moldeo de Plásticos', 'carrera'=>'Ing. Moldeo de Plásticos',           'frase'=>'La forma sigue a la innovación', 'valores'=>['Precisión','Responsabilidad','Innovación'],  'desc'=>'Diseño y fabricación de productos plásticos.'],
            ['imagen'=>'imagenes/casas/calzado.webp',    'nombre'=>'Calzado',             'carrera'=>'Gestión y Productividad de Calzado', 'frase'=>'Cada paso deja huella',          'valores'=>['Creatividad','Calidad','Trabajo en Equipo'],'desc'=>'Industria del calzado y manufactura.'],
        ],
    ],
    [
        'nombre'  => 'Mecatrónica',
        'color'   => '#A81E1E',
        'imagen'  => 'imagenes/dominios/Mecatronica.webp',
        'carreras'=> 'Manufactura Flexible · Optomecatrónica · Automatización',
        'casas'   => [
            ['imagen'=>'imagenes/casas/manufactura.webp',    'nombre'=>'Manufactura Flexible','carrera'=>'Manufactura Flexible','frase'=>'Adaptarse es evolucionar',               'valores'=>['Innovación','Precisión','Creatividad'],     'desc'=>'Sistemas automatizados de producción.'],
            ['imagen'=>'imagenes/casas/optomecatronica.webp','nombre'=>'Optomecatrónica',     'carrera'=>'Optomecatrónica',     'frase'=>'La precisión guía el camino',            'valores'=>['Precisión','Responsabilidad','Innovación'], 'desc'=>'Sistemas ópticos y electrónicos.'],
            ['imagen'=>'imagenes/casas/automatizacion.webp', 'nombre'=>'Automatización',      'carrera'=>'Automatización',      'frase'=>'La eficiencia es inteligencia aplicada', 'valores'=>['Eficiencia','Compromiso','Innovación'],     'desc'=>'Automatización de procesos industriales.'],
        ],
    ],
    [
        'nombre'  => 'Licenciaturas',
        'color'   => '#9A7B10',
        'imagen'  => 'imagenes/dominios/Licenciaturas.webp',
        'carreras'=> 'Gastronomía · Administración · Turismo · Negocios y Mercadotecnia',
        'casas'   => [
            ['imagen'=>'imagenes/casas/gastronomia2.webp',  'nombre'=>'Gastronomía',             'carrera'=>'Gastronomía',                           'frase'=>'Crear experiencias para recordar','valores'=>['Servicio','Creatividad','Disciplina'],   'desc'=>'Experiencias culinarias y hospitalidad.'],
            ['imagen'=>'imagenes/casas/administracion.webp','nombre'=>'Administración',           'carrera'=>'Administración',                        'frase'=>'Liderar para construir',          'valores'=>['Liderazgo','Responsabilidad','Ética'],   'desc'=>'Gestión de empresas y recursos.'],
            ['imagen'=>'imagenes/casas/turismo.webp',       'nombre'=>'Turismo',                  'carrera'=>'Turismo',                               'frase'=>'Descubrir conecta culturas',      'valores'=>['Servicio','Empatía','Creatividad'],      'desc'=>'Experiencias turísticas y culturales.'],
            ['imagen'=>'imagenes/casas/mercadotecnia.webp', 'nombre'=>'Negocios y Mercadotecnia', 'carrera'=>'Innovación de Negocios y Mercadotecnia','frase'=>'Las ideas iluminan el cambio',    'valores'=>['Innovación','Liderazgo','Comunicación'], 'desc'=>'Marketing y desarrollo de negocios.'],
        ],
    ],
];
$activoIdx = 0;
@endphp

<section id="dominios" style="background:rgba(6,6,15,0.15);">

    {{-- Título --}}
    <div style="display:flex;align-items:center;gap:1.5rem;justify-content:center;margin-bottom:.5rem;">
        <div class="section-rule" style="height:1px;width:200px;background:linear-gradient(to left,#8D6627,transparent);"></div>
        <h2 style="margin:0;font-size:1.5rem;font-weight:700;color:#FFFFFF;
                   font-family:'Headland One',serif;letter-spacing:.12em;
                   text-transform:uppercase;white-space:nowrap;">
            Dominios Académicos
        </h2>
        <div class="section-rule" style="height:1px;width:200px;background:linear-gradient(to right,#8D6627,transparent);"></div>
    </div>

    <p style="text-align:center;font-size:.75rem;color:#B0A898;
              max-width:420px;margin:0 auto 2rem;line-height:1.7;
              letter-spacing:.08em;text-transform:uppercase;">
        Explora los dominios académicos que conforman la Universidad Tecnológica de León.
    </p>

    {{-- Banner del dominio activo --}}
    <div id="dominio-banner"
         style="border:1px solid #2B1F3D;border-radius:6px;
                padding:1.2rem 1.5rem;display:flex;align-items:center;
                gap:1.25rem;margin-bottom:1.5rem;background:#14141F;">
        <div style="width:64px;height:64px;flex-shrink:0;
                    border-radius:6px;overflow:hidden;
                    background:#0D0D1A;border:1px solid #2B1F3D;">
            <img id="banner-img"
                 src="{{ asset($dominiosHome[$activoIdx]['imagen']) }}"
                 alt="{{ $dominiosHome[$activoIdx]['nombre'] }}"
                 style="width:100%;height:100%;object-fit:cover;display:block;">
        </div>
        <div>
            <p id="banner-nombre"
               style="font-size:.95rem;font-weight:700;color:#F0EAD8;margin-bottom:.3rem;
                      font-family:'Headland One',serif;letter-spacing:.04em;">
                {{ $dominiosHome[$activoIdx]['nombre'] }}
            </p>
            <p id="banner-carreras"
               style="font-size:.82rem;color:#B0A898;line-height:1.5;margin:0;">
                {{ $dominiosHome[$activoIdx]['carreras'] }}
            </p>
        </div>
    </div>

    {{-- Carruseles: uno por dominio --}}
    @foreach($dominiosHome as $di => $dom)
    @php $cols = count($dom['casas']) >= 4 ? '' : 'cols-3'; @endphp
    <div id="carousel-wrap-{{ $di }}"
         style="{{ $di !== $activoIdx ? 'display:none;' : '' }}">
        <div id="carousel-{{ $di }}" class="dom-track {{ $cols }}">
            @foreach($dom['casas'] as $casa)
            <div class="dom-card">
                <div style="width:100%;aspect-ratio:1;overflow:hidden;flex-shrink:0;">
                    <img src="{{ asset($casa['imagen']) }}"
                         alt="{{ $casa['nombre'] }}"
                         style="width:100%;height:100%;object-fit:cover;display:block;">
                </div>
                <div style="padding:.85rem;display:flex;flex-direction:column;gap:.4rem;flex:1;">
                    <p style="font-size:.82rem;font-weight:700;color:#F0EAD8;margin:0;
                               font-family:'Headland One',serif;">{{ $casa['nombre'] }}</p>
                    <p style="font-size:.75rem;color:#B0A898;margin:0;">{{ $casa['carrera'] }}</p>
                    <p style="font-size:.72rem;color:#C8A84B;font-style:italic;margin:0;">{{ $casa['frase'] }}</p>
                    <div style="display:flex;flex-wrap:wrap;gap:3px;margin-top:.2rem;">
                        @foreach($casa['valores'] as $v)
                        <span style="font-size:.65rem;padding:2px 7px;
                                     border:1px solid #2B1F3D;border-radius:20px;
                                     color:#707085;background:#0D0D1A;">{{ $v }}</span>
                        @endforeach
                    </div>
                    <p style="font-size:.68rem;color:#707085;line-height:1.5;margin:0;">
                        {{ $casa['desc'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    {{-- Navegación ‹ Dominio › --}}
    <div class="dom-nav">
        <button class="dom-nav-btn" onclick="navDominio(-1)" aria-label="Dominio anterior">‹</button>
        <span class="dom-nav-label" id="dom-nav-label">
            {{ $dominiosHome[$activoIdx]['nombre'] }}
        </span>
        <button class="dom-nav-btn" onclick="navDominio(1)" aria-label="Dominio siguiente">›</button>
    </div>

</section>

{{-- ═══ FOOTER ════════════════════════════════════════════════════════════ --}}
<style>
    #footer-casas {
        padding:3rem 4rem; background:#06060F;
        border-top:1px solid #2B1F3D;
        position:relative; z-index:10; isolation:isolate;
    }
    #footer-casas-grid { display:flex;justify-content:space-around;flex-wrap:wrap;gap:3rem; }

    @media (max-width:600px) {
        #footer-casas { padding:2.5rem 1.25rem; }
        #footer-casas-grid { flex-direction:column;gap:2rem; }
        #footer-casas-grid > div { max-width:100% !important; }
        #footer-casas-grid h3 { font-size:1.1rem !important; }
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
        © {{ date('Y') }} SIIA · Sistema Integral de Identidad Académica
    </div>
</footer>

@endsection

@push('extra-js')
<script>
    {{-- Hamburger --}}
    const btn  = document.getElementById('hamburgerBtn');
    const menu = document.getElementById('mobileMenu');
    btn.addEventListener('click', () => {
        menu.classList.toggle('open');
        btn.setAttribute('aria-expanded', menu.classList.contains('open'));
    });
    document.addEventListener('click', e => {
        if (!btn.contains(e.target) && !menu.contains(e.target))
            menu.classList.remove('open');
    });

    {{-- Dominios --}}
    @php
    $dominiosDataJs = array_map(fn($d) => [
        'nombre'   => $d['nombre'],
        'imagen'   => asset($d['imagen']),
        'carreras' => $d['carreras'],
        'color'    => $d['color'],
    ], $dominiosHome);
    @endphp

    (function () {
        const dominiosData = @json($dominiosDataJs);
        const total = dominiosData.length;
        let activo  = {{ $activoIdx }};

        function cambiarDominio(idx) {
            document.getElementById('carousel-wrap-' + activo).style.display = 'none';
            activo = (idx + total) % total;
            const dom = dominiosData[activo];
            document.getElementById('carousel-wrap-' + activo).style.display = '';
            document.getElementById('banner-img').src              = dom.imagen;
            document.getElementById('banner-nombre').textContent   = dom.nombre;
            document.getElementById('banner-carreras').textContent = dom.carreras;
            document.getElementById('dom-nav-label').textContent   = dom.nombre;
            const track = document.getElementById('carousel-' + activo);
            if (track) track.scrollLeft = 0;
        }

        window.navDominio = function(dir) { cambiarDominio(activo + dir); };
    })();
</script>
@endpush