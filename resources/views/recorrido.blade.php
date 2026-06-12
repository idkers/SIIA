@extends('layouts.app')
@section('title', 'Recorrido — SIIA')

@section('content')

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<nav style="display:flex;align-items:center;justify-content:space-between;
            padding:.75rem 2rem;
            background:#06060F;
            border-bottom:1px solid #2B1F3D;
            margin-bottom:0;">
    <span style="font-weight:700;font-size:1rem;color:#C8A84B;
                 letter-spacing:.12em;font-family:'Headland One',serif;">
        UTL
    </span>
    <div style="display:flex;gap:2rem;">
        <a href="{{ route('welcome') }}"      style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Inicio</a>
        <a href="{{ route('quiz') }}"          style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Quiz</a>
        <a href="{{ route('recorrido') }}"     style="font-size:.82rem;color:#E8C96A;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Recorrido</a>
        <a href="{{ route('dominios') }}"      style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Dominios</a>
        <a href="{{ route('casas') }}"         style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Casas</a>
    </div>
    <div style="display:flex;align-items:center;gap:.75rem;">
        <a href="#"
           style="font-size:.82rem;color:#B0A898;text-decoration:none;
                  letter-spacing:.08em;text-transform:uppercase;">
            Ingresar
        </a>
        <div style="width:32px;height:32px;border-radius:50%;
                    background:#2B1F3D;border:1px solid #6B5020;"></div>
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
            ¡Descubre laboratorios, edificios académicos,
            áreas deportivas y espacios emblemáticos de la
            Universidad Tecnológica de León mediante una
            experiencia inmersiva con nuestro nuevo videojuego!
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
                Descargar
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
    padding:3rem 4rem;
    background:#06060F;
    border-top:1px solid #2B1F3D;
">

    <div style="
        display:flex;
        justify-content:space-around;
        flex-wrap:wrap;
        gap:3rem;
    ">

        <!-- Información UTL -->
        <div style="
            text-align:left;
            max-width:400px;
        ">

            <h3 style="
                font-family:'Headland One', serif;
                color:#C8A84B;
                margin-bottom:1rem;
                font-size:1.4rem;
            ">
                Universidad Tecnológica de León
            </h3>

            <p style="
                color:#F0EAD8;
                line-height:1.8;
                margin:0;
            ">
                Blvd. Universidad Tecnológica #225 Col. San Carlos<br>
                C.P. 37670 León, Gto. México<br><br>

                difusion@utleon.edu.mx<br><br>

                (477) 7 10 00 20
            </p>

        </div>

        <!-- Información del proyecto -->
        <div style="
            text-align:left;
            max-width:450px;
        ">

            <h3 style="
                font-family:'Headland One', serif;
                color:#C8A84B;
                margin-bottom:1rem;
                font-size:1.4rem;
            ">
                Desarrolladores del Proyecto
            </h3>

            <p style="
                color:#F0EAD8;
                line-height:2;
                margin:0;
            ">
                <strong>Citlalli Méndez</strong><br>
                citlallialejandrams@gmail.com
                <br><br>

                <strong>Miryam Muñoz</strong><br>
                miryammunoz26@gmail.com
                <br><br>

                <strong>Carlo Flores</strong><br>
                carlofernandoflores2006@gmail.com
            </p>

        </div>

    </div>

    <div style="
        margin-top:2.5rem;
        border-top:1px solid rgba(200,168,75,.15);
        padding-top:1.5rem;
        text-align:center;
        color:#707085;
        font-size:.8rem;
        letter-spacing:.08em;
    ">
        © {{ date('Y') }} SIIA · Sistema Integral de Identidad Académica
    </div>

</footer>
@endsection