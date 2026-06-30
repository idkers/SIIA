@extends('layouts.app')
@section('title', 'Quiz — SIIA')

@section('content')

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<style>
    /* ── Layout general: footer siempre al fondo ── */
    html, body { height: 100%; margin: 0; }
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    /* Anular cualquier min-height que el layout padre ponga en main u otros wrappers */
    body > main,
    body > .main-content,
    body > #app,
    body > #content,
    body > .content {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: unset !important;
    }
    /* El wrapper del contenido de @yield('content') debe crecer */
    .page-content-wrapper {
        flex: 1 0 auto;
        display: flex;
        flex-direction: column;
    }
    /* El footer nunca crece, se queda al fondo */
    #footer-main { flex-shrink: 0; }

    /* ── Navbar ── */
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

    /* ── Stage wrap ── */
    .stage-wrap {
        padding: 2rem;
        /* Permite que cada etapa llene el espacio vertical disponible */
        flex: 1;
        display: flex;
        flex-direction: column;
        /* Evita desbordamiento horizontal */
        overflow-x: hidden;
        box-sizing: border-box;
        width: 100%;
    }
    @media (max-width: 768px) {
        .stage-wrap { padding: .6rem !important; }
    }
    .stage {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .stage-wrap > section {
        flex: 1;
    }

    /* ── ETAPA 1 — base (desktop) ── */
    #stage-1-inner {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        min-height: 550px;
        padding: 4rem;
        gap: 2rem;
    }
    #stage-1-title { font-size: 4rem; }
    #stage-1-img   { max-width: 820px; width: 100%; display: block; }

    /* mobile — clase aplicada por JS para garantizar que funcione */
    #stage-1-inner.mobile-layout {
        grid-template-columns: 1fr !important;
        padding: 2rem 1rem !important;
        min-height: auto !important;
        text-align: center !important;
        /* Evita que el contenido se desborde */
        overflow: hidden !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    #stage-1-inner.mobile-layout #stage-1-title {
        /* clamp: nunca mas grande de lo que cabe */
        font-size: clamp(1.6rem, 8vw, 2.4rem) !important;
        line-height: 1.15 !important;
        word-break: break-word !important;
        overflow-wrap: break-word !important;
    }
    #stage-1-inner.mobile-layout #stage-1-img-wrap {
        order: -1;
        display: flex !important;
        justify-content: center !important;
        width: 100% !important;
    }
    #stage-1-inner.mobile-layout #stage-1-img {
        width: 65vw !important;
        max-width: 65vw !important;
        margin: 0 auto !important;
    }
    #stage-1-inner.mobile-layout #stage-1-desc {
        max-width: 100% !important;
        font-size: .9rem !important;
        line-height: 1.7 !important;
    }
    #stage-1-inner.mobile-layout #stage-1-btn {
        width: 100% !important;
        box-sizing: border-box !important;
    }

    /* ── ETAPA 2 ── */
    #stage-2-inner {
        padding: 2.5rem 2rem;
        min-height: 420px;
    }
    #stage-2-ref-img {
        width: 200px;
        height: 200px;
        flex-shrink: 0;
    }
    #stage-2-btn { align-self: center; }

    @media (max-width: 768px) {
        #stage-2-inner { padding: 2rem 1.25rem; min-height: auto; }
        /* Imagen de referencia usable en móvil */
        #stage-2-ref-img {
            width: min(75vw, 300px) !important;
            height: min(75vw, 300px) !important;
        }
        #stage-2-btn { width: 100%; }
    }

    /* ── ETAPA 3 ── */
    #stage-3-inner { padding: 2.5rem 2rem; }
    #stage-3-video { width: 220px; }

    @media (max-width: 768px) {
        #stage-3-inner {
            padding: 2rem 1rem !important;
            width: 100% !important;
            box-sizing: border-box !important;
            overflow: hidden !important;
            align-items: center !important;
        }
        #stage-3-title { font-size: 2rem !important; }
        #stage-3-video-wrap {
            width: 85vw !important;
            max-width: 85vw !important;
            margin: 1rem auto !important;
            box-sizing: border-box !important;
        }
        #stage-3-video {
            width: 100% !important;
            height: auto !important;
        }
        #stage-3-btn { width: 100% !important; box-sizing: border-box !important; }
    }

    /* ── ETAPA 4 ── */
    #stage-4-inner {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        min-height: 550px;
        padding: 4rem;
        gap: 2rem;
    }
    #stage-4-result-title { font-size: 5rem; }
    #stage-4-img          { max-width: 500px; width: 100%; }
    #stage-4-btns         { display: flex; gap: 1rem; margin-top: 2rem; flex-wrap: wrap; }

    @media (max-width: 768px) {
        #stage-4-inner {
            grid-template-columns: 1fr !important;
            padding: 2rem 1rem !important;
            min-height: auto !important;
            text-align: left !important;
            overflow: hidden !important;
            box-sizing: border-box !important;
            width: 100% !important;
        }
        #stage-4-img-wrap { display: flex; justify-content: center; order: -1; }
        #stage-4-img      { max-width: min(85vw, 380px) !important; width: 100% !important; }
        #stage-4-result-title {
            font-size: clamp(1.6rem, 7vw, 2.2rem) !important;
            word-break: break-word !important;
            line-height: 1.2 !important;
        }
        #stage-4-desc {
            max-width: 100% !important;
            font-size: .9rem !important;
            line-height: 1.7 !important;
        }
        #stage-4-btns { flex-direction: column; }
        #stage-4-btns a,
        #stage-4-btns button {
            width: 100% !important;
            text-align: center !important;
            box-sizing: border-box !important;
        }
    }

    /* ── FOOTER ── */
    #footer-grid { display:flex; justify-content:space-around; flex-wrap:wrap; gap:3rem; }

    @media (max-width: 600px) {
        #footer-main { padding: 2.5rem 1.25rem !important; }
        #footer-grid { flex-direction: column; gap: 2rem; }
        #footer-grid > div { max-width: 100% !important; }
        #footer-grid h3 { font-size: 1.15rem !important; }
    }
