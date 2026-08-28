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
                <button id="stage-1-btn" onclick="iniciarQuiz()"
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
                <p><span>Este quiz es de un solo intento, por lo que es importante que respondas con atención.</span></p>
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
                    [2, 'No tengo preferencia'],
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
                        Comparte tu resultado en redes sociales!
                    </button>
                </div>
            </div>

        </section>
    </div>

</div>

</div>{{-- /page-content-wrapper --}}

 @include('partials.footer')
 
@endsection

@push('extra-js')
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
// ── Mapeo carrera 
const RESULTADOS_IMG_EXT = 'png';

const RESULTADOS_IMG = {
    ADM:      'administracionResultado',
    AMBI:     'ambientalResultado',
    MECAAUTO: 'automatizacionResultado',
    AUTO:     'automotrizResultado',
    CALZ:     'calzadoResultado',
    DATOS:    'datosResultados',
    ELECTRO:  'electromovilidadResultado',
    MULT:     'entornosResultado',
    GAST:     'gastronomiaResultado',
    IA:       'iaResultado',
    LOG:      'logisticaResultado',
    MANT:     'mantenimientoResultado',
    MECASMF:  'manufacturaResultado',
    MKT:      'mercadotecniaResultado',
    PLAS:     'moldeoResultado',
    MECAOPTO: 'optomecatrónicaResultado',
    PRO:      'procesosResultado',
    REDES:    'redesResultado',
    DSM:      'softwareResultado',
    TUR:      'turismoResultado',
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
    const key = estado.carreraFinal;
    const archivo = RESULTADOS_IMG[key];

    if (!archivo) {
        console.error('No hay imagen de resultado configurada para la carrera:', key);
        return;
    }

    const url = `/imagenes/quiz/resultados/${archivo}.${RESULTADOS_IMG_EXT}`;

    const link = document.createElement('a');
    link.href = url;
    link.download = `resultado-nova-${slugify(CARRERAS[key]?.nombre || key)}.${RESULTADOS_IMG_EXT}`;
    document.body.appendChild(link);
    link.click();
    link.remove();
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