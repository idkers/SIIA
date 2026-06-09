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
<section style="display:grid;grid-template-columns:1fr 1fr;
                border:1px solid #ccc;border-radius:6px;
                overflow:hidden;margin-bottom:1.5rem;min-height:280px;">

    <div style="padding:2rem;display:flex;flex-direction:column;
                justify-content:center;gap:1rem;
                border-right:1px solid #ccc;background:#fff;">

        <p style="font-size:.7rem;text-transform:uppercase;letter-spacing:.1em;color:#999;margin:0;">
            Recorrido Virtual
        </p>

        <h1 style="font-size:1.4rem;font-weight:700;color:#222;margin:0;line-height:1.3;">
            Explora el campus de la UTL
        </h1>

        <p style="font-size:.85rem;color:#555;max-width:300px;line-height:1.6;margin:0;">
            Conoce los espacios académicos, laboratorios y áreas que conforman
            la Universidad Tecnológica de León con un divertido juego.
        </p>

        <div>
            <a href="#puntos"
               style="padding:.45rem 1.4rem;border:1px solid #333;border-radius:4px;
                      font-size:.85rem;font-weight:600;color:#333;
                      text-decoration:none;background:#fff;display:inline-block;">
                Iniciar recorrido
            </a>
        </div>
    </div>

    <div style="background:#f0f0f0;display:flex;align-items:center;
                justify-content:center;min-height:260px;">
        <div style="width:200px;height:200px;background:#ddd;
                    border:1px dashed #999;border-radius:4px;
                    display:flex;flex-direction:column;align-items:center;
                    justify-content:center;gap:.4rem;
                    font-size:.75rem;color:#888;text-align:center;padding:1rem;">
            <span style="font-size:1.8rem;"></span>
            [ Enlace del video a YouTube<br>del campus ]
        </div>
    </div>
</section>

{{-- ═══ MAPA ════════════════════════════════════════════════════════════════ --}}
<section style="border:1px solid #ccc;border-radius:6px;
                padding:2rem;margin-bottom:1.5rem;background:#fff;">

    <p style="text-align:center;font-size:.7rem;text-transform:uppercase;
              letter-spacing:.1em;color:#999;margin-bottom:.3rem;">
        Orientación espacial
    </p>
    <h2 style="text-align:center;font-size:1.3rem;font-weight:700;
               color:#222;margin-bottom:1.2rem;">
        Mapa del campus
    </h2>

    <div style="height:280px;background:#e8e8e8;border:1px dashed #bbb;
                border-radius:4px;display:flex;align-items:center;
                justify-content:center;font-size:.85rem;color:#aaa;
                letter-spacing:.08em;">
        🗺 &nbsp;[ Mapa interactivo del campus UTL ]
    </div>
</section>

{{-- ═══ FOOTER PLACEHOLDER ════════════════════════════════════════════════ --}}
<footer style="border:1px solid #ccc;border-radius:6px;
               padding:2rem;background:#f0f0f0;text-align:center;
               color:#aaa;font-size:.85rem;letter-spacing:.08em;">
    [ FOOTER ]
</footer>

@endsection