</style>


{{-- ═══ NAVBAR (más alto: padding 1.1rem) ════════════════════════════════ --}}
<nav style="display:flex;align-items:center;justify-content:space-between;
            padding:1.6rem 1.75rem;
            background:rgba(6,6,15,0.6);
            backdrop-filter:blur(12px);
            -webkit-backdrop-filter:blur(12px);
            position:sticky;top:0;z-index:100;isolation:isolate;">

<img src="{{ asset('imagenes/isotipo_dorado.webp') }}"
     alt="UTL"
     style="height:2.6rem;width:auto;display:block;">

    <div class="nav-links">
        <a href="{{ route('welcome') }}"   style="font-size:.88rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Inicio</a>
        <a href="{{ route('quiz') }}"      style="font-size:.88rem;color:#E8C96A;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Quiz</a>
        <a href="{{ route('recorrido') }}" style="font-size:.88rem;color:#B0A898
        ;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Recorrido</a>
        <a href="{{ route('dominios') }}"  style="font-size:.88rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Dominios</a>
        <a href="{{ route('casas') }}"     style="font-size:.88rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Casas</a>
    </div>

    <div class="nav-auth">
        <a href="#" style="font-size:.88rem;color:#B0A898;text-decoration:none;
                           letter-spacing:.08em;text-transform:uppercase;">Ingresar</a>
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

