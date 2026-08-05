@extends('layouts.app')
@section('title', 'Quiz — NOVA')

@section('content')

<style>
    html, body { height:100%; margin:0; }
    body { display:flex; flex-direction:column; min-height:100vh; }
    .page-content-wrapper { flex:1 0 auto; display:flex; flex-direction:column; }

    /* ── Stage wrap ── */
    .stage-wrap { padding:2rem; flex:1; display:flex; flex-direction:column;
                  overflow-x:hidden; box-sizing:border-box; width:100%; }
    @media (max-width:768px) { .stage-wrap { padding:.75rem !important; } }
    .stage { flex:1; display:flex; flex-direction:column; }
    .stage-wrap > section { flex:1; }

    /* ── Etapa 1 ── */
    #stage-1-inner { display:grid; grid-template-columns:1fr 1fr;
                     align-items:center; min-height:550px; padding:4rem; gap:2rem;
                     overflow:hidden; }
    #stage-1-title { font-size:4rem; }
    #stage-1-img-wrap { max-width:100%; overflow:hidden; }
    #stage-1-img { display:block; width:100%; max-width:380px; height:auto;
                   object-fit:contain; margin:0 auto; }
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

    /* ── Barra de progreso flotante (solo móvil) ──
       Aparece pegada arriba de la pantalla cuando la barra original
       de .quiz-progress-wrap sale del viewport, como si "te siguiera". */
    #quiz-progress-floating {
        display:none;
        position:fixed;
        top:74px; left:0; right:0;
        z-index:99;
        background:rgba(6,6,15,.92);
        backdrop-filter:blur(14px);
        -webkit-backdrop-filter:blur(14px);
        border-bottom:1px solid rgba(200,168,75,.25);
        padding:.65rem 1rem;
        flex-direction:column;
        gap:.4rem;
        transform:translateY(-100%);
        transition:transform .25s ease;
    }
    #quiz-progress-floating.visible { transform:translateY(0); }
    @media (max-width:768px) {
        #quiz-progress-floating.activo { display:flex; }
    }

    .quiz-fase-badge {
        display:inline-block; font-size:1rem; text-transform:uppercase;
        letter-spacing:.14em; color:#C8A84B; border:1px solid rgba(200,168,75,.3);
        border-radius:20px; padding:.45rem 1.25rem; width:fit-content;
        font-weight:700;
    }

    .quiz-fase-img-wrap {
        width:100%; max-width:280px; margin:0 auto;
        border-radius:12px; overflow:hidden;
        border:1px solid rgba(200,168,75,.25);
        background:#000000;
    }
    .quiz-fase-img-wrap img { display:block; width:100%; height:160px; object-fit:cover; }
    @media (max-width:600px) {
        .quiz-fase-img-wrap { max-width:220px; }
        .quiz-fase-img-wrap img { height:120px; }
    }

    /* ── Speak / disclaimer del quiz (solo visible en Fase 1) ── */
    .quiz-disclaimer {
        background:rgba(200,168,75,.06);
        border:1px solid rgba(200,168,75,.25);
        border-radius:10px;
        padding:1rem 1.25rem;
        display:flex;
        flex-direction:column;
        gap:.5rem;
    }
    .quiz-disclaimer p {
        margin:0;
        color:#F0EAD8;
        font-size:.85rem;
        line-height:1.6;
        display:flex;
        align-items:flex-start;
        gap:.55rem;
    }
    .quiz-disclaimer p strong { color:#E8C96A; }
    .quiz-disclaimer .icono { flex-shrink:0; }

    .quiz-pregunta {
        font-family:'Headland One',serif; font-size:1.4rem; color:#F0EAD8;
        line-height:1.5; max-width:680px;
    }

    /* ── Opciones: vertical por default (ideal en móvil) ── */
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
        width:28px; height:28px; border-radius:50%; border:2px solid #4A3560;
        flex-shrink:0; display:flex; align-items:center; justify-content:center;
        transition:border-color .2s, background .2s;
    }
    .quiz-opcion.seleccionada .opcion-bullet { border-color:#C8A84B; background:#C8A84B; }
    .opcion-bullet-dot { width:8px; height:8px; border-radius:50%; background:#1A1000;
                         opacity:0; transition:opacity .15s; }
    .quiz-opcion.seleccionada .opcion-bullet-dot { opacity:1; }

    .opcion-val  { font-size:1.35rem; font-weight:800; color:#8D6627; min-width:1.6rem; text-align:center; }
    .opcion-text { font-size:.9rem; color:#F0EAD8; }
    .quiz-opcion.seleccionada .opcion-val { color:#E8C96A; }

    /* ── En PC (>768px), aprovechar el ancho horizontal:
         las 5 opciones se acomodan en fila, cada una como una tarjeta
         vertical (bullet arriba, texto abajo), repartiendo el espacio. ── */
    @media (min-width:769px) {
        .quiz-opciones { flex-direction:row; gap:1rem; }
        .quiz-opcion {
            flex:1 1 0;
            flex-direction:column;
            justify-content:center;
            text-align:center;
            gap:.6rem;
            padding:1.35rem 1rem;
        }
        .opcion-bullet { order:1; }
        .opcion-val    { order:2; min-width:0; font-size:1.6rem; }
        .opcion-text   { order:3; font-size:.82rem; line-height:1.3; }
    }

    .quiz-nav { display:flex; justify-content:flex-end; align-items:center; flex-wrap:wrap; gap:1rem; }
    #btn-anterior { margin-right:auto; }

    /* ── En móvil, apilar los botones de navegación en vez de que
         se acomoden torcidos al envolver en dos líneas. ── */
    @media (max-width:600px) {
        .quiz-nav { flex-direction:column; align-items:stretch; gap:.75rem; }
        #btn-anterior { margin-right:0; order:2; }
        #btn-siguiente { order:1; }
        .quiz-nav .btn-quiz { width:100%; text-align:center; }
    }

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

    .mini-result {
        display:flex; align-items:center; gap:.6rem;
        background:rgba(20,20,31,.6); border:1px solid rgba(200,168,75,.2);
        border-radius:8px; padding:.4rem .8rem .4rem .4rem;
        max-width:100%;
        text-decoration:none;
        cursor:pointer;
        transition:border-color .2s, background .2s, transform .15s;
    }
    .mini-result:hover {
        border-color:rgba(200,168,75,.6);
        background:rgba(200,168,75,.08);
        transform:translateY(-2px);
    }
    .mini-result img {
        width:34px; height:34px; object-fit:contain; border-radius:6px;
        background:#0D0D1A; flex-shrink:0;
    }
    .mini-result-info { display:flex; flex-direction:column; line-height:1.25; min-width:0; }
    .mini-result-rank { font-size:.6rem; text-transform:uppercase; letter-spacing:.08em; color:#707085; }
    .mini-result-name { font-size:.8rem; color:#F0EAD8; font-family:'Headland One',serif; }
    .mini-result-carrera { font-size:.68rem; color:#B0A898; }
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
                   max-height:90vh; max-height:90dvh; overflow-y:auto;
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
@include('partials.navbar')


{{-- Barra de progreso flotante (solo móvil): sigue al usuario cuando la
     barra original sale del viewport --}}
<div id="quiz-progress-floating">
    <div class="quiz-progress-label">
        <span id="quiz-fase-label-float">Fase 1 de 3</span>
        <span id="quiz-progress-txt-float">Pregunta 1 de 25</span>
    </div>
    <div class="quiz-progress-track">
        <div class="quiz-progress-fill" id="quiz-progress-fill-float" style="width:4%;"></div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════
     AVISO DE PRIVACIDAD 
     ══════════════════════════════════════════════════════════════════════════ --}}

<style>
    /* ── Overlay de privacidad ── */
    #privacy-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.78);
        z-index: 200;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.25rem;
    }
 
    #privacy-box {
        background: #14141F;
        border: 1px solid rgba(200,168,75,.35);
        border-radius: 16px;
        padding: 2.5rem 2rem;
        max-width: 480px;
        width: 100%;
        max-height: 90vh;
        max-height: 90dvh;
        overflow-y: auto;
        box-shadow: 0 0 40px rgba(200,168,75,.10);
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }
 
    #privacy-box h2 {
        font-family: 'Headland One', serif;
        color: #C8A84B;
        font-size: 1.4rem;
        margin: 0;
        letter-spacing: .06em;
    }
 
    #privacy-box p {
        color: #B0A898;
        font-size: .88rem;
        line-height: 1.75;
        margin: 0;
    }
 
    .privacy-notice {
        background: rgba(200,168,75,.07);
        border: 1px solid rgba(200,168,75,.2);
        border-radius: 8px;
        padding: .85rem 1rem;
        color: #F0EAD8;
        font-size: .82rem;
        line-height: 1.7;
    }
 
    /* Checkbox personalizado */
    .privacy-check-wrap {
        display: flex;
        align-items: flex-start;
        gap: .85rem;
        cursor: pointer;
        user-select: none;
    }
    .privacy-check-wrap input[type="checkbox"] {
        display: none;
    }
    .privacy-circle {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 2px solid #8D6627;
        flex-shrink: 0;
        margin-top: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .2s, border-color .2s;
        background: transparent;
    }
    .privacy-circle svg {
        opacity: 0;
        transition: opacity .2s;
    }
    .privacy-check-wrap input:checked ~ .privacy-circle {
        background: #C6A050;
        border-color: #C6A050;
    }
    .privacy-check-wrap input:checked ~ .privacy-circle svg {
        opacity: 1;
    }
    .privacy-check-label {
        font-size: .85rem;
        color: #B0A898;
        line-height: 1.6;
    }
    .privacy-check-label a {
        color: #E8C96A;
        text-decoration: underline;
        cursor: pointer;
    }
    .privacy-check-label a:hover { color: #fff; }
 
    /* Botón continuar */
    #privacy-continue {
        width: 100%;
        padding: .85rem;
        background: linear-gradient(135deg, #C6A050, #8D6627);
        border: none;
        border-radius: 6px;
        color: #1A1000;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        opacity: .4;
        pointer-events: none;
        transition: opacity .2s;
        font-family: inherit;
        letter-spacing: .04em;
    }
    #privacy-continue.activo {
        opacity: 1;
        pointer-events: auto;
    }
 
    /* ── Modal de políticas ── */
    #policy-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.82);
        z-index: 300;
        align-items: center;
        justify-content: center;
        padding: 1.25rem;
    }
    #policy-modal.abierto { display: flex; }
 
    #policy-box {
        background: #14141F;
        border: 1px solid rgba(200,168,75,.3);
        border-radius: 16px;
        max-width: 620px;
        width: 100%;
        max-height: 85vh;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 0 40px rgba(200,168,75,.10);
    }
    #policy-box::-webkit-scrollbar { width: 5px; }
    #policy-box::-webkit-scrollbar-track { background: #0D0D1A; }
    #policy-box::-webkit-scrollbar-thumb { background: #4A3010; border-radius: 10px; }
 
    .policy-header {
        padding: 1.75rem 2rem 1rem;
        border-bottom: 1px solid rgba(200,168,75,.15);
        position: sticky;
        top: 0;
        background: #14141F;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .policy-header h3 {
        font-family: 'Headland One', serif;
        color: #C8A84B;
        font-size: 1.2rem;
        margin: 0;
    }
    .policy-close {
        background: none;
        border: none;
        color: #707085;
        font-size: 1.4rem;
        cursor: pointer;
        line-height: 1;
        transition: color .2s;
    }
    .policy-close:hover { color: #E8C96A; }
 
    .policy-body {
        padding: 1.5rem 2rem 2rem;
        color: #B0A898;
        font-size: .87rem;
        line-height: 1.85;
    }
    .policy-body h4 {
        color: #E8C96A;
        font-size: .82rem;
        text-transform: uppercase;
        letter-spacing: .12em;
        margin: 1.5rem 0 .5rem;
    }
    .policy-body h4:first-child { margin-top: 0; }
    .policy-body p { margin: 0 0 .75rem; color: #B0A898; }
    .policy-body strong { color: #F0EAD8; }
 
    @media (max-width: 500px) {
        #privacy-box { padding: 2rem 1.25rem; }
        .policy-body { padding: 1.25rem; }
        .policy-header { padding: 1.25rem 1.25rem .85rem; }
    }
</style>

{{-- ── Overlay de privacidad ── --}}
<div id="privacy-overlay" style="display:none;">
    <div id="privacy-box">

        <h2>Antes de continuar</h2>

        <p>
            Para ofrecerte la mejor experiencia en el Quiz de Selección de Casa,
            necesitamos que leas y aceptes el Aviso de Privacidad Integral de la
            Universidad Tecnológica de León.
        </p>

        {{-- Aviso importante --}}
        <div class="privacy-notice">
            ⚠️ <strong style="color:#E8C96A;">Nota importante:</strong>
            La Universidad Tecnológica de León <strong>no cuenta con áreas de ciencias
            de la salud</strong> (medicina, enfermería, biología, etc.). Los resultados del quiz están
            orientados exclusivamente a las carreras y dominios que ofrece la UTL.
        </div>

        {{-- Checkbox de aceptación --}}
        <label class="privacy-check-wrap" for="privacy-cb">
            <input type="checkbox" id="privacy-cb" onchange="toggleContinue(this)">
            <span class="privacy-circle">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 6L5 9L10 3" stroke="#1A1000" stroke-width="2"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <span class="privacy-check-label">
                He leído y acepto el
                <a onclick="abrirPolitica(event)">Aviso de Privacidad Integral</a>
                de la Universidad Tecnológica de León.
            </span>
        </label>

        <button id="privacy-continue" onclick="aceptarPrivacidad()">
            Continuar al Quiz →
        </button>

    </div>
</div>

{{-- ── Modal: Aviso de Privacidad Integral UTL (texto completo) ── --}}
<div id="policy-modal" onclick="cerrarPoliticaOverlay(event)">
    <div id="policy-box">

        <div class="policy-header">
            <h3>Aviso de Privacidad Integral — UTL</h3>
            <button class="policy-close" onclick="cerrarPolitica()">&#x2715;</button>
        </div>

        <div class="policy-body">

            <p class="intro">
                La <strong>Universidad Tecnológica de León (UTL)</strong>, conforme a lo establecido en los
                artículos 3, fracción I, 34, 35, 36, 37, 38, 39, 40, 42, así como lo dispuesto en el
                Título Tercero, Capítulo Primero de la Ley de Protección de Datos Personales en
                Posesión de Sujetos Obligados para el Estado de Guanajuato, publicada en el
                Periódico Oficial del Gobierno del Estado de Guanajuato el 14 de julio de 2017,
                informa que la protección de los datos personales es un derecho humano
                vinculado a la protección de la privacidad y da a conocer el presente Aviso de
                Privacidad Integral.
            </p>

            <h4>I. Denominación del Responsable</h4>
            <p>
                La <strong>Universidad Tecnológica de León</strong>: es un Organismo Público Descentralizado
                de la Administración Pública Estatal, con personalidad jurídica y patrimonio
                propios, de conformidad con el Decreto Gubernativo número 108 publicado en
                el Periódico Oficial de Gobierno del Estado de Guanajuato de fecha 9 de
                diciembre de 1994, reestructurado a través del Decreto Gubernativo número
                240 publicado el 18 de octubre de 2005 en el Periódico Oficial de Gobierno del
                Estado de Guanajuato, número 166, Cuarta Parte.
            </p>

            <h4>II. Domicilio del Responsable</h4>
            <p>
                La <strong>Universidad Tecnológica de León</strong> se encuentra ubicada en Boulevard
                Universidad Tecnológica, número 225, Colonia San Carlos, C.P. 37670, en la
                ciudad de León, Guanajuato.
            </p>

            <h4>III. Los Datos Personales que Serán Sometidos a Tratamiento, Identificando Aquéllos que Sean Sensibles</h4>
            <p>
                Los datos personales, se refieren a cualquier información concerniente a una
                persona física identificada o identificable y los datos personales sensibles, son
                aquellos que afecten a la esfera más íntima de su titular, o cuya utilización
                indebida pueda dar origen a discriminación o conlleve un riesgo grave para éste.
            </p>
            <p>
                Los datos personales y sensibles que recaba la Universidad Tecnológica de
                León, y que son sometidos a tratamiento o transferencia, dependiendo del
                proceso para el cuál se recaben, entre otros son:
            </p>
            <ul>
                <li><strong>Datos de Identificación:</strong> Nombre completo, estado civil, registro federal de
                    contribuyentes (RFC), clave única de registro de población (CURP), número de
                    seguridad social, acta de nacimiento, lugar y fecha de nacimiento,
                    nacionalidad, edad, fotografía, firma autógrafa, nombre del padre y la madre,
                    tutor o tutora del alumno o alumna.</li>
                <li><strong>Datos de Contacto:</strong> Domicilio, correo electrónico, teléfono fijo, teléfono
                    celular, que nos permita mantener contacto con estudiantes, padres de familia,
                    personal docente y administrativo, en caso de emergencia, así como de
                    proveedores.</li>
                <li><strong>Datos Laborales:</strong> Puesto actual y anterior, teléfono institucional y correo
                    electrónico, fecha de ingreso al puesto que actualmente ocupa o en anteriores
                    empleos y lo concerniente a trayectoria laboral, para procesos de
                    reclutamiento, selección, contratación, nombramiento, evaluación y
                    capacitación.</li>
                <li><strong>Datos sobre características físicas y aspectos particulares:</strong> Fotografía, si
                    pertenece a alguna etnia o maneja alguna lengua indígena, estado de salud,
                    historial clínico, señas particulares, sexo, tipo de sangre, peso, talla, alergias,
                    enfermedades físicas y psicológicas, tratamientos médicos o psicológicos,
                    discapacidades.</li>
                <li><strong>Datos académicos:</strong> Nombre, domicilio y clave centro de trabajo de la
                    institución educativa de nivel medio superior de procedencia del alumnado,
                    trayectoria educativa como calificaciones, promedio de egreso y certificados
                    emitidos por otras Instituciones, idiomas, título profesional, número de cedula
                    profesional, certificados y constancias de estudios, así como antecedentes
                    escolares.</li>
                <li><strong>Datos patrimoniales o financieros:</strong> Bienes muebles e inmuebles, ingresos y
                    egresos personales, ingresos y egresos de madres, padres, o de quienes
                    dependa económicamente, referencias personales, recibos de nómina y en
                    general datos sobre la situación económica de la familia. Así como aquellos que
                    permitan identificar si se trata de una persona moral o persona física y su
                    cumplimiento en materia fiscal y administrativa.</li>
                <li><strong>Datos biométricos:</strong> Huella dactilar para control de entradas y salidas de la
                    jornada laboral de docentes y administrativos.</li>
                <li><strong>Datos sobre afiliación sindical:</strong> Pertenencia a un sindicato.</li>
            </ul>
            <p>
                Los datos sensibles que puede recabar la Universidad Tecnológica de León,
                son los relativos a afiliación sindical, de salud, origen étnico o racial y
                biométricos.
            </p>
            <p>
                Todos los datos personales y sensibles recabados de estudiantes, personal
                docente y administrativo, y público en general, serán utilizados para la
                adecuada función y prestación de servicios educativos y administrativos que
                brinda la Universidad Tecnológica de León.
            </p>
            <p>
                Para las finalidades señaladas en el presente Aviso de Privacidad, la
                Universidad Tecnológica de León, podrá recabar datos personales de distintas
                formas; tales como, que sean proporcionados de manera directa por el titular;
                cuando se visite la página de internet institucional o se utilicen los servicios en
                línea, así como cuando se obtenga información a través de otras fuentes que
                están permitidas por las disposiciones legales aplicables.
            </p>

            <h4>IV. Las Finalidades del Tratamiento para las Cuales se Obtienen los Datos Personales</h4>
            <p>
                Los datos personales otorgados ante las áreas administrativas y académicas
                de la Universidad se integran a los respectivos expedientes internos relativos al
                trámite y/o servicio que corresponda, siendo resguardado por la misma área
                que los recibe para las finalidades en cada caso específico por las cuales se
                solicitaron, siendo las siguientes:
            </p>

            <span class="subsection">a) En materia de servicios académicos.</span>
            <p>
                Para recabar información indispensable a efecto de brindar los servicios
                escolares que ofrece la Universidad, de acuerdo con los programas
                académicos vigentes, por lo cual se requiere recabar datos personales de
                menores de edad y sus padres o tutores si es el caso, o de ciudadanos
                interesados en ingresar como estudiantes de la Universidad; de igual forma, se
                recabará información para actos consistentes en: 1. Admisión, 2. Inscripción, 3.
                Reinscripción, 4. Reincorporación por baja, 5. Proceso de recuperación, 6.
                Proceso de recuperación y extraordinario, 7. Estadías, 8. Tutorías; 9. Titulación; 10.
                Equivalencias, 11. Revalidaciones, 12. Constancias de estudios, 13. Actividades
                extracurriculares, 14. Préstamo de material bibliográfico, deportivo o de
                cómputo; 15. Cédula profesional; 16. Becas y diversos apoyos a través de
                programas; 17. La identificación de posibles beneficiarios para el otorgamiento
                de una beca; 18. Cualquier otro servicio escolar que sea indispensable o tenga
                relación con la estadía académica del alumnado, 19.- Falta de atención
                psicopedagógica.
            </p>

            <span class="subsection">b) En materia de recursos humanos.</span>
            <p>
                Para cualquier trámite de índole laboral, se recabarán datos laborales y
                profesionales concernientes a la trayectoria laboral y académica del personal
                a contratar, así como para procesos de reclutamiento, selección, contratación,
                nombramiento, evaluación, capacitación y cualquier otro que tenga relación
                directa con los derechos y obligaciones laborales de las personas trabajadoras
                de la Universidad Tecnológica de León.
            </p>

            <span class="subsection">c) En materia administrativa.</span>
            <p>
                Para trámites legales, relativos a actos y contratos que lleven a cabo y celebre
                la Universidad Tecnológica de León, en materia de adquisiciones y de
                prestación de servicios conforme a la Ley de Contrataciones Públicas para el
                Estado de Guanajuato; el Reglamento de la Ley de Contrataciones Públicas
                para el Estado de Guanajuato para la Administración Pública Estatal; los
                lineamientos que al afecto emita la Secretaría de finanzas, Inversión y
                Administración; y demás disposiciones legales y administrativas aplicables; así
                como lo concerniente a la celebración de convenios de colaboración o
                coordinación entre la Universidad Tecnológica de León, con otros sujetos
                obligados y particulares. Tramitación de procedimientos administrativos,
                penales, civiles, laborales y otros, así como atender recomendaciones emitidas
                por Organismos Garantes de Derechos Humanos. Para integrar o modificar las
                bases de datos de nuestros sistemas electrónicos: para efectos operativos y
                estadísticos.
            </p>

            <h4>V. El Fundamento Legal que Faculta Expresamente al Responsable para Llevar a Cabo el Tratamiento de Datos Personales</h4>
            <p>
                El tratamiento y transferencia de los datos personales y datos personales
                sensibles se efectúa con apego en los artículos 3o., 6o., apartado A, fracciones
                II y III, y 16, párrafo segundo, de la Constitución Política de los Estados Unidos
                Mexicanos; 3o., 14, inciso B), fracción III, de la Constitución Política para el Estado
                de Guanajuato; 3o., 34 y 45, de la Ley Orgánica del Poder Ejecutivo para el
                Estado de Guanajuato; la Ley General de Educación; la Ley General de
                Educación Superior; la Ley de Educación para el Estado de Guanajuato; 116 de
                la Ley General de Transparencia y Acceso a la Información Pública; 25, fracción
                VI, 65, fracción III, 76 y 77, de la Ley de Transparencia y Acceso a la Información
                Pública para el Estado de Guanajuato; 1 y 3, fracciones IX y X, de la Ley General
                de Protección de Datos Personales en Posesión de Sujetos Obligados; 3,
                fracciones I, VI, VII, VIII y IX, 13, 16, 20, 22, 34, 36, 37, 38, 39, 40, 42, 62, 63, 64, 65,
                66, 67, 68, 78, 96, 97, 98, 99, 100, 101 de la Ley de Protección de Datos Personales
                en Posesión de Sujetos Obligados para el Estado de Guanajuato; Capítulo VI de
                los Lineamientos Generales en Materia de Clasificación y Desclasificación de la
                Información, así como para la elaboración de versiones públicas; 125 y 126 de
                los Lineamientos Generales para la Administración de los Recursos Humanos
                adscritos a las Secretarías y Entidades de la Administración Pública Estatal; el
                Decreto Gubernativo número 240 publicado el 18 de octubre de 2005 en el
                Periódico Oficial de Gobierno del Estado de Guanajuato, número 166, Cuarta
                Parte; así como lo establecido en los artículos 1, 15, 18, 19 y 93 del Reglamento
                Académico de la Universidad Tecnológica de León y lo señalado en su artículo
                1 y Capítulo Tercero por el Reglamento de Ingreso, Promoción y Permanencia
                del Personal Académico de la Universidad Tecnológica de León.
            </p>

            <h4>VI. De las Transferencias</h4>
            <p>
                Se hace de conocimiento que los datos personales y sensibles proporcionados
                podrán ser transmitidos a otras autoridades siempre y cuando los datos
                transferidos tengan como finalidad ser utilizados para el ejercicio de facultades
                propias de las mismas autoridades, compatible o análogas con la finalidad que
                motivó el tratamiento de los datos personales; además de otras transmisiones
                previstas en el artículo 97 de la Ley de Protección de Datos Personales en
                Posesión de Sujetos Obligados para el Estado de Guanajuato. Así como cuando
                la transferencia sea legalmente exigida para la investigación y persecución de
                los delitos, así como la procuración o administración de justicia; cuando sea
                precisa para el reconocimiento, ejercicio o defensa de un derecho ante
                autoridad competente, siempre y cuando medie el requerimiento de esta
                última; cuando sea necesaria para la prevención o el diagnóstico médico, la
                prestación de asistencia sanitaria, el tratamiento médico o la gestión de
                servicios sanitarios, siempre y cuando dichos fines sean acreditados; cuando se
                precise para el mantenimiento o cumplimiento de una relación jurídica entre el
                responsable y el titular, o cuando sea necesaria por virtud de un contrato
                celebrado o por celebrar en interés del titular, por el responsable y un tercero.
            </p>
            <p>
                Nos comprometemos a que los mismos serán tratados bajo las más estrictas
                medidas de seguridad que garanticen su confidencialidad.
            </p>
            <p>
                También se informa al titular que <strong>no se realizarán</strong> transferencias de datos
                personales o sensibles que requieran de su consentimiento, sin la manifestación
                expresa.
            </p>

            <h4>VII. Mecanismos y Medios Disponibles para que el Titular de los Datos Personales Pueda Manifestar su Negativa para el Tratamiento de sus Datos Personales</h4>
            <p>
                La Universidad Tecnológica de León, a través de las áreas administrativas y
                académicas ante las cuales se proporcionen los datos personales, pondrá a
                consideración del ciudadano, el formato para la autorización o no de la
                transferencia de los datos personales a otras autoridades, cuyo tratamiento sea
                susceptible de transferencia.
            </p>
            <p>
                Ofrece los medios para controlar el uso ajeno y destino de la información
                personal, con el propósito de impedir su tráfico ilícito y la potencial vulneración
                de la dignidad del titular de los datos, de manera que de conformidad con
                lo establecido en el artículo 78 de la Ley de Protección de Datos Personales
                en Posesión de Sujetos Obligados para el Estado de Guanajuato, puede ejercer
                sus derechos ARCO por el acrónimo de Acceso, Rectificación, Cancelación y
                Oposición de Datos Personales, a través de los cuales tiene la facultad de:
            </p>
            <ul>
                <li>Conocer en todo momento quién dispone de sus datos y para qué están siendo utilizados.</li>
                <li>Solicitar rectificación de sus datos en caso de que resulten incompletos o inexactos.</li>
                <li>Solicitar la cancelación de estos por no ajustarse a las disposiciones aplicables.</li>
                <li>Oponerse al uso de sus datos si es que los mismos fueron obtenidos sin su consentimiento.</li>
            </ul>
            <p>
                A efecto de garantizar la debida protección de sus datos personales, además
                de establecer los derechos ARCO, la ley en la materia incluye una serie de
                principios rectores en el tratamiento de este tipo de datos como son: el de
                finalidad, calidad, consentimiento, deber de información, seguridad,
                confidencialidad, disponibilidad y temporalidad.
            </p>
            <p>
                El incumplimiento de estos principios por parte de quienes detentan y/o
                administran sus datos constituye una vulneración a su protección y tiene como
                consecuencia una sanción.
            </p>

            <h4>VIII. Mecanismos y Medios Disponibles para que el Titular de los Datos Personales Pueda Manifestar su Negativa para el Tratamiento de sus Datos Personales</h4>
            <p>
                La Universidad Tecnológica de León, informa que la <strong>«Unidad de Transparencia
                del Poder Ejecutivo del Estado de Guanajuato»</strong>, es la unidad administrativa
                responsable del sistema de datos personales; y el lugar en donde el interesado
                podrá ejercer sus derechos de acceso, rectificación, cancelación y oposición
                al tratamiento de datos personales (ARCO).
            </p>

            <h4>IX. El Domicilio de la Unidad de Transparencia</h4>
            <p>
                La Universidad Tecnológica de León, informa que las oficinas de la <strong>Unidad de
                Transparencia del Poder Ejecutivo del Estado de Guanajuato</strong>, se encuentran
                ubicadas en calle San Sebastián número 78, Zona Centro, Guanajuato,
                Guanajuato. C.P. 36000. con los teléfonos 473 73 51500 ext. 2272, en un horario
                de atención de lunes a viernes de 08:30 a 16:00 horas; o bien a través del correo
                electrónico <a href="mailto:unidadtransparencia@guanajuato.gob.mx">unidadtransparencia@guanajuato.gob.mx</a>.
            </p>

            <h4>X. Los Medios a Través de los Cuales el Responsable Comunicará a los Titulares los Cambios al Aviso de Privacidad</h4>
            <p>
                La Universidad Tecnológica de León, informa que los cambios a su Aviso de
                Privacidad <em>(Simplificado e Integral)</em> se comunicarán por correo electrónico
                institucional o a través de la página institucional en Internet, en donde podrá
                consultar la última versión del Aviso de Privacidad:
                <a href="http://www.utleon.edu.mx" target="_blank" rel="noopener">http://www.utleon.edu.mx</a>.
            </p>

        </div>
    </div>
