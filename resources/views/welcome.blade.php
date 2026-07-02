@extends('layouts.app')
@section('title', 'Inicio — NOVA')

@section('content')

<style>
    /* ══ NAVBAR ══ */
    .siia-nav { display:flex; align-items:center; padding:1.1rem 2rem;
                background:rgba(6,6,15,.65); backdrop-filter:blur(14px);
                -webkit-backdrop-filter:blur(14px); position:sticky;top:0;z-index:100; }

    /* ══ HERO ══ */
    #hero { position:relative; height:100svh; overflow:hidden; background:#06060F; }
    #hero-bg { position:absolute;inset:0;
               background-image:url('{{ asset("imagenes/hero-leon.webp") }}');
               background-size:cover; background-position:right center; }
    #hero-overlay { position:absolute;inset:0;
                    background:linear-gradient(to right,
                        rgba(15,10,3,.95) 0%,rgba(12,8,2,.90) 23%,
                        rgba(6,6,15,.7) 45%,rgba(6,6,15,.2) 65%,transparent 100%); }
    #hero-bottom  { position:absolute;bottom:0;left:0;right:0;height:35%;z-index:1;
                    background:linear-gradient(to bottom,transparent,rgba(6,6,15,.6) 50%,#06060F); }
    #hero-content { position:relative;z-index:2;height:100%;
                    display:flex;flex-direction:column;justify-content:center;
                    align-items:flex-start;gap:1.25rem;padding:0 5%; }

    #hero-title {
        margin:0;padding:0;font-family:'Headland One',serif;font-weight:700;
        line-height:.88;letter-spacing:.02em;
        font-size:clamp(7rem,14vw,14rem);
        background:linear-gradient(to bottom,#E8C96A 0%,#C8A84B 20%,#C6A050 40%,
                   #8D6627 60%,#6B5020 80%,#8B6914 100%);
        -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    }
    #hero-desc {
        margin:0;letter-spacing:.09em;text-transform:uppercase;
        line-height:1.9;color:#F0EAD8;font-size:.95rem;max-width:440px;
    }
    #hero-btns { display:flex;gap:1rem;flex-wrap:wrap; }
    #hero-btns a { padding:.85rem 2.5rem;font-size:.95rem;border-radius:4px; }

    /* ══ IDENTIDAD ══ */
    #identidad { padding:3.5rem 4rem; background:rgba(6,6,15,0.15); }
    .section-divider { display:flex;align-items:center;gap:1.25rem;justify-content:center;margin-bottom:.5rem; }
    .section-divider-line { height:1px;width:160px; }
    .section-divider-text { font-size:.68rem;text-transform:uppercase;letter-spacing:.14em;color:#707085;white-space:nowrap; }

    #identidad-cards { display:flex;justify-content:center;gap:2rem;flex-wrap:wrap;margin-bottom:2rem; }
    .identidad-card { width:220px;border:1px solid rgba(200,168,75,.18);border-radius:14px;
                      overflow:hidden;background:transparent;transition:all .35s; }
    .identidad-card:hover { transform:translateY(-7px);border-color:#C8A84B;
                            box-shadow:0 0 20px rgba(200,168,75,.18); }
    .identidad-img { height:220px;display:flex;justify-content:center;align-items:center;
                     padding:16px;background:radial-gradient(circle at center,rgba(255,255,255,.03),transparent 70%); }
    .identidad-img img { width:100%;height:100%;object-fit:contain;transition:transform .35s; }
    .identidad-card:hover .identidad-img img { transform:scale(1.05); }
    .identidad-titulo { padding:.85rem 1rem;text-align:center;color:#F0EAD8;
                        font-family:'Headland One',serif;font-size:1.05rem;
                        border-top:1px solid rgba(255,255,255,.06); }

    /* ══ DOMINIOS ══ */
    #dominios { padding:3.5rem 4rem; background:rgba(6,6,15,0.15); }

    .dom-track { display:flex;gap:.85rem;overflow-x:auto;
                 scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;
                 scrollbar-width:none;padding-bottom:4px; }
    .dom-track::-webkit-scrollbar { display:none; }
    .dom-card { flex:0 0 calc(25% - .64rem);scroll-snap-align:start;
                border:1px solid #2B1F3D;border-radius:8px;background:#14141F;
                display:flex;flex-direction:column;overflow:hidden;min-width:180px; }
    .dom-track.cols-3 .dom-card { flex:0 0 calc(33.333% - .57rem); }

    .dom-nav { display:flex;justify-content:center;align-items:center;gap:1.5rem;margin-top:1.25rem; }
    .dom-nav-btn { width:40px;height:40px;border-radius:50%;border:1px solid #2B1F3D;
                   background:#14141F;color:#C8A84B;font-size:1.3rem;cursor:pointer;
                   display:flex;align-items:center;justify-content:center;
                   transition:border-color .2s,background .2s;line-height:1; }
    .dom-nav-btn:hover { border-color:#C8A84B;background:#1e1a0e; }
    .dom-nav-label { font-family:'Headland One',serif;font-size:.88rem;color:#F0EAD8;
                     letter-spacing:.06em;min-width:200px;text-align:center; }

    /* ══════════════════════════════
       TABLET ≤ 900px
       ══════════════════════════════ */
    @media (max-width: 900px) {
        #identidad { padding:2.5rem 2rem; }
        #dominios  { padding:2.5rem 2rem; }
        .dom-card  { flex:0 0 calc(50% - .43rem) !important; }
    }

    /* ══════════════════════════════
       MÓVIL ≤ 600px
       ══════════════════════════════ */
    @media (max-width: 600px) {
        /* Hero */
        #hero-overlay {
            background:linear-gradient(to bottom,
                rgba(6,6,15,.45) 0%,rgba(6,6,15,.25) 35%,
                rgba(6,6,15,.75) 70%,#06060F 100%) !important;
        }
        #hero-bg { background-position:center center !important; }
        #hero-content {
            align-items:center !important;
            justify-content:flex-end !important;
            padding:0 1.25rem 3.5rem !important;
            text-align:center !important;
        }
        #hero-title { font-size:clamp(5.5rem,26vw,8rem) !important; }
        #hero-desc  { font-size:.85rem !important; max-width:100% !important; }
        #hero-btns  { flex-direction:column !important; width:100% !important; }
        #hero-btns a { padding:.85rem 1rem !important; font-size:.88rem !important;
                       text-align:center !important; width:100% !important; }

        /* Identidad */
        #identidad { padding:2.5rem 1.25rem !important; }
        .section-divider-line { width:60px !important; }
        #identidad-cards { gap:1rem !important; }
        .identidad-card { width:calc(50% - .5rem); }
        .identidad-img  { height:150px !important; padding:12px !important; }
        .identidad-titulo { font-size:.88rem !important; padding:.65rem !important; }

        /* Dominios */
        #dominios { padding:2.5rem 1.25rem !important; }
        .dom-card { flex:0 0 78vw !important; min-width:0 !important; }
        .dom-nav-label { min-width:0; font-size:.82rem; }
    }

    @media (max-width: 360px) {
        .identidad-card { width:100%; }
        #hero-title { font-size:clamp(4.5rem,22vw,7rem) !important; }
    }
