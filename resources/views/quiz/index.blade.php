@extends('layouts.app')
@section('title', 'Quiz — NOVA')

@section('content')

<style>
    html, body { height:100%; margin:0; }
    body { display:flex; flex-direction:column; min-height:100vh; }
    .page-content-wrapper { flex:1 0 auto; display:flex; flex-direction:column; }

    /* ── Navbar ── */
    .nav-links { flex:1; display:flex; justify-content:center; gap:3rem; }
    .nav-links a { color:#B0A898; text-decoration:none; font-size:.88rem;
                   letter-spacing:.08em; text-transform:uppercase; transition:.25s; }
    .nav-links a:hover { color:#E8C96A; }
    .nav-auth  { display:flex; align-items:center; }
    .hamburger { display:none; background:none; border:none; cursor:pointer;
                 padding:.25rem; flex-direction:column; gap:5px; }
    .hamburger span { display:block; width:22px; height:2px; background:#C8A84B; border-radius:2px; }
    .mobile-menu { display:none; flex-direction:column; background:rgba(6,6,15,.97); padding:.5rem 0; }
    .mobile-menu a { display:block; padding:.75rem 2rem; font-size:.85rem; color:#B0A898;
                     text-decoration:none; letter-spacing:.08em; text-transform:uppercase;
                     border-bottom:1px solid rgba(43,31,61,.4); }
    .mobile-menu a:last-child { border-bottom:none; }
    .mobile-menu.open { display:flex; }
    @media (max-width:768px) {
        .nav-links { display:none !important; }
        .nav-auth  { display:none !important; }
        .hamburger { display:flex !important; }
    }

    /* ── Stage wrap ── */
    .stage-wrap { padding:2rem; flex:1; display:flex; flex-direction:column;
                  overflow-x:hidden; box-sizing:border-box; width:100%; }
    @media (max-width:768px) { .stage-wrap { padding:.75rem !important; } }
    .stage { flex:1; display:flex; flex-direction:column; }
    .stage-wrap > section { flex:1; }

    /* ── Etapa 1 ── */
    #stage-1-inner { display:grid; grid-template-columns:1fr 1fr;
                     align-items:center; min-height:550px; padding:4rem; gap:2rem; }
    #stage-1-title { font-size:4rem; }
    #stage-1-inner.mobile-layout { grid-template-columns:1fr !important; padding:2rem 1rem !important;
        min-height:auto !important; text-align:center !important; overflow:hidden !important; }
    #stage-1-inner.mobile-layout #stage-1-title { font-size:clamp(1.6rem,8vw,2.4rem) !important; }
    #stage-1-inner.mobile-layout #stage-1-img-wrap { order:-1; display:flex !important;
        justify-content:center !important; }
    #stage-1-inner.mobile-layout #stage-1-img { width:60vw !important; max-width:60vw !important; }
    #stage-1-inner.mobile-layout #stage-1-btn { width:100% !important; }

    /* ── Quiz (Etapa 2) ── */
    .quiz-card {
        border:1px solid #8B6914; border-radius:12px;
        background:linear-gradient(rgba(6,6,15,.82),rgba(6,6,15,.95)),
                   url('{{ asset("imagenes/fondoquiz.webp") }}');
        background-size:cover; background-position:center;
        padding:2.5rem 3rem; display:flex; flex-direction:column; gap:1.75rem;
        flex:1;
    }

    .quiz-progress-wrap { display:flex; flex-direction:column; gap:.5rem; }
    .quiz-progress-label { display:flex; justify-content:space-between;
                           font-size:.72rem; color:#B0A898; letter-spacing:.06em; }
    .quiz-progress-track { height:5px; background:rgba(43,31,61,.8); border-radius:3px; overflow:hidden; }
    .quiz-progress-fill  { height:100%; background:linear-gradient(to right,#8D6627,#C8A84B);
                           border-radius:3px; transition:width .4s ease; }

    .quiz-fase-badge {
        display:inline-block; font-size:.65rem; text-transform:uppercase;
        letter-spacing:.14em; color:#C8A84B; border:1px solid rgba(200,168,75,.3);
        border-radius:20px; padding:.2rem .75rem; width:fit-content;
    }

    .quiz-pregunta {
        font-family:'Headland One',serif; font-size:1.4rem; color:#F0EAD8;
        line-height:1.5; max-width:680px;
    }

    .quiz-opciones { display:flex; flex-direction:column; gap:.65rem; }

    .quiz-opcion {
        display:flex; align-items:center; gap:1rem;
        padding:.9rem 1.25rem;
        background:rgba(13,13,26,.6); border:1px solid rgba(43,31,61,.7);
        border-radius:8px; cursor:pointer; transition:border-color .2s, background .2s;
        user-select:none;
    }
    .quiz-opcion:hover { border-color:#8D6627; background:rgba(141,102,39,.08); }
    .quiz-opcion.seleccionada { border-color:#C8A84B; background:rgba(200,168,75,.12); }

    .opcion-bullet {
        width:20px; height:20px; border-radius:50%; border:2px solid #4A3560;
        flex-shrink:0; display:flex; align-items:center; justify-content:center;
        transition:border-color .2s, background .2s;
    }
    .quiz-opcion.seleccionada .opcion-bullet { border-color:#C8A84B; background:#C8A84B; }
    .opcion-bullet-dot { width:8px; height:8px; border-radius:50%; background:#1A1000;
                         opacity:0; transition:opacity .15s; }
    .quiz-opcion.seleccionada .opcion-bullet-dot { opacity:1; }

    .opcion-val  { font-size:.7rem; color:#4A3560; min-width:1.2rem; }
    .opcion-text { font-size:.9rem; color:#F0EAD8; }
    .quiz-opcion.seleccionada .opcion-val { color:#C8A84B; }

    .quiz-nav { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; }

    .btn-quiz {
        padding:.75rem 2rem; border-radius:6px; font-size:.9rem;
        font-weight:700; cursor:pointer; font-family:inherit; letter-spacing:.04em;
        border:none; transition:opacity .2s;
    }
    .btn-quiz-primary { background:linear-gradient(135deg,#C6A050,#8D6627); color:#1A1000; }
    .btn-quiz-primary:hover { opacity:.88; }
    .btn-quiz-primary:disabled { opacity:.35; cursor:not-allowed; }
    .btn-quiz-ghost { background:transparent; border:1px solid #2B1F3D; color:#B0A898; }
    .btn-quiz-ghost:hover { border-color:#C8A84B; color:#E8C96A; }

    /* ── Procesando (Etapa 3) ── */
    #stage-3-inner { width:740px; max-width:90%; padding:2.5rem 2rem; margin:0 auto;
        background:linear-gradient(180deg,rgba(6,6,15,.55),rgba(0,0,0,.65));
        backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px); }
    @media (max-width:768px) {
        #stage-3-inner { width:100% !important; padding:2rem 1rem !important; }
        #stage-3-title { font-size:2rem !important; }
        #stage-3-video { width:100% !important; }
        #stage-3-btn   { width:100% !important; }
    }

    /* ── Resultado (Etapa 4) ── */
    #stage-4-inner { display:grid; grid-template-columns:1fr 1fr;
                     align-items:center; min-height:550px; padding:4rem; gap:2rem; }
    #stage-4-result-title { font-size:3.5rem; }
    #stage-4-btns  { display:flex; gap:1rem; margin-top:2rem; flex-wrap:wrap; }
    @media (max-width:768px) {
        #stage-4-inner { grid-template-columns:1fr !important; padding:2rem 1rem !important;
                         min-height:auto !important; }
        #stage-4-img-wrap { display:flex; justify-content:center; order:-1; }
        #stage-4-img  { max-width:min(80vw,320px) !important; }
        #stage-4-result-title { font-size:clamp(1.6rem,7vw,2.2rem) !important; }
        #stage-4-btns { flex-direction:column; }
        #stage-4-btns a, #stage-4-btns button { width:100% !important; text-align:center !important; }
    }

    /* ── Privacidad ── */
    #privacy-overlay { position:fixed; inset:0; background:rgba(0,0,0,.78); z-index:200;
                       display:flex; align-items:center; justify-content:center; padding:1.25rem; }
    #privacy-box { background:#14141F; border:1px solid rgba(200,168,75,.35); border-radius:16px;
                   padding:2.5rem 2rem; max-width:480px; width:100%;
                   box-shadow:0 0 40px rgba(200,168,75,.10); display:flex; flex-direction:column; gap:1.25rem; }
    #privacy-box h2 { font-family:'Headland One',serif; color:#C8A84B; font-size:1.4rem; margin:0; }
    #privacy-box > p { color:#B0A898; font-size:.88rem; line-height:1.75; margin:0; }
    .privacy-notice { background:rgba(200,168,75,.07); border:1px solid rgba(200,168,75,.2);
                      border-radius:8px; padding:.85rem 1rem; color:#F0EAD8; font-size:.82rem; line-height:1.7; }
    .privacy-check-wrap { display:flex; align-items:flex-start; gap:.85rem; cursor:pointer; user-select:none; }
    .privacy-check-wrap input { display:none; }
    .privacy-circle { width:22px; height:22px; border-radius:50%; border:2px solid #8D6627;
                      flex-shrink:0; margin-top:1px; display:flex; align-items:center;
                      justify-content:center; transition:background .2s,border-color .2s; }
    .privacy-circle svg { opacity:0; transition:opacity .2s; }
    .privacy-check-wrap input:checked ~ .privacy-circle { background:#C6A050; border-color:#C6A050; }
    .privacy-check-wrap input:checked ~ .privacy-circle svg { opacity:1; }
    .privacy-check-label { font-size:.85rem; color:#B0A898; line-height:1.6; }
    .privacy-check-label a { color:#E8C96A; text-decoration:underline; cursor:pointer; }
    #privacy-continue { width:100%; padding:.85rem; background:linear-gradient(135deg,#C6A050,#8D6627);
                        border:none; border-radius:6px; color:#1A1000; font-size:1rem; font-weight:700;
                        cursor:pointer; opacity:.4; pointer-events:none; transition:opacity .2s; font-family:inherit; }
    #privacy-continue.activo { opacity:1; pointer-events:auto; }
    #policy-modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,.82); z-index:300;
                    align-items:center; justify-content:center; padding:1.25rem; }
    #policy-modal.abierto { display:flex; }
    #policy-box { background:#14141F; border:1px solid rgba(200,168,75,.3); border-radius:16px;
                  max-width:640px; width:100%; max-height:88vh; overflow-y:auto; position:relative; }
    .policy-header { padding:1.5rem 2rem 1rem; border-bottom:1px solid rgba(200,168,75,.15);
                     position:sticky; top:0; background:#14141F; z-index:1;
                     display:flex; align-items:center; justify-content:space-between; }
    .policy-header h3 { font-family:'Headland One',serif; color:#C8A84B; font-size:1.1rem; margin:0; }
    .policy-close { background:none; border:none; color:#707085; font-size:1.4rem; cursor:pointer; }
    .policy-close:hover { color:#E8C96A; }
    .policy-body { padding:1.5rem 2rem 2rem; color:#B0A898; font-size:.86rem; line-height:1.9; }
    .policy-body h4 { color:#E8C96A; font-size:.78rem; text-transform:uppercase; letter-spacing:.12em;
                      margin:1.5rem 0 .5rem; border-bottom:1px solid rgba(200,168,75,.15); padding-bottom:.35rem; }
    .policy-body p  { margin:0 0 .75rem; }
    .policy-body strong { color:#F0EAD8; }
    .policy-body ul { margin:0 0 .75rem 1.25rem; padding:0; }
    .policy-body ul li { margin-bottom:.4rem; }
    .policy-body a  { color:#E8C96A; }

    /* ── Footer ── */
    #footer-casas { padding:3rem 4rem; background:#06060F; border-top:1px solid #2B1F3D; }
    #footer-casas-grid { display:flex; justify-content:space-around; flex-wrap:wrap; gap:3rem; }
    @media (max-width:600px) {
        #footer-casas { padding:2.5rem 1.25rem; }
        #footer-casas-grid { flex-direction:column; gap:2rem; }
        #footer-casas-grid > div { max-width:100% !important; }
        .quiz-card { padding:1.5rem 1rem !important; }
        .quiz-pregunta { font-size:1.1rem !important; }
    }
</style>

{{-- NAVBAR --}}
<nav style="display:flex;align-items:center;padding:1.6rem 2rem;background:rgba(6,6,15,.6);
            backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);
            position:sticky;top:0;z-index:100;">
    <img src="{{ asset('imagenes/isotipo_dorado.webp') }}" alt="UTL" style="height:2.6rem;">
    <div class="nav-links">
        <a href="{{ route('welcome') }}">Inicio</a>
        <a href="{{ route('quiz') }}">Quiz</a>
        <a href="{{ route('recorrido') }}">Recorrido</a>
        <a href="{{ route('dominios') }}">Dominios</a>
        <a href="{{ route('casas') }}">Casas</a>
        <a href="{{ route('ingresar') }}">Ingresar</a>
    </div>
    <button class="hamburger" id="hamburgerBtn" aria-label="Abrir menú">
        <span></span><span></span><span></span>
    </button>
</nav>

<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('welcome') }}">Inicio</a>
    <a href="{{ route('quiz') }}" style="color:#E8C96A;">Quiz</a>
    <a href="{{ route('recorrido') }}">Recorrido</a>
    <a href="{{ route('dominios') }}">Dominios</a>
    <a href="{{ route('casas') }}">Casas</a>
    <a href="{{ route('ingresar') }}">Ingresar</a>
</div>

{{-- AVISO DE PRIVACIDAD --}}
<div id="privacy-overlay" style="display:none;">
    <div id="privacy-box">
        <h2>Antes de continuar</h2>
        <p>Para ofrecerte la mejor orientación vocacional, necesitamos que leas y aceptes el Aviso de Privacidad Integral de la UTL.</p>
        <div class="privacy-notice">
            ⚠️ <strong style="color:#E8C96A;">Nota importante:</strong>
            La UTL <strong>no cuenta con áreas de ciencias de la salud</strong> (medicina, enfermería, biología, etc.).
            Los resultados están orientados exclusivamente a las carreras que ofrece la UTL.
        </div>
        <label class="privacy-check-wrap" for="privacy-cb">
            <input type="checkbox" id="privacy-cb" onchange="toggleContinue(this)">
            <span class="privacy-circle">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <path d="M2 6L5 9L10 3" stroke="#1A1000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <span class="privacy-check-label">
                He leído y acepto el <a onclick="abrirPolitica(event)">Aviso de Privacidad Integral</a> de la UTL.
            </span>
        </label>
        <button id="privacy-continue" onclick="aceptarPrivacidad()">Continuar al Quiz →</button>
    </div>
</div>

<div id="policy-modal" onclick="cerrarPoliticaOverlay(event)">
    <div id="policy-box">
        <div class="policy-header">
            <h3>Aviso de Privacidad Integral — UTL</h3>
            <button class="policy-close" onclick="cerrarPolitica()">&#x2715;</button>
        </div>
        <div class="policy-body">
            <p>La <strong>Universidad Tecnológica de León (UTL)</strong>, conforme a lo establecido en los artículos 3, fracción I, 34, 35, 36, 37, 38, 39, 40, 42, así como lo dispuesto en el Título Tercero, Capítulo Primero de la Ley de Protección de Datos Personales en Posesión de Sujetos Obligados para el Estado de Guanajuato, publicada el 14 de julio de 2017, informa que la protección de los datos personales es un derecho humano vinculado a la protección de la privacidad y da a conocer el presente Aviso de Privacidad Integral.</p>
            <h4>I. Denominación del Responsable</h4>
            <p>La <strong>Universidad Tecnológica de León</strong> es un Organismo Público Descentralizado de la Administración Pública Estatal, con personalidad jurídica y patrimonio propios, de conformidad con el Decreto Gubernativo número 108 publicado el 9 de diciembre de 1994, reestructurado mediante el Decreto Gubernativo número 240 publicado el 18 de octubre de 2005.</p>
            <h4>II. Domicilio</h4>
            <p>Boulevard Universidad Tecnológica #225, Colonia San Carlos, C.P. 37670, León, Guanajuato.</p>
            <h4>III. Datos Personales Tratados</h4>
            <p>Identificación, contacto, laborales, características físicas, académicos, patrimoniales, biométricos y afiliación sindical. Los datos sensibles son los relativos a afiliación sindical, salud, origen étnico o racial y biométricos.</p>
            <h4>IV. Finalidades</h4>
            <p>Servicios académicos (admisión, inscripción, reinscripción, titulación, becas, entre otros), recursos humanos y materia administrativa.</p>
            <h4>V. Fundamento Legal</h4>
            <p>Artículos 3o., 6o. apartado A fracciones II y III, 16 párrafo segundo de la CPEUM; Ley General de Educación; Ley de Protección de Datos Personales en Posesión de Sujetos Obligados para el Estado de Guanajuato, entre otros ordenamientos.</p>
            <h4>VI. Transferencias</h4>
            <p>Los datos podrán ser transmitidos a otras autoridades con fines compatibles con los de su recabación. <strong>No se realizarán</strong> transferencias que requieran consentimiento sin manifestación expresa.</p>
            <h4>VII. Derechos ARCO</h4>
            <p>Puede ejercer derechos de Acceso, Rectificación, Cancelación y Oposición ante la <strong>Unidad de Transparencia del Poder Ejecutivo del Estado de Guanajuato</strong>, calle San Sebastián #78, Zona Centro, Guanajuato. Tel: 473 73 51500 ext. 2272. Correo: <a href="mailto:unidadtransparencia@guanajuato.gob.mx">unidadtransparencia@guanajuato.gob.mx</a></p>
            <h4>X. Cambios al Aviso</h4>
            <p>Los cambios se comunicarán por correo institucional o vía <a href="http://www.utleon.edu.mx" target="_blank">www.utleon.edu.mx</a>.</p>
        </div>
    </div>
</div>

<div class="page-content-wrapper">

{{-- ═══ ETAPA 1: Bienvenida ═══════════════════════════════════════════════ --}}
<div id="stage-1" class="stage">
    <div class="stage-wrap">
        <section id="stage-1-inner"
                 style="background:linear-gradient(rgba(6,6,15,.75),rgba(6,6,15,.95));
                        border:1px solid #8B6914; border-radius:10px;">
            <div>
                <p style="color:#E8C96A;letter-spacing:4px;text-transform:uppercase;font-size:.82rem;">
                    Orientación Vocacional
                </p>
                <h1 id="stage-1-title" class="siia-title" style="color:#C8A84B;margin:0;">
                    LA GARRA<br>SELECCIONADORA
                </h1>
                <p id="stage-1-desc" style="color:#F0EAD8;line-height:1.8;max-width:500px;margin-top:1.5rem;">
                    Responde honestamente 25 preguntas generales. Según tus respuestas, el sistema
                    identificará tu área de afinidad y te hará preguntas más específicas para
                    descubrir qué casa académica representa mejor tu vocación.
                </p>
                <p style="color:#B0A898;font-size:.82rem;margin-top:.75rem;">
                    ⏱ Tiempo estimado: 10–15 minutos &nbsp;·&nbsp; 📋 Sin respuestas incorrectas
                </p>
                <button id="stage-1-btn" onclick="abrirAviso()"
                        style="background:#C6A050;color:#06060F;border:none;padding:.9rem 2rem;
                               font-weight:700;border-radius:4px;cursor:pointer;margin-top:1.5rem;
                               font-size:1rem;font-family:inherit;letter-spacing:.04em;">
                    Comenzar
                </button>
            </div>
            <div id="stage-1-img-wrap" style="display:flex;justify-content:center;align-items:center;">
                <img id="stage-1-img" src="{{ asset('imagenes/pata.webp') }}"
                     class="float" alt="Garra seleccionadora">
            </div>
        </section>
    </div>
</div>

{{-- ═══ ETAPA 2: Preguntas (Niveles 1, 2 y 3) ════════════════════════════ --}}
<div id="stage-2" class="stage" style="display:none;">
    <div class="stage-wrap">
        <section class="quiz-card">

            {{-- Progreso --}}
            <div class="quiz-progress-wrap">
                <div class="quiz-progress-label">
                    <span id="quiz-fase-label">Fase 1 de 3</span>
                    <span id="quiz-progress-txt">Pregunta 1 de 25</span>
                </div>
                <div class="quiz-progress-track">
                    <div class="quiz-progress-fill" id="quiz-progress-fill" style="width:4%;"></div>
                </div>
            </div>

            {{-- Badge de fase --}}
            <div>
                <span class="quiz-fase-badge" id="quiz-badge">Intereses Generales</span>
            </div>

            {{-- Pregunta --}}
            <p class="quiz-pregunta" id="quiz-texto">Cargando pregunta...</p>

            {{-- Opciones (escala 0-4) --}}
            <div class="quiz-opciones" id="quiz-opciones">
                @php
                $opciones = [
                    [0, 'Nada me interesa'],
                    [1, 'Poco me interesa'],
                    [2, 'Me es indiferente'],
                    [3, 'Me interesa'],
                    [4, 'Me interesa mucho'],
                ];
                @endphp
                @foreach($opciones as [$val, $label])
                <label class="quiz-opcion" data-val="{{ $val }}" onclick="seleccionarOpcion(this)">
                    <span class="opcion-bullet"><span class="opcion-bullet-dot"></span></span>
                    <span class="opcion-val">{{ $val }}</span>
                    <span class="opcion-text">{{ $label }}</span>
                </label>
                @endforeach
            </div>

            {{-- Navegación --}}
            <div class="quiz-nav">
                <button class="btn-quiz btn-quiz-ghost" id="btn-anterior" onclick="preguntaAnterior()" style="display:none;">
                    ← Anterior
                </button>
                <button class="btn-quiz btn-quiz-primary" id="btn-siguiente" onclick="preguntaSiguiente()" disabled>
                    Siguiente →
                </button>
            </div>

        </section>
    </div>
</div>

{{-- ═══ ETAPA 3: Procesando ════════════════════════════════════════════════ --}}
<div id="stage-3" class="stage" style="display:none;">
    <div class="stage-wrap">
        <section id="stage-3-inner"
                 style="background:radial-gradient(circle at 50% 30%,rgba(38,66,118,.45),transparent 55%),
                        linear-gradient(160deg,#06060F,#0A1428 35%,#0D1A33 60%,#06060F);
                        border:1px solid rgba(120,160,220,.28); border-radius:10px;
                        display:flex;flex-direction:column;align-items:center;justify-content:center;
                        position:relative;overflow:hidden;">
            <div style="position:absolute;inset:0;background-image:radial-gradient(#E8C96A 1px,transparent 1px);
                        background-size:120px 120px;opacity:.08;pointer-events:none;"></div>
            <h2 id="stage-3-title" class="siia-title" style="color:#C8A84B;font-size:3rem;">NOVA</h2>
            <div id="stage-3-video-wrap" style="background:rgba(8,14,28,.55);backdrop-filter:blur(12px);
                 border:1px solid rgba(140,175,225,.22);border-radius:18px;padding:20px;margin:1.5rem 0;">
                <video id="stage-3-video" autoplay muted loop playsinline
                       style="max-width:100%;border-radius:8px;display:block;">
                    <source src="{{ asset('videos/garrita.mp4') }}" type="video/mp4">
                </video>
            </div>
            <p style="color:#F0EAD8;text-align:center;line-height:2;padding:0 1rem;">
                La garra está analizando tu perfil vocacional...<br>
                Calculando afinidades académicas...
            </p>
            <button id="stage-3-btn" onclick="mostrarResultado()"
                    style="background:#C6A050;color:#06060F;border:none;padding:.9rem 2rem;
                           font-weight:700;border-radius:4px;cursor:pointer;margin-bottom:2rem;
                           font-family:inherit;font-size:1rem;">
                Ver mi resultado
            </button>
        </section>
    </div>
</div>

{{-- ═══ ETAPA 4: Resultado ═════════════════════════════════════════════════ --}}
<div id="stage-4" class="stage" style="display:none;">
    <div class="stage-wrap">
        <section id="stage-4-inner"
                 style="background:rgba(6,6,15,.75);border:1px solid #8B6914;border-radius:10px;">

            <div id="stage-4-img-wrap">
                <img id="stage-4-img" src="" alt="Casa resultado"
                     style="max-width:420px;width:100%;object-fit:contain;">
            </div>

            <div>
                <p style="color:#E8C96A;letter-spacing:4px;text-transform:uppercase;font-size:.8rem;">
                    Tu destino es
                </p>
                <h1 id="stage-4-result-title" class="siia-title" style="color:#C8A84B;margin:.25rem 0;"></h1>
                <p id="stage-4-casa-nombre" style="color:#FFFFFF;font-size:1.2rem;font-family:'Headland One',serif;margin-bottom:.5rem;"></p>
                <p id="stage-4-frase" style="color:#E8C96A;font-style:italic;font-size:1rem;margin-bottom:1rem;"></p>
                <p id="stage-4-desc" style="color:#F0EAD8;line-height:1.8;max-width:480px;font-size:.95rem;"></p>

                {{-- Puntuaciones --}}
                <div id="stage-4-scores" style="margin-top:1.5rem;"></div>

                <div id="stage-4-btns">
                    <a href="{{ route('welcome') }}"
                       style="background:#C6A050;color:#06060F;padding:.9rem 2rem;border-radius:4px;
                              text-decoration:none;font-weight:700;display:inline-block;">
                        Inicio
                    </a>
                    <button onclick="descargarResultado()"
                            style="background:transparent;border:1px solid #8B6914;color:#F0EAD8;
                                   padding:.9rem 2rem;cursor:pointer;border-radius:4px;font-family:inherit;">
                        Compartir resultado
                    </button>
                </div>
            </div>

        </section>
    </div>

    {{-- Tarjeta Instagram (oculta) --}}
    <div id="instagram-card"
         style="width:1080px;height:1920px;background:#06060F;display:flex;flex-direction:column;
                justify-content:center;align-items:center;padding:80px;box-sizing:border-box;
                position:absolute;left:-99999px;">
        <img id="ig-img" src="" style="width:600px;max-width:100%;margin-bottom:60px;object-fit:contain;">
        <p style="color:#E8C96A;letter-spacing:8px;font-size:32px;margin-bottom:16px;">TU DESTINO ES</p>
        <h1 id="ig-title" style="font-family:'Headland One',serif;color:#C8A84B;font-size:80px;text-align:center;margin:0;"></h1>
        <p id="ig-casa" style="color:#FFFFFF;font-size:48px;text-align:center;margin:20px 0;"></p>
        <p id="ig-frase" style="color:#E8C96A;font-style:italic;font-size:38px;text-align:center;max-width:800px;"></p>
    </div>
</div>

</div>{{-- /page-content-wrapper --}}

{{-- FOOTER --}}
<footer id="footer-casas">
    <div id="footer-casas-grid">
        <div style="max-width:400px;">
            <h3 style="font-family:'Headland One',serif;color:#C8A84B;margin-bottom:1rem;font-size:1.4rem;">
                Universidad Tecnológica de León
            </h3>
            <p style="color:#F0EAD8;line-height:1.8;margin:0;">
                Blvd. Universidad Tecnológica #225 Col. San Carlos<br>
                C.P. 37670 León, Gto. México<br><br>
                comunicacionutl@utleon.edu.mx<br><br>
                (477) 7 10 00 20
            </p>
        </div>
        <div style="max-width:450px;">
            <h3 style="font-family:'Headland One',serif;color:#C8A84B;margin-bottom:1rem;font-size:1.4rem;">
                Desarrolladores del Proyecto
            </h3>
            <p style="color:#F0EAD8;line-height:2;margin:0;">
                <strong>Citlalli Méndez</strong><br>Documentadora y Administradora de Base de Datos<br>citlallialejandrams@gmail.com<br><br>
                <strong>Miryam Muñoz</strong><br>Diseñadora<br>miryammunoz26@gmail.com<br><br>
                <strong>Carlo Flores</strong><br>Programador<br>carlofernandoflores2006@gmail.com
            </p>
        </div>
    </div>
    <div style="margin-top:2.5rem;border-top:1px solid rgba(200,168,75,.15);padding-top:1.5rem;
                text-align:center;color:#707085;font-size:.8rem;letter-spacing:.08em;">
        © {{ date('Y') }} NOVA · Navegador de Orientación Vocacional y Aptitudes
    </div>
</footer>

@endsection

@push('extra-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
// ════════════════════════════════════════════════════════════════════════════
//  DATOS DEL QUIZ — extraídos del Excel (OV_UTL_Final.xlsx)
// ════════════════════════════════════════════════════════════════════════════

// ── NIVEL 1: 25 preguntas generales (discrimina TEII vs EA) — hoja "Encuesta área" ──
const NIVEL1 = [
    { id:1,  texto:'Me interesa entender cómo funcionan las cosas',           dim:'TEC', grupo:'TEII' },
    { id:2,  texto:'Me gusta analizar información o datos',                    dim:'ANA', grupo:'TEII' },
    { id:3,  texto:'Me gusta usar computadoras o tecnología',                  dim:'DIG', grupo:'TEII' },
    { id:4,  texto:'Me interesa organizar actividades o procesos',             dim:'PRO', grupo:'TEII' },
    { id:5,  texto:'Me gusta ayudar o atender personas',                       dim:'SOC', grupo:'EA'   },
    { id:6,  texto:'Me interesa el cuidado del medio ambiente',                dim:'AMB', grupo:'TEII' },
    { id:7,  texto:'Me gusta crear cosas nuevas o innovar',                    dim:'CRE', grupo:'EA'   },
    { id:8,  texto:'Me interesa el mundo de los negocios',                     dim:'NEG', grupo:'EA'   },
    { id:9,  texto:'Me gusta resolver problemas prácticos',                    dim:'TEC', grupo:'TEII' },
    { id:10, texto:'Me interesa trabajar en equipo',                           dim:'SOC', grupo:'EA'   },
    { id:11, texto:'Prefiero analizar información que hacer tareas manuales',  dim:'ANA', grupo:'TEII' },
    { id:12, texto:'Me gusta trabajar con herramientas o máquinas',            dim:'TEC', grupo:'TEII' },
    { id:13, texto:'Disfruto diseñar ideas o soluciones innovadoras',          dim:'CRE', grupo:'EA'   },
    { id:14, texto:'Me interesa coordinar equipos o proyectos',                dim:'PRO', grupo:'TEII' },
    { id:15, texto:'Me gusta usar tecnología para resolver problemas',         dim:'DIG', grupo:'TEII' },
    { id:16, texto:'Me interesa investigar temas científicos',                 dim:'AMB', grupo:'TEII' },
    { id:17, texto:'Me gusta vender productos o ideas',                        dim:'NEG', grupo:'EA'   },
    { id:18, texto:'Me gusta interactuar con clientes o usuarios',             dim:'SOC', grupo:'EA'   },
    { id:19, texto:'Me interesa mejorar procesos en empresas',                 dim:'PRO', grupo:'TEII' },
    { id:20, texto:'Me interesa desarrollar soluciones digitales',             dim:'DIG', grupo:'TEII' },
    { id:21, texto:'Me gusta trabajar en ambientes dinámicos',                 dim:'SOC', grupo:'EA'   },
    { id:22, texto:'Prefiero actividades prácticas más que teóricas',          dim:'TEC', grupo:'TEII' },
    { id:23, texto:'Me gusta analizar comportamientos o tendencias',           dim:'ANA', grupo:'TEII' },
    { id:24, texto:'Me interesa emprender un negocio',                        dim:'NEG', grupo:'EA'   },
    { id:25, texto:'Me interesa crear contenido o experiencias',               dim:'CRE', grupo:'EA'   },
];

// Máximos nivel 1 (hoja "Nivel 1 y 2"): TEII 15 preguntas × 4 = 60, EA 10 preguntas × 4 = 40
const MAX_TEII_N1 = 60;
const MAX_EA_N1   = 40;

// ── NIVEL 2-TI: 30 preguntas — hoja "Encuesta2 Carreras" (si gana TEII) ─────────────
const NIVEL2_TI = [
    { id:26,  texto:'Configurar redes o sistemas de comunicación',                             carrera:'REDES'    },
    { id:27,  texto:'Administrar redes y garantizar la conexión entre equipos',                carrera:'REDES'    },
    { id:28,  texto:'Desarrollar soluciones con inteligencia artificial',                      carrera:'IA'       },
    { id:29,  texto:'Crear sistemas que aprendan o automaticen decisiones',                    carrera:'IA'       },
    { id:30,  texto:'Crear páginas web o aplicaciones',                                        carrera:'DSM'      },
    { id:31,  texto:'Resolver problemas mediante programación',                                carrera:'DSM'      },
    { id:32,  texto:'Analizar grandes volúmenes de datos',                                     carrera:'DATOS'    },
    { id:33,  texto:'Interpretar datos para la toma de decisiones',                            carrera:'DATOS'    },
    { id:34,  texto:'Diseñar experiencias digitales o multimedia',                             carrera:'MULT'     },
    { id:35,  texto:'Crear contenido interactivo para plataformas digitales',                  carrera:'MULT'     },
    { id:36,  texto:'Programar robots o sistemas automáticos',                                 carrera:'MECAAUTO' },
    { id:37,  texto:'Automatizar procesos utilizando controladores y sensores',                carrera:'MECAAUTO' },
    { id:38,  texto:'Trabajar con sensores y circuitos optoelectrónicos',                      carrera:'MECAOPTO' },
    { id:39,  texto:'Mantener sistemas optoelectrónicos para su correcto funcionamiento',      carrera:'MECAOPTO' },
    { id:40,  texto:'Integrar sistemas mecánicos y electrónicos',                              carrera:'MECASMF'  },
    { id:41,  texto:'Diseñar sistemas de manufactura automatizada',                            carrera:'MECASMF'  },
    { id:42,  texto:'Supervisar procesos de producción',                                       carrera:'PRO'      },
    { id:43,  texto:'Mejorar la eficiencia de procesos industriales',                          carrera:'PRO'      },
    { id:44,  texto:'Trabajar en industria automotriz',                                        carrera:'AUTO'     },
    { id:45,  texto:'Participar en procesos de fabricación de vehículos',                      carrera:'AUTO'     },
    { id:46,  texto:'Trabajar con materiales plásticos',                                       carrera:'PLAS'     },
    { id:47,  texto:'Diseñar o fabricar productos plásticos',                                  carrera:'PLAS'     },
    { id:48,  texto:'Participar en producción de calzado',                                     carrera:'CALZ'     },
    { id:49,  texto:'Diseñar o mejorar procesos de fabricación de calzado',                    carrera:'CALZ'     },
    { id:50,  texto:'Dar mantenimiento a maquinaria o equipos',                                carrera:'MANT'     },
    { id:51,  texto:'Diagnosticar fallas en sistemas industriales',                            carrera:'MANT'     },
    { id:52,  texto:'Analizar impacto ambiental y diseñar soluciones ecológicas',              carrera:'AMBI'     },
    { id:53,  texto:'Evaluar el uso de recursos para reducir contaminación',                   carrera:'AMBI'     },
    { id:54,  texto:'Trabajar con vehículos eléctricos y nuevas tecnologías de transporte',    carrera:'ELECTRO'  },
    { id:55,  texto:'Diseñar o mantener sistemas de electromovilidad',                         carrera:'ELECTRO'  },
];

// ── NIVEL 2-EA: 10 preguntas — hoja "Encuesta2 Carreras" (si gana EA) ───────────
const NIVEL2_EA = [
    { id:56, texto:'Optimizar rutas o tiempos de distribución de productos', carrera:'LOG'  },
    { id:57, texto:'Organizar procesos de transporte y logística',            carrera:'LOG'  },
    { id:58, texto:'Administrar recursos en una empresa',                     carrera:'ADM'  },
    { id:59, texto:'Coordinar personal y operaciones administrativas',        carrera:'ADM'  },
    { id:60, texto:'Analizar mercado y comportamiento del consumidor',        carrera:'MKT'  },
    { id:61, texto:'Diseñar estrategias de marketing y ventas',               carrera:'MKT'  },
    { id:62, texto:'Preparar alimentos o crear platillos',                    carrera:'GAST' },
    { id:63, texto:'Diseñar menús o servicios gastronómicos',                 carrera:'GAST' },
    { id:64, texto:'Organizar eventos o experiencias turísticas',             carrera:'TUR'  },
    { id:65, texto:'Planear actividades para visitantes o turistas',          carrera:'TUR'  },
];

// ── NIVEL 3: 80 preguntas de confirmación — hoja "Encuesta3 Confirmación" (todas las carreras) ──
const NIVEL3 = [
    { id:66, texto:'Me visualizo administrando redes y sistemas de comunicación digital.', carrera:'REDES' },
    { id:67, texto:'Me interesa garantizar que los equipos y sistemas permanezcan conectados correctamente.', carrera:'REDES' },
    { id:68, texto:'Disfrutaría resolver problemas relacionados con la conectividad y transmisión de información.', carrera:'REDES' },
    { id:69, texto:'Me gustaría especializarme en tecnologías de redes y comunicación.', carrera:'REDES' },
    { id:70, texto:'Me interesa desarrollar sistemas capaces de aprender y tomar decisiones.', carrera:'IA' },
    { id:71, texto:'Me visualizo trabajando en proyectos de inteligencia artificial.', carrera:'IA' },
    { id:72, texto:'Disfrutaría utilizar algoritmos para resolver problemas complejos.', carrera:'IA' },
    { id:73, texto:'Me gustaría participar en el desarrollo de tecnologías innovadoras basadas en IA.', carrera:'IA' },
    { id:74, texto:'Me visualizo creando aplicaciones o sistemas informáticos.', carrera:'DSM' },
    { id:75, texto:'Disfrutaría resolver problemas mediante programación.', carrera:'DSM' },
    { id:76, texto:'Me interesa aprender nuevos lenguajes y tecnologías de desarrollo.', carrera:'DSM' },
    { id:77, texto:'Me gustaría participar en proyectos de desarrollo de software.', carrera:'DSM' },
    { id:78, texto:'Me interesa analizar información para apoyar la toma de decisiones.', carrera:'DATOS' },
    { id:79, texto:'Disfruto encontrar patrones y tendencias en grandes volúmenes de datos.', carrera:'DATOS' },
    { id:80, texto:'Me visualizo trabajando con herramientas de análisis de datos.', carrera:'DATOS' },
    { id:81, texto:'Me gustaría generar información útil a partir de bases de datos.', carrera:'DATOS' },
    { id:82, texto:'Me interesa crear experiencias digitales innovadoras.', carrera:'MULT' },
    { id:83, texto:'Me visualizo desarrollando contenido multimedia e interactivo.', carrera:'MULT' },
    { id:84, texto:'Disfrutaría diseñar entornos digitales para usuarios.', carrera:'MULT' },
    { id:85, texto:'Me gustaría participar en proyectos de innovación digital.', carrera:'MULT' },
    { id:86, texto:'Me interesa automatizar procesos mediante tecnología.', carrera:'MECAAUTO' },
    { id:87, texto:'Me visualizo programando sistemas automáticos y robots.', carrera:'MECAAUTO' },
    { id:88, texto:'Disfrutaría optimizar procesos industriales mediante automatización.', carrera:'MECAAUTO' },
    { id:89, texto:'Me gustaría trabajar en proyectos de control y automatización.', carrera:'MECAAUTO' },
    { id:90, texto:'Me interesa trabajar con sistemas que integren óptica y electrónica.', carrera:'MECAOPTO' },
    { id:91, texto:'Me visualizo realizando mantenimiento a sistemas optoelectrónicos.', carrera:'MECAOPTO' },
    { id:92, texto:'Disfrutaría utilizar sensores y tecnologías avanzadas de medición.', carrera:'MECAOPTO' },
    { id:93, texto:'Me gustaría especializarme en tecnologías optoelectrónicas.', carrera:'MECAOPTO' },
    { id:94, texto:'Me interesa integrar componentes mecánicos, electrónicos y computacionales.', carrera:'MECASMF' },
    { id:95, texto:'Me visualizo trabajando en procesos de manufactura automatizada.', carrera:'MECASMF' },
    { id:96, texto:'Disfrutaría diseñar soluciones para mejorar la producción industrial.', carrera:'MECASMF' },
    { id:97, texto:'Me gustaría participar en la implementación de sistemas inteligentes de manufactura.', carrera:'MECASMF' },
    { id:98, texto:'Me interesa mejorar la eficiencia de procesos productivos.', carrera:'PRO' },
    { id:99, texto:'Me visualizo coordinando operaciones industriales.', carrera:'PRO' },
    { id:100, texto:'Disfrutaría identificar oportunidades de mejora continua.', carrera:'PRO' },
    { id:101, texto:'Me gustaría contribuir a incrementar la productividad de una organización.', carrera:'PRO' },
    { id:102, texto:'Me interesa participar en la fabricación de componentes automotrices.', carrera:'AUTO' },
    { id:103, texto:'Me visualizo trabajando en procesos relacionados con la industria automotriz.', carrera:'AUTO' },
    { id:104, texto:'Disfrutaría mejorar la calidad y productividad en este sector.', carrera:'AUTO' },
    { id:105, texto:'Me gustaría formar parte de proyectos de innovación automotriz.', carrera:'AUTO' },
    { id:106, texto:'Me interesa el desarrollo de productos plásticos.', carrera:'PLAS' },
    { id:107, texto:'Me visualizo trabajando en procesos de transformación de materiales.', carrera:'PLAS' },
    { id:108, texto:'Disfrutaría participar en la fabricación de nuevos productos.', carrera:'PLAS' },
    { id:109, texto:'Me gustaría especializarme en tecnologías de manufactura de plásticos.', carrera:'PLAS' },
    { id:110, texto:'Me interesa mejorar procesos de fabricación de calzado.', carrera:'CALZ' },
    { id:111, texto:'Me visualizo participando en proyectos de diseño y producción.', carrera:'CALZ' },
    { id:112, texto:'Disfrutaría contribuir a elevar la calidad de productos del sector.', carrera:'CALZ' },
    { id:113, texto:'Me gustaría trabajar en la industria del calzado.', carrera:'CALZ' },
    { id:114, texto:'Me interesa mantener equipos y maquinaria en óptimas condiciones.', carrera:'MANT' },
    { id:115, texto:'Me visualizo resolviendo fallas técnicas en sistemas industriales.', carrera:'MANT' },
    { id:116, texto:'Disfrutaría diagnosticar problemas en maquinaria.', carrera:'MANT' },
    { id:117, texto:'Me gustaría asegurar el funcionamiento eficiente de los procesos productivos.', carrera:'MANT' },
    { id:118, texto:'Me interesa contribuir al cuidado y conservación del medio ambiente.', carrera:'AMBI' },
    { id:119, texto:'Me visualizo desarrollando proyectos de sustentabilidad.', carrera:'AMBI' },
    { id:120, texto:'Disfrutaría evaluar impactos ambientales y proponer soluciones.', carrera:'AMBI' },
    { id:121, texto:'Me gustaría participar en iniciativas que favorezcan el uso responsable de los recursos.', carrera:'AMBI' },
    { id:122, texto:'Me interesa trabajar con vehículos eléctricos y tecnologías sustentables de transporte.', carrera:'ELECTRO' },
    { id:123, texto:'Me visualizo participando en proyectos de electromovilidad.', carrera:'ELECTRO' },
    { id:124, texto:'Disfrutaría diseñar o mejorar sistemas de transporte eléctrico.', carrera:'ELECTRO' },
    { id:125, texto:'Me gustaría contribuir al desarrollo de soluciones de movilidad sustentable.', carrera:'ELECTRO' },
    { id:126, texto:'Me interesa optimizar la distribución y transporte de productos.', carrera:'LOG' },
    { id:127, texto:'Me visualizo coordinando operaciones logísticas.', carrera:'LOG' },
    { id:128, texto:'Disfrutaría organizar rutas, tiempos y recursos.', carrera:'LOG' },
    { id:129, texto:'Me gustaría contribuir a mejorar la eficiencia de las cadenas de suministro.', carrera:'LOG' },
    { id:130, texto:'Me interesa dirigir y coordinar recursos dentro de una organización.', carrera:'ADM' },
    { id:131, texto:'Me visualizo tomando decisiones administrativas.', carrera:'ADM' },
    { id:132, texto:'Disfrutaría liderar equipos de trabajo.', carrera:'ADM' },
    { id:133, texto:'Me gustaría contribuir al cumplimiento de los objetivos de una empresa.', carrera:'ADM' },
    { id:134, texto:'Me interesa analizar el comportamiento de consumidores y mercados.', carrera:'MKT' },
    { id:135, texto:'Me visualizo diseñando estrategias comerciales y de marketing.', carrera:'MKT' },
    { id:136, texto:'Disfrutaría desarrollar nuevos productos o servicios.', carrera:'MKT' },
    { id:137, texto:'Me gustaría participar en proyectos de innovación y crecimiento empresarial.', carrera:'MKT' },
    { id:138, texto:'Me interesa desarrollar habilidades culinarias de nivel profesional.', carrera:'GAST' },
    { id:139, texto:'Me visualizo creando experiencias gastronómicas para las personas.', carrera:'GAST' },
    { id:140, texto:'Disfrutaría trabajar en ambientes relacionados con alimentos y bebidas.', carrera:'GAST' },
    { id:141, texto:'Me gustaría emprender o dirigir proyectos gastronómicos.', carrera:'GAST' },
    { id:142, texto:'Me interesa diseñar experiencias turísticas para diferentes públicos.', carrera:'TUR' },
    { id:143, texto:'Me visualizo trabajando en el sector turístico.', carrera:'TUR' },
    { id:144, texto:'Disfrutaría promover destinos, cultura y patrimonio.', carrera:'TUR' },
    { id:145, texto:'Me gustaría contribuir al desarrollo turístico de una región.', carrera:'TUR' },
];

// ── Catálogo de carreras con datos para resultado ────────────────────────
const CARRERAS = {
    DSM:      { nombre:'CODARIS', carrera:'Desarrollo de Software Multiplataforma', dominio:'Tecnologías de la Información', frase:'Cada línea construye el futuro',              imagen:'imagenes/casas/software.webp',       desc:'Crearás aplicaciones y sistemas que resuelven problemas reales, desde apps móviles hasta plataformas web de alta escala.' },
    REDES:    { nombre:'HEXANET', carrera:'Infraestructura de Redes Digitales',     dominio:'Tecnologías de la Información', frase:'Conectar es avanzar',                         imagen:'imagenes/casas/redes.webp',          desc:'Diseñarás y administrarás las redes que mantienen conectadas a las empresas, garantizando seguridad y disponibilidad.' },
    IA:       { nombre:'SYNTHERA',carrera:'Inteligencia Artificial',                dominio:'Tecnologías de la Información', frase:'Pensar más allá de los límites',               imagen:'imagenes/casas/ia.webp',             desc:'Desarrollarás sistemas inteligentes capaces de aprender, predecir y tomar decisiones para resolver problemas complejos.' },
    DATOS:    { nombre:'DATHEON', carrera:'Ciencia de Datos',                       dominio:'Tecnologías de la Información', frase:'Los datos cuentan historias',                 imagen:'imagenes/casas/datos.webp',          desc:'Analizarás grandes volúmenes de información para extraer insights que guíen decisiones estratégicas en cualquier industria.' },
    MULT:     { nombre:'NEXARIS', carrera:'Entornos Virtuales y Negocios Digitales',dominio:'Tecnologías de la Información', frase:'Imaginar es crear',                           imagen:'imagenes/casas/entornos.webp',       desc:'Crearás experiencias digitales interactivas, desde videojuegos hasta realidad virtual y contenido multimedia profesional.' },
    MECAAUTO: { nombre:'AUTRON',  carrera:'Automatización',                         dominio:'Mecatrónica',                   frase:'La eficiencia es inteligencia aplicada',       imagen:'imagenes/casas/automatizacion.webp', desc:'Automatizarás procesos industriales combinando programación, electrónica y sistemas de control para crear fábricas inteligentes.' },
    MECAOPTO: { nombre:'PRISMARA',carrera:'Optomecatrónica',                        dominio:'Mecatrónica',                   frase:'La precisión guía el camino',                 imagen:'imagenes/casas/optomecatronica.webp',desc:'Trabajarás con tecnología óptica y sistemas electrónicos de alta precisión para aplicaciones industriales y de medición.' },
    MECASMF:  { nombre:'FLEXION', carrera:'Manufactura Flexible',                   dominio:'Mecatrónica',                   frase:'Adaptarse es evolucionar',                    imagen:'imagenes/casas/manufactura.webp',    desc:'Diseñarás sistemas de producción automatizados que se adaptan a diferentes productos con máxima eficiencia.' },
    PRO:      { nombre:'OPERION', carrera:'Procesos Productivos',                   dominio:'Ingeniería Industrial',         frase:'La mejora nunca termina',                     imagen:'imagenes/casas/productivos.webp',    desc:'Optimizarás operaciones industriales aplicando metodologías de mejora continua para maximizar productividad y calidad.' },
    AUTO:     { nombre:'PISTORIA',carrera:'Automotriz',                             dominio:'Ingeniería Industrial',         frase:'Movimiento con propósito',                    imagen:'imagenes/casas/automotriz.webp',     desc:'Participarás en procesos de fabricación automotriz, mejorando calidad, eficiencia y adoptando nuevas tecnologías del sector.' },
    PLAS:     { nombre:'POLYMOR', carrera:'Moldeo de Plásticos',                    dominio:'Ingeniería Industrial',         frase:'La forma sigue a la innovación',               imagen:'imagenes/casas/plasticos.webp',      desc:'Diseñarás y fabricarás productos plásticos innovadores utilizando tecnologías avanzadas de transformación de materiales.' },
    CALZ:     { nombre:'SENDORIA',carrera:'Gestión y Productividad de Calzado',     dominio:'Ingeniería Industrial',         frase:'Cada paso deja huella',                       imagen:'imagenes/casas/calzado.webp',        desc:'Mejorarás los procesos de producción de calzado combinando creatividad, calidad y eficiencia operacional.' },
    MANT:     { nombre:'ENGRAVIA',carrera:'Mantenimiento Industrial',               dominio:'Ingenierías',                   frase:'La excelencia se construye cada día',          imagen:'imagenes/casas/mantenimiento.webp',  desc:'Mantendrás maquinaria industrial en óptimas condiciones utilizando técnicas predictivas y metodologías avanzadas.' },
    AMBI:     { nombre:'SYLVARA', carrera:'Ambiental y Sustentabilidad',            dominio:'Ingenierías',                   frase:'Proteger hoy para transformar mañana',         imagen:'imagenes/casas/ambiental.webp',      desc:'Desarrollarás soluciones ambientales sostenibles, evaluando impactos y creando tecnologías que cuidan el planeta.' },
    ELECTRO:  { nombre:'VOLTARA', carrera:'Electromovilidad',                       dominio:'Ingenierías',                   frase:'El futuro se mueve en silencio',               imagen:'imagenes/casas/automotriz.webp',     desc:'Trabajarás con vehículos eléctricos y sistemas de transporte sustentable, liderando la transición energética del sector.' },
    LOG:      { nombre:'NAVENTOR',carrera:'Logística',                              dominio:'Ingenierías',                   frase:'Toda ruta tiene un destino',                  imagen:'imagenes/casas/logistica.webp',      desc:'Coordinarás cadenas de suministro complejas, optimizando rutas, tiempos y costos para conectar empresas con clientes.' },
    ADM:      { nombre:'LAUREON', carrera:'Administración',                         dominio:'Licenciaturas',                 frase:'Liderar para construir',                       imagen:'imagenes/casas/administracion.webp', desc:'Dirigirás organizaciones gestionando recursos humanos, financieros y operativos para alcanzar objetivos estratégicos.' },
    MKT:      { nombre:'NOVARIS', carrera:'Negocios y Mercadotecnia',               dominio:'Licenciaturas',                 frase:'Las ideas iluminan el cambio',                imagen:'imagenes/casas/mercadotecnia.webp',  desc:'Analizarás mercados, diseñarás estrategias comerciales y desarrollarás productos que conectan marcas con consumidores.' },
    GAST:     { nombre:'FLAMORIA',carrera:'Gastronomía',                            dominio:'Licenciaturas',                 frase:'Crear experiencias para recordar',             imagen:'imagenes/casas/gastronomia2.webp',   desc:'Crearás experiencias culinarias extraordinarias combinando técnica, creatividad y pasión por el arte gastronómico.' },
    TUR:      { nombre:'GLOBARIS',carrera:'Turismo',                                dominio:'Licenciaturas',                 frase:'Descubrir conecta culturas',                  imagen:'imagenes/casas/turismo.webp',        desc:'Diseñarás y gestionarás experiencias turísticas que conectan a personas con culturas, destinos y experiencias únicas.' },
};

// ════════════════════════════════════════════════════════════════════════════
//  ESTADO DEL QUIZ
// ════════════════════════════════════════════════════════════════════════════
let estado = {
    fase:        1,       // 1=Nivel1 (25), 2=Nivel2 (30 o 10), 3=Nivel3 confirmación (80)
    preguntas:   [],      // lista activa
    indice:      0,       // pregunta actual
    respuestas:  {},      // { id: valor }  — todo en memoria, nada se guarda en base de datos aquí
    areaElegida: null,    // 'TEII' o 'EA'
    carreraFinal:null,    // key de CARRERAS
};

// ════════════════════════════════════════════════════════════════════════════
//  NAVEGACIÓN ENTRE ETAPAS
// ════════════════════════════════════════════════════════════════════════════
function goToStage(n) {
    document.querySelectorAll('.stage').forEach(s => s.style.display = 'none');
    document.getElementById('stage-' + n).style.display = 'flex';
    window.scrollTo({ top:0, behavior:'smooth' });
}

// ════════════════════════════════════════════════════════════════════════════
//  PRIVACIDAD
// ════════════════════════════════════════════════════════════════════════════
function toggleContinue(cb) {
    document.getElementById('privacy-continue').classList.toggle('activo', cb.checked);
}
function abrirAviso() {
    document.getElementById('privacy-overlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function aceptarPrivacidad() {
    document.getElementById('privacy-overlay').style.display = 'none';
    document.body.style.overflow = '';
    iniciarQuiz();
}
function abrirPolitica(e) { e.preventDefault(); document.getElementById('policy-modal').classList.add('abierto'); }
function cerrarPolitica() { document.getElementById('policy-modal').classList.remove('abierto'); }
function cerrarPoliticaOverlay(e) { if (e.target === document.getElementById('policy-modal')) cerrarPolitica(); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarPolitica(); });

// ════════════════════════════════════════════════════════════════════════════
//  LÓGICA DEL QUIZ
// ════════════════════════════════════════════════════════════════════════════
function iniciarQuiz() {
    estado = { fase:1, preguntas:NIVEL1, indice:0, respuestas:{}, areaElegida:null, carreraFinal:null };
    goToStage(2);
    renderPregunta();
}

function renderPregunta() {
    const p = estado.preguntas[estado.indice];
    const total = estado.preguntas.length;
    const current = estado.indice + 1;

    // Progreso
    const pct = Math.round((current / total) * 100);
    document.getElementById('quiz-progress-fill').style.width = pct + '%';
    document.getElementById('quiz-progress-txt').textContent = `Pregunta ${current} de ${total}`;

    // Fase badge
    const faseMap = { 1:'Intereses Generales', 2:'Actividades Específicas', 3:'Confirmación' };
    document.getElementById('quiz-fase-label').textContent = `Fase ${estado.fase} de 3`;
    document.getElementById('quiz-badge').textContent = faseMap[estado.fase] || '';

    // Texto pregunta
    document.getElementById('quiz-texto').textContent = p.texto;

    // Opciones: actualizar selección previa
    const prevVal = estado.respuestas[p.id];
    document.querySelectorAll('.quiz-opcion').forEach(op => {
        const val = parseInt(op.dataset.val);
        op.classList.toggle('seleccionada', prevVal === val);
    });

    // Botones nav
    document.getElementById('btn-anterior').style.display = estado.indice > 0 ? '' : 'none';
    const btnSig = document.getElementById('btn-siguiente');
    btnSig.textContent = (estado.indice === total - 1) ? 'Continuar →' : 'Siguiente →';
    btnSig.disabled = prevVal === undefined;
}

function seleccionarOpcion(el) {
    const p = estado.preguntas[estado.indice];
    estado.respuestas[p.id] = parseInt(el.dataset.val);
    document.querySelectorAll('.quiz-opcion').forEach(o => o.classList.remove('seleccionada'));
    el.classList.add('seleccionada');
    document.getElementById('btn-siguiente').disabled = false;
}

function preguntaSiguiente() {
    const total = estado.preguntas.length;
    if (estado.indice < total - 1) {
        estado.indice++;
        renderPregunta();
    } else {
        // Fin de la fase actual
        if (estado.fase === 1) {
            procesarNivel1();
        } else if (estado.fase === 2) {
            procesarNivel2();
        } else if (estado.fase === 3) {
            procesarNivel3();
        }
    }
}

function preguntaAnterior() {
    if (estado.indice > 0) {
        estado.indice--;
        renderPregunta();
    }
}

// ── Nivel 1 → decide TEII vs EA ──────────────────────────────────────────
function procesarNivel1() {
    let puntosTeii = 0, puntosEa = 0;

    NIVEL1.forEach(p => {
        const val = estado.respuestas[p.id] ?? 0;
        if (p.grupo === 'TEII') puntosTeii += val;
        else                     puntosEa   += val;
    });

    const pctTeii = puntosTeii / MAX_TEII_N1;
    const pctEa   = puntosEa   / MAX_EA_N1;

    estado.areaElegida = pctTeii >= pctEa ? 'TEII' : 'EA';

    // Pasa a Nivel 2 con las preguntas correspondientes
    estado.fase      = 2;
    estado.preguntas = estado.areaElegida === 'TEII' ? NIVEL2_TI : NIVEL2_EA;
    estado.indice    = 0;
    renderPregunta();
}

// ── Nivel 2 → puntúa carreras del área elegida (aún NO es el resultado final) ──
function procesarNivel2() {
    const scores = {};

    estado.preguntas.forEach(p => {
        const val = estado.respuestas[p.id] ?? 0;
        scores[p.carrera] = (scores[p.carrera] ?? 0) + val;
    });

    estado.nivel2Scores = scores; // referencia, no determina el resultado final

    // Pasa a Nivel 3: confirmación con las 80 preguntas (todas las carreras)
    estado.fase      = 3;
    estado.preguntas = NIVEL3;
    estado.indice    = 0;
    renderPregunta();
}

// ── Nivel 3 (confirmación) → calcula la carrera ganadora final ──────────
function procesarNivel3() {
    const scores = {};

    NIVEL3.forEach(p => {
        const val = estado.respuestas[p.id] ?? 0;
        scores[p.carrera] = (scores[p.carrera] ?? 0) + val;
    });

    let mejor = null, maxPts = -1;
    Object.entries(scores).forEach(([car, pts]) => {
        if (pts > maxPts) { maxPts = pts; mejor = car; }
    });

    estado.carreraFinal = mejor;
    estado.scoreFinal    = scores;

    // Va a la pantalla de procesando
    goToStage(3);
}

// ── Muestra resultado ─────────────────────────────────────────────────────
function mostrarResultado() {
    const key = estado.carreraFinal;
    const c   = CARRERAS[key] || CARRERAS['DSM'];

    document.getElementById('stage-4-result-title').textContent = c.nombre;
    document.getElementById('stage-4-casa-nombre').textContent  = c.carrera;
    document.getElementById('stage-4-frase').textContent        = '"' + c.frase + '"';
    document.getElementById('stage-4-desc').textContent         = c.desc;
    document.getElementById('stage-4-img').src                  = '/' + c.imagen;

    // Instagram card
    document.getElementById('ig-img').src    = '/' + c.imagen;
    document.getElementById('ig-title').textContent = c.nombre;
    document.getElementById('ig-casa').textContent  = c.carrera;
    document.getElementById('ig-frase').textContent = '"' + c.frase + '"';

    // Dominio badge
    const domEl = document.getElementById('stage-4-scores');
    domEl.innerHTML = `
        <span style="font-size:.72rem;text-transform:uppercase;letter-spacing:.1em;
                     color:#707085;display:block;margin-bottom:.4rem;">Dominio académico</span>
        <span style="background:rgba(200,168,75,.1);border:1px solid rgba(200,168,75,.3);
                     border-radius:20px;padding:.35rem .9rem;color:#E8C96A;
                     font-size:.82rem;">${c.dominio}</span>
    `;

    goToStage(4);
}

// ── Compartir resultado ───────────────────────────────────────────────────
function descargarResultado() {
    const card = document.getElementById('instagram-card');
    html2canvas(card, {
        width:1080, height:1920, scale:1,
        backgroundColor:'#06060F', useCORS:true
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'resultado-nova.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    });
}

// ════════════════════════════════════════════════════════════════════════════
//  HAMBURGER + MOBILE LAYOUT
// ════════════════════════════════════════════════════════════════════════════
const hamburgerBtn = document.getElementById('hamburgerBtn');
const mobileMenu   = document.getElementById('mobileMenu');
hamburgerBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('open');
    hamburgerBtn.setAttribute('aria-expanded', mobileMenu.classList.contains('open'));
});
document.addEventListener('click', e => {
    if (!hamburgerBtn.contains(e.target) && !mobileMenu.contains(e.target))
        mobileMenu.classList.remove('open');
});

function applyMobileLayout() {
    const inner = document.getElementById('stage-1-inner');
    if (!inner) return;
    inner.classList.toggle('mobile-layout', window.innerWidth <= 768);
}
applyMobileLayout();
window.addEventListener('resize', applyMobileLayout);
</script>
@endpush