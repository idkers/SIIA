@extends('layouts.app')
@section('title', 'Recorrido — SIIA')

@section('content')

{{-- ═══ ESTILOS GLOBALES ═══════════════════════════════════════════════════ --}}
<style>
    /* ── Reset mínimo ── */
    *, *::before, *::after { box-sizing: border-box; }

    /* ── Navbar ── */
    .nav-links { display:flex; gap:2rem; }
    .nav-auth  { display:flex; align-items:center; gap:.75rem; }
    .hamburger { display:none; background:none; border:none; cursor:pointer;
                 padding:.25rem; flex-direction:column; gap:5px; }
    .hamburger span { display:block; width:22px; height:2px;
                      background:#C8A84B; border-radius:2px; }
    .mobile-menu { display:none; flex-direction:column;
                   background:rgba(6,6,15,0.97); padding:.5rem 0; }
    .mobile-menu a { display:block; padding:.75rem 2rem; font-size:.85rem;
                     color:#B0A898; text-decoration:none; letter-spacing:.08em;
                     text-transform:uppercase;
                     border-bottom:1px solid rgba(43,31,61,0.4); }
    .mobile-menu a:last-child { border-bottom:none; }
    .mobile-menu.open { display:flex; }

    /* ── Contenedor de página ── */
    .page-wrap {
        display: flex;
        flex-direction: column;
        min-height: calc(100vh - 54px); /* 54px = altura aprox del navbar */
    }
    .page-content { flex: 1; padding: 1.5rem 2rem; }

    /* ── Hero ── */
    .hero-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 500px;
        align-items: center;
    }
    .hero-text { padding: 4rem; }
    .hero-title { font-size: 4rem; margin: .5rem 0; }
    .hero-desc  { max-width: 500px; }
    .hero-video-wrap {
        padding: 2rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .video-frame {
        width: 100%;
        max-width: 600px;
        aspect-ratio: 16/9;
        border: 2px solid #C6A050;
        border-radius: 10px;
        overflow: hidden;
        background: #14141F;
    }
    .video-frame iframe { width:100%; height:100%; display:block; }

    /* ── Mapa ── */
    .map-frame {
        height: 500px;
        background: #1A1424;
        border: 2px solid #C6A050;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #F0EAD8;
        font-size: 1rem;
    }

    /* ── Footer ── */
    .footer-grid { display:flex; justify-content:space-around;
                   flex-wrap:wrap; gap:3rem; }

    /* ══════════════════════════════
       RESPONSIVE — TABLET ≤ 900px
       ══════════════════════════════ */
    @media (max-width: 900px) {
        .hero-grid { grid-template-columns: 1fr; }
        .hero-text  { padding: 3rem 2rem 1.5rem; }
        .hero-title { font-size: 3rem; }
        .hero-desc  { max-width: 100%; }
        .hero-video-wrap { padding: 0 2rem 2.5rem; }
        .map-frame  { height: 400px; }
    }

    /* ══════════════════════════════
       RESPONSIVE — MÓVIL ≤ 600px
       ══════════════════════════════ */
    @media (max-width: 600px) {
        .nav-links { display:none !important; }
        .nav-auth  { display:none !important; }
        .hamburger { display:flex !important; }

        .page-content { padding: 1rem; }

        .hero-text  { padding: 2rem 1.25rem 1rem; text-align: center; }
        .hero-title { font-size: 2.4rem; }
        .hero-desc  { font-size: .9rem; }
        .hero-actions { justify-content: center !important; }
        .hero-actions a { width: 100%; text-align: center; }

        .hero-video-wrap { padding: 0 1.25rem 2rem; }
        /* El video queda a ancho completo y alto proporcional 16/9 automático */

        .map-frame { height: 280px; font-size: .85rem; }

        #mapa { padding: 1.75rem 1.25rem !important; }
        #mapa h2 { font-size: 1.15rem !important; margin-bottom: 1.25rem !important; }

        .footer-grid { flex-direction: column; gap: 2rem; }
        .footer-grid > div { max-width: 100% !important; }
        .footer-grid h3 { font-size: 1.1rem !important; }
        footer { padding: 2.5rem 1.25rem !important; }
    }
</style>

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<nav style="display:flex;align-items:center;justify-content:space-between;
            padding:.75rem 1.25rem;
            background:rgba(6,6,15,0.6);
            backdrop-filter:blur(12px);
            -webkit-backdrop-filter:blur(12px);
            position:sticky;top:0;z-index:100;isolation:isolate;">
    <span style="font-weight:700;font-size:1.4rem;color:#C8A84B;
                 letter-spacing:.12em;font-family:'Headland One',serif;">
        UTL
    </span>
    <div class="nav-links">
        <a href="{{ route('welcome') }}"   style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Inicio</a>
        <a href="{{ route('quiz') }}"      style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Quiz</a>
        <a href="{{ route('recorrido') }}" style="font-size:.82rem;color:#E8C96A;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Recorrido</a>
        <a href="{{ route('dominios') }}"  style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Dominios</a>
        <a href="{{ route('casas') }}"     style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Casas</a>
    </div>
    <div class="nav-auth">
        <a href="#" style="font-size:.82rem;color:#B0A898;text-decoration:none;
                           letter-spacing:.08em;text-transform:uppercase;">Ingresar</a>
        <div style="width:32px;height:32px;border-radius:50%;
                    background:#4A3560;border:1px solid #6B5080;"></div>
    </div>
    <button class="hamburger" id="hamburgerBtn" aria-label="Abrir menú" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>
</nav>

{{-- Menú móvil --}}
<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('welcome') }}">Inicio</a>
    <a href="{{ route('quiz') }}">Quiz</a>
    <a href="{{ route('recorrido') }}" style="color:#E8C96A;">Recorrido</a>
    <a href="{{ route('dominios') }}">Dominios</a>
    <a href="{{ route('casas') }}">Casas</a>
    <a href="#">Ingresar</a>
