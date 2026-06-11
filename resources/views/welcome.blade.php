@extends('layouts.app')
@section('title', 'Inicio — SIIA')

@section('content')

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<nav style="display:flex;align-items:center;justify-content:space-between;
            padding:.75rem 1.5rem;border:1px solid #ccc;border-radius:6px;
            margin-bottom:1.5rem;background:#f9f9f9;">
    <span style="font-weight:700;font-size:.95rem;color:#333;">UTL</span>
    <div style="display:flex;gap:1.5rem;">
        <a href="{{ route('welcome') }}"      style="font-size:.85rem;color:#555;text-decoration:none;">Inicio</a>
        <a href="{{ route('quiz') }}"      style="font-size:.85rem;color:#555;text-decoration:none;">Quiz</a>
        <a href="{{ route('recorrido') }}" style="font-size:.85rem;color:#555;text-decoration:none;">Recorrido</a>
        <a href="{{ route('dominios') }}"  style="font-size:.85rem;color:#555;text-decoration:none;">Dominios</a>
        <a href="{{ route('casas') }}"     style="font-size:.85rem;color:#555;text-decoration:none;">Casas</a>
    </div>
    <div style="display:flex;align-items:center;gap:.75rem;">
           style="font-size:.85rem;color:#555;text-decoration:none;
                  border:1px solid #bbb;padding:.3rem .9rem;border-radius:4px;">
            Ingresar
        </a>
        {{-- Avatar placeholder --}}
        <div style="width:32px;height:32px;border-radius:50%;
                    background:#ddd;border:1px solid #bbb;"></div>
    </div>
</nav>

{{-- ═══ HERO ═════════════════════════════════════════════════════════════════ --}}
<section id="hero"
         style="display:grid;grid-template-columns:1fr 1fr;
                border:1px solid #ccc;border-radius:6px;
                overflow:hidden;margin-bottom:1.5rem;min-height:280px;">

    {{-- Columna izquierda --}}
    <div style="padding:2rem;display:flex;flex-direction:column;
                justify-content:center;gap:1rem;
                border-right:1px solid #ccc;background:#fff;">

        {{-- Placeholder logo/título SIIA --}}
        <div style="width:160px;height:60px;background:#e8e8e8;
                    border:1px dashed #999;border-radius:4px;
                    display:flex;align-items:center;justify-content:center;
                    font-size:.75rem;color:#888;">
            [ Logo / Título SIIA ]
        </div>

        <p style="font-size:.85rem;color:#555;max-width:280px;line-height:1.6;margin:0;">
          El Sistema de Identidad Institucional Académica de la UTL. Descubre tu casa, explora los dominios académicos y conecta con tu identidad universitaria.
        </p>

        <div style="display:flex;gap:.75rem;">
            <a href="{{ route('quiz') }}"
               style="padding:.45rem 1.2rem;border:1px solid #333;border-radius:4px;
                      font-size:.85rem;font-weight:600;color:#333;
                      text-decoration:none;background:#fff;">
                Iniciar
            </a>
            <a href="{{ route('casas') }}"
               style="padding:.45rem 1.2rem;border:1px solid #145395;border-radius:4px;
                      font-size:.85rem;color:#555;text-decoration:none;background:#fff;">
                Conocer las casas
            </a>
        </div>
    </div>

    {{-- Columna derecha: imagen hero --}}
    <div style="background:#f0f0f0;display:flex;align-items:center;
                justify-content:center;min-height:260px;">
        <div style="width:200px;height:200px;background:#ddd;
                    border:1px dashed #999;border-radius:4px;
                    display:flex;flex-direction:column;align-items:center;
                    justify-content:center;gap:.4rem;
                    font-size:.75rem;color:#888;text-align:center;padding:1rem;">
            <span style="font-size:1.8rem;">🖼</span>
            [ Imagen / ilustración hero ]
        </div>
    </div>
</section>

{{-- ═══ SECCIÓN: DESCUBRE TU IDENTIDAD ════════════════════════════════════ --}}
<section id="identidad"
         style="border:1px solid #ccc;border-radius:6px;
                padding:2rem;margin-bottom:1.5rem;background:#fff;">

    {{-- Etiqueta superior --}}
    <p style="text-align:center;font-size:.7rem;text-transform:uppercase;
              letter-spacing:.1em;color:#999;margin-bottom:.3rem;">
        Descubre tu identidad académica
    </p>
    <h2 style="text-align:center;font-size:1.3rem;font-weight:700;
               color:#222;margin-bottom:1.5rem;">
        ¿A qué casa de la UTL perteneces?
    </h2>

    {{-- 3 placeholders de casas --}}
    <div style="display:flex;gap:1rem;justify-content:center;margin-bottom:1.5rem;">
        @for ($i = 0; $i < 3; $i++)
        <div style="width:180px;height:180px;background:#f0f0f0;
                    border:1px dashed #bbb;border-radius:6px;
                    display:flex;flex-direction:column;align-items:center;
                    justify-content:center;gap:.4rem;
                    font-size:.75rem;color:#999;text-align:center;padding:.75rem;">
            <span style="font-size:1.5rem;">🛡</span>
            [ Escudo o imagen<br>representativa de casa ]
        </div>
        @endfor
    </div>

    {{-- Botón descúbrelo ya --}}
    <div style="text-align:center;">
        <a href="{{ route('quiz') }}"
           style="display:inline-block;padding:.5rem 2rem;
                  border:1px solid #555;border-radius:4px;
                  font-size:.9rem;font-weight:600;color:#333;
                  text-decoration:none;background:#fff;">
            ¡Descúbrelo ya!
        </a>
    </div>