{{-- ═══ ETAPA 1: Inicio del quiz ══════════════════════════════════════════ --}}
<div id="stage-1" class="stage">
    <div class="stage-wrap">
        <section id="stage-1-inner"
                 style="background:linear-gradient(rgba(6,6,15,.85),rgba(6,6,15,.95));
                        border:1px solid #8B6914;
                        border-radius:10px;">

            <div>
                <p style="color:#E8C96A;letter-spacing:4px;">
                    CEREMONIA DE SELECCIÓN
                </p>
                <h1 id="stage-1-title"
                    class="siia-title"
                    style="color:#C8A84B;margin:0;">
                    LA GARRA<br>SELECCIONADORA
                </h1>
                <p id="stage-1-desc"
                   style="color:#F0EAD8;line-height:1.8;max-width:500px;margin-top:1.5rem;">
                    Descubre qué casa académica representa mejor tus talentos,
                    intereses y fortalezas dentro de la Universidad Tecnológica de León.
                </p>
                <button id="stage-1-btn"
                        onclick="goToStage(2)"
                        class="gold-btn"
                        style="background:#C6A050;color:#06060F;border:none;
                               padding:.9rem 2rem;font-weight:700;
                               border-radius:4px;cursor:pointer;margin-top:1rem;">
                    Comenzar
                </button>
            </div>

            <div id="stage-1-img-wrap"
                 style="display:flex;justify-content:center;align-items:center;">
                <img id="stage-1-img"
                     src="{{ asset('imagenes/pata.webp') }}"
                     class="float"
                     alt="Garra seleccionadora">
            </div>

        </section>
    </div>
</div>

{{-- ═══ ETAPA 2: Pregunta ══════════════════════════════════════════════════ --}}
<div id="stage-2" class="stage" style="display:none;">
    <div class="stage-wrap">
        <section id="stage-2-inner"
                 style="border:1px solid #8B6914;
                        border-radius:10px;
                        margin-bottom:1.5rem;
                        background:linear-gradient(rgba(6,6,15,.75),rgba(6,6,15,.85)),
                                   url('{{ asset('imagenes/fondoquiz.webp') }}');
                        background-size:cover;
                        background-position:center;
                        background-repeat:no-repeat;
                        display:flex;
                        flex-direction:column;
                        align-items:center;
                        gap:1.5rem;
                        position:relative;">

            <div style="text-align:center;">
                <div style="font-family:'Headland One',serif;font-size:1.3rem;
                            color:#C8A84B;letter-spacing:.08em;">SIIA</div>
                <p style="font-size:.65rem;text-transform:uppercase;
                          letter-spacing:.15em;color:#E8C96A;margin:.2rem 0 0;">
                    [Pregunta]
                </p>
            </div>

            <div style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;justify-content:center;">
                <div id="stage-2-ref-img"
                     style="background:#1A1424;
                            border:1px dashed #C6A050;
                            border-radius:6px;
                            display:flex;align-items:center;justify-content:center;
                            font-size:.75rem;color:#B0A898;
                            text-align:center;padding:1rem;">
                    [ Imagen de<br>referencia ]
                </div>
            </div>

            <p style="font-size:.7rem;text-transform:uppercase;
                      letter-spacing:.12em;color:#F0EAD8;margin:0;text-align:center;">
                [Opción]
            </p>

            <button id="stage-2-btn"
                    onclick="goToStage(3)"
                    style="padding:.65rem 2rem;border:none;border-radius:6px;
                           font-size:.85rem;font-weight:700;color:#06060F;
                           background:#C6A050;cursor:pointer;transition:.3s;">
                Siguiente
            </button>

        </section>
    </div>
</div>