</div>

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
                   Descubre qué casa académica representa mejor tus talentos, intereses y fortalezas dentro de la Universidad Tecnológica de León.
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
            <div class="quiz-progress-wrap" id="quiz-progress-wrap">
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

            {{-- Speak / disclaimer del quiz — solo visible en Fase 1 --}}
            <div class="quiz-disclaimer" id="quiz-disclaimer">
                <p><span><strong>No hay respuestas correctas o incorrectas</strong> — responde según lo que realmente sientes, no lo que crees que "deberías" contestar.</span></p>
                <p><span>Contestar este quiz <strong>no garantiza tu admisión</strong> a la Universidad Tecnológica de León; es una herramienta de orientación, no un proceso de admisión.</span></p>
                <p><span>El resultado <strong>no es definitivo</strong>: es una guía para ayudarte a explorar opciones, no una etiqueta permanente sobre lo que debes estudiar.</span></p>
                <p><span>Contesta de la manera <strong>más honesta posible</strong>. Entre más sincero seas, más útil será el resultado para ti.</span></p>
                <p><span>Tómate tu tiempo: no hay límite ni penalización por pensar bien cada respuesta.</span></p>
            </div>

            {{-- Imagen ilustrativa de la fase actual --}}
            <div class="quiz-fase-img-wrap" id="quiz-fase-img-wrap">
                <img id="quiz-fase-img" src="" alt="">
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

                {{-- Top 2 y Top 3 (versión pequeña: solo logo y nombre) --}}
                <div id="stage-4-top23" style="display:flex;gap:.75rem;margin-top:1.25rem;flex-wrap:wrap;"></div>

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

