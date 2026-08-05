@extends('layouts.app')
@section('title', 'Casas — NOVA')

@section('content')

<style>
    @media (max-width:768px) {
        .casas-header-section { padding:3rem 1.25rem !important; }
        .casas-header-section h1 { font-size:2rem !important; }
        .filtros-section { padding:0 1rem !important; }
        .filtro-btn { font-size:.72rem !important; padding:.3rem .7rem !important; }
        .casas-cta { padding:3rem 1.25rem !important; }
        .casas-cta h2 { font-size:1.6rem !important; }
        .casas-cta a  { width:100%;box-sizing:border-box;text-align:center;display:block !important; }
    }

    .filtro-btn {
        font-size:.78rem; color:#B0A898;
        border:1px solid rgba(200,168,75,.2);
        padding:.35rem 1rem; border-radius:50px;
        background:transparent; cursor:pointer; letter-spacing:.06em;
        transition:border-color .2s,color .2s,background .2s;
        font-family:inherit;
    }
    .filtro-btn:hover, .filtro-btn.activo {
        border-color:#C8A84B; color:#E8C96A; background:rgba(200,168,75,.08);
    }

    .casa-card {
        background:#14141F;
        border:1px solid rgba(200,168,75,.15);
        border-radius:18px; overflow:hidden;
        transition:border-color .35s ease, box-shadow .35s ease;
        display:flex; flex-direction:column;
    }
    .casa-card:hover {
        border-color:rgba(200,168,75,.85);
        box-shadow:0 0 0 1px rgba(200,168,75,.4), 0 0 18px rgba(200,168,75,.18);
    }
    .casa-card.oculta { display:none !important; }

    .casa-card-body {
        padding:1.5rem;
        display:flex; flex-direction:column;
        flex:1;
    }

    /* ── Imagen: contain para que no se recorte el logo ── */
    .casa-img-wrap {
        width:100%;
        aspect-ratio:1;
        overflow:hidden;
        flex-shrink:0;
        background:radial-gradient(circle at center,rgba(255,255,255,.04),transparent 70%);
        border-radius:12px;
        margin-bottom:1.5rem;
        display:flex;
        align-items:center;
        justify-content:center;
    }
    .casa-img-wrap img {
        width:100%;
        height:100%;
        object-fit:contain;   /* sin recorte */
        display:block;
        padding:10px;
    }

    /* ── Grid: 3 columnas fijas en desktop ── */
    #casasGrid {
        display:grid;
        grid-template-columns:repeat(3, 1fr);
        gap:1.5rem;
    }
    @media (max-width:900px) { #casasGrid { grid-template-columns:repeat(2,1fr); } }
    @media (max-width:560px) { #casasGrid { grid-template-columns:1fr; } }

    /* Modal */
    .modal-overlay {
        display:none; position:fixed; inset:0;
        background:rgba(0,0,0,.72); z-index:1000;
        align-items:center; justify-content:center; padding:1.5rem;
    }
    .modal-overlay.abierto { display:flex; }
    .modal-box {
        background:#14141F; border:1px solid rgba(200,168,75,.35);
        border-radius:20px; max-width:600px; width:100%;
        max-height:88vh; overflow-y:auto; position:relative;
        box-shadow:0 0 40px rgba(200,168,75,.12);
    }
    .modal-header-bar { height:7px; border-radius:20px 20px 0 0; }
    .modal-body { padding:2rem; }
    .modal-close {
        position:absolute; top:1rem; right:1.2rem;
        background:none; border:none; color:#707085;
        font-size:1.5rem; cursor:pointer; line-height:1; transition:color .2s;
    }
    .modal-close:hover { color:#E8C96A; }
    .modal-label { font-size:.68rem;text-transform:uppercase;letter-spacing:.14em;color:#707085;margin-bottom:.25rem; }
    .modal-title { font-family:'Headland One',serif;color:#FFFFFF;font-size:1.4rem;margin-bottom:.3rem; }
    .modal-dominio { color:#C8A84B;font-size:.82rem;margin-bottom:1.5rem; }
    .modal-section-title {
        font-size:.72rem;text-transform:uppercase;letter-spacing:.12em;color:#C8A84B;
        border-bottom:1px solid rgba(200,168,75,.2);padding-bottom:.4rem;margin-bottom:.8rem;
    }
    .modal-oferta-text { margin-bottom:1.75rem; }
    .modal-link { font-size:.85rem;color:#B0A898;line-height:1.7; }
    .modal-link a { color:#E8C96A;text-decoration:underline;word-break:break-all; }
    .modal-link a:hover { color:#FFFFFF; }
    .btn-ver-mas {
        margin-top:auto; width:100%; padding:.6rem 0; border-radius:8px;
        border:1px solid rgba(200,168,75,.4); background:transparent;
        color:#E8C96A; font-size:.82rem; letter-spacing:.08em;
        cursor:pointer; transition:background .2s,color .2s; font-family:inherit;
    }
    .btn-ver-mas:hover { background:rgba(200,168,75,.12); color:#FFFFFF; }

    .modal-oferta-list {
        display:grid;grid-template-columns:repeat(2,1fr);
        gap:.45rem .75rem;margin:0;padding:0;list-style:none;
    }
    .modal-oferta-list li {
        display:flex;align-items:flex-start;gap:.45rem;
        color:#F0EAD8;font-size:.88rem;line-height:1.5;
    }
    .modal-oferta-list li::before {
        content:'';display:block;flex-shrink:0;
        width:5px;height:5px;border-radius:50%;
        background:#C8A84B;margin-top:.45em;
    }
    @media (max-width:500px) { .modal-oferta-list { grid-template-columns:1fr; } }
</style>

@include('partials.navbar')

{{-- ENCABEZADO --}}
<section class="casas-header-section"
         style="padding:5rem 2rem;text-align:center;
                background:url('{{ asset('imagenes/casas/hero-casas.png') }}');
                background-size:cover;background-position:center;
                border-bottom:1px solid rgba(200,168,75,.15);">
    <p style="color:#E8C96A;text-transform:uppercase;letter-spacing:.2em;font-size:.75rem;margin-bottom:.8rem;">
        Navegador de Orientación Vocacional y Aptitudes
    </p>
    <h1 style="color:#FFFFFF;font-size:3rem;font-family:'Headland One',serif;margin-bottom:1rem;">
        Casas Académicas
    </h1>
    <p style="max-width:750px;margin:auto;color:#F0EAD8;line-height:1.9;font-size:1rem;">
        Cada casa representa una carrera con su propia identidad, valores y filosofía académica.
        Descubre cuál resuena con tu vocación y forma de ver el mundo.
    </p>
</section>

<br>

{{-- FILTROS --}}
<section class="filtros-section" style="max-width:1400px;margin:0 auto 2rem;padding:0 2rem;">
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;">
        <span style="font-size:.72rem;text-transform:uppercase;letter-spacing:.12em;
                     color:#707085;margin-right:.25rem;">Filtrar:</span>
        <button type="button" class="filtro-btn activo" data-dominio="Todos">Todos</button>
        @foreach($dominios as $dominio)
        <button type="button" class="filtro-btn" data-dominio="{{ $dominio->nombre }}">
            @switch($dominio->slug)
                @case('tecnologias-de-la-informacion') Tec. Información @break
                @case('ingenierias-industriales')      Ing. Industriales @break
                @default {{ $dominio->nombre }}
            @endswitch
        </button>
        @endforeach
    </div>
</section>

{{-- GRID DE CASAS --}}
<section class="casas-grid-section" style="max-width:1400px;margin:auto;padding:0 2rem 4rem;">
    <div id="casasGrid">

        @forelse($casas as $casa)
        <div class="casa-card" data-dominio="{{ $casa->dominio->nombre }}">

            <div style="height:8px;background:{{ $casa->color }};flex-shrink:0;"></div>

            <div class="casa-card-body">

                {{-- IMAGEN SIN RECORTE --}}
                <div class="casa-img-wrap">
                    @if(!empty($casa->imagen))
                        <img src="{{ asset($casa->imagen) }}" alt="{{ $casa->nombre }}">
                    @else
                        <div style="width:100%;height:100%;background:#1D1D2B;
                                    border:1px dashed rgba(255,255,255,.15);border-radius:10px;"></div>
                    @endif
                </div>

                <p style="font-size:.7rem;text-transform:uppercase;letter-spacing:.12em;
                           color:#707085;margin-bottom:.4rem;">{{ $casa->dominio->nombre }}</p>

                <h4 style="color:#eedca7;font-size:1.05rem;margin-bottom:.2rem;
                            font-family:'Headland One',serif;">{{ $casa->nombre_casa }}</h4>

                <h3 style="color:#FFFFFF;font-size:1.05rem;margin-bottom:.4rem;
                            font-family:'Headland One',serif;">{{ $casa->nombre }}</h3>

                <p style="color:#C8A84B;font-size:.82rem;font-style:italic;margin-bottom:.9rem;">
                    {{ $casa->frase }}
                </p>

                <p style="color:#B0A898;line-height:1.7;font-size:.9rem;margin-bottom:1.5rem;flex-grow:1;">
                    {{ $casa->descripcion }}
                </p>

                <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1rem;">
                    @foreach($casa->valores ?? [] as $valor)
                    <span style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);
                                 color:#F0EAD8;padding:.4rem .75rem;border-radius:50px;font-size:.72rem;">
                        {{ $valor }}
                    </span>
                    @endforeach
                </div>

                <button type="button" class="btn-ver-mas"
                        data-nombre="{{ $casa->nombre }}"
                        data-dominio="{{ $casa->dominio->nombre }}"
                        data-oferta="{{ $casa->oferta }}"
                        data-link="{{ $casa->link }}"
                        data-color="{{ $casa->color }}">
                    Ver más
                </button>

            </div>
        </div>
        @empty
        <div style="grid-column:1 / -1;background:#14141F;
                    border:1px solid rgba(200,168,75,.15);
                    border-radius:18px;padding:2rem;text-align:center;">
            <p style="color:#B0A898;margin:0;">No hay casas académicas registradas.</p>
        </div>
        @endforelse

    </div>
</section>

{{-- MODAL --}}
<div class="modal-overlay" id="modalOverlay">
    <div class="modal-box" id="modalBox">
        <div class="modal-header-bar" id="modalHeaderBar"></div>
        <div class="modal-body">
            <button type="button" class="modal-close" id="modalClose" aria-label="Cerrar modal">&#x2715;</button>
            <p class="modal-label">Casa Académica</p>
            <h2 class="modal-title" id="modalNombre"></h2>
            <p class="modal-dominio" id="modalDominio"></p>
            <p class="modal-section-title">Plan de Estudios</p>
            <div class="modal-oferta-text" id="modalOferta"></div>
            <p class="modal-section-title">Más Información</p>
            <p class="modal-link">
                Para más información visita la página oficial de la UTL:
                <a id="modalLink" href="#" target="_blank" rel="noopener noreferrer"></a>
            </p>
        </div>
    </div>
</div>

{{-- CTA --}}
<section class="casas-cta"
         style="padding:5rem 2rem;text-align:center;
                background:rgba(6,6,15,.45);
                border-top:1px solid rgba(200,168,75,.12);
                border-bottom:1px solid rgba(200,168,75,.12);">
    <h2 style="color:#FFFFFF;font-family:'Headland One',serif;margin-bottom:1rem;">
        Descubre tu casa académica
    </h2>
    <p style="max-width:650px;margin:auto auto 2rem;color:#F0EAD8;line-height:1.8;">
        Realiza el cuestionario NOVA y descubre qué casa y qué dominio
        representan mejor tus intereses, habilidades y forma de aprender.
    </p>
    <a href="{{ route('quiz') }}"
       style="display:inline-block;background:#C6A050;color:#06060F;
              text-decoration:none;padding:.9rem 2rem;border-radius:8px;font-weight:700;">
        Realizar Test
    </a>
</section>

{{-- FOOTER --}}
@include('partials.footer')

@endsection

@push('extra-js')
<script>
document.addEventListener('DOMContentLoaded', () => {

    // FILTROS
    const botonesFiltro = document.querySelectorAll('.filtro-btn');
    const tarjetas      = document.querySelectorAll('.casa-card');

    botonesFiltro.forEach(btn => {
        btn.addEventListener('click', () => {
            botonesFiltro.forEach(b => b.classList.remove('activo'));
            btn.classList.add('activo');
            const sel = btn.dataset.dominio;
            tarjetas.forEach(t => {
                t.classList.toggle('oculta', sel !== 'Todos' && t.dataset.dominio !== sel);
            });
        });
    });

    // MODAL
    const overlay      = document.getElementById('modalOverlay');
    const modalClose   = document.getElementById('modalClose');
    const modalNombre  = document.getElementById('modalNombre');
    const modalDominio = document.getElementById('modalDominio');
    const modalBar     = document.getElementById('modalHeaderBar');
    const modalOferta  = document.getElementById('modalOferta');
    const modalLink    = document.getElementById('modalLink');

    function abrirModal(btn) {
        modalNombre.textContent  = btn.dataset.nombre  ?? '';
        modalDominio.textContent = btn.dataset.dominio ?? '';
        modalBar.style.background = btn.dataset.color ?? '#C8A84B';

        const materias = (btn.dataset.oferta ?? '')
            .split(',').map(m => m.trim()).filter(m => m.length);
        const ul = document.createElement('ul');
        ul.className = 'modal-oferta-list';
        materias.forEach(m => {
            const li = document.createElement('li');
            li.textContent = m;
            ul.appendChild(li);
        });
        modalOferta.innerHTML = '';
        modalOferta.appendChild(ul);

        modalLink.href        = btn.dataset.link ?? '#';
        modalLink.textContent = btn.dataset.link ?? '';

        overlay.classList.add('abierto');
        document.body.style.overflow = 'hidden';
    }

    function cerrarModal() {
        overlay.classList.remove('abierto');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.btn-ver-mas').forEach(btn => {
        btn.addEventListener('click', () => abrirModal(btn));
    });

    modalClose.addEventListener('click', cerrarModal);
    overlay.addEventListener('click', e => { if (e.target === overlay) cerrarModal(); });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && overlay.classList.contains('abierto')) cerrarModal();
    });
});
</script>
@endpush