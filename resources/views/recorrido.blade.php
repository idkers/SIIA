@extends('layouts.app')
@section('title', 'Recorrido — NOVA')

@section('content')

{{-- ═══ ESTILOS GLOBALES ═══════════════════════════════════════════════════ --}}
<style>
    *, *::before, *::after { box-sizing: border-box; }

    /* ── Navbar ── */
    .nav-links { display:flex; gap:2rem; }
    .nav-auth  { display:flex; align-items:center; gap:.75rem; }
    .hamburger { display:none; background:none; border:none; cursor:pointer;
                 padding:.25rem; flex-direction:column; gap:5px; }
    .hamburger span { display:block; width:24px; height:2px;
                      background:#C8A84B; border-radius:2px; }
    .mobile-menu { display:none; flex-direction:column;
                   background:rgba(6,6,15,0.97); padding:.5rem 0; }
    .mobile-menu a { display:block; padding:.85rem 2rem; font-size:.9rem;
                     color:#B0A898; text-decoration:none; letter-spacing:.08em;
                     text-transform:uppercase;
                     border-bottom:1px solid rgba(43,31,61,0.4); }
    .mobile-menu a:last-child { border-bottom:none; }
    .mobile-menu.open { display:flex; }

    /* ── Page layout ── */
.page-wrap { 
    display:flex; 
    flex-direction:column; 
    min-height: calc(100vh - 90px); 
}
    .page-content { flex:1; padding:1.5rem 2rem; }

    /* ── Panel compartido (hero, instructivo, mapa) ── */
    .panel {
        background: linear-gradient(rgba(6,6,15,.85), rgba(6,6,15,.95)),
                    url('/img/campus-bg.jpg');
        background-size: cover;
        background-position: center;
        border: 1px solid #8B6914;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    /* ── Hero grid ── */
    .hero-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 500px;
        align-items: center;
    }
    .hero-text       { padding: 4rem; }
    .hero-title      { font-size: 4rem; margin: .5rem 0; }
    .hero-desc       { max-width: 500px; }
    .hero-video-wrap { padding: 2rem; display:flex;
                       justify-content:center; align-items:center; }
    .video-frame {
        width: 100%; max-width: 600px; aspect-ratio: 16/9;
        border: 2px solid #C6A050; border-radius: 10px;
        overflow: hidden; background: #14141F;
    }
    .video-frame iframe { width:100%; height:100%; display:block; }

    /* ── Instructivo y Mapa (padding interno) ── */
    .inner-pad { padding: 3rem; }

    /* ── Mapa ── */
    .map-frame {
        height: 500px; background: rgba(26,20,36,0.6);
        border: 2px solid #C6A050; border-radius: 8px;
        display:flex; justify-content:center; align-items:center;
        color: #F0EAD8; font-size: 1rem;
    }

    /* ── Footer ── */
    #footer-casas {
        padding: 3rem 4rem; background: #06060F;
        border-top: 1px solid #2B1F3D;
    }
    #footer-casas-grid {
        display: flex; justify-content:space-around;
        flex-wrap: wrap; gap: 3rem;
    }

    /* ══════════════════════
       TABLET ≤ 900px
       ══════════════════════ */
    @media (max-width: 900px) {
        .hero-grid       { grid-template-columns: 1fr; }
        .hero-text       { padding: 3rem 2rem 1.5rem; }
        .hero-title      { font-size: 3rem; }
        .hero-desc       { max-width: 100%; }
        .hero-video-wrap { padding: 0 2rem 2.5rem; }
        .map-frame       { height: 400px; }
    }

    /* ══════════════════════
       MÓVIL ≤ 600px
       ══════════════════════ */
    @media (max-width: 600px) {
        .nav-links { display:none !important; }
        .nav-auth  { display:none !important; }
        .hamburger { display:flex !important; }

        .page-content    { padding: 1rem; }
        .hero-text       { padding: 2rem 1.25rem 1rem; text-align:center; }
        .hero-title      { font-size: 2.4rem; }
        .hero-desc       { font-size: .9rem; }
        .hero-actions    { justify-content:center !important; }
        .hero-actions a  { width:100%; text-align:center; }
        .hero-video-wrap { padding: 0 1.25rem 2rem; }
        .inner-pad       { padding: 1.75rem 1.25rem; }
        .map-frame       { height: 280px; font-size:.85rem; }
        .section-title   { font-size: 1.15rem !important; }

        #footer-casas      { padding: 2.5rem 1.25rem; }
        #footer-casas-grid { flex-direction:column; gap:2rem; }
        #footer-casas-grid > div { max-width:100% !important; }
        #footer-casas-grid h3    { font-size:1.1rem !important; }
    }
</style>

