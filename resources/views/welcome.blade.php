@extends('layouts.app')
@section('title', 'Inicio — SIIA')

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
        <a href="{{ route('recorrido') }}"     style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Recorrido</a>
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

{{-- ═══ HERO ═════════════════════════════════════════════════════════════════ --}}
<section id="hero"
         style="display:grid;grid-template-columns:1fr 1fr;
                min-height:400px;
                background:#06060F;">

    {{-- Columna izquierda --}}
    <div style="padding:3rem 3rem 3rem 4rem;display:flex;flex-direction:column;
                justify-content:center;gap:1.5rem;">

        {{-- Título SIIA --}}
        <div style="font-family:'Headland One',serif;font-size:5rem;font-weight:700;
                    color:#C8A84B;letter-spacing:.04em;line-height:1;
                    text-shadow:0 2px 24px rgba(198,160,80,.25);">
            SIIA
        </div>

        <p style="font-size:.82rem;color:#F0EAD8;max-width:320px;line-height:1.8;
                  margin:0;letter-spacing:.04em;text-transform:uppercase;">
            Forma parte de una casa que represente<br>tus habilidades, valores y visión profesional.
        </p>

        <div style="display:flex;gap:1rem;">
            <a href="{{ route('quiz') }}"
               style="padding:.6rem 1.8rem;
                      background:linear-gradient(135deg,#C6A050,#8D6627);
                      border:1px solid #C6A050;border-radius:4px;
                      font-size:.85rem;font-weight:600;color:#06060F;
                      text-decoration:none;letter-spacing:.06em;">
                Iniciar
            </a>
            <a href="{{ route('casas') }}"
               style="padding:.6rem 1.8rem;
                      border:1px solid #8D6627;border-radius:4px;
                      font-size:.85rem;color:#F0EAD8;text-decoration:none;
                      background:transparent;letter-spacing:.06em;">
                Conocer las casas
            </a>
        </div>
    </div>

    {{-- Columna derecha: imagen hero --}}
    <div style="background:#06060F;display:flex;align-items:center;
                justify-content:center;min-height:360px;
                border-left:1px solid #2B1F3D;">
        <div style="width:240px;height:240px;
                    background:#14141F;
                    border:1px dashed #2B1F3D;border-radius:4px;
                    display:flex;flex-direction:column;align-items:center;
                    justify-content:center;gap:.4rem;
                    font-size:.75rem;color:#707085;text-align:center;padding:1rem;">
            <span style="font-size:2rem;opacity:.4;">🖼</span>
            [ Imagen / ilustración hero ]
        </div>
    </div>
</section>

{{-- ═══ SECCIÓN: DESCUBRE TU IDENTIDAD ════════════════════════════════════ --}}
<section id="identidad"
         style="padding:3rem 4rem;
                background:#0D0D1A;
                border-top:1px solid #2B1F3D;
                border-bottom:1px solid #2B1F3D;">

    <p style="text-align:center;font-size:.7rem;text-transform:uppercase;
              letter-spacing:.14em;color:#707085;margin-bottom:.4rem;">
        Descubre tu identidad académica
    </p>
    <h2 style="text-align:center;font-size:1.5rem;font-weight:700;
               color:#FFFFFF;margin-bottom:2rem;
               font-family:'Headland One',serif;letter-spacing:.06em;">
        ¿A qué casa de la UTL perteneces?
    </h2>

    {{-- 3 placeholders de casas --}}
    <div style="display:flex;gap:1.25rem;justify-content:center;margin-bottom:2rem;">
        @for ($i = 0; $i < 3; $i++)
        <div style="width:190px;height:190px;
                    background:#14141F;
                    border:1px solid #2B1F3D;border-radius:6px;
                    display:flex;flex-direction:column;align-items:center;
                    justify-content:center;gap:.4rem;
                    font-size:.75rem;color:#707085;text-align:center;padding:.75rem;">
            <span style="font-size:1.5rem;opacity:.5;">🛡</span>
            [ Escudo o imagen<br>representativa de casa ]
        </div>
        @endfor
    </div>

    <div style="text-align:center;">
        <a href="{{ route('quiz') }}"
           style="display:inline-block;padding:.55rem 2.2rem;
                  border:1px solid #8D6627;border-radius:4px;
                  font-size:.88rem;font-weight:600;color:#E8C96A;
                  text-decoration:none;background:transparent;
                  letter-spacing:.08em;">
            ¡Descúbrelo ya!
        </a>
    </div>
</section>

{{-- ═══ SECCIÓN: DOMINIOS ACADÉMICOS ══════════════════════════════════════ --}}
<section id="dominios"
         style="padding:3rem 4rem;
                background:#0D0D1A;">

    <p style="text-align:center;font-size:.7rem;text-transform:uppercase;
              letter-spacing:.14em;color:#707085;margin-bottom:.4rem;">
        Dominios académicos
    </p>
    <p style="text-align:center;font-size:.85rem;color:#B0A898;
              max-width:420px;margin:0 auto 2rem;line-height:1.7;">
        Explora los dominios académicos que conforman la Universidad Tecnológica de León.
    </p>

    {{-- Banner del dominio activo --}}
    <div style="border:1px solid #2B1F3D;border-radius:6px;
                padding:1.2rem 1.5rem;display:flex;align-items:flex-start;
                gap:1.25rem;margin-bottom:1.5rem;
                background:#14141F;">

        <div style="width:56px;height:56px;flex-shrink:0;
                    background:#0D0D1A;border:1px dashed #2B1F3D;border-radius:4px;
                    display:flex;flex-direction:column;align-items:center;
                    justify-content:center;font-size:.65rem;color:#707085;text-align:center;">
            Ícono<br>dominio
        </div>

        <div>
            <p style="font-size:.95rem;font-weight:700;color:#F0EAD8;margin-bottom:.3rem;
                      font-family:'Headland One',serif;letter-spacing:.04em;">
                Nombre del dominio
            </p>
            <p style="font-size:.82rem;color:#B0A898;line-height:1.5;margin:0;">
                Carreras que lo conforman
            </p>
        </div>
    </div>

    {{-- Carrusel de casas --}}
    <div style="position:relative;">

        <button onclick="document.getElementById('carousel').scrollBy({left:-260,behavior:'smooth'})"
                style="position:absolute;left:-18px;top:50%;transform:translateY(-50%);
                       width:32px;height:32px;border-radius:50%;
                       border:1px solid #2B1F3D;background:#14141F;
                       color:#C8A84B;font-size:1.1rem;cursor:pointer;z-index:2;">
            ‹
        </button>

        <div id="carousel"
             style="display:grid;grid-template-columns:repeat(4,1fr);
                    gap:.85rem;overflow:hidden;">

            @for ($i = 0; $i < 4; $i++)
            <div style="border:1px solid #2B1F3D;border-radius:6px;
                        padding:.85rem;
                        background:#14141F;
                        display:flex;flex-direction:column;gap:.5rem;">

                <div style="width:100%;aspect-ratio:1;
                            background:#0D0D1A;
                            border:1px dashed #2B1F3D;border-radius:4px;
                            display:flex;align-items:center;justify-content:center;
                            font-size:.72rem;color:#707085;text-align:center;padding:.5rem;">
                    [ Escudo /<br>imagen casa ]
                </div>

                <p style="font-size:.82rem;font-weight:700;color:#F0EAD8;margin:0;
                           font-family:'Headland One',serif;">
                    Nombre casa
                </p>
                <p style="font-size:.75rem;color:#B0A898;margin:0;">
                    Nombre carrera
                </p>
                <p style="font-size:.72rem;color:#C8A84B;font-style:italic;margin:0;">
                    Frase distintiva
                </p>

                <div style="display:flex;flex-wrap:wrap;gap:3px;">
                    <span style="font-size:.65rem;padding:2px 7px;
                                 border:1px solid #2B1F3D;border-radius:20px;
                                 color:#707085;background:#0D0D1A;">valor</span>
                    <span style="font-size:.65rem;padding:2px 7px;
                                 border:1px solid #2B1F3D;border-radius:20px;
                                 color:#707085;background:#0D0D1A;">valor</span>
                    <span style="font-size:.65rem;padding:2px 7px;
                                 border:1px solid #2B1F3D;border-radius:20px;
                                 color:#707085;background:#0D0D1A;">valor</span>
                </div>

                <p style="font-size:.68rem;color:#707085;line-height:1.5;margin:0;">
                    Significado del escudo, relación con la carrera y sus valores.
                </p>
            </div>
            @endfor

        </div>

        <button onclick="document.getElementById('carousel').scrollBy({left:260,behavior:'smooth'})"
                style="position:absolute;right:-18px;top:50%;transform:translateY(-50%);
                       width:32px;height:32px;border-radius:50%;
                       border:1px solid #2B1F3D;background:#14141F;
                       color:#C8A84B;font-size:1.1rem;cursor:pointer;z-index:2;">
            ›
        </button>
    </div>
</section>

{{-- ═══ FOOTER ════════════════════════════════════════════════════════════ --}}
<footer style="padding:2rem 4rem;
               background:#06060F;
               border-top:1px solid #2B1F3D;
               text-align:center;
               color:#707085;font-size:.8rem;letter-spacing:.1em;
               text-transform:uppercase;">
    [ FOOTER ]
</footer>

@endsection