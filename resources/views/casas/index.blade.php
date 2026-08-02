@extends('layouts.app')
@section('title', 'Casas — NOVA')

@section('content')

<style>
    @media (max-width: 768px) {
        .casas-header-section {
            padding: 3rem 1.25rem !important;
        }

        .casas-header-section h1 {
            font-size: 2rem !important;
        }

        .filtros-section {
            padding: 0 1rem !important;
        }

        .filtro-btn {
            font-size: .72rem !important;
            padding: .3rem .7rem !important;
        }

        .casas-cta {
            padding: 3rem 1.25rem !important;
        }

        .casas-cta h2 {
            font-size: 1.6rem !important;
        }

        .casas-cta a {
            width: 100%;
            box-sizing: border-box;
            text-align: center;
            display: block !important;
        }
    }

    .filtro-btn {
        font-size: .78rem;
        color: #B0A898;
        border: 1px solid rgba(200, 168, 75, .2);
        padding: .35rem 1rem;
        border-radius: 50px;
        background: transparent;
        cursor: pointer;
        letter-spacing: .06em;
        transition: border-color .2s, color .2s, background .2s;
        font-family: inherit;
    }

    .filtro-btn:hover,
    .filtro-btn.activo {
        border-color: #C8A84B;
        color: #E8C96A;
        background: rgba(200, 168, 75, .08);
    }

    .casa-card {
        background: #14141F;
        border: 1px solid rgba(200, 168, 75, .15);
        border-radius: 18px;
        overflow: hidden;
        transition: border-color .35s ease, box-shadow .35s ease;
        display: flex;
        flex-direction: column;
    }

    .casa-card:hover {
        border-color: rgba(200, 168, 75, .85);
        box-shadow:
            0 0 0 1px rgba(200, 168, 75, .4),
            0 0 18px rgba(200, 168, 75, .18);
    }

    .casa-card.oculta {
        display: none !important;
    }

    .casa-card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    /* Modal */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .72);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }

    .modal-overlay.abierto {
        display: flex;
    }

    .modal-box {
        background: #14141F;
        border: 1px solid rgba(200, 168, 75, .35);
        border-radius: 20px;
        max-width: 600px;
        width: 100%;
        max-height: 88vh;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 0 40px rgba(200, 168, 75, .12);
    }

    .modal-header-bar {
        height: 7px;
        border-radius: 20px 20px 0 0;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-close {
        position: absolute;
        top: 1rem;
        right: 1.2rem;
        background: none;
        border: none;
        color: #707085;
        font-size: 1.5rem;
        cursor: pointer;
        line-height: 1;
        transition: color .2s;
    }

    .modal-close:hover {
        color: #E8C96A;
    }

    .modal-label {
        font-size: .68rem;
        text-transform: uppercase;
        letter-spacing: .14em;
        color: #707085;
        margin-bottom: .25rem;
    }

    .modal-title {
        font-family: 'Headland One', serif;
        color: #FFFFFF;
        font-size: 1.4rem;
        margin-bottom: .3rem;
    }

    .modal-dominio {
        color: #C8A84B;
        font-size: .82rem;
        margin-bottom: 1.5rem;
    }

    .modal-section-title {
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .12em;
        color: #C8A84B;
        border-bottom: 1px solid rgba(200, 168, 75, .2);
        padding-bottom: .4rem;
        margin-bottom: .8rem;
    }

    .modal-oferta-text {
        margin-bottom: 1.75rem;
    }

    .modal-link {
        font-size: .85rem;
        color: #B0A898;
        line-height: 1.7;
    }

    .modal-link a {
        color: #E8C96A;
        text-decoration: underline;
        word-break: break-all;
    }

    .modal-link a:hover {
        color: #FFFFFF;
    }

    .btn-ver-mas {
        margin-top: 1rem;
        width: 100%;
        padding: .6rem 0;
        border-radius: 8px;
        border: 1px solid rgba(200, 168, 75, .4);
        background: transparent;
        color: #E8C96A;
        font-size: .82rem;
        letter-spacing: .08em;
        cursor: pointer;
        transition: background .2s, color .2s;
        font-family: inherit;
    }

    .btn-ver-mas:hover {
        background: rgba(200, 168, 75, .12);
        color: #FFFFFF;
    }

    .modal-oferta-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: .45rem .75rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .modal-oferta-list li {
        display: flex;
        align-items: flex-start;
        gap: .45rem;
        color: #F0EAD8;
        font-size: .88rem;
        line-height: 1.5;
    }

    .modal-oferta-list li::before {
        content: '';
        display: block;
        flex-shrink: 0;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #C8A84B;
        margin-top: .45em;
    }

    @media (max-width: 500px) {
        .modal-oferta-list {
            grid-template-columns: 1fr;
        }
    }
</style>

@include('partials.navbar')

{{-- ENCABEZADO --}}
<section
    class="casas-header-section"
    style="
        padding:5rem 2rem;
        text-align:center;
        background:url('{{ asset('imagenes/casas/hero-casas.png') }}');
        background-size:cover;
        background-position:center;
        border-bottom:1px solid rgba(200,168,75,.15);
    "
>
    <p style="
        color:#E8C96A;
        text-transform:uppercase;
        letter-spacing:.2em;
        font-size:.75rem;
        margin-bottom:.8rem;
    ">
        Navegador de Orientación Vocacional y Aptitudes
    </p>

    <h1 style="
        color:#FFFFFF;
        font-size:3rem;
        font-family:'Headland One',serif;
        margin-bottom:1rem;
    ">
        Casas Académicas
    </h1>

    <p style="
        max-width:750px;
        margin:auto;
        color:#F0EAD8;
        line-height:1.9;
        font-size:1rem;
    ">
        Cada casa representa una carrera con su propia identidad, valores y filosofía académica.
        Descubre cuál resuena con tu vocación y forma de ver el mundo.
    </p>
</section>

<br>

{{-- FILTROS --}}
<section
    class="filtros-section"
    style="max-width:1400px;margin:0 auto 2rem;padding:0 2rem;"
>
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;">
        <span style="
            font-size:.72rem;
            text-transform:uppercase;
            letter-spacing:.12em;
            color:#707085;
            margin-right:.25rem;
        ">
            Filtrar:
        </span>

        <button
            type="button"
            class="filtro-btn activo"
            data-dominio="Todos"
        >
            Todos
        </button>

        @foreach($dominios as $dominio)
            <button
                type="button"
                class="filtro-btn"
                data-dominio="{{ $dominio->nombre }}"
            >
                @switch($dominio->slug)
                    @case('tecnologias-de-la-informacion')
                        Tec. Información
                        @break

                    @case('ingenierias-industriales')
                        Ing. Industriales
                        @break

                    @default
                        {{ $dominio->nombre }}
                @endswitch
            </button>
        @endforeach
    </div>
</section>

{{-- GRID --}}
<style>
    #casasGrid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
        align-items: stretch;
        justify-content: start;
    }

    .casa-card {
        display: flex;
        flex-direction: column;
        background: #14141F;
        border-radius: 12px;
        overflow: hidden;
        width: 100%;
        max-width: 280px;
    }

    .casa-card-body {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        padding: 1.5rem;
    }

    .btn-ver-mas {
        margin-top: auto;
    }

    @media (max-width: 900px) {
        #casasGrid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1.25rem;
        }

        .casa-card {
            max-width: 240px;
        }
    }

    @media (max-width: 600px) {
        #casasGrid {
            grid-template-columns: 1fr;
            gap: 1rem;
            justify-content: stretch;
        }

        .casa-card {
            max-width: 100%;
        }

        .casa-card-body {
            padding: 1rem;
        }
    }