</div>{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
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
    <a href="{{ route('recorrido') }}" style="color:#E8C96A;">Recorrido</a>
    <a href="{{ route('dominios') }}">Dominios</a>
    <a href="{{ route('casas') }}">Casas</a>
    <a href="{{ route('ingresar') }}">Ingresar</a>
</div>

{{-- ═══ CONTENIDO ══════════════════════════════════════════════════════════ --}}
<div class="page-wrap">
<div class="page-content">

    {{-- ── Hero ── --}}
    <section class="panel">
        <div class="hero-grid">

            <div class="hero-text">
                <span style="color:#E8C96A;letter-spacing:4px;
                             text-transform:uppercase;font-size:.8rem;">
                    Exploración UTL
                </span>

                <h1 class="hero-title siia-title"
                    style="font-family:'Headland One',serif;color:#C8A84B;">
                    RECORRIDO<br>VIRTUAL
                </h1>

                <p class="hero-desc" style="color:#F0EAD8;line-height:1.8;">
                    ¡Descubre laboratorios, edificios académicos,
                    áreas deportivas y espacios emblemáticos de la
                    Universidad Tecnológica de León mediante una
                    experiencia inmersiva con nuestro nuevo videojuego!
                </p>

                <div class="hero-actions"
                     style="margin-top:2rem;display:flex;gap:1rem;">
                    <a href="https://drive.google.com/file/d/1phgZnZ-psX86cTQpZF3BC-VnwqMkG2at/view?usp=sharing"
                       target="_blank" rel="noopener"
                       style="display:inline-flex;align-items:center;gap:14px;
                              background:#1a1a2e;border:1.5px solid #C6A050;
                              border-radius:12px;padding:1rem 2rem;
                              text-decoration:none;color:#F0EAD8;
                              max-width:340px;width:100%;
                              transition:background .2s,border-color .2s;"
                       onmouseover="this.style.background='#2a1f00';this.style.borderColor='#E8C96A'"
                       onmouseout="this.style.background='#1a1a2e';this.style.borderColor='#C6A050'">

                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                             viewBox="0 0 24 24" fill="#00ADEF" aria-hidden="true">
                            <path d="M3 12V6.75l6-1.32v6.57H3zm17-9v8.75h-7V3.91L20 3zM3 13h6v6.57l-6-1.32V13zm17 .25V22l-7-1.23V13.25H20z"/>
                        </svg>

                        <div style="display:flex;flex-direction:column;gap:2px;">
                            <span style="font-size:.7rem;color:#C8A84B;letter-spacing:.1em;
                                         text-transform:uppercase;font-weight:500;">
                                Disponible para Windows
                            </span>
                            <span style="font-size:1.1rem;font-weight:700;color:#F0EAD8;">
                                Descargar juego
                            </span>
                            <span style="font-size:.72rem;color:#B0A898;">
                                Conoce tu Universidad &nbsp;·&nbsp; PC
                            </span>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             viewBox="0 0 24 24" fill="none" stroke="#C8A84B"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true" style="margin-left:auto;flex-shrink:0;">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="hero-video-wrap">
                <div class="video-frame">
                    <iframe
                        src="https://www.youtube.com/embed/bIaBevHGpCk?si=HtfQYVHtMvma9u2B"
                        title="Recorrido UTL" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write;
                               encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>

        </div>
    </section>

    {{-- ── Instructivo ── --}}
    <section class="panel">
        <div class="inner-pad">

            <div style="display:flex;align-items:center;gap:1.5rem;
                        justify-content:center;margin-bottom:.5rem;">
                <div style="height:1px;flex:1;max-width:200px;
                            background:linear-gradient(to left,#8D6627,transparent);"></div>
                <h2 class="section-title"
                    style="margin:0;font-size:1.5rem;font-weight:700;color:#FFFFFF;
                           font-family:'Headland One',serif;letter-spacing:.10em;
                           text-transform:uppercase;white-space:nowrap;">
                    ¿Cómo jugar?
                </h2>
                <div style="height:1px;flex:1;max-width:200px;
                            background:linear-gradient(to right,#8D6627,transparent);"></div>
            </div>

            <p style="text-align:center;font-size:.8rem;color:#B0A898;
                      margin:0 auto 2rem;letter-spacing:.06em;">
                Sigue estos pasos para instalar y ejecutar el recorrido virtual.
            </p>

            <div style="max-width:680px;margin:0 auto;
                        display:flex;flex-direction:column;gap:.75rem;">

                {{-- Paso 1 --}}
                <div class="accordion-item"
                     style="border:1px solid #2B1F3D;border-radius:8px;
                            overflow:hidden;background:rgba(13,13,26,0.6);">
                    <button onclick="toggleAccordion(this)"
                            style="width:100%;display:flex;align-items:center;gap:1rem;
                                   padding:1rem 1.25rem;background:none;border:none;
                                   cursor:pointer;text-align:left;">
                        <span style="width:28px;height:28px;border-radius:50%;flex-shrink:0;
                                     background:linear-gradient(135deg,#C6A050,#8D6627);
                                     display:flex;align-items:center;justify-content:center;
                                     font-size:.8rem;font-weight:700;color:#1A1000;">1</span>
                        <span style="font-size:.95rem;font-weight:600;color:#F0EAD8;flex:1;">
                            Descarga el archivo ZIP
                        </span>
                        <svg class="accordion-arrow" xmlns="http://www.w3.org/2000/svg"
                             width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="#C8A84B" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round"
                             style="transition:transform .3s;flex-shrink:0;">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>
                    <div class="accordion-body"
                         style="display:none;padding:0 1.25rem 1.1rem 3.75rem;">
                        <p style="font-size:.88rem;color:#B0A898;line-height:1.8;margin:0;">
                            Haz clic en el botón <strong style="color:#E8C96A;">Descargar juego</strong>
                            de arriba. Se abrirá Google Drive donde deberás hacer clic en los
                            tres puntos y en "Descargar" para comenzar la descarga del archivo
                            <code style="background:#1A1A2E;padding:2px 6px;border-radius:4px;
                                         color:#C8A84B;font-size:.82rem;">Conoce_tu_Universidad.zip</code>
                            a tu computadora.
                        </p>
                    </div>
                </div>

                {{-- Paso 2 --}}
                <div class="accordion-item"
                     style="border:1px solid #2B1F3D;border-radius:8px;
                            overflow:hidden;background:rgba(13,13,26,0.6);">
                    <button onclick="toggleAccordion(this)"
                            style="width:100%;display:flex;align-items:center;gap:1rem;
                                   padding:1rem 1.25rem;background:none;border:none;
                                   cursor:pointer;text-align:left;">
                        <span style="width:28px;height:28px;border-radius:50%;flex-shrink:0;
                                     background:linear-gradient(135deg,#C6A050,#8D6627);
                                     display:flex;align-items:center;justify-content:center;
                                     font-size:.8rem;font-weight:700;color:#1A1000;">2</span>
                        <span style="font-size:.95rem;font-weight:600;color:#F0EAD8;flex:1;">
                            Extrae el contenido
                        </span>
                        <svg class="accordion-arrow" xmlns="http://www.w3.org/2000/svg"
                             width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="#C8A84B" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round"
                             style="transition:transform .3s;flex-shrink:0;">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>
                    <div class="accordion-body"
                         style="display:none;padding:0 1.25rem 1.1rem 3.75rem;">
                        <p style="font-size:.88rem;color:#B0A898;line-height:1.8;margin:0;">
                            Localiza el ZIP descargado, haz clic derecho sobre él y selecciona
                            <strong style="color:#E8C96A;">Extraer todo...</strong>
                            Elige la carpeta donde quieres guardarlo y confirma. Windows extraerá
                            todos los archivos automáticamente.
                        </p>
                    </div>
                </div>

                {{-- Paso 3 --}}
                <div class="accordion-item"
                     style="border:1px solid #2B1F3D;border-radius:8px;
                            overflow:hidden;background:rgba(13,13,26,0.6);">
                    <button onclick="toggleAccordion(this)"
                            style="width:100%;display:flex;align-items:center;gap:1rem;
                                   padding:1rem 1.25rem;background:none;border:none;
                                   cursor:pointer;text-align:left;">
                        <span style="width:28px;height:28px;border-radius:50%;flex-shrink:0;
                                     background:linear-gradient(135deg,#C6A050,#8D6627);
                                     display:flex;align-items:center;justify-content:center;
                                     font-size:.8rem;font-weight:700;color:#1A1000;">3</span>
                        <span style="font-size:.95rem;font-weight:600;color:#F0EAD8;flex:1;">
                            Ejecuta el juego
                        </span>
                        <svg class="accordion-arrow" xmlns="http://www.w3.org/2000/svg"
                             width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="#C8A84B" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round"
                             style="transition:transform .3s;flex-shrink:0;">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>
                    <div class="accordion-body"
                         style="display:none;padding:0 1.25rem 1.1rem 3.75rem;">
                        <p style="font-size:.88rem;color:#B0A898;line-height:1.8;margin:0;">
                            Abre la carpeta extraída y haz doble clic en
                            <code style="background:#1A1A2E;padding:2px 6px;border-radius:4px;
                                         color:#C8A84B;font-size:.82rem;">Conoce tu Universidad.exe</code>
                            El juego abrirá directamente, sin necesidad de instalación.
                            Si Windows muestra una advertencia de seguridad, haz clic en
                            <strong style="color:#E8C96A;">Ejecutar de todas formas</strong>.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ── Mapa ── --}}
    <section id="mapa" class="panel">
        <div class="inner-pad">
            <h2 class="section-title"
                style="text-align:center;color:#FFFFFF;
                       font-family:'Headland One',serif;margin-bottom:2rem;">
                ───── MAPA DEL CAMPUS ─────
            </h2>
            <div class="map-frame">
                [Mapa interactivo]
            </div>
        </div>
    </section>

</div>{{-- /page-content --}}

{{-- ═══ FOOTER ════════════════════════════════════════════════════════════ --}}
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

</div>{{-- /page-wrap --}}

@push('extra-js')
<script>
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

    function toggleAccordion(btn) {
        const body = btn.nextElementSibling;
        const arrow = btn.querySelector('.accordion-arrow');
        const open  = body.style.display === 'block';
        document.querySelectorAll('.accordion-body').forEach(b => b.style.display = 'none');
        document.querySelectorAll('.accordion-arrow').forEach(a => a.style.transform = '');
        if (!open) {
            body.style.display = 'block';
            arrow.style.transform = 'rotate(180deg)';
        }
    }
</script>
@endpush

@endsection