const CASAS_URL = "{{ route('casas') }}";
const RESULTADOS_URL = "{{ route('resultados.guardar') }}";
const CSRF_TOKEN = "{{ csrf_token() }}";

let resultadoGuardado = false;

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
// ── Imágenes ilustrativas por fase del quiz ──────────────────────────────
// fase 1: única para las 25 preguntas generales.
// fase 2: depende del área elegida (TEII = 30 preguntas, EA = 10 preguntas).
// fase 3: única para las 80 preguntas de confirmación.
const FASE_IMAGENES = {
    1:        'imagenes/quiz/nivel1-general.webp',
    '2-TEII': 'imagenes/quiz/nivel2-tecnologico.webp',
    '2-EA':   'imagenes/quiz/nivel2-economico.webp',
    3:        'imagenes/quiz/nivel3-confirmacion.webp',
};

const CARRERAS = {
    DSM:      { nombre:'CODARIS', carrera:'Desarrollo de Software Multiplataforma', dominio:'Tecnologías de la Información', frase:'Cada línea construye el futuro',              imagen:'imagenes/casas/software.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Codaris, los Arquitectos del Código. Eres una persona que convierte ideas abstractas en herramientas reales mediante una combinación única de lógica afilada y curiosidad constante. Prosperas en ambientes que cambian rápido, utilizando tu capacidad de aprender nuevas tecnologías para resolver cualquier reto sin perder el rumbo. Tu mayor virtud es la persistencia: entiendes la programación como un lenguaje vivo donde cada error es una pista y cada solución abre la puerta a algo más grande.' },
    REDES:    { nombre:'HEXANET', carrera:'Infraestructura de Redes Digitales',     dominio:'Tecnologías de la Información', frase:'Conectar es avanzar',                         imagen:'imagenes/casas/redes.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Hexanet, los Guardianes de la Conexión. Eres una persona que mantiene el mundo unido mediante una combinación única de orden metódico y visión estructural. Prosperas en ambientes donde la estabilidad importa, utilizando tu mirada atenta para anticipar fallas antes de que ocurran. Tu mayor virtud es la responsabilidad: entiendes la conectividad como el sistema nervioso de toda organización, donde la seguridad y la disponibilidad se unen para que nada se detenga.' },
    IA:       { nombre:'SYNTHERA',carrera:'Inteligencia Artificial',                dominio:'Tecnologías de la Información', frase:'Pensar más allá de los límites',               imagen:'imagenes/casas/ia.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Synthera, los Forjadores de Mentes Digitales. Eres una persona que desafía lo establecido mediante una combinación única de pensamiento analítico y creatividad audaz. Prosperas en ambientes de investigación constante, utilizando tu curiosidad para enseñar a las máquinas a razonar como nunca antes. Tu mayor virtud es la visión de futuro: entiendes la inteligencia artificial como una herramienta para expandir lo posible, donde los datos y la imaginación se unen para dar forma a lo que viene.' },
    DATOS:    { nombre:'DATHEON', carrera:'Ciencia de Datos',                       dominio:'Tecnologías de la Información', frase:'Los datos cuentan historias',                 imagen:'imagenes/casas/datos.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Datheon, los Oráculos de la Información. Eres una persona que encuentra sentido donde otros solo ven números mediante una combinación única de pensamiento crítico y paciencia analítica. Prosperas en ambientes llenos de información compleja, utilizando tu instinto para detectar patrones que guían decisiones importantes. Tu mayor virtud es la objetividad: entiendes los datos como historias esperando ser contadas, donde la evidencia y la intuición se unen para revelar lo que realmente importa.' },
    MULT:     { nombre:'NEXARIS', carrera:'Entornos Virtuales y Negocios Digitales',dominio:'Tecnologías de la Información', frase:'Imaginar es crear',                           imagen:'imagenes/casas/entornos.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Nexaris, los Tejedores de Mundos. Eres una persona que da vida a realidades nuevas mediante una combinación única de imaginación desbordante y dominio técnico. Prosperas en ambientes donde la creatividad no tiene límites, utilizando tu sensibilidad estética para construir experiencias que la gente recuerda. Tu mayor virtud es la innovación: entiendes lo digital como un lienzo infinito, donde el arte y la tecnología se unen para crear mundos que antes solo existían en la mente.' },
    MECAAUTO: { nombre:'AUTRON',  carrera:'Automatización',                         dominio:'Mecatrónica',                   frase:'La eficiencia es inteligencia aplicada',       imagen:'imagenes/casas/automatizacion.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Autron, los Maestros del Movimiento Autónomo. Eres una persona que convierte procesos complicados en sistemas fluidos mediante una combinación única de precisión técnica y pensamiento lógico. Prosperas en ambientes industriales dinámicos, utilizando tu ingenio para que máquinas y procesos trabajen en perfecta armonía. Tu mayor virtud es la eficiencia: entiendes la automatización como la orquesta silenciosa detrás de cada fábrica, donde el control y la innovación se unen para que todo funcione sin fricción.' },
    MECAOPTO: { nombre:'PRISMARA',carrera:'Optomecatrónica',                        dominio:'Mecatrónica',                   frase:'La precisión guía el camino',                 imagen:'imagenes/casas/optomecatronica.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Prismara, los Artesanos de la Luz. Eres una persona que trabaja en los detalles más finos mediante una combinación única de rigor técnico y sensibilidad casi artística. Prosperas en ambientes que exigen exactitud milimétrica, utilizando tu paciencia para dominar tecnologías que combinan óptica y electrónica. Tu mayor virtud es la precisión: entiendes la luz y los sensores como herramientas de verdad, donde la ciencia y el detalle se unen para medir lo que a simple vista es invisible.' },
    MECASMF:  { nombre:'FLEXION', carrera:'Manufactura Flexible',                   dominio:'Mecatrónica',                   frase:'Adaptarse es evolucionar',                    imagen:'imagenes/casas/manufactura.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Flexion, los Arquitectos de la Adaptación. Eres una persona que encuentra soluciones donde los procesos parecen rígidos mediante una combinación única de pensamiento sistémico y creatividad práctica. Prosperas en ambientes de producción cambiante, utilizando tu capacidad de integrar mecánica, electrónica y software en un mismo diseño. Tu mayor virtud es la versatilidad: entiendes la manufactura como un organismo que debe evolucionar, donde la tecnología y la adaptabilidad se unen para responder a lo que el mercado necesita.' },
    PRO:      { nombre:'OPERION', carrera:'Procesos Productivos',                   dominio:'Ingeniería Industrial',         frase:'La mejora nunca termina',                     imagen:'imagenes/casas/productivos.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Operion, los Guardianes de la Eficiencia. Eres una persona que ve oportunidades de mejora donde otros ven rutina mediante una combinación única de observación aguda y disciplina metódica. Prosperas en ambientes de producción constante, utilizando tu mirada analítica para eliminar lo que sobra y potenciar lo que funciona. Tu mayor virtud es la mejora continua: entiendes cada proceso como algo perfectible, donde el orden y la productividad se unen para elevar la calidad de todo lo que se fabrica.' },
    AUTO:     { nombre:'PISTORIA',carrera:'Automotriz',                             dominio:'Ingeniería Industrial',         frase:'Movimiento con propósito',                    imagen:'imagenes/casas/automotriz.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Pistoria, los Forjadores del Movimiento. Eres una persona que se apasiona por lo que avanza mediante una combinación única de precisión técnica y espíritu competitivo. Prosperas en ambientes de manufactura exigente, utilizando tu liderazgo para elevar la calidad en cada etapa de producción. Tu mayor virtud es el compromiso: entiendes la industria automotriz como un motor en constante evolución, donde la innovación y la eficiencia se unen para llevar el transporte al siguiente nivel.' },
    PLAS:     { nombre:'POLYMOR', carrera:'Moldeo de Plásticos',                    dominio:'Ingeniería Industrial',         frase:'La forma sigue a la innovación',               imagen:'imagenes/casas/plasticos.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Polymor, los Escultores de la Materia. Eres una persona que transforma lo maleable en algo útil mediante una combinación única de precisión técnica y sentido práctico. Prosperas en ambientes de manufactura creativa, utilizando tu atención al detalle para dar forma a productos que la gente usa todos los días. Tu mayor virtud es la innovación aplicada: entiendes el diseño de materiales como un arte funcional, donde la tecnología y la creatividad se unen para moldear literalmente el futuro.' },
    CALZ:     { nombre:'SENDORIA',carrera:'Gestión y Productividad de Calzado',     dominio:'Ingeniería Industrial',         frase:'Cada paso deja huella',                       imagen:'imagenes/casas/calzado.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Sendoria, los Artesanos del Paso. Eres una persona que cuida cada detalle de un proceso mediante una combinación única de sensibilidad creativa y enfoque en la calidad. Prosperas en ambientes donde tradición e industria se encuentran, utilizando tu ojo crítico para mejorar cada etapa de producción. Tu mayor virtud es el trabajo en equipo: entiendes el calzado como una industria que combina arte y eficiencia, donde el diseño y la productividad se unen para dejar huella en cada paso.' },
    MANT:     { nombre:'ENGRAVIA',carrera:'Mantenimiento Industrial',               dominio:'Ingenierías',                   frase:'La excelencia se construye cada día',          imagen:'imagenes/casas/mantenimiento.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Engravia, los Guardianes del Engranaje. Eres una persona que previene el caos antes de que suceda mediante una combinación única de precisión técnica y responsabilidad constante. Prosperas en ambientes industriales exigentes, utilizando tu capacidad de diagnóstico para mantener todo funcionando sin fallas. Tu mayor virtud es el compromiso: entiendes el mantenimiento como el pulso silencioso de toda industria, donde la disciplina y la anticipación se unen para que la excelencia nunca se detenga.' },
    AMBI:     { nombre:'SYLVARA', carrera:'Ambiental y Sustentabilidad',            dominio:'Ingenierías',                   frase:'Proteger hoy para transformar mañana',         imagen:'imagenes/casas/ambiental.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Sylvara, los Custodios de la Tierra. Eres una persona que piensa en las próximas generaciones mediante una combinación única de conciencia ética y rigor científico. Prosperas en ambientes donde la sustentabilidad es prioridad, utilizando tu sentido de responsabilidad para diseñar soluciones que cuidan el entorno. Tu mayor virtud es el compromiso social: entiendes el planeta como un sistema delicado, donde la ciencia y la ética se unen para transformar el presente sin comprometer el mañana.' },
    ELECTRO:  { nombre:'VOLTARA', carrera:'Electromovilidad',                       dominio:'Ingenierías',                   frase:'El futuro se mueve en silencio',               imagen:'imagenes/casas/automotriz.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Voltara, los Pioneros del Silencio Eléctrico. Eres una persona que ve hacia adelante mediante una combinación única de mentalidad innovadora y rigor técnico. Prosperas en ambientes de transformación tecnológica, utilizando tu visión de futuro para liderar la transición hacia una movilidad más limpia. Tu mayor virtud es la audacia: entiendes la electromovilidad como el próximo gran cambio de la industria, donde la sustentabilidad y la tecnología se unen para mover al mundo sin hacer ruido.' },
    LOG:      { nombre:'NAVENTOR',carrera:'Logística',                              dominio:'Ingenierías',                   frase:'Toda ruta tiene un destino',                  imagen:'imagenes/casas/logistica.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Naventor, los Navegantes de la Ruta. Eres una persona que encuentra el camino más eficiente mediante una combinación única de organización estratégica y capacidad de reacción. Prosperas en ambientes donde el tiempo y los recursos son clave, utilizando tu visión global para coordinar cadenas de suministro complejas. Tu mayor virtud es la responsabilidad: entiendes la logística como el pulso invisible que mueve al mundo, donde la planeación y la agilidad se unen para que todo llegue a su destino.' },
    ADM:      { nombre:'LAUREON', carrera:'Administración',                         dominio:'Licenciaturas',                 frase:'Liderar para construir',                       imagen:'imagenes/casas/administracion.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Laureon, los Estrategas del Liderazgo. Eres una persona que organiza el caos y lo convierte en resultados mediante una combinación única de visión estratégica y sentido de responsabilidad. Prosperas en ambientes donde se necesita dirección clara, utilizando tu capacidad de coordinar personas y recursos hacia un mismo objetivo. Tu mayor virtud es el liderazgo: entiendes la administración como el arte de construir estructuras sólidas, donde la ética y la estrategia se unen para hacer que las organizaciones crezcan.' },
    MKT:      { nombre:'NOVARIS', carrera:'Negocios y Mercadotecnia',               dominio:'Licenciaturas',                 frase:'Las ideas iluminan el cambio',                imagen:'imagenes/casas/mercadotecnia.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Novaris, los Visionarios del Mercado. Eres una persona que conecta ideas con personas mediante una combinación única de creatividad estratégica y sensibilidad social. Prosperas en ambientes cambiantes y competitivos, utilizando tu intuición para anticipar lo que el mercado va a querer antes que nadie. Tu mayor virtud es la innovación: entiendes los negocios como un espacio de constante reinvención, donde la comunicación y la estrategia se unen para transformar ideas en marcas que la gente recuerda.' },
    GAST:     { nombre:'FLAMORIA',carrera:'Gastronomía',                            dominio:'Licenciaturas',                 frase:'Crear experiencias para recordar',             imagen:'imagenes/casas/gastronomia2.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Flamoria, los Alquimistas del Sabor. Eres una persona que transforma el caos en excelencia mediante una combinación única de creatividad vibrante y disciplina técnica. Prosperas en ambientes dinámicos, utilizando tu instinto práctico para resolver cualquier reto al instante. Tu mayor virtud es el espíritu de servicio: entiendes la cocina como un arte noble donde la precisión y el cuidado se unen para crear experiencias que nutren el alma.' },
    TUR:      { nombre:'GLOBARIS',carrera:'Turismo',                                dominio:'Licenciaturas',                 frase:'Descubrir conecta culturas',                  imagen:'imagenes/casas/turismo.webp',
        desc:'Tu perfil muestra una afinidad natural con la casa Globaris, los Guardianes del Descubrimiento. Eres una persona que conecta a las personas con el mundo mediante una combinación única de calidez humana y espíritu aventurero. Prosperas en ambientes diversos y en constante movimiento, utilizando tu sensibilidad cultural para crear experiencias memorables. Tu mayor virtud es la empatía: entiendes el turismo como un puente entre culturas, donde la hospitalidad y el descubrimiento se unen para transformar cada viaje en un recuerdo que perdura.' },
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
//  PRIVACIDAD — bloqueo de scroll robusto (fija el body para que la página
//  no se pueda deslizar mientras el modal está abierto, sin importar si el
//  scroll real ocurre en <body> o en <html>).
// ════════════════════════════════════════════════════════════════════════════
let scrollYAntesDelModal = 0;

function bloquearScroll() {
    scrollYAntesDelModal = window.scrollY || document.documentElement.scrollTop || 0;
    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';
    document.body.style.position = 'fixed';
    document.body.style.top = `-${scrollYAntesDelModal}px`;
    document.body.style.left = '0';
    document.body.style.right = '0';
    document.body.style.width = '100%';
}

function desbloquearScroll() {
    document.documentElement.style.overflow = '';
    document.body.style.overflow = '';
    document.body.style.position = '';
    document.body.style.top = '';
    document.body.style.left = '';
    document.body.style.right = '';
    document.body.style.width = '';
    window.scrollTo(0, scrollYAntesDelModal);
}

function toggleContinue(cb) {
    document.getElementById('privacy-continue').classList.toggle('activo', cb.checked);
}
function abrirAviso() {
    document.getElementById('privacy-overlay').style.display = 'flex';
    bloquearScroll();
}
function aceptarPrivacidad() {
    document.getElementById('privacy-overlay').style.display = 'none';
    desbloquearScroll();
    iniciarQuiz();
}
function abrirPolitica(e) { e.preventDefault(); document.getElementById('policy-modal').classList.add('abierto'); }
function cerrarPolitica() { document.getElementById('policy-modal').classList.remove('abierto'); }
function cerrarPoliticaOverlay(e) { if (e.target === document.getElementById('policy-modal')) cerrarPolitica(); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarPolitica(); });