</style>

{{-- NAVBAR --}}
<nav class="siia-nav">
    <img src="{{ asset('imagenes/isotipo_dorado.webp') }}" alt="UTL" class="siia-nav-logo">
    <div class="nav-links">
        <a href="{{ route('welcome') }}" class="active">Inicio</a>
        <a href="{{ route('quiz') }}">Quiz</a>
        <a href="{{ route('recorrido') }}">Recorrido</a>
        <a href="{{ route('dominios') }}">Dominios</a>
        <a href="{{ route('casas') }}">Casas</a>
        <a href="{{ route('ingresar') }}">Ingresar</a>
    </div>
    <button class="hamburger" id="hamburgerBtn" aria-label="Abrir menú" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>
</nav>

<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('welcome') }}" class="active">Inicio</a>
    <a href="{{ route('quiz') }}">Quiz</a>
    <a href="{{ route('recorrido') }}">Recorrido</a>
    <a href="{{ route('dominios') }}">Dominios</a>
    <a href="{{ route('casas') }}">Casas</a>
    <a href="{{ route('ingresar') }}">Ingresar</a>
</div>

{{-- HERO --}}
<section id="hero">
    <div id="hero-bg"></div>
    <div id="hero-overlay"></div>
    <div id="hero-bottom"></div>
    <div id="hero-content">
        <h1 id="hero-title">NOVA</h1>
        <p id="hero-desc">
            Forma parte de una casa que represente<br>
            tus habilidades, valores y visión profesional.
        </p>
        <div id="hero-btns">
            <a href="{{ route('quiz') }}"
               style="display:inline-block;background:linear-gradient(135deg,#C6A050,#8D6627);
                      border:1px solid #C6A050;font-weight:700;color:#1A1000;text-decoration:none;
                      letter-spacing:.05em;">
                Iniciar
            </a>
            <a href="{{ route('casas') }}"
               style="display:inline-block;border:1px solid #7A6030;color:#E8E0D0;
                      text-decoration:none;background:transparent;letter-spacing:.05em;">
                Conocer las casas
            </a>
        </div>
    </div>
