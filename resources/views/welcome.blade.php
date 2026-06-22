@extends('layouts.app')
@section('title', 'Inicio — SIIA')

@section('content')

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<style>
    .nav-links { display:flex; gap:2rem; }
    .nav-auth  { display:flex; align-items:center; gap:.75rem; }
    .hamburger { display:none; background:none; border:none; cursor:pointer;
                 padding:.25rem; flex-direction:column; gap:5px; }
    .hamburger span { display:block; width:22px; height:2px; background:#C8A84B; border-radius:2px; }
    .mobile-menu { display:none; flex-direction:column; gap:0;
                   background:rgba(6,6,15,0.97); padding:.5rem 0; }
    .mobile-menu a { display:block; padding:.75rem 2rem;
                     font-size:.85rem; color:#B0A898; text-decoration:none;
                     letter-spacing:.08em; text-transform:uppercase;
                     border-bottom:1px solid rgba(43,31,61,0.4); }
    .mobile-menu a:last-child { border-bottom:none; }
    .mobile-menu.open { display:flex; }

    @media (max-width: 768px) {
        .nav-links { display:none !important; }
        .nav-auth  { display:none !important; }
        .hamburger { display:flex !important; }
    }
</style>

<nav style="display:flex;align-items:center;justify-content:space-between;
            padding:.75rem 1.25rem;
            background:rgba(6,6,15,0.6);
            backdrop-filter:blur(12px);
            -webkit-backdrop-filter:blur(12px);
            position:sticky;
            top:0;
            z-index:100;
            isolation:isolate;">
    <span style="font-weight:700;font-size:1.4rem;color:#C8A84B;
                 letter-spacing:.12em;font-family:'Headland One',serif;">
        UTL
    </span>
    <div class="nav-links">
        <a href="{{ route('welcome') }}"   style="font-size:.82rem;color:#E8C96A;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Inicio</a>
        <a href="{{ route('quiz') }}"      style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Quiz</a>
        <a href="{{ route('recorrido') }}" style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Recorrido</a>
        <a href="{{ route('dominios') }}"  style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Dominios</a>
        <a href="{{ route('casas') }}"     style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Casas</a>
    </div>
    <div class="nav-auth">
        <a href="#" style="font-size:.82rem;color:#B0A898;text-decoration:none;
                           letter-spacing:.08em;text-transform:uppercase;">Ingresar</a>
        <div style="width:32px;height:32px;border-radius:50%;
                    background:#4A3560;border:1px solid #6B5080;"></div>
    </div>
    <button class="hamburger" id="hamburgerBtn" aria-label="Abrir menú">
        <span></span><span></span><span></span>
    </button>
</nav>

{{-- Menú móvil desplegable --}}
<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('welcome') }}"   style="color:#E8C96A;">Inicio</a>
    <a href="{{ route('quiz') }}">Quiz</a>
    <a href="{{ route('recorrido') }}">Recorrido</a>
    <a href="{{ route('dominios') }}">Dominios</a>
    <a href="{{ route('casas') }}">Casas</a>
    <a href="#">Ingresar</a>
</div>

{{-- ═══ HERO ═════════════════════════════════════════════════════════════════ --}}
<style>
    #hero-content {
        width: 50%;
        padding: 0 2rem;
    }
    #hero-title {
        font-size: clamp(9rem, 15vw, 14rem);
    }
    #hero-desc {
        font-size: 1.03rem;
        max-width: 480px;
    }
    #hero-btns a {
        padding: .85rem 3rem;
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        #hero {
            height: 100svh !important;
        }
        #hero-bg {
            background-position: center center !important;
        }
        #hero-overlay-left {
            background: linear-gradient(
                to bottom,
                rgba(6,6,15,0.55) 0%,
                rgba(6,6,15,0.30) 40%,
                rgba(6,6,15,0.70) 75%,
                rgba(6,6,15,1) 100%
            ) !important;
        }
        #hero-content {
            width: 100% !important;
            padding: 0 1.5rem !important;
            justify-content: flex-end !important;
            padding-bottom: 3.5rem !important;
        }
        #hero-title {
            font-size: clamp(6rem, 28vw, 9rem) !important;
        }
        #hero-desc {
            font-size: .92rem !important;
            max-width: 100% !important;
        }
        #hero-btns {
            flex-direction: column !important;
            align-items: stretch !important;
            width: 100% !important;
        }
        #hero-btns a {
            padding: .85rem 1.5rem !important;
            font-size: .9rem !important;
            text-align: center !important;
        }
    }
