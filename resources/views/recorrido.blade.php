@extends('layouts.app')
@section('title', 'Recorrido — SIIA')

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
           color:#F0EAD8;
           text-decoration:none;
           font-size:.8rem;
           letter-spacing:.08em;
        ">
            QUIZ
        </a>

        <a href="{{ route('recorrido') }}"
           style="
           color: #E8C96A;
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

{{-- ═══ HERO ═══════════════════════════════════════════════════════════════ --}}
<section style="
background:linear-gradient(rgba(6,6,15,.85),rgba(6,6,15,.95)),
url('/img/campus-bg.jpg');
background-size:cover;
background-position:center;
border:1px solid #8B6914;
border-radius:10px;
overflow:hidden;
margin-bottom:2rem;
display:grid;
grid-template-columns:1fr 1fr;
min-height:500px;
">

    <div style="
    display:flex;
    flex-direction:column;
    justify-content:center;
    padding:4rem;
    ">

        <span style="
        color:#E8C96A;
        letter-spacing:4px;
        text-transform:uppercase;
        font-size:.8rem;
        ">
            Exploración UTL
        </span>

        <h1 style="
        font-family:'Headland One',serif;
        color:#C8A84B;
        font-size:4rem;
        margin:.5rem 0;
        ">
            RECORRIDO
            <br>
            VIRTUAL
        </h1>

        <p style="
        color:#F0EAD8;
        line-height:1.8;
        max-width:500px;
        ">
            Descubre laboratorios, edificios académicos,
            áreas deportivas y espacios emblemáticos de la
            Universidad Tecnológica de León mediante una
            experiencia inmersiva.
        </p>

        <div style="margin-top:2rem;display:flex;gap:1rem;">

            <a href="#mapa" style="
            background:#C6A050;
            color:#06060F;
            padding:.9rem 2rem;
            text-decoration:none;
            font-weight:700;
            border-radius:4px;
            ">
                Iniciar exploración
            </a>



        </div>

    </div>

    <div style="
    display:flex;
    justify-content:center;
    align-items:center;
    padding:2rem;
    ">

        <div style="
        width:100%;
        max-width:600px;
        aspect-ratio:16/9;
        border:2px solid #C6A050;
        border-radius:10px;
        overflow:hidden;
        background:#14141F;
        ">

            <iframe
                width="100%"
                height="100%"
                src="https://www.youtube.com/embed/AqpQu6D0Yyc?si=OTlRThrGbrbJjgJR"
                title="Recorrido UTL"
                frameborder="0"
                allowfullscreen>
            </iframe>

        </div>

    </div>

</section>

{{-- ═══ MAPA ════════════════════════════════════════════════════════════════ --}}
<section id="mapa" style="
background:#14141F;
border:1px solid #8B6914;
border-radius:10px;
padding:3rem;
margin-bottom:2rem;
">

    <h2 style="
    text-align:center;
    color:#FFFFFF;
    font-family:'Headland One',serif;
    margin-bottom:2rem;
    ">
        ───── MAPA DEL CAMPUS ─────
    </h2>

    <div style="
    height:500px;
    background:#1A1424;
    border:2px solid #C6A050;
    border-radius:8px;
    display:flex;
    justify-content:center;
    align-items:center;
    color:#F0EAD8;
    ">
        [Mapa interactivo]
    </div>

</section>

{{-- ═══ FOOTER PLACEHOLDER ═══════════════════════════════════════════════ --}}
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