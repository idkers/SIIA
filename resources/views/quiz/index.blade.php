@extends('layouts.app')
@section('title', 'Quiz — SIIA')

@section('content')

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<nav style="
    display:flex;
    align-items:center;
    justify-content:space-between;

    padding:.9rem 2.5rem;

    background:rgba(6,6,15,.55);

    backdrop-filter:blur(10px);
    -webkit-backdrop-filter:blur(10px);

    border-bottom:1px solid rgba(200,168,75,.15);

    margin-bottom:1.5rem;
">

    <!-- Logo -->
    <span style="
        font-family:'Headland One', serif;
        font-size:1.2rem;
        color:#C8A84B;
        letter-spacing:.08em;
    ">
        UTL
    </span>

    <!-- Menú -->
    <div style="
        display:flex;
        gap:3rem;
        align-items:center;
    ">

        <a href="{{ route('welcome') }}"
           style="
           color:#F0EAD8;
           text-decoration:none;
           font-size:.8rem;
           letter-spacing:.08em;
        ">
            INICIO
        </a>

        <a href="{{ route('quiz') }}"
           style="
           color:#E8C96A;
           text-decoration:none;
           font-size:.8rem;
           letter-spacing:.08em;
        ">
            QUIZ
        </a>

        <a href="{{ route('recorrido') }}"
           style="
           color:#F0EAD8;
           text-decoration:none;
           font-size:.8rem;
           letter-spacing:.08em;
        ">
            RECORRIDO
        </a>

        <a href="{{ route('dominios') }}"
           style="
           color:#F0EAD8;
           text-decoration:none;
           font-size:.8rem;
           letter-spacing:.08em;
        ">
            DOMINIOS
        </a>

        <a href="{{ route('casas') }}"
           style="
           color:#F0EAD8;
           text-decoration:none;
           font-size:.8rem;
           letter-spacing:.08em;
        ">
            CASAS
        </a>

    </div>

    <!-- Perfil -->
    <div style="
        display:flex;
        align-items:center;
        gap:1rem;
    ">

        <a href="#"
           style="
           color:#F0EAD8;
           text-decoration:none;
           font-size:.8rem;
           letter-spacing:.08em;
        ">
            INGRESAR
        </a>

        <div style="
            width:28px;
            height:28px;
            border-radius:50%;
            background:#EAEAEA;
        ">
        </div>

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
            LA GARRA
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

 <img src="{{ asset('imagenes/pata.png') }}"
     class="float"
     style="max-width:820px;">

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

    background:
    linear-gradient(
        rgba(6,6,15,.75),
        rgba(6,6,15,.85)
    ),
    url('{{ asset('imagenes/fondoquiz.png') }}');


    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;

    display:flex;
    flex-direction:column;
    align-items:center;
    gap:1.5rem;
    min-height:420px;
    position:relative;
">


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

        <img src="../imagenes/garra.png"
             style="width:300px;">

    </div>

    <p style="
    color:#F0EAD8;
    text-align:center;
    line-height:2;
    ">
        La garra está observando tu potencial...
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

        <img src="../imagenes/gastronomia2.png"
             style="max-width:500px;">

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
            Casa Ignisculin (Gastronomía)
        </h1>

        <p style="
        color:#E8C96A;
        font-style:italic;
        font-size:1.2rem;
        ">
            "En la llama, está la verdad de tu vocación."
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
<footer style="
    margin-top:4rem;

    height:250px;

    border:1px solid rgba(139,105,20,.35);

    background:rgba(6,6,15,.45);

    backdrop-filter:blur(8px);
    -webkit-backdrop-filter:blur(8px);

    position:relative;

    display:flex;
    justify-content:center;
    align-items:center;
">

    <span style="
        font-family:'Headland One', serif;
        color:#C8A84B;
        font-size:2rem;
        letter-spacing:.08em;
        text-align:center;
    ">
        [FOOTER CON INFORMACIÓN DE LA UTL Y NUESTRA]
    </span>

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