// ════════════════════════════════════════════════════════════════════════════
//  Convierte un nombre de carrera en un "slug" (mismo criterio que Str::slug
//  de Laravel: minúsculas, sin acentos, espacios y símbolos como guiones).
// ════════════════════════════════════════════════════════════════════════════
function slugify(texto) {
    return texto.toString().trim().toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

// ════════════════════════════════════════════════════════════════════════════
//  BARRA DE PROGRESO FLOTANTE (móvil) — sigue al usuario cuando la barra
//  original sale del viewport, mostrando el mismo avance en la parte superior.
// ════════════════════════════════════════════════════════════════════════════
const quizProgressWrapEl  = document.getElementById('quiz-progress-wrap');
const quizProgressFloatEl = document.getElementById('quiz-progress-floating');
const quizNavEl           = document.querySelector('nav');

function posicionarBarraFlotante() {
    if (quizNavEl) quizProgressFloatEl.style.top = quizNavEl.getBoundingClientRect().bottom + 'px';
}
window.addEventListener('resize', posicionarBarraFlotante);

const progressObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        // Solo actuar si la etapa 2 (preguntas) está visible
        const stage2Visible = document.getElementById('stage-2').style.display !== 'none';
        if (!stage2Visible) {
            quizProgressFloatEl.classList.remove('visible');
            return;
        }
        if (entry.isIntersecting) {
            quizProgressFloatEl.classList.remove('visible');
        } else if (entry.boundingClientRect.top < 0) {
            // Solo mostrar cuando la barra original quedó ARRIBA del viewport
            posicionarBarraFlotante();
            quizProgressFloatEl.classList.add('visible');
        }
    });
}, { threshold: 0 });

