@extends('layouts.app')
@section('title', 'Acerca de — NOVA')

@section('content')

<style>
    *, *::before, *::after { box-sizing: border-box; }

    .acerca-wrap {
        max-width: 980px;
        margin: 0 auto;
        padding: 3.5rem 2rem 2rem;
    }

    .acerca-hero {
        text-align: center;
        margin-bottom: 3rem;
    }
    .acerca-eyebrow {
        color: #E8C96A;
        letter-spacing: 4px;
        text-transform: uppercase;
        font-size: .78rem;
        display: block;
        margin-bottom: .75rem;
    }
    .acerca-title {
        font-family: 'Headland One', serif;
        color: #C8A84B;
        font-size: clamp(2rem, 5vw, 3rem);
        margin: 0 0 1rem;
    }
    .acerca-lead {
        color: #F0EAD8;
        line-height: 1.9;
        max-width: 680px;
        margin: 0 auto;
        font-size: 1rem;
    }

    .panel {
        background: linear-gradient(rgba(6,6,15,.7), rgba(6,6,15,.9));
        border: 1px solid #8B6914;
        border-radius: 10px;
        padding: 2.5rem;
        margin-bottom: 2rem;
    }

    .panel h2 {
        font-family: 'Headland One', serif;
        color: #FFFFFF;
        font-size: 1.35rem;
        letter-spacing: .06em;
        text-transform: uppercase;
        margin: 0 0 1.5rem;
        display: flex;
        align-items: center;
        gap: .75rem;
    }
    .panel h2::before {
        content: '';
        width: 4px;
        height: 1.2rem;
        background: #C8A84B;
        border-radius: 2px;
        flex-shrink: 0;
    }

    /* ── Funcionalidades ── */
    .feature-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    .feature-item {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }
    .feature-icon {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        border-radius: 10px;
        background: rgba(200,168,75,.1);
        border: 1px solid rgba(200,168,75,.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #E8C96A;
    }
    .feature-text h3 {
        font-family: 'Headland One', serif;
        color: #E8C96A;
        font-size: .98rem;
        margin: 0 0 .35rem;
    }
    .feature-text p {
        color: #B0A898;
        font-size: .87rem;
        line-height: 1.7;
        margin: 0;
    }
/* ── Colaboradores ── */
    .collab-group {
        margin-bottom: 1.75rem;
    }
    .collab-group:last-child {
        margin-bottom: 0;
    }
    .collab-group-title {
        font-family: 'Headland One', serif;
        color: #C8A84B;
        font-size: 1rem;
        margin: 0 0 1rem;
        padding-bottom: .6rem;
        border-bottom: 1px solid rgba(200,168,75,.15);
    }
    .collab-list {
        display: flex;
        flex-direction: column;
        gap: .9rem;
    }
    .collab-item {
        display: flex;
        flex-wrap: wrap;
        align-items: baseline;
        gap: .1rem .5rem;
    }
    .collab-item .collab-name {
        color: #F0EAD8;
        font-weight: 700;
        font-size: .92rem;
    }
    .collab-item .collab-role {
        color: #B0A898;
        font-size: .85rem;
    }
    /* ── Desarrolladores ── */
    .dev-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
    }
    .dev-card {
        background: rgba(13,13,26,.6);
        border: 1px solid #2B1F3D;
        border-radius: 10px;
        padding: 1.5rem 1.25rem;
        text-align: center;
        transition: border-color .2s;
    }
    .dev-card:hover { border-color: rgba(200,168,75,.5); }
    .dev-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        margin: 0 auto .9rem;
        background: linear-gradient(135deg,#C6A050,#8D6627);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1A1000;
        font-family: 'Headland One', serif;
        font-size: 1.2rem;
        font-weight: 700;
    }
    .dev-card h3 {
        font-family: 'Headland One', serif;
        color: #F0EAD8;
        font-size: 1rem;
        margin: 0 0 .3rem;
    }
    .dev-role {
        color: #C8A84B;
        font-size: .74rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        display: block;
        margin-bottom: .6rem;
    }
    .dev-card a {
        color: #B0A898;
        font-size: .78rem;
        text-decoration: none;
        word-break: break-all;
    }
    .dev-card a:hover { color: #E8C96A; }

    @media (max-width: 768px) {
        .acerca-wrap { padding: 2.5rem 1.25rem 1.5rem; }
        .panel { padding: 1.75rem 1.25rem; }
        .feature-grid { grid-template-columns: 1fr; }
        .dev-grid { grid-template-columns: 1fr; }
    }
</style>

@include('partials.navbar')

<div class="acerca-wrap">

    {{-- ── Hero ── --}}
    <div class="acerca-hero">
        <span class="acerca-eyebrow">Sobre la plataforma</span>
        <h1 class="acerca-title">¿Qué es NOVA?</h1>
        <p class="acerca-lead">
            NOVA es el Navegador de Orientación Vocacional y Aptitudes de la
            Universidad Tecnológica de León. A través de un quiz interactivo,
            ayuda a estudiantes de nuevo ingreso a descubrir qué casa académica
            —y con ella, qué carrera y dominio— se alinea mejor con sus
            intereses, habilidades y forma de pensar.
        </p>
    </div>

    {{-- ── Funcionalidades ── --}}
    <section class="panel">
        <h2>¿Qué puedes hacer aquí?</h2>

        <div class="feature-grid">

            <div class="feature-item">
                <div class="feature-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2l3 6 6 .9-4.5 4.4 1 6.2L12 16l-5.5 3.5 1-6.2L3 8.9 9 8z"/>
                    </svg>
                </div>
                <div class="feature-text">
                    <h3>Quiz vocacional</h3>
                    <p>Responde una serie de preguntas divididas en fases y descubre la casa académica que mejor representa tu perfil.</p>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <div class="feature-text">
                    <h3>Explora las casas y dominios</h3>
                    <p>Conoce a detalle cada casa académica, su carrera asociada, sus valores y el dominio al que pertenece dentro de la UTL.</p>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                </div>
                <div class="feature-text">
                    <h3>Recorrido virtual</h3>
                    <p>Explora el campus mediante un videojuego inmersivo y un mapa interactivo con la ubicación de cada edificio.</p>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="feature-text">
                    <h3>Tu cuenta y resultados</h3>
                    <p>Regístrate, realiza el quiz una vez y consulta tu resultado, incluyendo tu segunda y tercera casa más afines.</p>
                </div>
            </div>

        </div>
    </section>

    {{-- ── Desarrolladores ── --}}
    <section class="panel">
        <h2>Desarrolladores del proyecto</h2>

        <div class="dev-grid">

            <div class="dev-card">
                <div class="dev-avatar">CM</div>
                <h3>Citlalli Méndez</h3>
                <span class="dev-role">Documentadora y Administradora de Base de Datos</span>
                <a href="mailto:citlallialejandrams@gmail.com">citlallialejandrams@gmail.com</a>
            </div>

            <div class="dev-card">
                <div class="dev-avatar">MM</div>
                <h3>Miryam Muñoz</h3>
                <span class="dev-role">Diseñadora</span>
                <a href="mailto:miryammunoz26@gmail.com">miryammunoz26@gmail.com</a>
            </div>

            <div class="dev-card">
                <div class="dev-avatar">CF</div>
                <h3>Carlo Flores</h3>
                <span class="dev-role">Programador</span>
                <a href="mailto:carlofernandoflores2006@gmail.com">carlofernandoflores2006@gmail.com</a>
            </div>

        </div>
    </section>
{{-- ── Colaboradores ── --}}
    <section class="panel">
        <h2>Colaboradores</h2>

        <div class="collab-group">
            <h3 class="collab-group-title">Departamento de Comunicación Estratégica Digital</h3>
            <div class="collab-list">
                <div class="collab-item">
                    <span class="collab-name">Allan Ignacio González Gómez</span>
                    <span class="collab-role">— Jefe de Departamento de Comunicación Estratégica y Digital</span>
                </div>
                <div class="collab-item">
                    <span class="collab-name">Nancy Morales Tapia</span>
                    <span class="collab-role">— Coordinadora de Comunicación Digital</span>
                </div>
                <div class="collab-item">
                    <span class="collab-name">Juan Jesús Ibarra Moncada</span>
                    <span class="collab-role">— Coordinador de Comunicación</span>
                </div>
            </div>
        </div>

        <div class="collab-group">
            <h3 class="collab-group-title">Dirección de Desarrollo Académico y Docente</h3>
            <div class="collab-list">
                <div class="collab-item">
                    <span class="collab-name">Liliana González Arredondo</span>
                    <span class="collab-role">— Jefa de Departamento de Innovación Educativa</span>
                </div>
                <div class="collab-item">
                    <span class="collab-name">Reyna Gabriela Martínez García</span>
                    <span class="collab-role">— Jefa de Departamento de Psicopedagógico</span>
                </div>
            </div>
        </div>
    </section>
</div>

@include('partials.footer')

@endsection