{{-- ═══ ETAPA 3: Procesando ════════════════════════════════════════════════ --}}
<div id="stage-3" class="stage" style="display:none;">
    <div class="stage-wrap">
        <section id="stage-3-inner"
                 style="background:radial-gradient(circle at top right,
                            rgba(232,201,106,.25) 0%,
                            rgba(200,168,75,.12) 20%,
                            transparent 45%),
                        linear-gradient(135deg,#06060F 0%,#120D08 30%,#1A1208 60%,#06060F 100%);
                        border:1px solid rgba(200,168,75,.35);
                        border-radius:10px;
                        display:flex;
                        flex-direction:column;
                        align-items:center;
                        justify-content:center;
                        position:relative;
                        overflow:hidden;">

            <div style="position:absolute;inset:0;
                        background-image:radial-gradient(#E8C96A 1px,transparent 1px);
                        background-size:120px 120px;
                        opacity:.08;pointer-events:none;">
            </div>

            <h2 id="stage-3-title"
                class="siia-title"
                style="color:#C8A84B;font-size:3rem;">
                SIIA
            </h2>

            <div id="stage-3-video-wrap"
                 style="display:flex;justify-content:center;align-items:center;
                        padding:1rem;margin:2rem auto;
                        border:1px solid rgba(200,168,75,.25);
                        border-radius:12px;
                        background:rgba(0,0,0,.20);
                        width:fit-content;
                        max-width:100%;
                        box-sizing:border-box;">
                <video id="stage-3-video"
                       autoplay muted loop playsinline
                       style="max-width:100%;border-radius:8px;display:block;">
                    <source src="{{ asset('videos/garrita.mp4') }}" type="video/mp4">
                </video>
            </div>

            <p style="color:#F0EAD8;text-align:center;line-height:2;padding:0 1rem;">
                La garra está observando tu potencial...<br>
                Analizando afinidades académicas...
            </p>

            <button id="stage-3-btn"
                    onclick="goToStage(4)"
                    class="gold-btn"
                    style="background:#C6A050;color:#06060F;border:none;
                           padding:.9rem 2rem;font-weight:700;
                           border-radius:4px;cursor:pointer;margin-bottom:2rem;">
                Ver resultado
            </button>

        </section>
    </div>
</div>

{{-- ═══ ETAPA 4: Resultado ════════════════════════════════════════════════ --}}
<div id="stage-4" class="stage" style="display:none;">
    <div class="stage-wrap">
        <section id="stage-4-inner"
                 style="background:#06060F;border:1px solid #8B6914;border-radius:10px;">

            <div id="stage-4-img-wrap">
                <img id="stage-4-img"
                     src="../imagenes/gastronomia2.webp"
                     alt="Casa Ignisculin">
            </div>

            <div>
                <p style="color:#E8C96A;letter-spacing:4px;">TU DESTINO ES</p>

                <h1 id="stage-4-result-title"
                    class="siia-title"
                    style="color:#C8A84B;margin:0;">
                    Casa Ignisculin (Gastronomía)
                </h1>

                <p style="color:#E8C96A;font-style:italic;font-size:1.2rem;">
                    "En la llama, está la verdad de tu vocación."
                </p>

                <p id="stage-4-desc"
                   style="color:#F0EAD8;line-height:1.8;max-width:450px;">
                    Tu perfil muestra una afinidad natural con la casa Ignisculina, los Alquimistas del Sabor.
                    Eres una persona que transforma el caos en excelencia mediante una combinación única de
                    creatividad vibrante y disciplina técnica. Prosperas en ambientes dinámicos, utilizando
                    tu instinto práctico para resolver cualquier reto al instante. Tu mayor virtud es el
                    espíritu de servicio: entiendes la cocina como un arte noble donde la precisión y el
                    cuidado se unen para crear experiencias que nutren el alma.
                </p>

                <div id="stage-4-btns">
                    <a href="{{ route('welcome') }}"
                       style="background:#C6A050;color:#06060F;
                              padding:.9rem 2rem;border-radius:4px;
                              text-decoration:none;font-weight:700;
                              display:inline-block;">
                        Inicio
                    </a>
                    <button onclick="descargarResultado()"
                            style="background:transparent;border:1px solid #8B6914;
                                   color:#F0EAD8;padding:.9rem 2rem;
                                   cursor:pointer;border-radius:4px;">
                        Compartir resultado
                    </button>
                </div>
            </div>

        </section>
    </div>

    {{-- Tarjeta oculta para Instagram --}}
    <div id="instagram-card"
         style="width:1080px;height:1920px;background:#06060F;
                display:flex;flex-direction:column;
                justify-content:center;align-items:center;
                padding:80px;box-sizing:border-box;
                position:absolute;left:-99999px;">
        <img src="{{ asset('imagenes/casas/gastronomia2.webp') }}"
             style="width:700px;max-width:100%;margin-bottom:80px;">
        <p style="color:#E8C96A;letter-spacing:8px;font-size:32px;margin-bottom:20px;">
            TU DESTINO ES
        </p>
        <h1 style="font-family:'Headland One',serif;color:#C8A84B;
                   font-size:90px;text-align:center;margin:0;">
            Casa Ignisculin
        </h1>
        <p style="color:#E8C96A;font-style:italic;font-size:40px;
                  text-align:center;margin:40px 0;">
            "En la llama, está la verdad de tu vocación."
        </p>
        <p style="color:#F0EAD8;font-size:32px;line-height:1.8;
                  text-align:center;max-width:800px;">
            Tu perfil muestra una afinidad natural con la casa Ignisculina,
            los Alquimistas del Sabor.
        </p>
    </div>
</div>

</div>{{-- /page-content-wrapper --}}

{{-- ═══ FOOTER ════════════════════════════════════════════════════════════ --}}
<style>
    #footer-casas {
        padding: 3rem 4rem;
        background: #06060F;
        border-top: 1px solid #2B1F3D;
        position: relative;
        z-index: 10;
        isolation: isolate;
    }
    #footer-casas-grid {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 3rem;
    }

    @media (max-width: 600px) {
        #footer-casas { padding: 2.5rem 1.25rem; }
        #footer-casas-grid { flex-direction: column; gap: 2rem; }
        #footer-casas-grid > div { max-width: 100% !important; }
        #footer-casas-grid h3 { font-size: 1.1rem !important; }
    }
