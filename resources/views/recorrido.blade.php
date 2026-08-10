@extends('layouts.app')
@section('title', 'Recorrido — NOVA')

@section('content')

{{-- ═══ ESTILOS GLOBALES ═══════════════════════════════════════════════════ --}}
<style>
    *, *::before, *::after { box-sizing: border-box; }

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


@include('partials.navbar')

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
                    <a href="https://drive.google.com/drive/folders/1GX-zAEzDj9HeKKNb-q-BflfZPN529lNR?usp=drive_link"
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

    {{-- ── Mapa I N T E R A C T I V O v1 hotspot w3 ── --}}
    <section id="mapa" class="panel">
        <div class="inner-pad">

            <h2 class="section-title"
                style="text-align:center;color:#FFFFFF;
                       font-family:'Headland One',serif;margin-bottom:2rem;">
                ─── MAPA DEL CAMPUS ────
            </h2>

            
            <style>
    .nova-map-outer {
        position: relative; 
    }
    .nova-map-stage {
        position: relative;
        width: 100%;
        line-height: 0;
        border-radius: 8px;
        overflow: hidden; /* esto solo recorta la imagen, ya no al tooltip */
        border: 2px solid #C6A050;
    }
    .nova-map-stage img {
        width: 100%;
        display: block;
    }
    .nova-map-hotspot {
        position: absolute;
        border: 1.5px solid transparent;
        border-radius: 3px;
        cursor: pointer;
        transition: background .15s ease, border-color .15s ease;
    }
    .nova-map-hotspot:hover {
        background: rgba(200,168,75,0.18);
        border-color: rgba(200,168,75,0.9);
        box-shadow: 0 0 14px rgba(200,168,75,0.35) inset;
    }
    .nova-map-tooltip {
        position: absolute;
        z-index: 999;
        max-width: 240px;
        background: linear-gradient(180deg,#1a1a2e,#0d0d1a);
        border: 1px solid #C6A050;
        border-radius: 6px;
        padding: 12px 14px;
        pointer-events: none;
        opacity: 0;
        transform: translateY(4px);
        transition: opacity .12s ease, transform .12s ease;
        box-shadow: 0 8px 24px rgba(0,0,0,0.5);
    }
    .nova-map-tooltip.show { opacity: 1; transform: translateY(0); }
    .nova-map-tooltip h4 {
        margin: 0 0 4px;
        font-family: 'Headland One', serif;
        font-size: .95rem;
        color: #E8C96A;
    }
    .nova-map-tooltip p {
        margin: 0;
        font-size: .85rem;
        line-height: 1.5;
        color: #B0A898;
    }

    /* Móvil: posición fija predecible, ya no se calcula con el toque */
    @media (max-width: 600px) {
        .nova-map-stage { border-radius: 6px; }
        .nova-map-tooltip {
            position: fixed !important;
            left: 1rem !important;
            right: 1rem !important;
            bottom: 1rem !important;
            top: auto !important;
            max-width: none;
            width: calc(100% - 2rem);
            z-index: 9999;
        }
    }.nova-map-tooltip {
    position: fixed;
    z-index: 9999;
    max-width: 280px;
    max-height: 70vh;
    overflow-y: auto;
    background: linear-gradient(180deg,#1a1a2e,#0d0d1a);
    border: 1px solid #C6A050;
    border-radius: 6px;
    padding: 12px 14px;
    pointer-events: none;
    opacity: 0;
    transform: translateY(4px);
    transition: opacity .12s ease, transform .12s ease;
    box-shadow: 0 8px 24px rgba(0,0,0,0.5);
}
.nova-map-tooltip.show { opacity: 1; transform: translateY(0); pointer-events: auto; }
.nova-map-tooltip-close {
    display: none;
    position: absolute;
    top: 6px;
    right: 8px;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    border: 1px solid #C6A050;
    background: rgba(198,160,80,0.12);
    color: #E8C96A;
    font-size: 1.1rem;
    line-height: 1;
    cursor: pointer;
    align-items: center;
    justify-content: center;
}
@media (max-width: 600px) {
    .nova-map-tooltip-close { display: flex; }
    .nova-map-tooltip { padding-top: 32px; }
}
.nova-map-tooltip.show { opacity: 1; transform: translateY(0); }
.nova-map-tooltip h4 {
    margin: 0 0 4px;
    font-family: 'Headland One', serif;
    font-size: .95rem;
    color: #E8C96A;
}
.nova-map-tooltip p {
    margin: 0;
    font-size: .85rem;
    line-height: 1.5;
    color: #B0A898;
    white-space: pre-line; /* respeta los \n del texto */
}

@media (max-width: 600px) {
    .nova-map-tooltip {
        left: 1rem !important;
        right: 1rem !important;
        bottom: 1rem !important;
        top: auto !important;
        max-width: none;
        width: calc(100% - 2rem);
    }
}
</style>
<div class="nova-map-outer" id="novaMapaOuter">
    <div class="nova-map-stage" id="novaMapaStage">
        <img src="{{ asset('imagenes/mapaCampusCentral.webp') }}" alt="Mapa del campus UTL">
    </div>
</div>
<div class="nova-map-tooltip" id="novaMapaTooltip">
    <button type="button" class="nova-map-tooltip-close" id="novaMapaTooltipClose" aria-label="Cerrar">&times;</button>
    <h4></h4>
    <p></p>
</div>
    </section>

</div>{{-- /page-content --}}

 @include('partials.footer')

</div>{{-- /page-wrap --}}

@push('extra-js')
<script>
    function toggleAccordion(btn) {
        const body = btn.nextElementSibling;
        const arrow = btn.querySelector('.accordion-arrow');
        const open = body.style.display === 'block';

        document.querySelectorAll('.accordion-body').forEach((elemento) => {
            elemento.style.display = 'none';
        });

        document.querySelectorAll('.accordion-arrow').forEach((elemento) => {
            elemento.style.transform = '';
        });

        if (!open) {
            body.style.display = 'block';
            arrow.style.transform = 'rotate(180deg)';
        }
    }
</script>
@endpush


@push('extra-js')
<script>
(function () {

  
var zonasMapa = [
    {
        top: 20.0, left: 63.5, width: 7.5, height: 6.6, title: "A Pesado",
        desc: "PA:\n- Laboratorio de Metrología\n- Oficina Sindical\n- Almacén\n- Laboratorio de Química\n- Laboratorio de Termodinámica\n- Laboratorio de Análisis Fisicoquímicos\n- Laboratorio de Análisis Espectrofotométricos\n- Baños\n- Laboratorio de Biotecnología"
    },
    {
        top: 30.9, left: 65.1, width: 8.2, height: 8.6, title: "Edificio A",
        desc: "PA:\n- Aulas A11-A20\n- Cubículos de profesorado de Tiempo completo de TSU\n- Sala de Juntas Académicas\n- Órgano Interno de Control\n- Sala de Asignatura\n\nPB:\n- Aulas A01-A10\n- Cubículos de profesorado de Tiempo completo de TSU\n- Auditorio A\n- Dirección de Área de Tecnologías Emergentes e Industriales"
    },
    {
        top: 68.2, left: 10.5, width: 7.1, height: 10.7, title: "Edificio F",
        desc: "PA:\n- Aulas F08-F14\n- Cubículos de Profesorado de Tiempo Completo de TSU\n- Sala de Juntas\n- Subdirección de Industrial Sustentable\n- Self Access Centre (SAC)\n- Cubículos de Profesorado de Tiempo Completo de Comunicación y Habilidades Digitales\n- Cubículos de Profesorado de Tiempo Completo de Francés\n\nPB:\n- Aulas F01-F07\n- Cubículos de Profesorado de Tiempo Completo de TSU\n- Auditorio F\n- Sala de Asignatura\n- Laboratorio de Operaciones Unitarias\n- Cubículos de profesorado de Tiempo Completo de Inglés\n- Coordinación de Investigación y Posgrado"
    },
    {
        top: 71.8, left: 19.0, width: 7.3, height: 12.1, title: "Edificio E",
        desc: "PA:\n- Gestoría de la Carrera de Infraestructura de Redes Digitales\n- Laboratorio de CCNA Práctica\n- Profesores de Tiempo Completo\n- Laboratorio de CCNA de Lectura\n- Laboratorio de Electrónica\n- Almacén del Área de Tecnologías de la Información e Innovación Digital\n- Laboratorio de CCNA de Práctica\n- Aula Virtual\n- Laboratorio de Seguridad\n- Laboratorio de Sistemas Operativos de Red\n\nPB:\n- Centros de Cómputo\n- Centro de Datos (SITE)\n- Dirección de Servicios Informáticos\n- Infraestructura y Mantenimiento Informático\n- Sistemas de información"
    },
    {
        top: 68.0, left: 28.1, width: 7.7, height: 12.5, title: "Edificio D",
        desc: "PA:\n- Aulas D09-D14\n- Laboratorio de Negocios Electrónicos\n- Laboratorio de Base de Datos\n- Laboratorio de Desarrollo Web\n- Laboratorio de Producción Audiovisual\n- Laboratorio de Animación 3D\n- Laboratorio de Multimedia\n- Laboratorio de Desarrollo Multiplataforma\n- Laboratorio de IOT\n- Laboratorio de Ingeniería de Software\n- Cubículo de Profesores de Tiempo Completo\n\nPB:\n- Aulas D01-D08-D15\n- Auditorio D\n- Subdirección de Tecnologías de la Información\n- Cubículo de profesorado de Tiempo Completo"
    },
    {
        top: 69.2, left: 36.8, width: 5.9, height: 14.1, title: "C Pesado",
        desc: "Acceso 1:\n- Baños\n\nAcceso 2:\n- Laboratorio de Óptica\n- Laboratorio de Electrónica Digital\n- Laboratorio de Electrónica Analógica\n\nAcceso 3:\n- Laboratorio de Automatización y Robótica\n- Laboratorio de Neumática e Hidráulica\n- Laboratorio de Instrumentación I\n- Laboratorio de Instrumentación II\n\nPasillo Exterior:\n- Aulas CP-01 al CP-06"
    },
    {
        top: 70.8, left: 44.5, width: 7.3, height: 10.3, title: "Edificio C",
        desc: "PA:\n- Aulas C11-C19\n- Aula de Matemáticas\n- Cubículos de profesorado de Tiempo completo ing.\n- Cubículos de profesorado de Tiempo completo de matemáticas\n- Sala de profesores\n- Sala de juntas\n\nPB:\n- Aulas C01-C10\n- Auditorio C\n- Salón de Espejos\n- Desarrollo Integral del Alumnado"
    },
    {
        top: 69.0, left: 54.1, width: 6.8, height: 10.1, title: "Edificio B",
        desc: "PA:\n- Aulas B11-B21\n- Dirección del Área Económico Administrativa\n- Cubículos de profesorado de Tiempo completo de LIC/TSU\n- Coordinación de Carrera y Academia LTU-LGCH VP-LNM VP\n- Sala de Juntas del Profesorado / Asesorías\n- Área de Asistente de Dirección\n- Sanitarios de docentes\n\nPB:\n- Aulas B01-B10\n- Sala de Usos Múltiples (SUM-B)\n- Cubículo de Profesorado de Tiempo Completo LIC/TSU\n- Coordinación de Carrera y Academia LTM-GAST-LDGR\n- Sala de Juntas del profesorado\n- Sala de Consulta del Profesorado\n- Recepción Asistente Académico\n- Baños alumnado"
    },
    {
        top: 67.6, left: 63.1, width: 7.2, height: 9.9, title: "B Pesado",
        desc: "- Laboratorio de Transporte\n- Laboratorio de Calzado\n- Laboratorio de Polímeros\n- Laboratorio de Electricidad\n- Laboratorio de Pruebas Mecánicas\n- Laboratorio de Métodos de Trabajo\n- Baños\n- Laboratorio de Alimentos y Bebidas"
    },
    {
        top: 22.7, left: 17.5, width: 6.5, height: 16.4, title: "Edificio CVD",
        desc: "PA:\n- Dirección de Desarrollo Académico y Docente\n- Psicopedagógico\n- Innovación y Tecnología Educativa\n- Investigación y Posgrados\n\nPB:\n- Salud Integral\n- Desempeño de Egresados y Bolsa de Trabajo\n- Prácticas, Estadías e Internacionalización\n- Servicios Escolares\n- Aula Pecera\n- Aula Magna\n- Lactario"
    },
    { top: 33.0, left: 27.4, width: 4.6, height: 10.0, title: "Cajeros BBVA", desc: "" },
    { top: 27.8, left: 33.8, width: 6.5, height: 14.1, title: "Cafetería", desc: "Laboratorio de Gastronomía" },
    {
        top: 34.0, left: 42.0, width: 7.2, height: 8.6, title: "Centro de Información",
        desc: "- Rectoría\n- Biblioteca\n- Videoteca"
    },
    {
        top: 18.0, left: 74.7, width: 19.5, height: 17.7, title: "Canchas de fútbol",
        desc: "- Fútbol\n- Fútbol Americano"
    },
    {
        top: 67.4, left: 81.4, width: 11.8, height: 17.2, title: "Cancha de básquetbol",
        desc: "- Voleibol\n- Baloncesto"
    },
    { top: 77.4, left: 73.9, width: 2.9, height: 9.4, title: "Planta de tratamiento", desc: "" },
    { top: 87.1, left: 37.9, width: 4.3, height: 6.2, title: "Casetas de alimentos", desc: "" },
    {
        top: 44.0, left: 2.1, width: 9.5, height: 16.4, title: "Olimpo",
        desc: "PA:\n- Sala de Rectores\n- Gimnasio de Emprendimiento e Innovación\n- Centro Incubador de Empresas -CIEM-\n- Sala Coworking / Design Thinking\n- Zona Emprende -explanada-\n\nPB:\n- Desarrollo Humano y Organizacional\n- Servicios Administrativos\n- Contabilidad y Presupuesto\n- Nómina\n- Servicios de Apoyo al Sector Productivo y Social\n- Promoción de Carreras\n- Caja\n- Secretaría de Vinculación\n- Extensión y Educación Continua"
    },
];

    var stage = document.getElementById('novaMapaStage');
    var outer = document.getElementById('novaMapaOuter');
    if (!stage || !outer) return;
    var tooltip = document.getElementById('novaMapaTooltip');

    function isMobile() {
        return window.matchMedia('(max-width: 600px)').matches;
    }

    function showTooltip(z) {
        tooltip.querySelector('h4').textContent = z.title;
        tooltip.querySelector('p').textContent = z.desc;
        tooltip.classList.add('show');
    }
function positionTooltip(e) {
    if (isMobile()) return; // en móvil la posición la fija el CSS

    var x = e.clientX + 16;
    var y = e.clientY + 16;
    var tw = 280, th = tooltip.offsetHeight || 90;

    if (x + tw > window.innerWidth)  x = e.clientX - tw - 16;
    if (y + th > window.innerHeight) y = window.innerHeight - th - 16;
    if (y < 8) y = 8;

    tooltip.style.left = x + 'px';
    tooltip.style.top  = y + 'px';
}

    zonasMapa.forEach(function (z) {
        var el = document.createElement('div');
        el.className = 'nova-map-hotspot';
        el.style.top = z.top + '%';
        el.style.left = z.left + '%';
        el.style.width = z.width + '%';
        el.style.height = z.height + '%';

        // Escritorio: hover
        el.addEventListener('mouseenter', function () {
            if (isMobile()) return;
            showTooltip(z);
        });
        el.addEventListener('mousemove', positionTooltip);
        el.addEventListener('mouseleave', function () {
            if (isMobile()) return;
            tooltip.classList.remove('show');
        });

        // Móvil: toque
        el.addEventListener('touchstart', function (e) {
            e.stopPropagation();
            showTooltip(z);
        }, { passive: true });

        stage.appendChild(el);
    });

var closeBtn = document.getElementById('novaMapaTooltipClose');
    if (closeBtn) {
        closeBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            tooltip.classList.remove('show');
        });
        closeBtn.addEventListener('touchstart', function (e) {
            e.stopPropagation();
            tooltip.classList.remove('show');
        }, { passive: true });
    }
})();
</script>
@endpush

@endsection