@extends('layouts.app')
@section('title', 'Inicio — NOVA')

@section('content')

@include('partials.navbar')

{{-- ═══ HERO ══════════════════════════════════════════════════════════════ --}}
<style>
    #hero-content { width:50%; padding:0 2rem; }
    #hero-desc    { font-size:1.03rem; max-width:480px; }
    #hero-btns a  { padding:.85rem 3rem; font-size:1rem; }

@media (max-width:768px) {
    #hero { height:100svh !important; }
    #hero-bg { background-position:center center !important; }
    #hero-overlay-left {
        background:linear-gradient(to bottom,
            rgba(6,6,15,0.55) 0%,rgba(6,6,15,0.30) 40%,
            rgba(6,6,15,0.70) 75%,rgba(6,6,15,1) 100%) !important;
    }
    #hero-content {
        width:100% !important;
        box-sizing:border-box !important;
        padding:0 1.5rem !important;
        justify-content:flex-end !important;
        align-items:center !important;
        padding-bottom:3.5rem !important;
        margin:0 !important;
    }
    #hero-title { margin:0 auto !important; }
    #hero-desc {
        font-size:.92rem !important;
        max-width:100% !important;
        text-align:center !important;
    }
    #hero-btns {
        flex-direction:column !important;
        align-items:stretch !important;
        width:100% !important;
        box-sizing:border-box !important;
        margin:0 !important;
    }
    #hero-btns a {
        box-sizing:border-box !important;
        width:100% !important;
        padding:.85rem 1.5rem !important;
        font-size:.9rem !important;
        text-align:center !important;
    }
}
</style>