if (quizProgressWrapEl) progressObserver.observe(quizProgressWrapEl);

function updateProgressUI(pct, faseTxt, progressTxt) {
    document.getElementById('quiz-progress-fill').style.width = pct + '%';
    document.getElementById('quiz-progress-txt').textContent  = progressTxt;
    document.getElementById('quiz-fase-label').textContent    = faseTxt;

    document.getElementById('quiz-progress-fill-float').style.width = pct + '%';
    document.getElementById('quiz-progress-txt-float').textContent  = progressTxt;
    document.getElementById('quiz-fase-label-float').textContent    = faseTxt;
}

// ════════════════════════════════════════════════════════════════════════════
//  LÓGICA DEL QUIZ
// ════════════════════════════════════════════════════════════════════════════
function iniciarQuiz() {
    resultadoGuardado = false;

    estado = {
        fase: 1,
        preguntas: NIVEL1,
        indice: 0,
        respuestas: {},
        areaElegida: null,
        carreraFinal: null
    };

    goToStage(2);
    quizProgressFloatEl.classList.add('activo');
    renderPregunta();
}

function renderPregunta() {
    const p = estado.preguntas[estado.indice];
    const total = estado.preguntas.length;
    const current = estado.indice + 1;

    // Progreso
    const pct = Math.round((current / total) * 100);
    updateProgressUI(pct, `Fase ${estado.fase} de 3`, `Pregunta ${current} de ${total}`);

    // Fase badge
    const faseMap = { 1:'Intereses Generales', 2:'Actividades Específicas', 3:'Confirmación' };
    document.getElementById('quiz-badge').textContent = faseMap[estado.fase] || '';

    // Speak/disclaimer: solo visible durante la Fase 1
    document.getElementById('quiz-disclaimer').style.display = (estado.fase === 1) ? 'flex' : 'none';

    // Imagen ilustrativa según la fase (y el área elegida si es fase 2)
    const imgKey = estado.fase === 2 ? ('2-' + estado.areaElegida) : estado.fase;
    const imgSrc = FASE_IMAGENES[imgKey];
    document.getElementById('quiz-fase-img').src = imgSrc ? '/' + imgSrc : '';

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

// ── Nivel 2 → puntúa carreras del área elegida y saca el TOP 3 ──────────
function procesarNivel2() {
    const scores = {};

    estado.preguntas.forEach(p => {
        const val = estado.respuestas[p.id] ?? 0;
        scores[p.carrera] = (scores[p.carrera] ?? 0) + val;
    });

    estado.nivel2Scores = scores;

    // K-ésimo mayor: ordena las carreras del área elegida y toma las 3 con más puntos
    const ranking = Object.entries(scores).sort((a, b) => b[1] - a[1]);
    estado.top3 = ranking.slice(0, 3).map(([carrera]) => carrera);

    // Pasa a Nivel 3: confirmación, pero solo con las preguntas de esas 3 carreras (4 c/u = 12 preguntas)
    estado.fase      = 3;
    estado.preguntas = NIVEL3.filter(p => estado.top3.includes(p.carrera));
    estado.indice    = 0;
    renderPregunta();
}

// ── Nivel 3 (confirmación) → calcula la carrera ganadora entre el TOP 3 ──
function procesarNivel3() {
    const scores = {};

    // Solo se evalúan las carreras del top-3 (estado.preguntas ya viene filtrado)
    estado.preguntas.forEach(p => {
        const val = estado.respuestas[p.id] ?? 0;
        scores[p.carrera] = (scores[p.carrera] ?? 0) + val;
    });

    const ranking = Object.entries(scores).sort((a, b) => b[1] - a[1]);

    estado.carreraFinal = ranking[0]?.[0] ?? estado.top3[0];
    estado.scoreFinal   = scores;
    estado.rankingFinal = ranking.map(([carrera]) => carrera); // orden final: 1°, 2°, 3°

    // Va a la pantalla de procesando
    quizProgressFloatEl.classList.remove('activo');
    quizProgressFloatEl.classList.remove('visible');
    goToStage(3);
}

async function guardarResultado(casa) {
    if (resultadoGuardado) {
        return;
    }

    try {
        const respuesta = await fetch(RESULTADOS_URL, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            body: JSON.stringify({
                nombre_casa: casa.nombre
            })
        });

        const datos = await respuesta.json();

        if (!respuesta.ok) {
            throw new Error(
                datos.message || 'No fue posible guardar el resultado.'
            );
        }

        resultadoGuardado = true;

        console.log('Resultado guardado correctamente:', datos);
    } catch (error) {
        console.error('Error al guardar el resultado:', error);
    }
}