</style>

<section id="hero"
         style="position:relative;
                height:calc(100vh - 50px);
                overflow:hidden;
                background:#06060F;">

    <div id="hero-bg"
         style="position:absolute;inset:0;
                background-image:url('{{ asset('imagenes/hero-leon.webp') }}');
                background-size:cover;
                background-position:right center;">
    </div>

    <div id="hero-overlay-left"
         style="position:absolute;inset:0;
                background:linear-gradient(
                    to right,
                    rgba(15,10,3,0.95) 0%,
                    rgba(12,8,2,0.90) 23%,
                    rgba(6,6,15,.7) 45%,
                    rgba(6,6,15,.2) 65%,
                    transparent 100%
                );">
    </div>

    <div style="position:absolute;
                bottom:0;left:0;right:0;
                height:35%;
                background:linear-gradient(
                    to bottom,
                    transparent 0%,
                    rgba(6,6,15,.6) 50%,
                    #06060F 100%
                );
                z-index:1;">
    </div>

    <div id="hero-content"
         style="position:relative;z-index:2;
                height:100%;
                display:flex;
                flex-direction:column;
                justify-content:center;
                align-items:center;
                gap:1.5rem;">

        <h1 id="hero-title"
            style="margin:0;padding:0;
                   font-family:'Headland One',serif;
                   font-weight:700;
                   line-height:0.85;
                   letter-spacing:.02em;
                   background:linear-gradient(
                       to bottom,
                       #E8C96A 0%,
                       #C8A84B 20%,
                       #C6A050 40%,
                       #8D6627 60%,
                       #6B5020 80%,
                       #8B6914 100%
                   );
                   -webkit-background-clip:text;
                   -webkit-text-fill-color:transparent;
                   background-clip:text;">
            SIIA
        </h1>

        <p id="hero-desc"
           style="margin:0;
                  letter-spacing:.10em;
                  text-transform:uppercase;
                  line-height:2;
                  color:#F0EAD8;
                  text-align:center;">
            Forma parte de una casa que represente
            tus habilidades, valores y visión profesional.
        </p>

        <div id="hero-btns" style="display:flex;gap:1.5rem;margin-top:.5rem;">
            <a href="{{ route('quiz') }}"
               style="display:inline-block;
                      background:linear-gradient(135deg,#C6A050,#8D6627);
                      border:1px solid #C6A050;
                      border-radius:3px;
                      font-weight:700;
                      color:#1A1000;
                      text-decoration:none;
                      letter-spacing:.05em;">
                Iniciar
            </a>
            <a href="{{ route('casas') }}"
               style="display:inline-block;
                      border:1px solid #7A6030;
                      border-radius:3px;
                      color:#E8E0D0;
                      text-decoration:none;
                      background:transparent;
                      letter-spacing:.05em;">
                Conocer las casas
            </a>
        </div>
    </div>

</section>

{{-- ═══ SECCIÓN: DESCUBRE TU IDENTIDAD ════════════════════════════════════ --}}
<style>
    #identidad { padding: 3rem 4rem; }
    #identidad-cards { display:flex; gap:1.25rem; justify-content:center; }
    #identidad-cards > div { width:190px; height:190px; flex-shrink:0; }

    @media (max-width: 768px) {
        #identidad { padding: 2.5rem 1.25rem !important; }
        .section-rule { width: 80px !important; }
        #identidad-cards { gap:.85rem !important; }
        #identidad-cards > div { width:100px !important; height:100px !important; }
    }
    @media (max-width: 480px) {
        #identidad-cards > div { width:85px !important; height:85px !important; font-size:.65rem !important; }
        .identidad-shield { font-size:1.1rem !important; }
    }
</style>

<section id="identidad" style="background:rgba(6,6,15,0.15);">

    <div style="display:flex;align-items:center;gap:1.5rem;justify-content:center;margin-bottom:.5rem;">
        <div class="section-rule" style="height:1px;width:200px;background:linear-gradient(to left, #8D6627, transparent);"></div>
        <p style="margin:0;font-size:.7rem;text-transform:uppercase;
                  letter-spacing:.14em;color:#707085;white-space:nowrap;">
            Descubre tu identidad académica
        </p>
        <div class="section-rule" style="height:1px;width:200px;background:linear-gradient(to right, #8D6627, transparent);"></div>
    </div>

    <h2 style="text-align:center;font-size:1.5rem;font-weight:700;
               color:#FFFFFF;margin-bottom:2rem;
               font-family:'Headland One',serif;letter-spacing:.10em;
               text-transform:uppercase;">
        ¿A qué casa de la UTL perteneces?
    </h2>

    <div id="identidad-cards" style="margin-bottom:2rem;">
        @for ($i = 0; $i < 3; $i++)
        <div style="background:#14141F;
                    border:1px solid #2B1F3D;border-radius:6px;
                    display:flex;flex-direction:column;align-items:center;
                    justify-content:center;gap:.4rem;
                    font-size:.75rem;color:#707085;text-align:center;padding:.75rem;">
            <span class="identidad-shield" style="font-size:1.5rem;opacity:.5;">🛡</span>
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
<style>
    #dominios { padding: 3rem 4rem; }
    #carousel  { grid-template-columns: repeat(4,1fr); }
    .carousel-btn-left  { left:  -18px !important; }
    .carousel-btn-right { right: -18px !important; }

    @media (max-width: 900px) {
        #dominios { padding: 2.5rem 1.25rem !important; }
        #carousel  { grid-template-columns: repeat(2,1fr) !important; }
    }
    @media (max-width: 480px) {
        #carousel  { grid-template-columns: 1fr !important; }
        .carousel-btn-left  { left: 0 !important; }
        .carousel-btn-right { right: 0 !important; }
    }
</style>

<section id="dominios" style="background:rgba(6,6,15,0.15);">

    <div style="display:flex;align-items:center;gap:1.5rem;justify-content:center;margin-bottom:.5rem;">
        <div class="section-rule" style="height:1px;width:200px;background:linear-gradient(to left, #8D6627, transparent);"></div>
        <h2 style="margin:0;font-size:1.5rem;font-weight:700;
                   color:#FFFFFF;font-family:'Headland One',serif;
                   letter-spacing:.12em;text-transform:uppercase;white-space:nowrap;">
            Dominios Académicos
        </h2>
        <div class="section-rule" style="height:1px;width:200px;background:linear-gradient(to right, #8D6627, transparent);"></div>
    </div>

    <p style="text-align:center;font-size:.75rem;color:#B0A898;
              max-width:420px;margin:0 auto 2rem;line-height:1.7;
              letter-spacing:.08em;text-transform:uppercase;">
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

    {{-- Carrusel --}}
    <div style="position:relative;">
        <button class="carousel-btn-left"
                onclick="document.getElementById('carousel').scrollBy({left:-260,behavior:'smooth'})"
                style="position:absolute;top:50%;transform:translateY(-50%);
                       width:32px;height:32px;border-radius:50%;
                       border:1px solid #2B1F3D;background:#14141F;
                       color:#C8A84B;font-size:1.1rem;cursor:pointer;z-index:2;">
            ‹
        </button>

        <div id="carousel"
             style="display:grid;gap:.85rem;overflow:hidden;">
            @for ($i = 0; $i < 4; $i++)
            <div style="border:1px solid #2B1F3D;border-radius:6px;
                        padding:.85rem;background:#14141F;
                        display:flex;flex-direction:column;gap:.5rem;">
                <div style="width:100%;aspect-ratio:1;background:#0D0D1A;
                            border:1px dashed #2B1F3D;border-radius:4px;
                            display:flex;align-items:center;justify-content:center;
                            font-size:.72rem;color:#707085;text-align:center;padding:.5rem;">
                    [ Escudo /<br>imagen casa ]
                </div>
                <p style="font-size:.82rem;font-weight:700;color:#F0EAD8;margin:0;
                           font-family:'Headland One',serif;">Nombre casa</p>
                <p style="font-size:.75rem;color:#B0A898;margin:0;">Nombre carrera</p>
                <p style="font-size:.72rem;color:#C8A84B;font-style:italic;margin:0;">Frase distintiva</p>
                <div style="display:flex;flex-wrap:wrap;gap:3px;">
                    <span style="font-size:.65rem;padding:2px 7px;border:1px solid #2B1F3D;
                                 border-radius:20px;color:#707085;background:#0D0D1A;">valor</span>
                    <span style="font-size:.65rem;padding:2px 7px;border:1px solid #2B1F3D;
                                 border-radius:20px;color:#707085;background:#0D0D1A;">valor</span>
                    <span style="font-size:.65rem;padding:2px 7px;border:1px solid #2B1F3D;
                                 border-radius:20px;color:#707085;background:#0D0D1A;">valor</span>
                </div>
                <p style="font-size:.68rem;color:#707085;line-height:1.5;margin:0;">
                    Significado del escudo, relación con la carrera y sus valores.
                </p>
            </div>
            @endfor
        </div>

        <button class="carousel-btn-right"
                onclick="document.getElementById('carousel').scrollBy({left:260,behavior:'smooth'})"
                style="position:absolute;top:50%;transform:translateY(-50%);
                       width:32px;height:32px;border-radius:50%;
                       border:1px solid #2B1F3D;background:#14141F;
                       color:#C8A84B;font-size:1.1rem;cursor:pointer;z-index:2;">
            ›
        </button>
    </div>
</section>

{{-- ═══ FOOTER ════════════════════════════════════════════════════════════ --}}
<footer id="footer-casas"
        style="background:#06060F;border-top:1px solid #2B1F3D;">
    <div id="footer-casas-grid">
        <div style="text-align:left;max-width:400px;">
            <h3 style="font-family:'Headland One',serif;color:#C8A84B;
                       margin-bottom:1rem;font-size:1.4rem;">
                Universidad Tecnológica de León
            </h3>
            <p style="color:#F0EAD8;line-height:1.8;margin:0;">
                Blvd. Universidad Tecnológica #225 Col. San Carlos<br>
                C.P. 37670 León, Gto. México<br><br>
                difusion@utleon.edu.mx<br><br>
                (477) 7 10 00 20
            </p>
        </div>
        <div style="text-align:left;max-width:450px;">
            <h3 style="font-family:'Headland One',serif;color:#C8A84B;
                       margin-bottom:1rem;font-size:1.4rem;">
                Desarrolladores del Proyecto
            </h3>
            <p style="color:#F0EAD8;line-height:2;margin:0;">
                <strong>Citlalli Méndez</strong><br>citlallialejandrams@gmail.com<br><br>
                <strong>Miryam Muñoz</strong><br>miryammunoz26@gmail.com<br><br>
                <strong>Carlo Flores</strong><br>carlofernandoflores2006@gmail.com
            </p>
        </div>
    </div>
    <div style="margin-top:2.5rem;border-top:1px solid rgba(200,168,75,.15);
                padding-top:1.5rem;text-align:center;color:#707085;
                font-size:.8rem;letter-spacing:.08em;">
        © {{ date('Y') }} SIIA · Sistema Integral de Identidad Académica
    </div>
</footer>
@push('extra-js')
<script>
    const btn  = document.getElementById('hamburgerBtn');
    const menu = document.getElementById('mobileMenu');
    btn.addEventListener('click', () => {
        menu.classList.toggle('open');
        btn.setAttribute('aria-expanded', menu.classList.contains('open'));
    });
    document.addEventListener('click', e => {
        if (!btn.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove('open');
        }
    });
</script>
@endpush

@endsection