<section id="hero" style="position:relative;height:calc(100vh - 50px);overflow:hidden;background:#06060F;">
    <div id="hero-bg"
         style="position:absolute;inset:0;
                background-image:url('{{ asset('imagenes/hero-leon.webp') }}');
                background-size:cover;background-position:right center;"></div>
    <div id="hero-overlay-left"
         style="position:absolute;inset:0;
                background:linear-gradient(to right,
                    rgba(15,10,3,0.95) 0%,rgba(12,8,2,0.90) 23%,
                    rgba(6,6,15,.7) 45%,rgba(6,6,15,.2) 65%,transparent 100%);"></div>
    <div style="position:absolute;bottom:0;left:0;right:0;height:35%;
                background:linear-gradient(to bottom,transparent 0%,rgba(6,6,15,.6) 50%,#06060F 100%);
                z-index:1;"></div>
    <div id="hero-content"
         style="position:relative;z-index:2;height:100%;
                display:flex;flex-direction:column;justify-content:center;
                align-items:center;gap:1.5rem;">
        <img src="{{ asset('imagenes/nova.webp') }}" alt="NOVA" id="hero-title"
             style="max-width:clamp(300px,40vw,600px);width:100%;display:block;">
        <p id="hero-desc"
           style="margin:0;letter-spacing:.10em;text-transform:uppercase;
                  line-height:2;color:#F0EAD8;text-align:center;">
            Forma parte de una casa que represente<br>
            tus habilidades, valores y visión profesional.
        </p>
        <div id="hero-btns" style="display:flex;gap:1.5rem;margin-top:.5rem;">
            <a href="{{ route('quiz') }}"
               style="display:inline-block;background:linear-gradient(135deg,#C6A050,#8D6627);
                      border:1px solid #C6A050;border-radius:3px;font-weight:700;
                      color:#1A1000;text-decoration:none;letter-spacing:.05em;">
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

{{-- ═══ IDENTIDAD ══════════════════════════════════════════════════════════ --}}
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
        #dominios h2 { white-space:normal !important; }
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
        ['nombre'=>'Sylvara (Ambiental)',    'imagen'=>'imagenes/casas/ambiental.webp'],
        ['nombre'=>'Flamoria (Gastronomía)', 'imagen'=>'imagenes/casas/gastronomia2.webp'],
        ['nombre'=>'Sendoria (Calzado)',     'imagen'=>'imagenes/casas/calzado.webp'],
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
           style="display:inline-block;padding:.55rem 2.2rem;border:1px solid #8D6627;
                  border-radius:4px;font-size:.88rem;font-weight:600;color:#E8C96A;
                  text-decoration:none;background:transparent;letter-spacing:.08em;">
            ¡Descúbrelo ya!
        </a>
    </div>
</section>

{{-- ═══ DOMINIOS ACADÉMICOS ════════════════════════════════════════════════ --}}
<style>
    #dominios { padding:3rem 4rem; }

    .dom-track {
        display:flex; gap:.85rem;
        overflow-x:auto; scroll-snap-type:x mandatory;
        -webkit-overflow-scrolling:touch;
        scrollbar-width:none; padding-bottom:4px;
    }
    .dom-track::-webkit-scrollbar { display:none; }

    .dom-card-5 { flex:0 0 calc(20% - .68rem); scroll-snap-align:start; min-width:170px; }
    .dom-card-4 { flex:0 0 calc(25% - .64rem); scroll-snap-align:start; min-width:180px; }
    .dom-card-3 { flex:0 0 calc(33.333% - .57rem); scroll-snap-align:start; min-width:200px; }

    .dom-card {
        border:1px solid #2B1F3D; border-radius:8px;
        background:#14141F; display:flex; flex-direction:column; overflow:hidden;
    }
    .dom-card-img {
        width:100%; aspect-ratio:1; overflow:hidden; flex-shrink:0;
        background:#0D0D1A; display:flex; align-items:center; justify-content:center;
    }
    .dom-card-img img {
        width:100%; height:100%; object-fit:contain; padding:10px; display:block;
    }

    .dom-nav { display:flex;justify-content:center;align-items:center;gap:1.5rem;margin-top:1.25rem; }
    .dom-nav-btn {
        width:40px;height:40px;border-radius:50%;
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
        .dom-card-5,.dom-card-4,.dom-card-3 { flex:0 0 calc(50% - .43rem) !important; min-width:0 !important; }
    }
    @media (max-width:480px) {
        .dom-card-5,.dom-card-4,.dom-card-3 { flex:0 0 82vw !important; }
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
            ['imagen'=>'imagenes/casas/logistica.webp',    'nombre'=>'NAVENTOR', 'carrera'=>'Logística',                   'frase'=>'Toda ruta tiene un destino',            'valores'=>['Responsabilidad','Organización','Eficiencia']],
            ['imagen'=>'imagenes/casas/mantenimiento.webp','nombre'=>'ENGRAVIA', 'carrera'=>'Mantenimiento Industrial',    'frase'=>'La excelencia se construye cada día',  'valores'=>['Compromiso','Precisión','Responsabilidad']],
            ['imagen'=>'imagenes/casas/ambiental.webp',   'nombre'=>'SYLVARA',  'carrera'=>'Ambiental y Sustentabilidad', 'frase'=>'Proteger hoy para transformar mañana', 'valores'=>['Ética','Compromiso','Responsabilidad Social']],
        ],
    ],
    [
        'nombre'  => 'Tecnologías de la Información',
        'color'   => '#420FDB',
        'imagen'  => 'imagenes/dominios/Tecnologias_de_la_Informacion.webp',
        'carreras'=> 'Entornos Virtuales · Ciencia de Datos · Desarrollo de Software · Redes Digitales · Inteligencia Artificial',
        'casas'   => [
            ['imagen'=>'imagenes/casas/entornos.webp', 'nombre'=>'NEXARIS',  'carrera'=>'Entornos Virtuales y Negocios Digitales', 'frase'=>'Imaginar es crear',              'valores'=>['Creatividad','Innovación','Adaptación']],
            ['imagen'=>'imagenes/casas/datos.webp',    'nombre'=>'DATHEON',  'carrera'=>'Ciencia de Datos',                       'frase'=>'Los datos cuentan historias',    'valores'=>['Objetividad','Precisión','Pensamiento Crítico']],
            ['imagen'=>'imagenes/casas/software.webp', 'nombre'=>'CODARIS',  'carrera'=>'Desarrollo de Software',                  'frase'=>'Cada línea construye el futuro', 'valores'=>['Innovación','Perseverancia','Aprendizaje Continuo']],
            ['imagen'=>'imagenes/casas/redes.webp',    'nombre'=>'HEXANET',  'carrera'=>'Infraestructura de Redes Digitales',      'frase'=>'Conectar es avanzar',            'valores'=>['Responsabilidad','Orden','Seguridad']],
            ['imagen'=>'imagenes/casas/ia.webp',       'nombre'=>'SYNTHERA', 'carrera'=>'Inteligencia Artificial',                 'frase'=>'Pensar más allá de los límites', 'valores'=>['Creatividad','Innovación','Pensamiento Crítico']],
        ],
    ],
    [
        'nombre'  => 'Ingeniería Industrial',
        'color'   => '#CC7135',
        'imagen'  => 'imagenes/dominios/Ingenieria_Industrial.webp',
        'carreras'=> 'Automotriz · Procesos Productivos · Moldeo de Plásticos · Calzado · Mantenimiento Industrial',
        'casas'   => [
            ['imagen'=>'imagenes/casas/automotriz.webp',  'nombre'=>'PISTORIA', 'carrera'=>'Automotriz',                         'frase'=>'Movimiento con propósito',           'valores'=>['Eficiencia','Liderazgo','Compromiso']],
            ['imagen'=>'imagenes/casas/productivos.webp', 'nombre'=>'OPERION',  'carrera'=>'Procesos Productivos',               'frase'=>'La mejora nunca termina',            'valores'=>['Orden','Eficiencia','Mejora Continua']],
            ['imagen'=>'imagenes/casas/plasticos.webp',   'nombre'=>'POLYMOR',  'carrera'=>'Moldeo de Plásticos',                'frase'=>'La forma sigue a la innovación',     'valores'=>['Precisión','Responsabilidad','Innovación']],
            ['imagen'=>'imagenes/casas/calzado.webp',     'nombre'=>'SENDORIA', 'carrera'=>'Gestión y Productividad de Calzado', 'frase'=>'Cada paso deja huella',              'valores'=>['Creatividad','Calidad','Trabajo en Equipo']],
            ['imagen'=>'imagenes/casas/mantenimiento.webp','nombre'=>'ENGRAVIA','carrera'=>'Mantenimiento Industrial',           'frase'=>'La excelencia se construye cada día','valores'=>['Compromiso','Precisión','Responsabilidad']],
        ],
    ],
    [
        'nombre'  => 'Mecatrónica',
        'color'   => '#A81E1E',
        'imagen'  => 'imagenes/dominios/mecatronicaBaseSinTextura.webp',
        'carreras'=> 'Manufactura Flexible · Optomecatrónica · Automatización',
        'casas'   => [
            ['imagen'=>'imagenes/casas/manufactura.webp',    'nombre'=>'FLEXION',  'carrera'=>'Manufactura Flexible', 'frase'=>'Adaptarse es evolucionar',               'valores'=>['Innovación','Precisión','Creatividad']],
            ['imagen'=>'imagenes/casas/optomecatronica.webp','nombre'=>'PRISMARA', 'carrera'=>'Optomecatrónica',     'frase'=>'La precisión guía el camino',            'valores'=>['Precisión','Responsabilidad','Innovación']],
            ['imagen'=>'imagenes/casas/automatizacion.webp', 'nombre'=>'AUTRON',   'carrera'=>'Automatización',      'frase'=>'La eficiencia es inteligencia aplicada', 'valores'=>['Eficiencia','Compromiso','Innovación']],
        ],
    ],
    [
        'nombre'  => 'Licenciaturas',
        'color'   => '#9A7B10',
        'imagen'  => 'imagenes/dominios/Licenciaturas.webp',
        'carreras'=> 'Gastronomía · Administración · Turismo · Negocios y Mercadotecnia',
        'casas'   => [
            ['imagen'=>'imagenes/casas/gastronomia2.webp',  'nombre'=>'FLAMORIA', 'carrera'=>'Gastronomía',                           'frase'=>'Crear experiencias para recordar', 'valores'=>['Servicio','Creatividad','Disciplina']],
            ['imagen'=>'imagenes/casas/administracion.webp','nombre'=>'LAUREON',  'carrera'=>'Administración',                        'frase'=>'Liderar para construir',           'valores'=>['Liderazgo','Responsabilidad','Ética']],
            ['imagen'=>'imagenes/casas/turismo.webp',       'nombre'=>'GLOBARIS', 'carrera'=>'Turismo',                               'frase'=>'Descubrir conecta culturas',       'valores'=>['Servicio','Empatía','Creatividad']],
            ['imagen'=>'imagenes/casas/mercadotecnia.webp', 'nombre'=>'NOVARIS',  'carrera'=>'Innovación de Negocios y Mercadotecnia','frase'=>'Las ideas iluminan el cambio',     'valores'=>['Innovación','Liderazgo','Comunicación']],
        ],
    ],
];
$activoIdx = 4;
@endphp