// ── Muestra resultado ─────────────────────────────────────────────────────
function mostrarResultado() {
    const key = estado.carreraFinal;
    const c = CARRERAS[key] || CARRERAS['DSM'];

    document.getElementById('stage-4-result-title').textContent = c.nombre;
    document.getElementById('stage-4-casa-nombre').textContent = c.carrera;
    document.getElementById('stage-4-frase').textContent = '"' + c.frase + '"';
    document.getElementById('stage-4-desc').textContent = c.desc;
    document.getElementById('stage-4-img').src = '/' + c.imagen;

    // Tarjeta para compartir en Instagram
    document.getElementById('ig-img').src = '/' + c.imagen;
    document.getElementById('ig-title').textContent = c.nombre;
    document.getElementById('ig-casa').textContent = c.carrera;
    document.getElementById('ig-frase').textContent = '"' + c.frase + '"';

    // Dominio académico
    const domEl = document.getElementById('stage-4-scores');

    domEl.innerHTML = `
        <span style="font-size:.72rem;text-transform:uppercase;letter-spacing:.1em;
                     color:#707085;display:block;margin-bottom:.4rem;">
            Dominio académico
        </span>

        <span style="background:rgba(200,168,75,.1);
                     border:1px solid rgba(200,168,75,.3);
                     border-radius:20px;
                     padding:.35rem .9rem;
                     color:#E8C96A;
                     font-size:.82rem;">
            ${c.dominio}
        </span>
    `;

    // Segundo y tercer lugar
    const top23El = document.getElementById('stage-4-top23');
    const rankingRestante = (estado.rankingFinal || []).slice(1, 3);

    top23El.innerHTML = rankingRestante.map((carreraKey, i) => {
        const cc = CARRERAS[carreraKey];

        if (!cc) {
            return '';
        }

        const lugar = i === 0 ? '2do lugar' : '3er lugar';
        const slug = slugify(cc.carrera);

        return `
            <a class="mini-result" href="${CASAS_URL}?casa=${slug}">
                <img src="/${cc.imagen}" alt="${cc.nombre}">

                <div class="mini-result-info">
                    <span class="mini-result-rank">${lugar}</span>

                    <span class="mini-result-name">
                        ${cc.nombre}
                        <span class="mini-result-carrera">
                            (${cc.carrera})
                        </span>
                    </span>
                </div>
            </a>
        `;
    }).join('');

    // Mostrar la pantalla final
    goToStage(4);

    // Guardar únicamente el resultado ganador
    guardarResultado(c);
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

function applyMobileLayout() {
    const inner = document.getElementById('stage-1-inner');
    if (!inner) return;
    inner.classList.toggle('mobile-layout', window.innerWidth <= 768);
}
applyMobileLayout();
window.addEventListener('resize', applyMobileLayout);
</script>
@endpush