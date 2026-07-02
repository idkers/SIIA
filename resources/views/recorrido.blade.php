@extends('layouts.app')
@section('title', 'Recorrido — NOVA')

@section('content')

<style>
    *, *::before, *::after { box-sizing: border-box; }

    /* ══ LAYOUT ══ */
    .page-wrap    { display:flex;flex-direction:column;min-height:calc(100dvh - 72px); }
    .page-content { flex:1;padding:1.25rem 2rem; }

    /* ══ PANEL (borde dorado compartido) ══ */
    .panel {
        background: linear-gradient(rgba(6,6,15,.85),rgba(6,6,15,.95));
        border: 1px solid #8B6914;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    /* ══ HERO GRID ══ */
    .hero-grid { display:grid;grid-template-columns:1fr 1fr;align-items:center;min-height:480px; }
    .hero-text  { padding:3.5rem; }
    .hero-title { font-family:'Headland One',serif;color:#C8A84B;font-size:3.5rem;margin:.4rem 0; }
    .hero-desc  { color:#F0EAD8;line-height:1.8;max-width:460px; }

    /* VIDEO */
    .hero-video-wrap { padding:2rem;display:flex;justify-content:center;align-items:center; }
    .video-frame { width:100%;max-width:560px;aspect-ratio:16/9;
                   border:2px solid #C6A050;border-radius:10px;overflow:hidden;background:#14141F; }
    .video-frame iframe { width:100%;height:100%;display:block;border:none; }

    /* BOTÓN DESCARGA */
    .btn-download {
        display:inline-flex;align-items:center;gap:12px;
        background:#1a1a2e;border:1.5px solid #C6A050;border-radius:10px;
        padding:.9rem 1.75rem;text-decoration:none;color:#F0EAD8;
        transition:background .2s,border-color .2s;margin-top:1.5rem;
        max-width:340px;width:100%;
    }
    .btn-download:hover { background:#2a1f00;border-color:#E8C96A; }
    .btn-download-text  { display:flex;flex-direction:column;gap:2px; }
    .btn-download-sup   { font-size:.68rem;color:#C8A84B;letter-spacing:.1em;text-transform:uppercase;font-weight:500; }
    .btn-download-main  { font-size:1rem;font-weight:700;color:#F0EAD8; }
    .btn-download-sub   { font-size:.7rem;color:#B0A898; }

    /* INNER PADDING */
    .inner-pad { padding:2.5rem 3rem; }

    /* MAPA */
    .map-frame { height:460px;background:rgba(26,20,36,.6);border:2px solid #C6A050;
                 border-radius:8px;display:flex;justify-content:center;align-items:center;
                 color:#F0EAD8;font-size:.95rem; }

    /* ACORDEÓN */
    .accordion-item { border:1px solid #2B1F3D;border-radius:8px;overflow:hidden;background:rgba(13,13,26,.6); }
    .accordion-btn  { width:100%;display:flex;align-items:center;gap:1rem;
                      padding:1rem 1.25rem;background:none;border:none;cursor:pointer;text-align:left; }
    .accordion-num  { width:28px;height:28px;border-radius:50%;flex-shrink:0;
                      background:linear-gradient(135deg,#C6A050,#8D6627);
                      display:flex;align-items:center;justify-content:center;
                      font-size:.8rem;font-weight:700;color:#1A1000; }
    .accordion-body { display:none;padding:0 1.25rem 1.1rem 3.75rem; }
    .accordion-body p { font-size:.88rem;color:#B0A898;line-height:1.8;margin:0; }

    /* NAV BOTONES */
    .dom-nav { display:flex;justify-content:center;align-items:center;gap:1.5rem;margin-top:1.25rem; }
    .dom-nav-btn { width:38px;height:38px;border-radius:50%;border:1px solid #2B1F3D;
                   background:#14141F;color:#C8A84B;font-size:1.2rem;cursor:pointer;
                   display:flex;align-items:center;justify-content:center; }
    .dom-nav-btn:hover { border-color:#C8A84B;background:#1e1a0e; }
    .dom-nav-label { font-family:'Headland One',serif;font-size:.88rem;color:#F0EAD8;
                     letter-spacing:.06em;min-width:220px;text-align:center; }

    /* ══════════════════════════════
       TABLET ≤ 900px
       ══════════════════════════════ */
    @media (max-width: 900px) {
        .hero-grid  { grid-template-columns:1fr; min-height:auto; }
        .hero-text  { padding:2.5rem 2rem 1.25rem; }
        .hero-title { font-size:2.8rem; }
        .hero-desc  { max-width:100%; }
        .hero-video-wrap { padding:0 2rem 2rem; }
        .map-frame  { height:360px; }
    }

    /* ══════════════════════════════
       MÓVIL ≤ 600px
       ══════════════════════════════ */
    @media (max-width: 600px) {
        .page-content { padding:.75rem 1rem; }
        .hero-text  { padding:2rem 1.25rem 1rem; text-align:center; }
        .hero-title { font-size:2.2rem !important; }
        .hero-desc  { font-size:.88rem; }
        .hero-video-wrap { padding:0 1rem 1.5rem; }
        .btn-download { max-width:100%; }

        .inner-pad { padding:1.75rem 1.25rem; }
        .map-frame  { height:260px;font-size:.82rem; }

        /* Acordeón más compacto */
        .accordion-body { padding:0 1rem 1rem 1rem; }
        .accordion-btn  { padding:.85rem 1rem; gap:.75rem; }
        .accordion-num  { width:24px;height:24px;font-size:.72rem; }
    }
</style>

{{-- NAVBAR --}}
<nav class="siia-nav">
    <img src="{{ asset('imagenes/isotipo_dorado.webp') }}" alt="UTL" class="siia-nav-logo">
    <div class="nav-links">
        <a href="{{ route('welcome') }}">Inicio</a>
        <a href="{{ route('quiz') }}">Quiz</a>
        <a href="{{ route('recorrido') }}" class="active">Recorrido</a>
        <a href="{{ route('dominios') }}">Dominios</a>
        <a href="{{ route('casas') }}">Casas</a>
        <a href="{{ route('ingresar') }}">Ingresar</a>
    </div>
    <button class="hamburger" id="hamburgerBtn" aria-label="Abrir menú" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>
</nav>

<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('welcome') }}">Inicio</a>
    <a href="{{ route('quiz') }}">Quiz</a>
    <a href="{{ route('recorrido') }}" class="active">Recorrido</a>
    <a href="{{ route('dominios') }}">Dominios</a>
    <a href="{{ route('casas') }}">Casas</a>
    <a href="{{ route('ingresar') }}">Ingresar</a>
</div>

<div class="page-wrap">
<div class="page-content">

    {{-- HERO --}}
    <section class="panel">
        <div class="hero-grid">
            <div class="hero-text">
                <span style="color:#E8C96A;letter-spacing:4px;text-transform:uppercase;font-size:.78rem;">
                    Exploración UTL
                </span>
                <h1 class="hero-title">RECORRIDO<br>VIRTUAL</h1>
                <p class="hero-desc">
                    Descubre laboratorios, edificios académicos, áreas deportivas y espacios
                    emblemáticos de la UTL mediante una experiencia inmersiva con nuestro videojuego.
                </p>
                <a href="https://drive.google.com/drive/folders/1GX-zAEzDj9HeKKNb-q-BflfZPN529lNR?usp=drive_link"
                   target="_blank" rel="noopener" class="btn-download">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                         viewBox="0 0 24 24" fill="#00ADEF" aria-hidden="true" style="flex-shrink:0;">
                        <path d="M3 12V6.75l6-1.32v6.57H3zm17-9v8.75h-7V3.91L20 3zM3 13h6v6.57l-6-1.32V13zm17 .25V22l-7-1.23V13.25H20z"/>
                    </svg>
                    <div class="btn-download-text">
                        <span class="btn-download-sup">Disponible para Windows</span>
                        <span class="btn-download-main">Descargar juego</span>
                        <span class="btn-download-sub">Conoce tu Universidad · PC</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="#C8A84B" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" style="margin-left:auto;flex-shrink:0;" aria-hidden="true">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                </a>
            </div>
            <div class="hero-video-wrap">
                <div class="video-frame">
                    <iframe src="https://www.youtube.com/embed/AqpQu6D0Yyc?si=OTlRThrGbrbJjgJR"
                            title="Recorrido UTL"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>

    {{-- INSTRUCTIVO --}}
    <section class="panel">
        <div class="inner-pad">
            <div style="display:flex;align-items:center;gap:1.25rem;justify-content:center;margin-bottom:.5rem;">
                <div style="height:1px;flex:1;max-width:180px;background:linear-gradient(to left,#8D6627,transparent);"></div>
                <h2 style="margin:0;font-size:1.35rem;font-weight:700;color:#FFFFFF;
                           font-family:'Headland One',serif;letter-spacing:.09em;text-transform:uppercase;white-space:nowrap;">
                    ¿Cómo jugar?
                </h2>
                <div style="height:1px;flex:1;max-width:180px;background:linear-gradient(to right,#8D6627,transparent);"></div>
            </div>
            <p style="text-align:center;font-size:.78rem;color:#B0A898;margin:0 auto 1.75rem;letter-spacing:.06em;">
                Sigue estos pasos para instalar y ejecutar el recorrido virtual.
            </p>

            <div style="max-width:660px;margin:0 auto;display:flex;flex-direction:column;gap:.65rem;">

                {{-- Paso 1 --}}
                <div class="accordion-item">
                    <button class="accordion-btn" onclick="toggleAccordion(this)">
                        <span class="accordion-num">1</span>
                        <span style="font-size:.92rem;font-weight:600;color:#F0EAD8;flex:1;">Descarga el archivo ZIP</span>
                        <svg class="accordion-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="#C8A84B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             style="transition:transform .3s;flex-shrink:0;">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>
                    <div class="accordion-body">
                        <p>Haz clic en el botón <strong style="color:#E8C96A;">Descargar juego</strong> de arriba.
                        Se abrirá Google Drive donde deberás hacer clic en los tres puntos y en "Descargar" para comenzar
                        la descarga del archivo <code style="background:#1A1A2E;padding:2px 6px;border-radius:4px;
                        color:#C8A84B;font-size:.82rem;">Conoce_tu_Universidad.zip</code> a tu computadora.</p>
                    </div>
                </div>

                {{-- Paso 2 --}}
                <div class="accordion-item">
                    <button class="accordion-btn" onclick="toggleAccordion(this)">
                        <span class="accordion-num">2</span>
                        <span style="font-size:.92rem;font-weight:600;color:#F0EAD8;flex:1;">Extrae el contenido</span>
                        <svg class="accordion-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="#C8A84B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             style="transition:transform .3s;flex-shrink:0;">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>
                    <div class="accordion-body">
                        <p>Localiza el ZIP descargado, haz clic derecho y selecciona
                        <strong style="color:#E8C96A;">Extraer todo...</strong> Elige la carpeta donde quieres
                        guardarlo y confirma. Windows extraerá todos los archivos automáticamente.</p>
                    </div>
                </div>

                {{-- Paso 3 --}}
                <div class="accordion-item">
                    <button class="accordion-btn" onclick="toggleAccordion(this)">
                        <span class="accordion-num">3</span>
                        <span style="font-size:.92rem;font-weight:600;color:#F0EAD8;flex:1;">Ejecuta el juego</span>
                        <svg class="accordion-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="#C8A84B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             style="transition:transform .3s;flex-shrink:0;">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>
                    <div class="accordion-body">
                        <p>Abre la carpeta extraída y haz doble clic en
                        <code style="background:#1A1A2E;padding:2px 6px;border-radius:4px;color:#C8A84B;font-size:.82rem;">
                        Conoce tu Universidad.exe</code>. Si Windows muestra una advertencia de seguridad,
                        haz clic en <strong style="color:#E8C96A;">Ejecutar de todas formas</strong>.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- MAPA --}}
    <section class="panel" id="mapa">
        <div class="inner-pad">
            <h2 style="text-align:center;color:#FFFFFF;font-family:'Headland One',serif;margin-bottom:1.75rem;">
                ───── MAPA DEL CAMPUS ─────
            </h2>
            <div class="map-frame">[Mapa interactivo]</div>
        </div>
    </section>

</div>{{-- /page-content --}}

<footer class="siia-footer">
    <div class="siia-footer-grid">
        <div style="max-width:400px;">
            <h3>Universidad Tecnológica de León</h3>
            <p>Blvd. Universidad Tecnológica #225 Col. San Carlos<br>
               C.P. 37670 León, Gto. México<br><br>
               comunicacionutl@utleon.edu.mx<br><br>(477) 7 10 00 20</p>
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

</div>{{-- /page-wrap --}}

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

    function toggleAccordion(b) {
        const body  = b.nextElementSibling;
        const arrow = b.querySelector('.accordion-arrow');
        const open  = body.style.display === 'block';
        document.querySelectorAll('.accordion-body').forEach(x => x.style.display = 'none');
        document.querySelectorAll('.accordion-arrow').forEach(x => x.style.transform = '');
        if (!open) { body.style.display = 'block'; arrow.style.transform = 'rotate(180deg)'; }
    }
</script>
@endpush