</section>

{{-- IDENTIDAD --}}
<section id="identidad">
    <div class="section-divider">
        <div class="section-divider-line" style="background:linear-gradient(to left,#8D6627,transparent);"></div>
        <span class="section-divider-text">Descubre tu identidad académica</span>
        <div class="section-divider-line" style="background:linear-gradient(to right,#8D6627,transparent);"></div>
    </div>
    <h2 style="text-align:center;font-size:1.4rem;font-weight:700;color:#FFFFFF;
               margin-bottom:2rem;font-family:'Headland One',serif;
               letter-spacing:.09em;text-transform:uppercase;">
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
                <img src="{{ asset($casa['imagen']) }}" alt="{{ $casa['nombre'] }}" loading="lazy">
            </div>
            <div class="identidad-titulo">{{ $casa['nombre'] }}</div>
        </div>
        @endforeach
    </div>

    <div style="text-align:center;">
        <a href="{{ route('quiz') }}"
           style="display:inline-block;padding:.6rem 2.2rem;
                  border:1px solid #8D6627;border-radius:4px;
                  font-size:.88rem;font-weight:600;color:#E8C96A;
                  text-decoration:none;background:transparent;letter-spacing:.08em;">
            ¡Descúbrelo ya!
        </a>
    </div>
</section>