</style>

<section
    class="casas-grid-section"
    style="max-width:1400px;margin:auto;padding:0 2rem 4rem;"
>
    <div id="casasGrid">

        @forelse($casas as $casa)
            <div
                class="casa-card"
                data-dominio="{{ $casa->dominio->nombre }}"
            >
                <div style="height:8px;background:{{ $casa->color }};"></div>

                <div class="casa-card-body">
                    <div
                        class="casa-img-wrap"
                        style="
                            width:100%;
                            aspect-ratio:1;
                            border-radius:12px;
                            overflow:hidden;
                            margin-bottom:1.5rem;
                        "
                    >
                        @if(!empty($casa->imagen))
                            <img
                                src="{{ asset($casa->imagen) }}"
                                alt="{{ $casa->nombre }}"
                                style="
                                    width:100%;
                                    height:100%;
                                    object-fit:cover;
                                "
                            >
                        @else
                            <div style="
                                width:100%;
                                height:100%;
                                background:#1D1D2B;
                                border:1px dashed rgba(255,255,255,.15);
                                border-radius:12px;
                            "></div>
                        @endif
                    </div>

                    <p style="
                        font-size:.7rem;
                        text-transform:uppercase;
                        letter-spacing:.12em;
                        color:#707085;
                        margin-bottom:.4rem;
                    ">
                        {{ $casa->dominio->nombre }}
                    </p>

                    <h4 style="
                        color:#eedca7;
                        font-size:1.05rem;
                        margin-bottom:.2rem;
                        font-family:'Headland One',serif;
                    ">
                        {{ $casa->nombre_casa }}
                    </h4>

                    <h3 style="
                        color:#FFFFFF;
                        font-size:1.05rem;
                        margin-bottom:.4rem;
                        font-family:'Headland One',serif;
                    ">
                        {{ $casa->nombre }}
                    </h3>

                    <p style="
                        color:#C8A84B;
                        font-size:.82rem;
                        font-style:italic;
                        margin-bottom:.9rem;
                    ">
                        {{ $casa->frase }}
                    </p>

                    <p style="
                        color:#B0A898;
                        line-height:1.7;
                        font-size:.9rem;
                        margin-bottom:1.5rem;
                        flex-grow:1;
                    ">
                        {{ $casa->descripcion }}
                    </p>

                    <div style="display:flex;flex-wrap:wrap;gap:.5rem;">
                        @foreach($casa->valores ?? [] as $valor)
                            <span style="
                                background:rgba(255,255,255,.04);
                                border:1px solid rgba(255,255,255,.08);
                                color:#F0EAD8;
                                padding:.4rem .75rem;
                                border-radius:50px;
                                font-size:.72rem;
                            ">
                                {{ $valor }}
                            </span>
                        @endforeach
                    </div>

                    <button
                        type="button"
                        class="btn-ver-mas"
                        data-nombre="{{ $casa->nombre }}"
                        data-dominio="{{ $casa->dominio->nombre }}"
                        data-oferta="{{ $casa->oferta }}"
                        data-link="{{ $casa->link }}"
                        data-color="{{ $casa->color }}"
                    >
                        Ver más
                    </button>
                </div>
            </div>
        @empty
            <div style="
                grid-column:1 / -1;
                background:#14141F;
                border:1px solid rgba(200,168,75,.15);
                border-radius:18px;
                padding:2rem;
                text-align:center;
            ">
                <p style="color:#B0A898;margin:0;">
                    No hay casas académicas registradas.
                </p>
            </div>
        @endforelse

    </div>
