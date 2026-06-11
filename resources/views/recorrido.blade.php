@extends('layouts.app')
@section('title', 'Recorrido — SIIA')

@section('content')

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<nav style="display:flex;align-items:center;justify-content:space-between;
            padding:.75rem 1.5rem;border:1px solid #ccc;border-radius:6px;
            margin-bottom:1.5rem;background:#f9f9f9;">
    <span style="font-weight:700;font-size:.95rem;color:#333;">UTL</span>
    <div style="display:flex;gap:1.5rem;">
        <a href="{{ route('welcome') }}"   style="font-size:.85rem;color:#555;text-decoration:none;">Inicio</a>
        <a href="{{ route('quiz') }}"      style="font-size:.85rem;color:#555;text-decoration:none;">Quiz</a>
        <a href="{{ route('recorrido') }}" style="font-size:.85rem;color:#333;text-decoration:none;font-weight:600;">Recorrido</a>
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

            <a href="#puntos" style="
            border:1px solid #8D6627;
            color:#F0EAD8;
            padding:.9rem 2rem;
            text-decoration:none;
            ">
                Ver puntos de interés
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
                src="https://www.youtube.com/embed/TU_VIDEO"
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
<footer style="border:1px solid #ccc;border-radius:6px;
               padding:2rem;background:#f0f0f0;text-align:center;
               color:#aaa;font-size:.85rem;letter-spacing:.08em;">
    [ FOOTER ]
</footer>

@endsectionq