{{-- DOMINIOS --}}
@php
$dominiosHome = [
    ['nombre'=>'Ingenierías','color'=>'#075E56','imagen'=>'imagenes/dominios/Ingenierias.webp',
     'carreras'=>'Logística · Mantenimiento Industrial · Ambiental y Sustentabilidad','casas'=>[
        ['imagen'=>'imagenes/casas/logistica.webp','nombre'=>'Logística','carrera'=>'Ingeniería en Logística','frase'=>'Toda ruta tiene un destino','valores'=>['Responsabilidad','Organización','Eficiencia'],'desc'=>'Te gusta planear, coordinar recursos y optimizar procesos.'],
        ['imagen'=>'imagenes/casas/mantenimiento.webp','nombre'=>'Mantenimiento Industrial','carrera'=>'Ing. Mantenimiento Industrial','frase'=>'La excelencia se construye cada día','valores'=>['Compromiso','Precisión','Responsabilidad'],'desc'=>'Diagnóstico y mantenimiento de maquinaria industrial.'],
        ['imagen'=>'imagenes/casas/ambiental.webp','nombre'=>'Ambiental y Sustentabilidad','carrera'=>'Ing. Ambiental y Sustentabilidad','frase'=>'Proteger hoy para transformar mañana','valores'=>['Ética','Compromiso','Responsabilidad Social'],'desc'=>'Desarrollo de soluciones ambientales sostenibles.'],
    ]],
    ['nombre'=>'Tecnologías de la Información','color'=>'#420FDB','imagen'=>'imagenes/dominios/Tecnologias_de_la_Informacion.webp',
     'carreras'=>'Entornos Virtuales · Ciencia de Datos · Desarrollo de Software · Redes Digitales','casas'=>[
        ['imagen'=>'imagenes/casas/entornos.webp','nombre'=>'Entornos Virtuales','carrera'=>'Entornos Virtuales y Negocios Digitales','frase'=>'Imaginar es crear','valores'=>['Creatividad','Innovación','Adaptación'],'desc'=>'Desarrollo de productos digitales interactivos.'],
        ['imagen'=>'imagenes/casas/datos.webp','nombre'=>'Ciencia de Datos','carrera'=>'Ciencia de Datos','frase'=>'Los datos cuentan historias','valores'=>['Objetividad','Precisión','Pensamiento Crítico'],'desc'=>'Interpretación y análisis de datos.'],
        ['imagen'=>'imagenes/casas/software.webp','nombre'=>'Desarrollo de Software','carrera'=>'Desarrollo de Software','frase'=>'Cada línea construye el futuro','valores'=>['Innovación','Perseverancia','Aprendizaje Continuo'],'desc'=>'Creación de aplicaciones y sistemas.'],
        ['imagen'=>'imagenes/casas/redes.webp','nombre'=>'Redes Digitales','carrera'=>'Infraestructura de Redes Digitales','frase'=>'Conectar es avanzar','valores'=>['Responsabilidad','Orden','Seguridad'],'desc'=>'Administración de redes y servidores.'],
    ]],
    ['nombre'=>'Ingeniería Industrial','color'=>'#CC7135','imagen'=>'imagenes/dominios/Ingenieria_Industrial.webp',
     'carreras'=>'Automotriz · Procesos Productivos · Moldeo de Plásticos · Calzado','casas'=>[
        ['imagen'=>'imagenes/casas/automotriz.webp','nombre'=>'Automotriz','carrera'=>'Ingeniería Automotriz','frase'=>'Movimiento con propósito','valores'=>['Eficiencia','Liderazgo','Compromiso'],'desc'=>'Mejora de procesos automotrices.'],
        ['imagen'=>'imagenes/casas/productivos.webp','nombre'=>'Procesos Productivos','carrera'=>'Ing. Procesos Productivos','frase'=>'La mejora nunca termina','valores'=>['Orden','Eficiencia','Mejora Continua'],'desc'=>'Gestión de operaciones industriales.'],
        ['imagen'=>'imagenes/casas/plasticos.webp','nombre'=>'Moldeo de Plásticos','carrera'=>'Ing. Moldeo de Plásticos','frase'=>'La forma sigue a la innovación','valores'=>['Precisión','Responsabilidad','Innovación'],'desc'=>'Diseño y fabricación de productos plásticos.'],
        ['imagen'=>'imagenes/casas/calzado.webp','nombre'=>'Calzado','carrera'=>'Gestión y Productividad de Calzado','frase'=>'Cada paso deja huella','valores'=>['Creatividad','Calidad','Trabajo en Equipo'],'desc'=>'Industria del calzado y manufactura.'],
    ]],
    ['nombre'=>'Mecatrónica','color'=>'#A81E1E','imagen'=>'imagenes/dominios/Mecatronica.webp',
     'carreras'=>'Manufactura Flexible · Optomecatrónica · Automatización','casas'=>[
        ['imagen'=>'imagenes/casas/manufactura.webp','nombre'=>'Manufactura Flexible','carrera'=>'Manufactura Flexible','frase'=>'Adaptarse es evolucionar','valores'=>['Innovación','Precisión','Creatividad'],'desc'=>'Sistemas automatizados de producción.'],
        ['imagen'=>'imagenes/casas/optomecatronica.webp','nombre'=>'Optomecatrónica','carrera'=>'Optomecatrónica','frase'=>'La precisión guía el camino','valores'=>['Precisión','Responsabilidad','Innovación'],'desc'=>'Sistemas ópticos y electrónicos.'],
        ['imagen'=>'imagenes/casas/automatizacion.webp','nombre'=>'Automatización','carrera'=>'Automatización','frase'=>'La eficiencia es inteligencia aplicada','valores'=>['Eficiencia','Compromiso','Innovación'],'desc'=>'Automatización de procesos industriales.'],
    ]],
    ['nombre'=>'Licenciaturas','color'=>'#9A7B10','imagen'=>'imagenes/dominios/Licenciaturas.webp',
     'carreras'=>'Gastronomía · Administración · Turismo · Negocios y Mercadotecnia','casas'=>[
        ['imagen'=>'imagenes/casas/gastronomia2.webp','nombre'=>'Gastronomía','carrera'=>'Gastronomía','frase'=>'Crear experiencias para recordar','valores'=>['Servicio','Creatividad','Disciplina'],'desc'=>'Experiencias culinarias y hospitalidad.'],
        ['imagen'=>'imagenes/casas/administracion.webp','nombre'=>'Administración','carrera'=>'Administración','frase'=>'Liderar para construir','valores'=>['Liderazgo','Responsabilidad','Ética'],'desc'=>'Gestión de empresas y recursos.'],
        ['imagen'=>'imagenes/casas/turismo.webp','nombre'=>'Turismo','carrera'=>'Turismo','frase'=>'Descubrir conecta culturas','valores'=>['Servicio','Empatía','Creatividad'],'desc'=>'Experiencias turísticas y culturales.'],
        ['imagen'=>'imagenes/casas/mercadotecnia.webp','nombre'=>'Negocios y Mercadotecnia','carrera'=>'Innovación de Negocios y Mercadotecnia','frase'=>'Las ideas iluminan el cambio','valores'=>['Innovación','Liderazgo','Comunicación'],'desc'=>'Marketing y desarrollo de negocios.'],
    ]],
];
$activoIdx = 0;
@endphp

