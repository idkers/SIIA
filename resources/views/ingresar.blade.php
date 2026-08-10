@extends('layouts.app')
@section('title', 'Ingresar — NOVA')

@section('content')

<style>
    *, *::before, *::after { box-sizing: border-box; }

    /* ── Layout ── */
    .login-page {
        min-height: calc(100vh - 88px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1.25rem;
        background: transparent;
        position: relative;
        overflow: hidden;
    }

    /* Fondo decorativo */
    .login-page::before {
        content: '';
        position: absolute;
        top: -200px; right: -200px;
        width: 600px; height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(200,168,75,.06) 0%, transparent 70%);
        pointer-events: none;
    }
    .login-page::after {
        content: '';
        position: absolute;
        bottom: -150px; left: -150px;
        width: 500px; height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(66,15,219,.05) 0%, transparent 70%);
        pointer-events: none;
    }

    /* ── Card ── */
    .login-card {
        background: #14141F;
        border: 1px solid rgba(200,168,75,.2);
        border-radius: 20px;
        width: 100%;
        max-width: 440px;
        padding: 2.75rem 2.5rem;
        position: relative;
        z-index: 1;
        box-shadow: 0 0 60px rgba(0,0,0,.4);
    }

    /* Franja dorada superior */
    .login-card::before {
        content: '';
        position: absolute;
        top: 0; left: 2rem; right: 2rem;
        height: 2px;
        background: linear-gradient(to right, transparent, #C8A84B, transparent);
        border-radius: 2px;
    }

    /* ── Logo ── */
    .login-logo {
        display: flex;
        justify-content: center;
        margin-bottom: 1.75rem;
    }
    .login-logo img {
        height: 3.5rem;
        width: auto;
    }

    /* ── Títulos ── */
    .login-title {
        font-family: 'Headland One', serif;
        color: #FFFFFF;
        font-size: 1.5rem;
        text-align: center;
        margin: 0 0 .35rem;
        letter-spacing: .04em;
    }
    .login-subtitle {
        color: #707085;
        font-size: .8rem;
        text-align: center;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin: 0 0 2rem;
    }

    /* ── Formulario ── */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: .45rem;
        margin-bottom: 1.25rem;
    }
    .form-label {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: #B0A898;
    }

    .input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-icon {
        position: absolute;
        left: .9rem;
        color: #4A3560;
        display: flex;
        align-items: center;
        pointer-events: none;
        transition: color .2s;
    }
    .form-input {
        width: 100%;
        background: #0D0D1A;
        border: 1px solid #2B1F3D;
        border-radius: 8px;
        padding: .75rem .9rem .75rem 2.6rem;
        color: #F0EAD8;
        font-size: .92rem;
        font-family: inherit;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
    .form-input::placeholder { color: #3D3550; }
    .form-input:focus {
        border-color: #C8A84B;
        box-shadow: 0 0 0 3px rgba(200,168,75,.1);
    }
    .form-input:focus + .input-focus-icon,
    .input-wrap:focus-within .input-icon { color: #C8A84B; }

    /* Toggle contraseña */
    .toggle-pass {
        position: absolute;
        right: .9rem;
        background: none;
        border: none;
        color: #4A3560;
        cursor: pointer;
        display: flex;
        align-items: center;
        padding: 0;
        transition: color .2s;
    }
    .toggle-pass:hover { color: #C8A84B; }

    /* Nota de dominio */
    .domain-hint {
        font-size: .75rem;
        color: #4A3560;
        margin-top: .3rem;
        padding-left: .25rem;
    }
    .domain-hint span {
        color: #8D6627;
        font-style: italic;
    }

    /* Error */
    .field-error {
        font-size: .75rem;
        color: #E05252;
        margin-top: .3rem;
        padding-left: .25rem;
        display: none;
    }
    .field-error.visible { display: block; }
    .form-input.error { border-color: #E05252; }
    .form-input.error:focus { box-shadow: 0 0 0 3px rgba(224,82,82,.1); }

    /* ── Botón principal ── */
    .btn-login {
        width: 100%;
        padding: .9rem;
        background: linear-gradient(135deg, #C6A050, #8D6627);
        border: none;
        border-radius: 8px;
        color: #1A1000;
        font-size: 1rem;
        font-weight: 700;
        font-family: inherit;
        letter-spacing: .04em;
        cursor: pointer;
        transition: opacity .2s, transform .15s;
        margin-top: .5rem;
    }
    .btn-login:hover  { opacity: .9; }
    .btn-login:active { transform: scale(.98); }

    /* ── Divisor ── */
    .divider {
        display: flex;
        align-items: center;
        gap: .75rem;
        margin: 1.5rem 0;
    }
    .divider::before, .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #2B1F3D;
    }
    .divider span {
        font-size: .72rem;
        color: #4A3560;
        text-transform: uppercase;
        letter-spacing: .1em;
        white-space: nowrap;
    }

    /* ── Registro ── */
    .register-prompt {
        text-align: center;
        font-size: .83rem;
        color: #707085;
    }
    .register-prompt a {
        color: #E8C96A;
        text-decoration: none;
        font-weight: 600;
    }
    .register-prompt a:hover { color: #fff; }

    /* ── Info alumno nuevo ── */
    .new-student-note {
        margin-top: 1.5rem;
        padding: .85rem 1rem;
        background: rgba(200,168,75,.05);
        border: 1px solid rgba(200,168,75,.12);
        border-radius: 8px;
        font-size: .78rem;
        color: #707085;
        line-height: 1.6;
        text-align: center;
    }
    .new-student-note strong { color: #C8A84B; }

    /* ── Footer ── */
    #footer-casas {
        padding: 3rem 4rem;
        background: #06060F;
        border-top: 1px solid #2B1F3D;
    }
    #footer-casas-grid {
        display: flex; justify-content:space-around; flex-wrap:wrap; gap:3rem;
    }
/* ── Privacidad ── */
    #privacy-overlay { position:fixed; inset:0; background:rgba(0,0,0,.78); z-index:200;
                       display:none; align-items:center; justify-content:center; padding:1.25rem; }
    #privacy-overlay.abierto { display:flex; }
    #privacy-box { background:#14141F; border:1px solid rgba(200,168,75,.35); border-radius:16px;
                   padding:2.5rem 2rem; max-width:480px; width:100%;
                   max-height:90vh; max-height:90dvh; overflow-y:auto;
                   box-shadow:0 0 40px rgba(200,168,75,.10); display:flex; flex-direction:column; gap:1.25rem; }
    #privacy-box h2 { font-family:'Headland One',serif; color:#C8A84B; font-size:1.4rem; margin:0; letter-spacing:.06em; }
    #privacy-box > p { color:#B0A898; font-size:.88rem; line-height:1.75; margin:0; }
    .privacy-notice { background:rgba(200,168,75,.07); border:1px solid rgba(200,168,75,.2);
                      border-radius:8px; padding:.85rem 1rem; color:#F0EAD8; font-size:.82rem; line-height:1.7; }
    .privacy-check-wrap { display:flex; align-items:flex-start; gap:.85rem; cursor:pointer; user-select:none; }
    .privacy-check-wrap input { display:none; }
    .privacy-circle { width:22px; height:22px; border-radius:50%; border:2px solid #8D6627;
                      flex-shrink:0; margin-top:1px; display:flex; align-items:center;
                      justify-content:center; transition:background .2s,border-color .2s; background:transparent; }
    .privacy-circle svg { opacity:0; transition:opacity .2s; }
    .privacy-check-wrap input:checked ~ .privacy-circle { background:#C6A050; border-color:#C6A050; }
    .privacy-check-wrap input:checked ~ .privacy-circle svg { opacity:1; }
    .privacy-check-label { font-size:.85rem; color:#B0A898; line-height:1.6; }
    .privacy-check-label a { color:#E8C96A; text-decoration:underline; cursor:pointer; }
    .privacy-check-label a:hover { color:#fff; }
    #privacy-continue { width:100%; padding:.85rem; background:linear-gradient(135deg,#C6A050,#8D6627);
                        border:none; border-radius:6px; color:#1A1000; font-size:1rem; font-weight:700;
                        cursor:pointer; opacity:.4; pointer-events:none; transition:opacity .2s; font-family:inherit; letter-spacing:.04em; }
    #privacy-continue.activo { opacity:1; pointer-events:auto; }
    #policy-modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,.82); z-index:300;
                    align-items:center; justify-content:center; padding:1.25rem; }
    #policy-modal.abierto { display:flex; }
    #policy-box { background:#14141F; border:1px solid rgba(200,168,75,.3); border-radius:16px;
                  max-width:640px; width:100%; max-height:88vh; overflow-y:auto; position:relative;
                  box-shadow:0 0 40px rgba(200,168,75,.10); }
    #policy-box::-webkit-scrollbar { width:5px; }
    #policy-box::-webkit-scrollbar-track { background:#0D0D1A; }
    #policy-box::-webkit-scrollbar-thumb { background:#4A3010; border-radius:10px; }
    .policy-header { padding:1.75rem 2rem 1rem; border-bottom:1px solid rgba(200,168,75,.15);
                     position:sticky; top:0; background:#14141F; z-index:1;
                     display:flex; align-items:center; justify-content:space-between; }
    .policy-header h3 { font-family:'Headland One',serif; color:#C8A84B; font-size:1.2rem; margin:0; }
    .policy-close { background:none; border:none; color:#707085; font-size:1.4rem; cursor:pointer; line-height:1; transition:color .2s; }
    .policy-close:hover { color:#E8C96A; }
    .policy-body { padding:1.5rem 2rem 2rem; color:#B0A898; font-size:.87rem; line-height:1.85; }
    .policy-body h4 { color:#E8C96A; font-size:.78rem; text-transform:uppercase; letter-spacing:.12em;
                      margin:1.5rem 0 .5rem; border-bottom:1px solid rgba(200,168,75,.15); padding-bottom:.35rem; }
    .policy-body h4:first-child { margin-top:0; }
    .policy-body p { margin:0 0 .75rem; }
    .policy-body strong { color:#F0EAD8; }
    .policy-body ul { margin:0 0 .75rem 1.25rem; padding:0; }
    .policy-body ul li { margin-bottom:.4rem; }
    .policy-body a { color:#E8C96A; }

    @media (max-width: 500px) {
        #privacy-box { padding: 2rem 1.25rem; }
        .policy-body { padding: 1.25rem; }
        .policy-header { padding: 1.25rem 1.25rem .85rem; }
    }
    @media (max-width: 600px) {
        .login-card { padding: 2rem 1.5rem; }
        #footer-casas { padding: 2.5rem 1.25rem; }
        #footer-casas-grid { flex-direction:column; gap:2rem; }
        #footer-casas-grid > div { max-width:100% !important; }
    }
</style>

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
@include('partials.navbar')

{{-- ── Overlay de privacidad ── --}}
<div id="privacy-overlay">
    <div id="privacy-box">

        <h2>Antes de continuar</h2>

        <p>
            Para ofrecerte la mejor experiencia en NOVA, necesitamos que leas y
            aceptes el Aviso de Privacidad Integral de la Universidad Tecnológica de León.
        </p>

        <div class="privacy-notice">
            ⚠️ <strong style="color:#E8C96A;">Nota importante:</strong>
            La Universidad Tecnológica de León <strong>no cuenta con áreas de ciencias
            de la salud</strong> (medicina, enfermería, biología, etc.). Los resultados del quiz están
            orientados exclusivamente a las carreras y dominios que ofrece la UTL.
        </div>

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
            Continuar →
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
{{-- ═══ LOGIN ═══════════════════════════════════════════════════════════════ --}}
<div class="login-page">
    <div class="login-card">

        {{-- Logo --}}
        <div class="login-logo">
            <img src="{{ asset('imagenes/isotipo_dorado.webp') }}" alt="UTL SIIA">
        </div>

        <h1 class="login-title">Bienvenido de vuelta</h1>
        <p class="login-subtitle">Navegador de Orientación Vocacional y Aptitudes</p>

        {{-- Mensajes de error del servidor --}}
        @if(session('error'))
        <div style="background:rgba(224,82,82,.1);border:1px solid rgba(224,82,82,.3);
                    border-radius:8px;padding:.75rem 1rem;margin-bottom:1.25rem;
                    font-size:.83rem;color:#E05252;text-align:center;">
            {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div style="background:rgba(75,200,100,.1);border:1px solid rgba(75,200,100,.3);
                    border-radius:8px;padding:.75rem 1rem;margin-bottom:1.25rem;
                    font-size:.83rem;color:#4BC864;text-align:center;">
            {{ session('success') }}
        </div>
        @endif

        {{-- Formulario --}}
        <form method="POST" action="{{ route('ingresar.post') }}" onsubmit="return validarLogin(event);">
            @csrf

            {{-- Correo --}}
            <div class="form-group">
                <label class="form-label" for="email">Correo</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </span>
                    <input type="text"
                           id="email"
                           name="email"
                           class="form-input @error('email') error @enderror"
                           placeholder="12345@gmail.com"
                           value="{{ old('email') }}"
                           autocomplete="username"
                           inputmode="email">
                </div>
                <p class="domain-hint">
                    Solo se permite correos <span>webmail o institucionales</span>
                </p>
                <span class="field-error @error('email') visible @enderror" id="emailError">
                    @error('email') {{ $message }} @else Ingresa tu correo personal o correo institucional válido. @enderror
                </span>
            </div>

            {{-- Contraseña --}}
            <div class="form-group">
                <label class="form-label" for="password">Contraseña</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                    <input type="password"
                           id="password"
                           name="password"
                           class="form-input @error('password') error @enderror"
                           placeholder="••••••••"
                           autocomplete="current-password">
                    <button type="button" class="toggle-pass"
                            onclick="togglePassword()" aria-label="Mostrar contraseña">
                        <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <span class="field-error @error('password') visible @enderror" id="passError">
                    @error('password') {{ $message }} @else Ingresa tu contraseña. @enderror
                </span>
            </div>

            <div style="display:flex;align-items:center;justify-content:space-between;
                        margin-bottom:1.25rem;flex-wrap:wrap;gap:.5rem;">

                {{-- Enlace a recuperar contraseña (futura implementación) --}}
                <a href="#"
                   style="font-size:.8rem;color:#8D6627;text-decoration:none;
                          letter-spacing:.04em;"
                   onclick="alert('Contacta a soporte: comunicacionutl@utleon.edu.mx'); return false;">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <button type="submit" class="btn-login">
                Ingresar
            </button>

        </form>

        <div class="divider"><span>o</span></div>

        <p class="register-prompt">
            ¿Aún no tienes cuenta?
            <a href="{{ route('registrar') }}">Regístrate aquí</a>
        </p>

    </div>
</div>

{{-- ═══ FOOTER ════════════════════════════════════════════════════════════ --}}
@include('partials.footer')

@endsection

@push('extra-js')
<script>
    // ── Aviso de privacidad: se muestra al cargar la página de login ──
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

    function aceptarPrivacidad() {
        document.getElementById('privacy-overlay').classList.remove('abierto');
        desbloquearScroll();
        localStorage.setItem('novaPrivacidadAceptada', '1');
    }

    function abrirPolitica(e) { e.preventDefault(); document.getElementById('policy-modal').classList.add('abierto'); }
    function cerrarPolitica() { document.getElementById('policy-modal').classList.remove('abierto'); }
    function cerrarPoliticaOverlay(e) { if (e.target === document.getElementById('policy-modal')) cerrarPolitica(); }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarPolitica(); });

    // Muestra el aviso automáticamente si aún no lo ha aceptado
    if (!localStorage.getItem('novaPrivacidadAceptada')) {
        document.getElementById('privacy-overlay').classList.add('abierto');
        bloquearScroll();
    }
    // Hamburger
    const btn  = document.getElementById('hamburgerBtn');
    const menu = document.getElementById('mobileMenu');
    const navEl = btn.closest('nav');
    function posicionarMenuMovil() {
        if (navEl) menu.style.top = navEl.getBoundingClientRect().bottom + 'px';
    }
    btn.addEventListener('click', () => {
        posicionarMenuMovil();
        menu.classList.toggle('open');
        btn.setAttribute('aria-expanded', menu.classList.contains('open'));
    });
    document.addEventListener('click', e => {
        if (!btn.contains(e.target) && !menu.contains(e.target))
            menu.classList.remove('open');
    });
    window.addEventListener('resize', posicionarMenuMovil);
    window.addEventListener('scroll', () => {
        if (menu.classList.contains('open')) posicionarMenuMovil();
    });

    // Toggle contraseña
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                <line x1="1" y1="1" x2="23" y2="23"/>`;
        } else {
            input.type = 'password';
            icon.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>`;
        }
    }

    // Validación del correo: acepta matrícula (6-10 dígitos) o cualquier correo válido
    function validarLogin(e) {
        let valido = true;
        const emailInput = document.getElementById('email');
        const passInput  = document.getElementById('password');
        const emailError = document.getElementById('emailError');
        const passError  = document.getElementById('passError');

        // Reset
        emailInput.classList.remove('error');
        passInput.classList.remove('error');
        emailError.classList.remove('visible');
        passError.classList.remove('visible');

        const val = emailInput.value.trim();

        // Acepta: solo números (matrícula) O cualquier correo válido
        // (gmail, outlook, hotmail, institucional @utleon.edu.mx, etc.)
        const esMatricula = /^\d{6,10}$/.test(val);
        const esCorreo    = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i.test(val);

        if (!esMatricula && !esCorreo) {
            emailInput.classList.add('error');
            emailError.textContent = '@gmail.com, @utleon.edu.mx, @outlook.com, etc.';
            emailError.classList.add('visible');
            valido = false;
        }

        if (!passInput.value) {
            passInput.classList.add('error');
            passError.textContent = 'Ingresa tu contraseña.';
            passError.classList.add('visible');
            valido = false;
        }

        // Si solo pusieron matrícula, convertir a correo antes de enviar
        if (valido && esMatricula) {
            emailInput.value = val + '@utleon.edu.mx';
        }

        return valido;
    }
</script>
@endpush