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

<button
    onclick="goToStage(2)"
    class="gold-btn"
    style="
    background:#C6A050 !important;
    color:#06060F !important;
    border:none !important;
    padding:.9rem 2rem !important;
    font-weight:700 !important;
    border-radius:4px !important;
    cursor:pointer;
    ">
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

<section style="
    border:1px solid #8B6914;
    border-radius:10px;
    padding:2.5rem 2rem;
    margin-bottom:1.5rem;
    background:#14141F;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:1.5rem;
    min-height:420px;
    position:relative;
    box-shadow:0 0 25px rgba(198,160,80,.12);
">

    <div style="
        position:absolute;
        top:1rem;
        right:1.5rem;
        font-size:.65rem;
        color:#707085;
        letter-spacing:.06em;
        text-align:right;
        line-height:1.7;">
        Fondo cósmico con<br>transparencia /<br>partículas animadas
    </div>

    <div style="text-align:center;">

        <div style="
            font-family:'Headland One', serif;
            font-size:1.3rem;
            color:#C8A84B;
            letter-spacing:.08em;">
            SIIA
        </div>

        <p style="
            font-size:.65rem;
            text-transform:uppercase;
            letter-spacing:.15em;
            color:#E8C96A;
            margin:.2rem 0 0;">
            [Pregunta]
        </p>

    </div>

    <div style="display:flex;align-items:center;gap:1.5rem;">

        <button style="
            width:34px;
            height:34px;
            border:1px solid #8B6914;
            background:#1A1424;
            border-radius:50%;
            font-size:1.1rem;
            color:#E8C96A;
            cursor:pointer;">
            ‹
        </button>

        <div style="
            width:200px;
            height:200px;
            background:#1A1424;
            border:1px dashed #C6A050;
            border-radius:6px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:.75rem;
            color:#B0A898;
            text-align:center;
            padding:1rem;">
            [ Imagen de<br>referencia ]
        </div>

        <button style="
            width:34px;
            height:34px;
            border:1px solid #8B6914;
            background:#1A1424;
            border-radius:50%;
            font-size:1.1rem;
            color:#E8C96A;
            cursor:pointer;">
            ›
        </button>

    </div>

    <p style="
        font-size:.7rem;
        text-transform:uppercase;
        letter-spacing:.12em;
        color:#F0EAD8;
        margin:0;">
        [Opción]
    </p>

    <button onclick="goToStage(3)"
            style="
            padding:.65rem 2rem;
            border:none;
            border-radius:6px;
            font-size:.85rem;
            font-weight:700;
            color:#06060F;
            background:#C6A050;
            cursor:pointer;
            transition:.3s;">
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
        class="gold-btn"
    style="
    background:#C6A050 !important;
    color:#06060F !important;
    border:none !important;
    padding:.9rem 2rem !important;
    font-weight:700 !important;
    border-radius:4px !important;
    cursor:pointer;
    ">
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

        <img src="/img/casa-xy.png"
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
            Casa
        </h1>

        <p style="
        color:#E8C96A;
        font-style:italic;
        font-size:1.2rem;
        ">
            "Características de perfil relacionadas a esta casa académica."
        </p>

        <p style="
        color:#F0EAD8;
        line-height:1.8;
        max-width:450px;
        ">
            Tu perfil muestra:
        </p>

        <div style="
        display:flex;
        gap:1rem;
        margin-top:2rem;
        ">

<a href="{{ route('welcome') }}"
   style="
   background:#C6A050;
   color:#06060F !important;
   padding:.9rem 2rem;
   border-radius:4px;
   text-decoration:none;
   font-weight:700;
   display:inline-block;
   ">
    Inicio
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