<section id="dominios" style="background:rgba(6,6,15,0.15);">

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
        Explora los dominios académicos de la Universidad Tecnológica de León.
    </p>

    {{-- Banner --}}
    <div id="dominio-banner"
         style="border:1px solid #2B1F3D;border-radius:8px;padding:1rem 1.25rem;
                display:flex;align-items:center;gap:1rem;margin-bottom:1.25rem;background:#14141F;">
        <div style="width:56px;height:56px;flex-shrink:0;border-radius:6px;overflow:hidden;
                    background:#0D0D1A;border:1px solid #2B1F3D;">
            <img id="banner-img" src="{{ asset($dominiosHome[$activoIdx]['imagen']) }}"
                 alt="" style="width:100%;height:100%;object-fit:cover;display:block;">
        </div>
        <div style="min-width:0;">
            <p id="banner-nombre"
               style="font-size:.92rem;font-weight:700;color:#F0EAD8;margin-bottom:.2rem;font-family:'Headland One',serif;">
                {{ $dominiosHome[$activoIdx]['nombre'] }}
            </p>
            <p id="banner-carreras"
               style="font-size:.76rem;color:#B0A898;margin:0;overflow:hidden;text-overflow:ellipsis;">
                {{ $dominiosHome[$activoIdx]['carreras'] }}
            </p>
        </div>
    </div>

    {{-- Un carrusel por dominio --}}
    @foreach($dominiosHome as $di => $dom)
    @php
        $n = count($dom['casas']);
        $cardClass = $n >= 5 ? 'dom-card-5' : ($n === 3 ? 'dom-card-3' : 'dom-card-4');
    @endphp
    <div id="carousel-wrap-{{ $di }}" style="{{ $di !== $activoIdx ? 'display:none;' : '' }}">
        <div id="carousel-{{ $di }}" class="dom-track">
            @foreach($dom['casas'] as $casa)
            <div class="dom-card {{ $cardClass }}">
                <div class="dom-card-img">
                    <img src="{{ asset($casa['imagen']) }}" alt="{{ $casa['nombre'] }}" loading="lazy">
                </div>
                <div style="padding:.75rem;display:flex;flex-direction:column;gap:.3rem;flex:1;">
                    <p style="font-size:.78rem;font-weight:700;color:#eedca7;margin:0;
                               font-family:'Headland One',serif;">{{ $casa['nombre'] }}</p>
                    <p style="font-size:.72rem;color:#B0A898;margin:0;">{{ $casa['carrera'] }}</p>
                    <p style="font-size:.68rem;color:#C8A84B;font-style:italic;margin:0;">{{ $casa['frase'] }}</p>
                    <div style="display:flex;flex-wrap:wrap;gap:3px;margin-top:.2rem;">
                        @foreach($casa['valores'] as $v)
                        <span style="font-size:.62rem;padding:2px 6px;border:1px solid #2B1F3D;
                                     border-radius:20px;color:#707085;background:#0D0D1A;">{{ $v }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    {{-- Navegación --}}
    <div class="dom-nav">
        <button class="dom-nav-btn" onclick="navDominio(-1)" aria-label="Dominio anterior">‹</button>
        <span class="dom-nav-label" id="dom-nav-label">{{ $dominiosHome[$activoIdx]['nombre'] }}</span>
        <button class="dom-nav-btn" onclick="navDominio(1)"  aria-label="Dominio siguiente">›</button>
    </div>

</section>

{{-- ═══ FOOTER ════════════════════════════════════════════════════════════ --}}
@include('partials.footer')

@endsection

@push('extra-js')
<script>
(function(){
    @php
    $dominiosDataJs = array_map(fn($d) => [
        'nombre'   => $d['nombre'],
        'imagen'   => asset($d['imagen']),
        'carreras' => $d['carreras'],
        'color'    => $d['color'],
    ], $dominiosHome);
    @endphp
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

{{-- Parallax hero --}}
const heroImg = document.getElementById('hero-bg');
window.addEventListener('scroll', () => {
    heroImg.style.transform = `scale(${1 + window.scrollY * 0.0003})`;
}, { passive:true });
</script>
@endpush