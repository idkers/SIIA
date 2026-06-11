@extends('layouts.app')
@section('title', 'Quiz — SIIA')

@section('content')

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<nav style="display:flex;align-items:center;justify-content:space-between;
            padding:.75rem 1.5rem;border:1px solid #ccc;border-radius:6px;
            margin-bottom:1.5rem;background:#f9f9f9;">
    <span style="font-weight:700;font-size:.95rem;color:#333;">UTL</span>
    <div style="display:flex;gap:1.5rem;">
        <a href="{{ route('welcome') }}"  style="font-size:.85rem;color:#555;text-decoration:none;">Inicio</a>
        <a href="{{ route('quiz') }}"     style="font-size:.85rem;color:#333;text-decoration:none;font-weight:600;">Quiz</a>
        <a href="{{ route('recorrido') }}" style="font-size:.85rem;color:#555;text-decoration:none;">Recorrido</a>
        <a href="{{ route('dominios') }}"  style="font-size:.85rem;color:#555;text-decoration:none;">Dominios</a>
        <a href="{{ route('casas') }}"     style="font-size:.85rem;color:#555;text-decoration:none;">Casas</a>
    </div>
    <div style="display:flex;align-items:center;gap:.75rem;">
        <a href="#" style="font-size:.85rem;color:#555;text-decoration:none;
                   border:1px solid #bbb;padding:.3rem .9rem;border-radius:4px;">
            Ingresar
        </a>
        <div style="width:32px;height:32px;border-radius:50%;background:#ddd;border:1px solid #bbb;"></div>
    </div>
</nav>

{{-- ═══ ETAPAS ═══════════════════════════════════════════════════════════════ --}}

{{-- ETAPA 1: Inicio del quiz --}}
<div id="stage-1" class="stage">

   <section style="
background:
linear-gradient(rgba(6,6,15,.85),rgba(6,6,15,.95));
border:1px solid #8B6914;
border-radius:10px;
padding:4rem;
display:grid;
grid-template-columns:1fr 1fr;
align-items:center;
min-height:550px;
">

    <div>

        <p style="color:#E8C96A;letter-spacing:4px;">
            CEREMONIA DE SELECCIÓN
        </p>

        <h1 class="siia-title"
            style="font-size:4rem;color:#C8A84B;margin:0;">
            LA GARRITA
            <br>
            SELECCIONADORA
        </h1>

        <p style="
        color:#F0EAD8;
        line-height:1.8;
        max-width:500px;
        margin-top:1.5rem;
        ">
            Descubre qué casa académica representa mejor tus talentos,
            intereses y fortalezas dentro de la Universidad Tecnológica de León.
        </p>

        <button onclick="goToStage(2)"
                class="gold-btn"
                style="margin-top:2rem;">
            Comenzar
        </button>

    </div>

    <div style="
    display:flex;
    justify-content:center;
    align-items:center;
    ">

        <img src="/img/garrita.png"
             class="float"
             style="max-width:350px;">

    </div>

</section>
</div>

{{-- ETAPA 2: Pregunta --}}
<div id="stage-2" class="stage" style="display:none;">

<section class="dark-card"
style="
padding:3rem;
display:flex;
flex-direction:column;
align-items:center;
gap:2rem;
min-height:600px;
">

    <span style="color:#B0A898;">
        Pregunta 1 de 10
    </span>

    <h2 class="siia-title"
        style="color:white;font-size:2.5rem;">
        ¿Qué actividad disfrutas más?
    </h2>

    <div style="
    width:250px;
    height:250px;
    border:1px solid #8B6914;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#B0A898;
    ">
        Imagen
    </div>

    <div style="
    width:100%;
    max-width:700px;
    display:grid;
    gap:1rem;
    ">

        <div class="quiz-option">
            Resolver problemas complejos
        </div>

        <div class="quiz-option">
            Diseñar nuevas soluciones
        </div>

        <div class="quiz-option">
            Liderar equipos
        </div>

        <div class="quiz-option">
            Crear experiencias innovadoras
        </div>

    </div>

    <button onclick="goToStage(3)"
            class="gold-btn">
        Siguiente
    </button>

</section>

</div>

{{-- ETAPA 3: Procesando --}}
<div id="stage-3" class="stage" style="display:none;">

  
  <section
style="
background:
radial-gradient(circle,#2B1F3D 0%,#06060F 70%);
border:1px solid #8B6914;
border-radius:10px;
padding:4rem;
display:flex;
flex-direction:column;
align-items:center;
justify-content:center;
gap:2rem;
min-height:600px;
">

    <h2 class="siia-title"
        style="color:#C8A84B;font-size:3rem;">
        SIIA
    </h2>

    <div class="float">

        <img src="/img/garrita.png"
             style="width:260px;">

    </div>

    <p style="
    color:#F0EAD8;
    text-align:center;
    line-height:2;
    ">
        La garrita está observando tu potencial...
        <br>
        Analizando afinidades académicas...
    </p>

    <button onclick="goToStage(4)"
            class="gold-btn">
        Ver resultado
    </button>

</section>
</div>

{{-- ETAPA 4: Resultado --}}
<div id="stage-4" class="stage" style="display:none;">

    <section
style="
background:#06060F;
border:1px solid #8B6914;
border-radius:10px;
padding:4rem;
display:grid;
grid-template-columns:1fr 1fr;
align-items:center;
min-height:550px;
">

    <div style="
    display:flex;
    justify-content:center;
    ">

        <img src="/img/casa-leon.png"
             style="max-width:320px;">

    </div>

    <div>

        <p style="
        color:#E8C96A;
        letter-spacing:4px;
        ">
            TU DESTINO ES
        </p>

        <h1 class="siia-title"
            style="
            color:#C8A84B;
            font-size:5rem;
            margin:0;
            ">
            LEÓN
        </h1>

        <p style="
        color:#E8C96A;
        font-style:italic;
        font-size:1.2rem;
        ">
            "Liderazgo y fortaleza"
        </p>

        <p style="
        color:#F0EAD8;
        line-height:1.8;
        max-width:450px;
        ">
            Las características de tu perfil muestran una fuerte afinidad
            con las carreras asociadas a esta casa académica.
        </p>

        <div style="
        display:flex;
        gap:1rem;
        margin-top:2rem;
        ">

            <a href="{{ route('casas') }}"
               class="gold-btn"
               style="text-decoration:none;">
                Conocer mi casa
            </a>

            <button onclick="goToStage(1)"
                    style="
                    background:transparent;
                    border:1px solid #8B6914;
                    color:#F0EAD8;
                    padding:.9rem 2rem;
                    cursor:pointer;
                    ">
                Repetir quiz
            </button>

        </div>

    </div>

</section>
</div>

{{-- ═══ FOOTER PLACEHOLDER ════════════════════════════════════════════════ --}}
<footer style="border:1px solid #ccc;border-radius:6px;
               padding:2rem;background:#f0f0f0;text-align:center;
               color:#aaa;font-size:.85rem;letter-spacing:.08em;">
    [ FOOTER ]
</footer>

@endsection

@section('extra-js')
<script>
function goToStage(n) {
    document.querySelectorAll('.stage').forEach(s => s.style.display = 'none');
    document.getElementById('stage-' + n).style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endsection