</section>

{{-- ═══ SECCIÓN: DOMINIOS ACADÉMICOS ══════════════════════════════════════ --}}
<section id="dominios"
         style="border:1px solid #ccc;border-radius:6px;
                padding:2rem;margin-bottom:1.5rem;background:#fff;">

    {{-- Encabezado --}}
    <p style="text-align:center;font-size:.7rem;text-transform:uppercase;
              letter-spacing:.1em;color:#999;margin-bottom:.3rem;">
        Dominios académicos
    </p>
    <p style="text-align:center;font-size:.85rem;color:#666;
              max-width:420px;margin:0 auto 1.5rem;line-height:1.6;">
        Explora los dominios académicos que conforman la Universidad Tecnológica de León.
    </p>

    {{-- Banner del dominio activo --}}
    <div style="border:1px solid #ccc;border-radius:6px;
                padding:1rem;display:flex;align-items:flex-start;
                gap:1rem;margin-bottom:1.2rem;background:#f9f9f9;">

        {{-- Ícono del dominio --}}
        <div style="width:56px;height:56px;flex-shrink:0;
                    background:#e0e0e0;border:1px dashed #bbb;border-radius:4px;
                    display:flex;flex-direction:column;align-items:center;
                    justify-content:center;font-size:.65rem;color:#999;text-align:center;">
            Ícono<br>dominio
        </div>

        <div>
            <p style="font-size:.95rem;font-weight:700;color:#222;margin-bottom:.3rem;">
                Nombre del dominio 
            </p>
            <p style="font-size:.82rem;color:#666;line-height:1.5;margin:0;">
                Carreras que lo conforman 
            </p>
        </div>
    </div>

    {{-- Carrusel de casas --}}
    <div style="position:relative;">

        {{-- Etiqueta flechas --}}
        <span style="position:absolute;right:0;top:-20px;
                     font-size:.65rem;color:#aaa;">
            Flechas carrusel
        </span>

        {{-- Flecha izquierda --}}
        <button onclick="document.getElementById('carousel').scrollBy({left:-260,behavior:'smooth'})"
                style="position:absolute;left:-18px;top:50%;transform:translateY(-50%);
                       width:32px;height:32px;border-radius:50%;
                       border:1px solid #ccc;background:#fff;
                       font-size:1rem;cursor:pointer;z-index:2;">
            ‹
        </button>

        {{-- Cards de casas --}}
        <div id="carousel"
             style="display:grid;grid-template-columns:repeat(4,1fr);
                    gap:.75rem;overflow:hidden;">

            @for ($i = 0; $i < 4; $i++)
            <div style="border:1px solid #ccc;border-radius:6px;
                        padding:.75rem;background:#f9f9f9;
                        display:flex;flex-direction:column;gap:.5rem;">

                {{-- Escudo --}}
                <div style="width:100%;aspect-ratio:1;background:#e0e0e0;
                            border:1px dashed #bbb;border-radius:4px;
                            display:flex;align-items:center;justify-content:center;
                            font-size:.72rem;color:#999;text-align:center;padding:.5rem;">
                    [ Escudo /<br>imagen casa ]
                </div>

                <p style="font-size:.82rem;font-weight:700;color:#222;margin:0;">
                    Nombre casa
                </p>
                <p style="font-size:.75rem;color:#555;margin:0;">
                    Nombre carrera
                </p>
                <p style="font-size:.72rem;color:#888;font-style:italic;margin:0;">
                    Frase distintiva
                </p>

                {{-- Badges de valores --}}
                <div style="display:flex;flex-wrap:wrap;gap:3px;">
                    <span style="font-size:.65rem;padding:2px 6px;
                                 border:1px solid #ccc;border-radius:20px;color:#666;">
                        valor
                    </span>
                    <span style="font-size:.65rem;padding:2px 6px;
                                 border:1px solid #ccc;border-radius:20px;color:#666;">
                        valor
                    </span>
                    <span style="font-size:.65rem;padding:2px 6px;
                                 border:1px solid #ccc;border-radius:20px;color:#666;">
                        valor
                    </span>
                </div>

                <p style="font-size:.68rem;color:#999;line-height:1.4;margin:0;">
                    Significado del escudo, relación con la carrera y sus valores.
                </p>
            </div>
            @endfor

        </div>

        {{-- Flecha derecha --}}
        <button onclick="document.getElementById('carousel').scrollBy({left:260,behavior:'smooth'})"
                style="position:absolute;right:-18px;top:50%;transform:translateY(-50%);
                       width:32px;height:32px;border-radius:50%;
                       border:1px solid #ccc;background:#fff;
                       font-size:1rem;cursor:pointer;z-index:2;">
            ›
        </button>
    </div>
</section>

{{-- ═══ FOOTER PLACEHOLDER ════════════════════════════════════════════════ --}}
<footer style="border:1px solid #ccc;border-radius:6px;
               padding:2rem;background:#f0f0f0;text-align:center;
               color:#aaa;font-size:.85rem;letter-spacing:.08em;">
    [ FOOTER ]
</footer>

@endsection