</section>

{{-- MODAL --}}
<div
    class="modal-overlay"
    id="modalOverlay"
>
    <div class="modal-box" id="modalBox">
        <div class="modal-header-bar" id="modalHeaderBar"></div>

        <div class="modal-body">
            <button
                type="button"
                class="modal-close"
                id="modalClose"
                aria-label="Cerrar modal"
            >
                &#x2715;
            </button>

            <p class="modal-label">Casa Académica</p>

            <h2 class="modal-title" id="modalNombre"></h2>

            <p class="modal-dominio" id="modalDominio"></p>

            <p class="modal-section-title">Plan de Estudios</p>

            <div class="modal-oferta-text" id="modalOferta"></div>

            <p class="modal-section-title">Más Información</p>

            <p class="modal-link">
                Para más información visita la página oficial de la UTL:
                <a
                    id="modalLink"
                    href="#"
                    target="_blank"
                    rel="noopener noreferrer"
                ></a>
            </p>
        </div>
    </div>
</div>

{{-- CTA --}}
<section
    class="casas-cta"
    style="
        padding:5rem 2rem;
        text-align:center;
        background:rgba(6,6,15,.45);
        border-top:1px solid rgba(200,168,75,.12);
        border-bottom:1px solid rgba(200,168,75,.12);
    "
