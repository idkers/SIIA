@extends('layouts.app')
@section('title', 'Quiz — NOVA')

@section('content')

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<style>
    /* ── Layout general: footer siempre al fondo ── */
    html, body { height: 100%; margin: 0; }
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    /* Anular cualquier min-height que el layout padre ponga en main u otros wrappers */
    body > main,
    body > .main-content,
    body > #app,
    body > #content,
    body > .content {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: unset !important;
    }
    /* El wrapper del contenido de @yield('content') debe crecer */
    .page-content-wrapper {
        flex: 1 0 auto;
        display: flex;
        flex-direction: column;
    }
    /* El footer nunca crece, se queda al fondo */
    #footer-main { flex-shrink: 0; }

    /* ── Navbar ── */
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

    /* ── Stage wrap ── */
    .stage-wrap {
        padding: 2rem;
        /* Permite que cada etapa llene el espacio vertical disponible */
        flex: 1;
        display: flex;
        flex-direction: column;
        /* Evita desbordamiento horizontal */
        overflow-x: hidden;
        box-sizing: border-box;
        width: 100%;
    }
    @media (max-width: 768px) {
        .stage-wrap { padding: .6rem !important; }
    }
    .stage {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .stage-wrap > section {
        flex: 1;
    }

    /* ── ETAPA 1 — base (desktop) ── */
    #stage-1-inner {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        min-height: 550px;
        padding: 4rem;
        gap: 2rem;
    }
    #stage-1-title { font-size: 4rem; }
    #stage-1-img   { max-width: 820px; width: 100%; display: block; }

    /* mobile — clase aplicada por JS para garantizar que funcione */
    #stage-1-inner.mobile-layout {
        grid-template-columns: 1fr !important;
        padding: 2rem 1rem !important;
        min-height: auto !important;
        text-align: center !important;
        /* Evita que el contenido se desborde */
        overflow: hidden !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    #stage-1-inner.mobile-layout #stage-1-title {
        /* clamp: nunca mas grande de lo que cabe */
        font-size: clamp(1.6rem, 8vw, 2.4rem) !important;
        line-height: 1.15 !important;
        word-break: break-word !important;
        overflow-wrap: break-word !important;
    }
    #stage-1-inner.mobile-layout #stage-1-img-wrap {
        order: -1;
        display: flex !important;
        justify-content: center !important;
        width: 100% !important;
    }
    #stage-1-inner.mobile-layout #stage-1-img {
        width: 65vw !important;
        max-width: 65vw !important;
        margin: 0 auto !important;
    }
    #stage-1-inner.mobile-layout #stage-1-desc {
        max-width: 100% !important;
        font-size: .9rem !important;
        line-height: 1.7 !important;
    }
    #stage-1-inner.mobile-layout #stage-1-btn {
        width: 100% !important;
        box-sizing: border-box !important;
    }

    /* ── ETAPA 2 ── */
    #stage-2-inner {
        padding: 2.5rem 2rem;
        min-height: 420px;
    }
    #stage-2-ref-img {
        width: 200px;
        height: 200px;
        flex-shrink: 0;
    }
    #stage-2-btn { align-self: center; }

    @media (max-width: 768px) {
        #stage-2-inner { padding: 2rem 1.25rem; min-height: auto; }
        /* Imagen de referencia usable en móvil */
        #stage-2-ref-img {
            width: min(75vw, 300px) !important;
            height: min(75vw, 300px) !important;
        }
        #stage-2-btn { width: 100%; }
    }

    /* ── ETAPA 3 ── */
    #stage-3-inner { padding: 2.5rem 2rem; }
    #stage-3-video { width: 220px; }

    @media (max-width: 768px) {
        #stage-3-inner {
            padding: 2rem 1rem !important;
            width: 100% !important;
            box-sizing: border-box !important;
            overflow: hidden !important;
            align-items: center !important;
        }
        #stage-3-title { font-size: 2rem !important; }
        #stage-3-video-wrap {
            width: 85vw !important;
            max-width: 85vw !important;
            margin: 1rem auto !important;
            box-sizing: border-box !important;
        }
        #stage-3-video {
            width: 100% !important;
            height: auto !important;
        }
        #stage-3-btn { width: 100% !important; box-sizing: border-box !important; }
    }

    /* ── ETAPA 4 ── */
    #stage-4-inner {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        min-height: 550px;
        padding: 4rem;
        gap: 2rem;
    }
    #stage-4-result-title { font-size: 5rem; }
    #stage-4-img          { max-width: 500px; width: 100%; }
    #stage-4-btns         { display: flex; gap: 1rem; margin-top: 2rem; flex-wrap: wrap; }

    @media (max-width: 768px) {
        #stage-4-inner {
            grid-template-columns: 1fr !important;
            padding: 2rem 1rem !important;
            min-height: auto !important;
            text-align: left !important;
            overflow: hidden !important;
            box-sizing: border-box !important;
            width: 100% !important;
        }
        #stage-4-img-wrap { display: flex; justify-content: center; order: -1; }
        #stage-4-img      { max-width: min(85vw, 380px) !important; width: 100% !important; }
        #stage-4-result-title {
            font-size: clamp(1.6rem, 7vw, 2.2rem) !important;
            word-break: break-word !important;
            line-height: 1.2 !important;
        }
        #stage-4-desc {
            max-width: 100% !important;
            font-size: .9rem !important;
            line-height: 1.7 !important;
        }
        #stage-4-btns { flex-direction: column; }
        #stage-4-btns a,
        #stage-4-btns button {
            width: 100% !important;
            text-align: center !important;
            box-sizing: border-box !important;
        }
    }

    /* ── FOOTER ── */
    #footer-grid { display:flex; justify-content:space-around; flex-wrap:wrap; gap:3rem; }

    @media (max-width: 600px) {
        #footer-main { padding: 2.5rem 1.25rem !important; }
        #footer-grid { flex-direction: column; gap: 2rem; }
        #footer-grid > div { max-width: 100% !important; }
        #footer-grid h3 { font-size: 1.15rem !important; }
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
    <a href="{{ route('quiz') }}" style="color:#E8C96A;">Quiz</a>
    <a href="{{ route('recorrido') }}">Recorrido</a>
    <a href="{{ route('dominios') }}">Dominios</a>
    <a href="{{ route('casas') }}">Casas</a>
    <a href="{{ route('ingresar') }}">Ingresar</a>
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
<div id="privacy-overlay">
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
            de la salud</strong> (medicina, enfermería, química,
            biología, etc.). Los resultados del quiz están
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

{{-- ═══ ETAPA 1: Inicio del quiz ══════════════════════════════════════════ --}}
<div id="stage-1" class="stage">
    <div class="stage-wrap">
        <section id="stage-1-inner"
                 style="background:linear-gradient(rgba(6,6,15,.85),rgba(6,6,15,.95));
                        border:1px solid #8B6914;
                        border-radius:10px;">

            <div>
                <p style="color:#E8C96A;letter-spacing:4px;">
                    CEREMONIA DE SELECCIÓN
                </p>
                <h1 id="stage-1-title"
                    class="siia-title"
                    style="color:#C8A84B;margin:0;">
                    LA GARRA<br>SELECCIONADORA
                </h1>
                <p id="stage-1-desc"
                   style="color:#F0EAD8;line-height:1.8;max-width:500px;margin-top:1.5rem;">
                    Descubre qué casa académica representa mejor tus talentos,
                    intereses y fortalezas dentro de la Universidad Tecnológica de León.
                </p>
                <button id="stage-1-btn"
                        onclick="goToStage(2)"
                        class="gold-btn"
                        style="background:#C6A050;color:#06060F;border:none;
                               padding:.9rem 2rem;font-weight:700;
                               border-radius:4px;cursor:pointer;margin-top:1rem;">
                    Comenzar
                </button>
            </div>

            <div id="stage-1-img-wrap"
                 style="display:flex;justify-content:center;align-items:center;">
                <img id="stage-1-img"
                     src="{{ asset('imagenes/pata.webp') }}"
                     class="float"
                     alt="Garra seleccionadora">
            </div>

        </section>
    </div>
</div>

{{-- ═══ ETAPA 2: Pregunta ══════════════════════════════════════════════════ --}}
<div id="stage-2" class="stage" style="display:none;">
    <div class="stage-wrap">
        <section id="stage-2-inner"
                 style="border:1px solid #8B6914;
                        border-radius:10px;
                        margin-bottom:1.5rem;
                        background:linear-gradient(rgba(6,6,15,.75),rgba(6,6,15,.85)),
                                   url('{{ asset('imagenes/fondoquiz.webp') }}');
                        background-size:cover;
                        background-position:center;
                        background-repeat:no-repeat;
                        display:flex;
                        flex-direction:column;
                        align-items:center;
                        gap:1.5rem;
                        position:relative;">

            <div style="text-align:center;">
                <div style="font-family:'Headland One',serif;font-size:1.3rem;
                            color:#C8A84B;letter-spacing:.08em;">SIIA</div>
                <p style="font-size:.65rem;text-transform:uppercase;
                          letter-spacing:.15em;color:#E8C96A;margin:.2rem 0 0;">
                    [Pregunta]
                </p>
            </div>

            <div style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;justify-content:center;">
                <div id="stage-2-ref-img"
                     style="background:#1A1424;
                            border:1px dashed #C6A050;
                            border-radius:6px;
                            display:flex;align-items:center;justify-content:center;
                            font-size:.75rem;color:#B0A898;
                            text-align:center;padding:1rem;">
                    [ Imagen de<br>referencia ]
                </div>
            </div>

            <p style="font-size:.7rem;text-transform:uppercase;
                      letter-spacing:.12em;color:#F0EAD8;margin:0;text-align:center;">
                [Opción]
            </p>

            <button id="stage-2-btn"
                    onclick="goToStage(3)"
                    style="padding:.65rem 2rem;border:none;border-radius:6px;
                           font-size:.85rem;font-weight:700;color:#06060F;
                           background:#C6A050;cursor:pointer;transition:.3s;">
                Siguiente
            </button>

        </section>
    </div>
</div>

{{-- ═══ ETAPA 3: Procesando ════════════════════════════════════════════════ --}}
<div id="stage-3" class="stage" style="display:none;">
    <div class="stage-wrap">
        <section id="stage-3-inner"
                 style="background:radial-gradient(circle at top right,
                            rgba(232,201,106,.25) 0%,
                            rgba(200,168,75,.12) 20%,
                            transparent 70%),
                        linear-gradient(135deg,#06060F 0%,#120D08 30%,#1A1208 60%,#06060F 100%);
                        border:1px solid rgba(200,168,75,.35);
                        border-radius:10px;
                        display:flex;
                        flex-direction:column;
                        align-items:center;
                        justify-content:center;
                        position:relative;
                        overflow:hidden;">

            <div style="position:absolute;inset:0;
                        background-image:radial-gradient(#E8C96A 1px,transparent 1px);
                        background-size:120px 120px;
                        opacity:.08;pointer-events:none;">
            </div>

            <h2 id="stage-3-title"
                class="siia-title"
                style="color:#C8A84B;font-size:3rem;">
                SIIA
            </h2>

            <div id="stage-3-video-wrap" style="
    background: rgba(0, 0, 0, 0.58);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);

    border: 1px solid rgba(200,168,75,.18);
    border-radius: 18px;
    padding: 20px;

    box-shadow:
        0 0 40px rgba(0,0,0,.45),
        inset 0 0 20px rgba(255,255,255,.02);
">
                <video id="stage-3-video"
                       autoplay muted loop playsinline
                       style="max-width:100%;border-radius:8px;display:block;">
                    <source src="{{ asset('videos/garrita.mp4') }}" type="video/mp4">
                </video>
            </div>

            <p style="color:#F0EAD8;text-align:center;line-height:2;padding:0 1rem;">
                La garra está observando tu potencial...<br>
                Analizando afinidades académicas...
            </p>

            <button id="stage-3-btn"
                    onclick="goToStage(4)"
                    class="gold-btn"
                    style="background:#C6A050;color:#06060F;border:none;
                           padding:.9rem 2rem;font-weight:700;
                           border-radius:4px;cursor:pointer;margin-bottom:2rem;">
                Ver resultado
            </button>

        </section>
    </div>
</div>

{{-- ═══ ETAPA 4: Resultado ════════════════════════════════════════════════ --}}
<div id="stage-4" class="stage" style="display:none;">
    <div class="stage-wrap">
        <section id="stage-4-inner"
                 style="background:#06060F;border:1px solid #8B6914;border-radius:10px;">

            <div id="stage-4-img-wrap">
                <img id="stage-4-img"
                     src="../imagenes/casas/gastronomia2.webp"
                     alt="Casa Ignisculin">
            </div>

            <div>
                <p style="color:#E8C96A;letter-spacing:4px;">TU DESTINO ES</p>

                <h1 id="stage-4-result-title"
                    class="siia-title"
                    style="color:#C8A84B;margin:0;">
                    Casa Ignisculin (Gastronomía)
                </h1>

                <p style="color:#E8C96A;font-style:italic;font-size:1.2rem;">
                    "En la llama, está la verdad de tu vocación."
                </p>

                <p id="stage-4-desc"
                   style="color:#F0EAD8;line-height:1.8;max-width:450px;">
                    Tu perfil muestra una afinidad natural con la casa Ignisculina, los Alquimistas del Sabor.
                    Eres una persona que transforma el caos en excelencia mediante una combinación única de
                    creatividad vibrante y disciplina técnica. Prosperas en ambientes dinámicos, utilizando
                    tu instinto práctico para resolver cualquier reto al instante. Tu mayor virtud es el
                    espíritu de servicio: entiendes la cocina como un arte noble donde la precisión y el
                    cuidado se unen para crear experiencias que nutren el alma.
                </p>

                <div id="stage-4-btns">
                    <a href="{{ route('welcome') }}"
                       style="background:#C6A050;color:#06060F;
                              padding:.9rem 2rem;border-radius:4px;
                              text-decoration:none;font-weight:700;
                              display:inline-block;">
                        Inicio
                    </a>
                    <button onclick="descargarResultado()"
                            style="background:transparent;border:1px solid #8B6914;
                                   color:#F0EAD8;padding:.9rem 2rem;
                                   cursor:pointer;border-radius:4px;">
                        Compartir resultado
                    </button>
                </div>
            </div>

        </section>
    </div>

    {{-- Tarjeta oculta para Instagram --}}
    <div id="instagram-card"
         style="width:1080px;height:1920px;background:#06060F;
                display:flex;flex-direction:column;
                justify-content:center;align-items:center;
                padding:80px;box-sizing:border-box;
                position:absolute;left:-99999px;">
        <img src="{{ asset('imagenes/casas/gastronomia2.webp') }}"
             style="width:700px;max-width:100%;margin-bottom:80px;">
        <p style="color:#E8C96A;letter-spacing:8px;font-size:32px;margin-bottom:20px;">
            TU DESTINO ES
        </p>
        <h1 style="font-family:'Headland One',serif;color:#C8A84B;
                   font-size:90px;text-align:center;margin:0;">
            Casa Ignisculin
        </h1>
        <p style="color:#E8C96A;font-style:italic;font-size:40px;
                  text-align:center;margin:40px 0;">
            "En la llama, está la verdad de tu vocación."
        </p>
        <p style="color:#F0EAD8;font-size:32px;line-height:1.8;
                  text-align:center;max-width:800px;">
            Tu perfil muestra una afinidad natural con la casa Ignisculina,
            los Alquimistas del Sabor.
        </p>
    </div>
</div>

</div>{{-- /page-content-wrapper --}}

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

@push('extra-js')
<script>
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const mobileMenu   = document.getElementById('mobileMenu');

    hamburgerBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('open');
        hamburgerBtn.setAttribute('aria-expanded', mobileMenu.classList.contains('open'));
    });
    document.addEventListener('click', e => {
        if (!hamburgerBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
            mobileMenu.classList.remove('open');
        }
    });

    function goToStage(n) {
        document.querySelectorAll('.stage').forEach(s => s.style.display = 'none');
        document.getElementById('stage-' + n).style.display = 'flex';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Aplica layout móvil via JS (más confiable que media queries en algunos navegadores móviles)
    function applyMobileLayout() {
        const inner = document.getElementById('stage-1-inner');
        if (!inner) return;
        if (window.innerWidth <= 768) {
            inner.classList.add('mobile-layout');
        } else {
            inner.classList.remove('mobile-layout');
        }
    }
    applyMobileLayout();
    window.addEventListener('resize', applyMobileLayout);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    function descargarResultado() {
        const card = document.getElementById('instagram-card');
        html2canvas(card, {
            width: 1080,
            height: 1920,
            scale: 1,
            backgroundColor: '#06060F',
            useCORS: true
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'resultado-siia-instagram.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        });
    }
    function toggleContinue(cb) {
        const btn = document.getElementById('privacy-continue');
        btn.classList.toggle('activo', cb.checked);
    }
 
    function aceptarPrivacidad() {
        document.getElementById('privacy-overlay').style.display = 'none';
    }
 
    function abrirPolitica(e) {
        e.preventDefault();
        document.getElementById('policy-modal').classList.add('abierto');
        document.body.style.overflow = 'hidden';
    }
 
    function cerrarPolitica() {
        document.getElementById('policy-modal').classList.remove('abierto');
        document.body.style.overflow = '';
    }
 
    function cerrarPoliticaOverlay(e) {
        if (e.target === document.getElementById('policy-modal')) cerrarPolitica();
    }
 
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') cerrarPolitica();
    });
</script>
@endpush