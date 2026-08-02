@extends('layouts.app')
@section('title', 'Dominios — NOVA')

@section('content')

<style>
    *, *::before, *::after {
        box-sizing: border-box;
    }

    .page-wrap {
        display: flex;
        flex-direction: column;
        min-height: calc(100vh - 54px);
    }

    .page-content {
        flex: 1;
    }

    .hero-section {
        padding: 5rem 2rem;
        text-align: center;
        border-bottom: 1px solid rgba(200, 168, 75, .15);
    }

    .hero-title {
        font-size: 3rem;
    }

    .explicacion-wrap {
        max-width: 1200px;
        margin: 3rem auto;
        padding: 0 2rem;
    }

    .dominios-wrap {
        max-width: 1400px;
        margin: auto;
        padding: 0 2rem 4rem;
    }

    .dominios-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
    }

    .dominio-card {
        background: #14141F;
        border: 1px solid rgba(200, 168, 75, .15);
        border-radius: 18px;
        overflow: hidden;
        transition: .3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .dominio-card:hover {
        border-color: rgba(200, 168, 75, .85);
        box-shadow:
            0 0 0 1px rgba(200, 168, 75, .4),
            0 0 18px rgba(200, 168, 75, .18);
    }

    .cta-section {
        padding: 5rem 2rem;
        text-align: center;
        background: rgba(6, 6, 15, .45);
        border-top: 1px solid rgba(200, 168, 75, .12);
        border-bottom: 1px solid rgba(200, 168, 75, .12);
    }

    .cta-title {
        margin-bottom: 1rem;
    }

    .cta-desc {
        max-width: 650px;
        margin: auto auto 2rem;
        line-height: 1.8;
    }

    @media (max-width: 900px) {
        .dominios-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .hero-section {
            padding: 3rem 1.25rem;
        }

        .hero-title {
            font-size: 2rem !important;
        }

        .explicacion-wrap {
            margin: 2rem auto;
            padding: 0 1.25rem;
        }

        .dominios-wrap {
            padding: 0 1.25rem 3rem;
        }

        .dominios-grid {
            grid-template-columns: 1fr;
        }

        .cta-section {
            padding: 3rem 1.25rem;
        }

        .cta-title {
            font-size: 1.4rem !important;
        }

        .cta-desc {
            font-size: .9rem;
        }

        .cta-btn {
            width: 100%;
            text-align: center;
        }
    }
</style>

@include('partials.navbar')

<div class="page-wrap">
    <div class="page-content">

        {{-- ENCABEZADO --}}
        <section
            class="hero-section"
            style="
                background:url('{{ asset('imagenes/dominios/hero-dominios.webp') }}');
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

            <h1
                class="hero-title"
                style="
                    color:#FFFFFF;
                    font-family:'Headland One',serif;
                    margin-bottom:1rem;
                "
            >
                Dominios Académicos
            </h1>

            <p style="
                max-width:750px;
                margin:auto;
                color:#F0EAD8;
                line-height:1.9;
                font-size:1rem;
            ">
                Los dominios representan grandes áreas del conocimiento dentro de la
                Universidad Tecnológica de León. Cada uno reúne carreras con intereses,
                habilidades y enfoques profesionales afines.
            </p>
        </section>

        {{-- ¿QUÉ ES UN DOMINIO? --}}
        <div class="explicacion-wrap">
            <div style="
                background:rgba(6,6,15,.75);
                border:1px solid rgba(200,168,45,.15);
                border-radius:16px;
                padding:2rem;
            ">
                <h2 style="
                    color:#C8A84B;
                    font-family:'Headland One',serif;
                    margin-bottom:1rem;
                ">
                    ¿Qué es un dominio?
                </h2>

                <p style="color:#F0EAD8;line-height:1.9;margin:0;">
                    Los dominios agrupan carreras que comparten intereses,
                    competencias y áreas de conocimiento similares.
                    Dentro de NOVA representan los grandes caminos académicos
                    que estructuran la identidad universitaria de cada estudiante.
                </p>
            </div>
        </div>

        {{-- GRID DE DOMINIOS --}}
        <div class="dominios-wrap">
            <div class="dominios-grid">

                @forelse($dominios as $dominio)
                    <div class="dominio-card">

                        <div style="
                            height:8px;
                            background:{{ $dominio->color }};
                            flex-shrink:0;
                        "></div>

                        <div style="
                            padding:1.5rem;
                            display:flex;
                            flex-direction:column;
                            flex:1;
                        ">
                            <div style="
                                width:100%;
                                aspect-ratio:1;
                                background:#1D1D2B;
                                border:1px dashed rgba(255,255,255,.15);
                                border-radius:12px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                margin-bottom:1.5rem;
                            ">
                            </div>

                            <h4 style="
                                color:#C8A84B;
                                font-size:1.15rem;
                                margin-bottom:.3rem;
                                font-family:'Headland One',serif;
                            ">
                                {{ $dominio->nombre_casa }}
                            </h4>

                            <h3 style="
                                color:#FFFFFF;
                                font-size:1.15rem;
                                margin-bottom:.8rem;
                                font-family:'Headland One',serif;
                            ">
                                {{ $dominio->nombre }}
                            </h3>

                            <p style="
                                color:#B0A898;
                                line-height:1.7;
                                margin-bottom:1.5rem;
                                flex:1;
                            ">
                                {{ $dominio->descripcion }}
                            </p>

                            <div style="display:flex;flex-wrap:wrap;gap:.5rem;">
                                @forelse($dominio->casas as $casa)
                                    <span style="
                                        background:rgba(255,255,255,.04);
                                        border:1px solid rgba(255,255,255,.08);
                                        color:#F0EAD8;
                                        padding:.4rem .75rem;
                                        border-radius:50px;
                                        font-size:.72rem;
                                    ">
                                        {{ $casa->nombre }}
                                    </span>
                                @empty
                                    <span style="
                                        color:#707085;
                                        font-size:.78rem;
                                        font-style:italic;
                                    ">
                                        No hay carreras registradas.
                                    </span>
                                @endforelse
                            </div>

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
                            No hay dominios académicos registrados.
                        </p>
                    </div>
                @endforelse

            </div>
        </div>

        {{-- CTA --}}
        <section class="cta-section">
            <h2
                class="cta-title"
                style="color:#FFFFFF;font-family:'Headland One',serif;"
            >
                Descubre tu camino académico
            </h2>

            <p class="cta-desc" style="color:#F0EAD8;">
                Realiza el cuestionario NOVA y descubre qué dominio y qué casa
                representan mejor tus intereses, habilidades y forma de aprender.
            </p>

            <a
                href="{{ route('quiz') }}"
                class="cta-btn"
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

    </div>

    {{-- FOOTER --}}
    @include('partials.footer')
</div>

@endsection