</div>

{{-- ═══ CONTENIDO PRINCIPAL ════════════════════════════════════════════════ --}}
<div class="page-wrap">
<div class="page-content">

    {{-- ── Hero ── --}}
    <section style="background:linear-gradient(rgba(6,6,15,.85),rgba(6,6,15,.95)),
                                url('/img/campus-bg.jpg');
                    background-size:cover;background-position:center;
                    border:1px solid #8B6914;border-radius:10px;
                    overflow:hidden;margin-bottom:2rem;">

        <div class="hero-grid">

            <div class="hero-text">
                <span style="color:#E8C96A;letter-spacing:4px;
                             text-transform:uppercase;font-size:.8rem;">
                    Exploración UTL
                </span>

                <h1 class="hero-title siia-title"
                    style="font-family:'Headland One',serif;color:#C8A84B;">
                    RECORRIDO<br>VIRTUAL
                </h1>

                <p class="hero-desc"
                   style="color:#F0EAD8;line-height:1.8;">
                    ¡Descubre laboratorios, edificios académicos,
                    áreas deportivas y espacios emblemáticos de la
                    Universidad Tecnológica de León mediante una
                    experiencia inmersiva con nuestro nuevo videojuego!
                </p>

                <div class="hero-actions"
                     style="margin-top:2rem;display:flex;gap:1rem;">
                    <a href="#mapa"
                       style="background:#C6A050;color:#06060F;
                              padding:.9rem 2rem;text-decoration:none;
                              font-weight:700;border-radius:4px;
                              display:inline-block;">
                        Descargar
                    </a>
                </div>
            </div>

            <div class="hero-video-wrap">
                <div class="video-frame">
                    <iframe
                        src="https://www.youtube.com/embed/AqpQu6D0Yyc?si=OTlRThrGbrbJjgJR"
                        title="Recorrido UTL"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write;
                               encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>

        </div>
    </section>

    {{-- ── Mapa ── --}}
    <section id="mapa"
             style="background:#14141F;border:1px solid #8B6914;
                    border-radius:10px;padding:3rem;margin-bottom:2rem;">

        <h2 style="text-align:center;color:#FFFFFF;
                   font-family:'Headland One',serif;margin-bottom:2rem;">
            ───── MAPA DEL CAMPUS ─────
        </h2>

        <div class="map-frame">
            [Mapa interactivo]
        </div>

    </section>

</div>{{-- /page-content --}}

{{-- ═══ FOOTER ════════════════════════════════════════════════════════════ --}}
<footer style="padding:3rem 4rem;background:#06060F;border-top:1px solid #2B1F3D;">
    <div class="footer-grid">
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
                <strong>Citlalli Méndez</strong><br>
                citlallialejandrams@gmail.com<br><br>
                <strong>Miryam Muñoz</strong><br>
                miryammunoz26@gmail.com<br><br>
                <strong>Carlo Flores</strong><br>
                carlofernandoflores2006@gmail.com
            </p>
        </div>
    </div>
    <div style="margin-top:2.5rem;border-top:1px solid rgba(200,168,75,.15);
                padding-top:1.5rem;text-align:center;color:#707085;
                font-size:.8rem;letter-spacing:.08em;">
        © {{ date('Y') }} SIIA · Sistema Integral de Identidad Académica
    </div>
</footer>

</div>{{-- /page-wrap --}}

@push('extra-js')
<script>
    const btn  = document.getElementById('hamburgerBtn');
    const menu = document.getElementById('mobileMenu');
    btn.addEventListener('click', () => {
        menu.classList.toggle('open');
        btn.setAttribute('aria-expanded', menu.classList.contains('open'));
    });
    document.addEventListener('click', e => {
        if (!btn.contains(e.target) && !menu.contains(e.target))
            menu.classList.remove('open');
    });
</script>
@endpush

@endsection