</style>

<footer id="footer-casas">
    <div id="footer-casas-grid">
        <div style="text-align:left;max-width:400px;">
            <h3 style="font-family:'Headland One',serif;color:#C8A84B;
                       margin-bottom:1rem;font-size:1.4rem;">
                Universidad Tecnológica de León
            </h3>
            <p style="color:#F0EAD8;line-height:1.8;margin:0;">
                Blvd. Universidad Tecnológica #225 Col. San Carlos<br>
                C.P. 37670 León, Gto. México<br><br>
                comunicacionutl@utleon.edu.mx<br><br>
                (477) 7 10 00 20
            </p>
        </div>
        <div style="text-align:left;max-width:450px;">
            <h3 style="font-family:'Headland One',serif;color:#C8A84B;
                       margin-bottom:1rem;font-size:1.4rem;">
                Desarrolladores del Proyecto
            </h3>
            <p style="color:#F0EAD8;line-height:2;margin:0;">
                <strong>Citlalli Méndez</strong><br>Documentadora y Administradora de Base de Datos<br>citlallialejandrams@gmail.com<br><br>
                <strong>Miryam Muñoz</strong><br>Diseñadora<br>miryammunoz26@gmail.com<br><br>
                <strong>Carlo Flores</strong><br>Programador<br>carlofernandoflores2006@gmail.com
            </p>
        </div>
    </div>
    <div style="margin-top:2.5rem;border-top:1px solid rgba(200,168,75,.15);
                padding-top:1.5rem;text-align:center;color:#707085;
                font-size:.8rem;letter-spacing:.08em;">
        © {{ date('Y') }} SIIA · Sistema Integral de Identidad Académica
    </div>
</footer>

@endsection

@push('extra-js')
<script>
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const mobileMenu   = document.getElementById('mobileMenu');

    hamburgerBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('open');
        hamburgerBtn.setAttribute('aria-expanded', mobileMenu.classList.contains('open'));
    });
    document.addEventListener('click', e => {
        if (!hamburgerBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
            mobileMenu.classList.remove('open');
        }
    });

    function goToStage(n) {
        document.querySelectorAll('.stage').forEach(s => s.style.display = 'none');
        document.getElementById('stage-' + n).style.display = 'flex';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Aplica layout móvil via JS (más confiable que media queries en algunos navegadores móviles)
    function applyMobileLayout() {
        const inner = document.getElementById('stage-1-inner');
        if (!inner) return;
        if (window.innerWidth <= 768) {
            inner.classList.add('mobile-layout');
        } else {
            inner.classList.remove('mobile-layout');
        }
    }
    applyMobileLayout();
    window.addEventListener('resize', applyMobileLayout);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    function descargarResultado() {
        const card = document.getElementById('instagram-card');
        html2canvas(card, {
            width: 1080,
            height: 1920,
            scale: 1,
            backgroundColor: '#06060F',
            useCORS: true
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'resultado-siia-instagram.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        });
    }
</script>
@endpush