<section id="dominios">

    <div class="section-divider" style="margin-bottom:.5rem;">
        <div class="section-divider-line" style="background:linear-gradient(to left,#8D6627,transparent);"></div>
        <h2 style="margin:0;font-size:1.4rem;font-weight:700;color:#FFFFFF;
                   font-family:'Headland One',serif;letter-spacing:.12em;
                   text-transform:uppercase;white-space:nowrap;">
            Dominios Académicos
        </h2>
        <div class="section-divider-line" style="background:linear-gradient(to right,#8D6627,transparent);"></div>
    </div>

    <p style="text-align:center;font-size:.72rem;color:#B0A898;max-width:400px;
              margin:0 auto 1.75rem;line-height:1.7;letter-spacing:.08em;text-transform:uppercase;">
        Explora los dominios académicos de la UTL.
    </p>

    {{-- Banner --}}
    <div id="dominio-banner"
         style="border:1px solid #2B1F3D;border-radius:8px;padding:1rem 1.25rem;
                display:flex;align-items:center;gap:1rem;margin-bottom:1.25rem;background:#14141F;">
        <div style="width:56px;height:56px;flex-shrink:0;border-radius:6px;overflow:hidden;
                    background:#0D0D1A;border:1px solid #2B1F3D;">
            <img id="banner-img" src="{{ asset($dominiosHome[$activoIdx]['imagen']) }}"
                 alt="{{ $dominiosHome[$activoIdx]['nombre'] }}"
                 style="width:100%;height:100%;object-fit:cover;display:block;">
        </div>
        <div style="min-width:0;">
            <p id="banner-nombre" style="font-size:.92rem;font-weight:700;color:#F0EAD8;
                  margin-bottom:.2rem;font-family:'Headland One',serif;">
                {{ $dominiosHome[$activoIdx]['nombre'] }}
            </p>
            <p id="banner-carreras" style="font-size:.78rem;color:#B0A898;margin:0;
               white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $dominiosHome[$activoIdx]['carreras'] }}
            </p>
        </div>
    </div>

    {{-- Carruseles --}}
    @foreach($dominiosHome as $di => $dom)
    @php $cols = count($dom['casas']) >= 4 ? '' : 'cols-3'; @endphp
    <div id="carousel-wrap-{{ $di }}" style="{{ $di !== $activoIdx ? 'display:none;' : '' }}">
        <div id="carousel-{{ $di }}" class="dom-track {{ $cols }}">
            @foreach($dom['casas'] as $casa)
            <div class="dom-card">
                <div style="width:100%;aspect-ratio:1;overflow:hidden;flex-shrink:0;background:#0D0D1A;">
                    <img src="{{ asset($casa['imagen']) }}" alt="{{ $casa['nombre'] }}" loading="lazy"
                         style="width:100%;height:100%;object-fit:contain;display:block;padding:8px;">
                </div>
                <div style="padding:.75rem;display:flex;flex-direction:column;gap:.35rem;flex:1;">
                    <p style="font-size:.8rem;font-weight:700;color:#F0EAD8;margin:0;
                               font-family:'Headland One',serif;">{{ $casa['nombre'] }}</p>
                    <p style="font-size:.72rem;color:#B0A898;margin:0;">{{ $casa['carrera'] }}</p>
                    <p style="font-size:.7rem;color:#C8A84B;font-style:italic;margin:0;">{{ $casa['frase'] }}</p>
                    <div style="display:flex;flex-wrap:wrap;gap:3px;margin-top:.15rem;">
                        @foreach($casa['valores'] as $v)
                        <span style="font-size:.62rem;padding:2px 6px;border:1px solid #2B1F3D;
                                     border-radius:20px;color:#707085;background:#0D0D1A;">{{ $v }}</span>
                        @endforeach
                    </div>
                    <p style="font-size:.66rem;color:#707085;line-height:1.5;margin:0;">{{ $casa['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <div class="dom-nav">
        <button class="dom-nav-btn" onclick="navDominio(-1)">‹</button>
        <span class="dom-nav-label" id="dom-nav-label">{{ $dominiosHome[$activoIdx]['nombre'] }}</span>
        <button class="dom-nav-btn" onclick="navDominio(1)">›</button>
    </div>

</section>

{{-- FOOTER --}}
<footer class="siia-footer">
    <div class="siia-footer-grid">
        <div style="max-width:400px;">
            <h3>Universidad Tecnológica de León</h3>
            <p>Blvd. Universidad Tecnológica #225 Col. San Carlos<br>
               C.P. 37670 León, Gto. México<br><br>
               comunicacionutl@utleon.edu.mx<br><br>
               (477) 7 10 00 20</p>
        </div>
        <div style="max-width:450px;">
            <h3>Desarrolladores del Proyecto</h3>
            <p><strong>Citlalli Méndez</strong><br>Documentadora y Administradora de Base de Datos<br>citlallialejandrams@gmail.com<br><br>
               <strong>Miryam Muñoz</strong><br>Diseñadora<br>miryammunoz26@gmail.com<br><br>
               <strong>Carlo Flores</strong><br>Programador<br>carlofernandoflores2006@gmail.com</p>
        </div>
    </div>
    <div class="siia-footer-copy">© {{ date('Y') }} NOVA · Navegador de Orientación Vocacional y Aptitudes</div>
</footer>

@endsection

@push('extra-js')
<script>
    const btn  = document.getElementById('hamburgerBtn');
    const menu = document.getElementById('mobileMenu');
    btn.addEventListener('click', () => {
        menu.classList.toggle('open');
        btn.setAttribute('aria-expanded', menu.classList.contains('open'));
    });
    document.addEventListener('click', e => {
        if (!btn.contains(e.target) && !menu.contains(e.target)) menu.classList.remove('open');
    });

    @php
    $dominiosDataJs = array_map(fn($d) => [
        'nombre'   => $d['nombre'],
        'imagen'   => asset($d['imagen']),
        'carreras' => $d['carreras'],
        'color'    => $d['color'],
    ], $dominiosHome);
    @endphp

    (function () {
        const data  = @json($dominiosDataJs);
        const total = data.length;
        let activo  = {{ $activoIdx }};

        function cambiar(idx) {
            document.getElementById('carousel-wrap-' + activo).style.display = 'none';
            activo = (idx + total) % total;
            const d = data[activo];
            document.getElementById('carousel-wrap-' + activo).style.display = '';
            document.getElementById('banner-img').src              = d.imagen;
            document.getElementById('banner-nombre').textContent   = d.nombre;
            document.getElementById('banner-carreras').textContent = d.carreras;
            document.getElementById('dom-nav-label').textContent   = d.nombre;
            const t = document.getElementById('carousel-' + activo);
            if (t) t.scrollLeft = 0;
        }
        window.navDominio = dir => cambiar(activo + dir);
    })();
</script>
@endpush