>
    <h2 style="
        color:#FFFFFF;
        font-family:'Headland One',serif;
        margin-bottom:1rem;
    ">
        Descubre tu casa académica
    </h2>

    <p style="
        max-width:650px;
        margin:auto auto 2rem;
        color:#F0EAD8;
        line-height:1.8;
    ">
        Realiza el cuestionario NOVA y descubre qué casa y qué dominio
        representan mejor tus intereses, habilidades y forma de aprender.
    </p>

    <a
        href="{{ route('quiz') }}"
        style="
            display:inline-block;
            background:#C6A050;
            color:#06060F;
            text-decoration:none;
            padding:.9rem 2rem;
            border-radius:8px;
            font-weight:700;
        "
    >
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
        const tarjetasCasas = document.querySelectorAll('.casa-card');

        botonesFiltro.forEach((boton) => {
            boton.addEventListener('click', () => {
                const dominioSeleccionado = boton.dataset.dominio;

                botonesFiltro.forEach((otroBoton) => {
                    otroBoton.classList.remove('activo');
                });

                boton.classList.add('activo');

                tarjetasCasas.forEach((tarjeta) => {
                    const coincide =
                        dominioSeleccionado === 'Todos' ||
                        tarjeta.dataset.dominio === dominioSeleccionado;

                    tarjeta.classList.toggle('oculta', !coincide);
                });
            });
        });

        // MODAL
        const modalOverlay = document.getElementById('modalOverlay');
        const modalClose = document.getElementById('modalClose');
        const modalNombre = document.getElementById('modalNombre');
        const modalDominio = document.getElementById('modalDominio');
        const modalHeaderBar = document.getElementById('modalHeaderBar');
        const modalOferta = document.getElementById('modalOferta');
        const modalLink = document.getElementById('modalLink');

        function abrirModalDesdeBoton(boton) {
            const nombre = boton.dataset.nombre ?? '';
            const dominio = boton.dataset.dominio ?? '';
            const oferta = boton.dataset.oferta ?? '';
            const link = boton.dataset.link ?? '';
            const color = boton.dataset.color ?? '#C8A84B';

            modalNombre.textContent = nombre;
            modalDominio.textContent = dominio;
            modalHeaderBar.style.background = color;

            const materias = oferta
                .split(',')
                .map((materia) => materia.trim())
                .filter((materia) => materia.length > 0);

            const lista = document.createElement('ul');
            lista.className = 'modal-oferta-list';

            materias.forEach((materia) => {
                const elemento = document.createElement('li');
                elemento.textContent = materia;
                lista.appendChild(elemento);
            });

            modalOferta.innerHTML = '';
            modalOferta.appendChild(lista);

            modalLink.href = link;
            modalLink.textContent = link;

            modalOverlay.classList.add('abierto');
            document.body.style.overflow = 'hidden';
        }

        function cerrarModal() {
            modalOverlay.classList.remove('abierto');
            document.body.style.overflow = '';
        }

        document.querySelectorAll('.btn-ver-mas').forEach((boton) => {
            boton.addEventListener('click', () => {
                abrirModalDesdeBoton(boton);
            });
        });

        modalClose.addEventListener('click', cerrarModal);

        modalOverlay.addEventListener('click', (event) => {
            if (event.target === modalOverlay) {
                cerrarModal();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (
                event.key === 'Escape' &&
                modalOverlay.classList.contains('abierto')
            ) {
                cerrarModal();
            }
        });
    });
</script>
@endpush