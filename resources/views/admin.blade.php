<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Panel Administrativo — NOVA</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Headland+One&display=swap"
        rel="stylesheet"
    >

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --gold: #C8A84B;
            --gold-lt: #E8C96A;
            --gold-dk: #8D6627;
            --bg: #06060F;
            --bg2: #0D0D1A;
            --bg3: #14141F;
            --border: rgba(200, 168, 75, .18);
            --border-hi: rgba(200, 168, 75, .55);
            --text: #F0EAD8;
            --text-muted: #B0A898;
            --success: #4BC864;
            --sidebar-w: 240px;
        }

        html,
        body {
            min-height: 100%;
            background: var(--bg);
            color: var(--text);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        button,
        input {
            font-family: inherit;
        }

        /* ================================================================
           ESTRUCTURA GENERAL
        ================================================================= */

        .admin-wrap {
            display: flex;
            min-height: 100vh;
        }

        /* ================================================================
           SIDEBAR
        ================================================================= */

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 50;

            display: flex;
            flex-direction: column;

            width: var(--sidebar-w);

            background: var(--bg2);
            border-right: 1px solid var(--border);

            transition: transform .3s ease;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: .75rem;

            padding: 1.5rem 1.25rem;

            border-bottom: 1px solid var(--border);
        }

        .sidebar-logo img {
            width: auto;
            height: 2rem;
            object-fit: contain;
        }

        .sidebar-logo span {
            color: var(--gold);
            font-family: "Headland One", serif;
            font-size: 1.05rem;
            letter-spacing: .08em;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }

        .nav-section-label {
            padding: .85rem 1.25rem .35rem;

            color: #595069;
            font-size: .62rem;
            letter-spacing: .15em;
            text-transform: uppercase;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: .75rem;

            width: 100%;
            padding: .75rem 1.25rem;

            background: none;
            border: none;
            border-left: 3px solid transparent;

            color: var(--text-muted);
            cursor: pointer;
            font-size: .85rem;
            letter-spacing: .03em;
            text-align: left;

            transition:
                background .15s,
                color .15s,
                border-color .15s;
        }

        .nav-item:hover {
            background: rgba(200, 168, 75, .06);
            color: var(--gold-lt);
        }

        .nav-item.active {
            background: rgba(200, 168, 75, .10);
            border-left-color: var(--gold);
            color: var(--gold-lt);
        }

        .nav-item svg {
            flex-shrink: 0;
            opacity: .75;
        }

        .nav-item:hover svg,
        .nav-item.active svg {
            opacity: 1;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--border);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;

            width: 100%;
            padding: .7rem 1rem;

            background: rgba(224, 82, 82, .08);
            border: 1px solid rgba(224, 82, 82, .25);
            border-radius: 6px;

            color: #E05252;
            cursor: pointer;
            font-size: .82rem;

            transition: background .2s;
        }

        .btn-logout:hover {
            background: rgba(224, 82, 82, .18);
        }

        /* ================================================================
           CONTENIDO PRINCIPAL
        ================================================================= */

        .main {
            display: flex;
            flex: 1;
            flex-direction: column;

            min-width: 0;
            min-height: 100vh;
            margin-left: var(--sidebar-w);
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 40;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 1rem 2rem;

            background: rgba(13, 13, 26, .82);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(12px);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar-title {
            color: var(--text);
            font-family: "Headland One", serif;
            font-size: 1.15rem;
            font-weight: 400;
            letter-spacing: .04em;
        }

        .topbar-badge {
            padding: .25rem .75rem;

            background: rgba(200, 168, 75, .12);
            border: 1px solid var(--border);
            border-radius: 20px;

            color: var(--gold);
            font-size: .72rem;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .hamburger-admin {
            display: none;
            flex-direction: column;
            gap: 5px;

            padding: .25rem;

            background: none;
            border: none;
            cursor: pointer;
        }

        .hamburger-admin span {
            display: block;

            width: 22px;
            height: 2px;

            background: var(--gold);
            border-radius: 2px;
        }

        .content {
            flex: 1;
            padding: 2rem;
            overflow-x: hidden;
        }

        .panel-section {
            display: none;
        }

        .panel-section.active {
            display: block;
        }

        /* ================================================================
           ENCABEZADOS DE SECCIÓN
        ================================================================= */

        .section-header {
            margin-bottom: 1.5rem;
        }

        .section-title {
            margin-bottom: .4rem;

            color: var(--text);
            font-family: "Headland One", serif;
            font-size: 1.45rem;
            font-weight: 400;
            letter-spacing: .03em;
        }

        .section-description {
            max-width: 760px;
            color: var(--text-muted);
            font-size: .88rem;
            line-height: 1.6;
        }

        /* ================================================================
           TARJETAS
        ================================================================= */

        .chart-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.25rem;

            margin-bottom: 1.5rem;
        }

        .chart-card {
            min-width: 0;
            padding: 1.5rem;

            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        .chart-card.full {
            grid-column: 1 / -1;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: .5rem;

            margin-bottom: 1.25rem;

            color: var(--text);
            font-family: "Headland One", serif;
            font-size: .95rem;
            font-weight: 400;
            letter-spacing: .04em;
        }

        .card-title::before {
            content: "";

            display: block;

            width: 3px;
            height: 1rem;

            background: var(--gold);
            border-radius: 2px;
        }

        /* ================================================================
           MÁS Y MENOS ELEGIDAS
        ================================================================= */

        .comparison-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .comparison-item {
            padding: 1.5rem;

            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 10px;

            text-align: center;
        }

        .comparison-label {
            display: block;

            margin-bottom: .65rem;

            color: var(--text-muted);
            font-size: .68rem;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .comparison-name {
            display: block;

            margin-bottom: .3rem;

            color: var(--text);
            font-size: 1.05rem;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .comparison-secondary {
            display: block;

            margin-bottom: .8rem;

            color: var(--text-muted);
            font-size: .76rem;
        }

        .comparison-value {
            display: block;

            color: var(--gold-lt);
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
        }

        .comparison-item.top .comparison-value {
            color: var(--success);
        }

        .comparison-item.low .comparison-value {
            color: var(--text-muted);
        }

        .comparison-caption {
            display: block;

            margin-top: .35rem;

            color: var(--text-muted);
            font-size: .72rem;
        }

        /* ================================================================
           GRÁFICAS
        ================================================================= */

        .chart-wrap {
            position: relative;
            width: 100%;
            height: 350px;
        }

        .chart-wrap.domain-chart {
            height: 360px;
        }

        /* ================================================================
           TABLAS
        ================================================================= */

        .table-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;

            margin-bottom: 1.25rem;
        }

        .table-summary {
            color: var(--text-muted);
            font-size: .82rem;
        }
.btn-export {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .6rem 1.1rem;
    background: rgba(200, 168, 75, .10);
    border: 1px solid var(--border);
    border-radius: 6px;
    color: var(--gold-lt);
    font-size: .82rem;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    transition: background .2s, border-color .2s;
}
.btn-export:hover {
    background: rgba(200, 168, 75, .18);
    border-color: var(--border-hi);
}
.table-toolbar { flex-wrap: wrap; }
@media (max-width: 768px) {
    .btn-export { width: 100%; justify-content: center; }
}
        .search-input {
            width: 270px;
            padding: .6rem 1rem;

            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 6px;
            outline: none;

            color: var(--text);
            font-size: .84rem;

            transition: border-color .2s;
        }

        .search-input:focus {
            border-color: var(--gold);
        }

        .search-input::placeholder {
            color: #62596F;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            min-width: 720px;

            border-collapse: collapse;

            font-size: .85rem;
        }

        .data-table th {
            padding: .7rem .85rem;

            border-bottom: 1px solid var(--border);

            color: var(--gold);
            font-size: .68rem;
            font-weight: 600;
            letter-spacing: .12em;
            text-align: left;
            text-transform: uppercase;
        }

        .data-table td {
            padding: .8rem .85rem;

            border-bottom: 1px solid rgba(200, 168, 75, .08);

            color: var(--text-muted);
            vertical-align: middle;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .data-table tbody tr:hover td {
            background: rgba(200, 168, 75, .04);
            color: var(--text);
        }

        .position-number {
            color: var(--gold-lt);
            font-weight: 700;
        }

        .name-cell {
            display: flex;
            align-items: center;
            gap: .65rem;

            color: var(--text);
            font-weight: 600;
        }

        .color-dot {
            display: inline-block;
            flex-shrink: 0;

            width: 11px;
            height: 11px;

            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 50%;
        }

        .domain-badge {
            display: inline-block;

            padding: .25rem .65rem;

            background: rgba(200, 168, 75, .08);
            border: 1px solid var(--border);
            border-radius: 20px;

            color: var(--gold-lt);
            font-size: .7rem;
        }

        .progress-bar-wrap {
            display: flex;
            align-items: center;
            gap: .75rem;

            min-width: 170px;
        }

        .progress-track {
            flex: 1;

            height: 7px;

            background: var(--bg2);
            border-radius: 20px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;

            background: linear-gradient(
                to right,
                var(--gold-dk),
                var(--gold)
            );

            border-radius: 20px;

            transition: width .6s ease;
        }

        .progress-value {
            min-width: 42px;

            color: var(--gold-lt);
            font-size: .76rem;
            text-align: right;
        }

        .result-count {
            color: var(--gold-lt);
            font-weight: 700;
        }

        /* ================================================================
           ESTADO VACÍO
        ================================================================= */

        .empty-state {
            padding: 3rem 1rem;

            color: var(--text-muted);
            font-size: .88rem;
            line-height: 1.6;
            text-align: center;
        }

        .empty-icon {
            display: block;

            margin-bottom: .75rem;

            color: var(--gold);
            font-size: 2rem;
        }

        /* ================================================================
           RESPONSIVE
        ================================================================= */

        @media (max-width: 1000px) {
            .chart-grid {
                grid-template-columns: 1fr;
            }

            .chart-card.full {
                grid-column: 1;
            }
        }

        @media (max-width: 768px) {
            :root {
                --sidebar-w: 0px;
            }

            .sidebar {
                width: 240px;
                transform: translateX(-240px);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
            }

            .hamburger-admin {
                display: flex;
            }

            .content {
                padding: 1.25rem 1rem;
            }

            .topbar {
                padding: .85rem 1.25rem;
            }

            .topbar-title {
                font-size: 1rem;
            }

            .comparison-grid {
                grid-template-columns: 1fr;
            }

            .table-toolbar {
                align-items: flex-start;
                flex-direction: column;
            }

            

            .search-input {
                width: 100%;
            }

            .chart-wrap {
                height: 300px;
            }
        }

        @media (max-width: 480px) {
            .chart-card {
                padding: 1.1rem;
            }

            .section-title {
                font-size: 1.2rem;
            }

            .chart-wrap {
                height: 270px;
            }

            .topbar-badge {
                display: none;
            }
        }
    </style>
</head>

<body>

@php
    $casaMaxima = $casas->max('resultados_count') ?? 0;
    $dominioMaximo = $dominios->max('resultados_count') ?? 0;
@endphp

<div class="admin-wrap">

    {{-- ================================================================
         SIDEBAR
    ================================================================= --}}

    <aside
        class="sidebar"
        id="adminSidebar"
    >
        <div class="sidebar-logo">
            <img
                src="{{ asset('imagenes/isotipo_dorado.webp') }}"
                alt="NOVA"
            >

            <span>NOVA Admin</span>
        </div>

        <nav class="sidebar-nav">

            <div class="nav-section-label">
                Panel
            </div>

            <button
                type="button"
                class="nav-item active"
                data-section="estadisticas"
                onclick="showSection('estadisticas', this)"
            >
                <svg
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>

                Estadísticas
            </button>

            <div class="nav-section-label">
                Resultados generales
            </div>

            <button
                type="button"
                class="nav-item"
                data-section="casas"
                onclick="showSection('casas', this)"
            >
                <svg
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>

                Estadísticas de casas
            </button>

            <button
                type="button"
                class="nav-item"
                data-section="dominios"
                onclick="showSection('dominios', this)"
            >
                <svg
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path>
                    <path d="M4.93 4.93a10 10 0 0 0 0 14.14"></path>
                </svg>

                Estadísticas de dominios
            </button>

        </nav>

        <div class="sidebar-footer">

            <form
                action="{{ route('salir') }}"
                method="POST"
            >
                @csrf

                <button
                    type="submit"
                    class="btn-logout"
                >
                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>

                    Cerrar sesión
                </button>
            </form>

        </div>
    </aside>

    {{-- ================================================================
         CONTENIDO PRINCIPAL
    ================================================================= --}}

    <div class="main">

        <header class="topbar">

            <div class="topbar-left">

                <button
                    type="button"
                    class="hamburger-admin"
                    id="adminHamburger"
                    aria-label="Abrir menú administrativo"
                >
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <h1
                    class="topbar-title"
                    id="topbarTitle"
                >
                    Estadísticas
                </h1>

            </div>

            <span class="topbar-badge">
                Administrador
            </span>

        </header>

        <main class="content">

            {{-- ============================================================
                 SECCIÓN GENERAL
            ============================================================= --}}

            <section
                class="panel-section active"
                id="sec-estadisticas"
            >

                <div class="section-header">
                    <h2 class="section-title">
                        Estadísticas generales
                    </h2>

                    <p class="section-description">
                        En este apartado se presenta una comparación general de las
                        casas y dominios obtenidos mediante el Quiz vocacional.
                        La información se actualiza de acuerdo con los resultados
                        almacenados en el sistema.
                    </p>
                </div>

                <div class="chart-grid">

                    {{-- Casas más y menos elegidas --}}

                    <article class="chart-card">

                        <h3 class="card-title">
                            Casas
                        </h3>

                        <div class="comparison-grid">

                            <div class="comparison-item top">

                                <span class="comparison-label">
                                    Más elegida
                                </span>

                                <span class="comparison-name">
                                    {{ $casaMasElegida?->nombre_casa ?? 'Sin resultados' }}
                                </span>

                                <span class="comparison-secondary">
                                    {{ $casaMasElegida?->nombre ?? '—' }}
                                </span>

                                <span class="comparison-value">
                                    {{ $casaMasElegida?->resultados_count ?? 0 }}
                                </span>

                                <span class="comparison-caption">
                                    resultados
                                </span>

                            </div>

                            <div class="comparison-item low">

                                <span class="comparison-label">
                                    Menos elegida
                                </span>

                                <span class="comparison-name">
                                    {{ $casaMenosElegida?->nombre_casa ?? 'Sin resultados' }}
                                </span>

                                <span class="comparison-secondary">
                                    {{ $casaMenosElegida?->nombre ?? '—' }}
                                </span>

                                <span class="comparison-value">
                                    {{ $casaMenosElegida?->resultados_count ?? 0 }}
                                </span>

                                <span class="comparison-caption">
                                    resultados
                                </span>

                            </div>

                        </div>

                    </article>

                    {{-- Dominios más y menos elegidos --}}

                    <article class="chart-card">

                        <h3 class="card-title">
                            Dominios
                        </h3>

                        <div class="comparison-grid">

                            <div class="comparison-item top">

                                <span class="comparison-label">
                                    Más elegido
                                </span>

                                <span class="comparison-name">
                                    {{ $dominioMasElegido?->nombre ?? 'Sin resultados' }}
                                </span>

                                <span class="comparison-secondary">
                                    {{ $dominioMasElegido?->nombre_casa ?? '—' }}
                                </span>

                                <span class="comparison-value">
                                    {{ $dominioMasElegido?->resultados_count ?? 0 }}
                                </span>

                                <span class="comparison-caption">
                                    resultados
                                </span>

                            </div>

                            <div class="comparison-item low">

                                <span class="comparison-label">
                                    Menos elegido
                                </span>

                                <span class="comparison-name">
                                    {{ $dominioMenosElegido?->nombre ?? 'Sin resultados' }}
                                </span>

                                <span class="comparison-secondary">
                                    {{ $dominioMenosElegido?->nombre_casa ?? '—' }}
                                </span>

                                <span class="comparison-value">
                                    {{ $dominioMenosElegido?->resultados_count ?? 0 }}
                                </span>

                                <span class="comparison-caption">
                                    resultados
                                </span>

                            </div>

                        </div>

                    </article>

                    {{-- Gráfica general de casas --}}

                    <article class="chart-card full">

                        <h3 class="card-title">
                            Resultados por casa
                        </h3>

                        @if ($casas->isNotEmpty())

                            <div class="chart-wrap">
                                <canvas id="graficaCasasGeneral"></canvas>
                            </div>

                        @else

                            <div class="empty-state">
                                <span class="empty-icon">⌂</span>
                                Todavía no existen casas registradas en la base de datos.
                            </div>

                        @endif

                    </article>

                    {{-- Gráfica general de dominios --}}

                    <article class="chart-card full">

                        <h3 class="card-title">
                            Resultados por dominio
                        </h3>

                        @if ($dominios->isNotEmpty())

                            <div class="chart-wrap domain-chart">
                                <canvas id="graficaDominiosGeneral"></canvas>
                            </div>

                        @else

                            <div class="empty-state">
                                <span class="empty-icon">◉</span>
                                Todavía no existen dominios registrados en la base de datos.
                            </div>

                        @endif

                    </article>

                </div>

            </section>

            {{-- ============================================================
                 SECCIÓN CASAS
            ============================================================= --}}

            <section
                class="panel-section"
                id="sec-casas"
            >

                <div class="section-header">

                    <h2 class="section-title">
                        Estadísticas por casa
                    </h2>

                    <p class="section-description">
                        La tabla muestra todas las casas registradas, la carrera
                        representada por cada una, su dominio y el número de veces
                        que fueron obtenidas como resultado del Quiz.
                    </p>

                </div>

                <article class="chart-card">

<div class="table-toolbar">

    <span class="table-summary">
        {{ $casas->count() }}
        {{ $casas->count() === 1 ? 'casa registrada' : 'casas registradas' }}
    </span>

    <div style="display:flex; gap:.75rem; flex-wrap:wrap; align-items:center;">
        <input
            type="search"
            class="search-input"
            id="buscarCasa"
            placeholder="Buscar casa, carrera o dominio..."
            autocomplete="off"
        >

        <a href="{{ route('admin.exportar.casas') }}" class="btn-export">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Descargar Excel
        </a>
    </div>

</div>

                    @if ($casas->isNotEmpty())

                        <div class="table-responsive">

                            <table
                                class="data-table"
                                id="tablaCasas"
                            >

                                <thead>
                                    <tr>
                                        <th>Posición</th>
                                        <th>Casa</th>
                                        <th>Carrera</th>
                                        <th>Dominio</th>
                                        <th>Resultados</th>
                                        <th>Porcentaje</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($casas as $casa)

                                        @php
                                            $porcentajeCasa = $totalResultados > 0
                                                ? round(($casa->resultados_count / $totalResultados) * 100, 1)
                                                : 0;
                                        @endphp

                                        <tr>

                                            <td>
                                                <span class="position-number">
                                                    {{ $loop->iteration }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="name-cell">

                                                    <span
                                                        class="color-dot"
                                                        style="background-color: {{ $casa->color ?: '#C8A84B' }};"
                                                    ></span>

                                                    {{ $casa->nombre_casa }}

                                                </div>
                                            </td>

                                            <td>
                                                {{ $casa->nombre }}
                                            </td>

                                            <td>
                                                <span class="domain-badge">
                                                    {{ $casa->dominio?->nombre ?? 'Sin dominio' }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="result-count">
                                                    {{ $casa->resultados_count }}
                                                </span>
                                            </td>

                                            <td>

                                                <div class="progress-bar-wrap">

                                                    <div class="progress-track">
                                                        <div
                                                            class="progress-fill"
                                                            style="width: {{ $porcentajeCasa }}%;"
                                                        ></div>
                                                    </div>

                                                    <span class="progress-value">
                                                        {{ $porcentajeCasa }}%
                                                    </span>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="empty-state">
                            <span class="empty-icon">⌂</span>
                            Aún no hay casas registradas.
                        </div>

                    @endif

                </article>

            </section>

            {{-- ============================================================
                 SECCIÓN DOMINIOS
            ============================================================= --}}

            <section
                class="panel-section"
                id="sec-dominios"
            >

                <div class="section-header">

                    <h2 class="section-title">
                        Estadísticas por dominio
                    </h2>

                    <p class="section-description">
                        La tabla presenta los dominios académicos, la cantidad de
                        casas que pertenecen a cada uno y el número de resultados
                        obtenidos dentro del Quiz vocacional.
                    </p>

                </div>

                <article class="chart-card">

                 <div class="table-toolbar">

    <span class="table-summary">
        {{ $dominios->count() }}
        {{ $dominios->count() === 1 ? 'dominio registrado' : 'dominios registrados' }}
    </span>

    <div style="display:flex; gap:.75rem; flex-wrap:wrap; align-items:center;">
        <input
            type="search"
            class="search-input"
            id="buscarDominio"
            placeholder="Buscar dominio..."
            autocomplete="off"
        >

        <a href="{{ route('admin.exportar.dominios') }}" class="btn-export">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Descargar Excel
        </a>
    </div>

</div>

                    @if ($dominios->isNotEmpty())

                        <div class="table-responsive">

                            <table
                                class="data-table"
                                id="tablaDominios"
                            >

                                <thead>
                                    <tr>
                                        <th>Posición</th>
                                        <th>Dominio</th>
                                        <th>Nombre simbólico</th>
                                        <th>Casas</th>
                                        <th>Resultados</th>
                                        <th>Porcentaje</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($dominios as $dominio)

                                        @php
                                            $porcentajeDominio = $totalResultados > 0
                                                ? round(($dominio->resultados_count / $totalResultados) * 100, 1)
                                                : 0;
                                        @endphp

                                        <tr>

                                            <td>
                                                <span class="position-number">
                                                    {{ $loop->iteration }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="name-cell">

                                                    <span
                                                        class="color-dot"
                                                        style="background-color: {{ $dominio->color ?: '#C8A84B' }};"
                                                    ></span>

                                                    {{ $dominio->nombre }}

                                                </div>
                                            </td>

                                            <td>
                                                {{ $dominio->nombre_casa ?: '—' }}
                                            </td>

                                            <td>
                                                {{ $dominio->casas_count }}
                                            </td>

                                            <td>
                                                <span class="result-count">
                                                    {{ $dominio->resultados_count }}
                                                </span>
                                            </td>

                                            <td>

                                                <div class="progress-bar-wrap">

                                                    <div class="progress-track">
                                                        <div
                                                            class="progress-fill"
                                                            style="width: {{ $porcentajeDominio }}%;"
                                                        ></div>
                                                    </div>

                                                    <span class="progress-value">
                                                        {{ $porcentajeDominio }}%
                                                    </span>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="empty-state">
                            <span class="empty-icon">◉</span>
                            Aún no hay dominios registrados.
                        </div>

                    @endif

                </article>

            </section>

        </main>

    </div>

</div>

<script>
    /*
    |--------------------------------------------------------------------------
    | Datos enviados por Laravel
    |--------------------------------------------------------------------------
    */

    const casasLabels = @json(
        $casas->map(
            fn ($casa) => $casa->nombre_casa ?: $casa->nombre
        )->values()
    );

    const casasResultados = @json(
        $casas->pluck('resultados_count')->values()
    );

    const casasColores = @json(
        $casas->map(
            fn ($casa) => $casa->color ?: '#C8A84B'
        )->values()
    );

    const dominiosLabels = @json(
        $dominios->pluck('nombre')->values()
    );

    const dominiosResultados = @json(
        $dominios->pluck('resultados_count')->values()
    );

    const dominiosColores = @json(
        $dominios->map(
            fn ($dominio) => $dominio->color ?: '#C8A84B'
        )->values()
    );

    /*
    |--------------------------------------------------------------------------
    | Configuración general de Chart.js
    |--------------------------------------------------------------------------
    */

    Chart.defaults.color = '#B0A898';
    Chart.defaults.borderColor = 'rgba(200, 168, 75, .10)';
    Chart.defaults.font.family =
        'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif';

    /*
    |--------------------------------------------------------------------------
    | Gráfica de casas
    |--------------------------------------------------------------------------
    */

    const canvasCasas = document.getElementById('graficaCasasGeneral');

    if (canvasCasas) {
        new Chart(canvasCasas, {
            type: 'bar',

            data: {
                labels: casasLabels,

                datasets: [
                    {
                        label: 'Resultados',
                        data: casasResultados,
                        backgroundColor: casasColores,
                        borderColor: casasColores,
                        borderWidth: 1,
                        borderRadius: 5,
                        maxBarThickness: 42,
                    }
                ]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                interaction: {
                    intersect: false,
                    mode: 'index',
                },

                plugins: {
                    legend: {
                        display: false,
                    },

                    tooltip: {
                        backgroundColor: '#0D0D1A',
                        borderColor: 'rgba(200, 168, 75, .35)',
                        borderWidth: 1,
                        titleColor: '#F0EAD8',
                        bodyColor: '#B0A898',
                        padding: 12,

                        callbacks: {
                            label: function (context) {
                                const value = context.raw ?? 0;

                                return `${value} ${
                                    value === 1 ? 'resultado' : 'resultados'
                                }`;
                            }
                        }
                    }
                },

                scales: {
                    x: {
                        grid: {
                            display: false,
                        },

                        ticks: {
                            maxRotation: 55,
                            minRotation: 25,
                            font: {
                                size: 10,
                            }
                        }
                    },

                    y: {
                        beginAtZero: true,

                        ticks: {
                            precision: 0,
                            stepSize: 1,
                        }
                    }
                }
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Gráfica de dominios
    |--------------------------------------------------------------------------
    */

    const canvasDominios = document.getElementById(
        'graficaDominiosGeneral'
    );

    if (canvasDominios) {
        new Chart(canvasDominios, {
            type: 'doughnut',

            data: {
                labels: dominiosLabels,

                datasets: [
                    {
                        data: dominiosResultados,
                        backgroundColor: dominiosColores,
                        borderColor: '#14141F',
                        borderWidth: 4,
                        hoverOffset: 8,
                    }
                ]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '58%',

                plugins: {
                    legend: {
                        position: 'bottom',

                        labels: {
                            padding: 18,
                            usePointStyle: true,
                            pointStyle: 'circle',
                        }
                    },

                    tooltip: {
                        backgroundColor: '#0D0D1A',
                        borderColor: 'rgba(200, 168, 75, .35)',
                        borderWidth: 1,
                        titleColor: '#F0EAD8',
                        bodyColor: '#B0A898',
                        padding: 12,

                        callbacks: {
                            label: function (context) {
                                const value = context.raw ?? 0;
                                const total = context.dataset.data.reduce(
                                    (acumulado, cantidad) =>
                                        acumulado + Number(cantidad),
                                    0
                                );

                                const porcentaje = total > 0
                                    ? ((value / total) * 100).toFixed(1)
                                    : 0;

                                return `${context.label}: ${value} (${porcentaje}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Navegación del panel
    |--------------------------------------------------------------------------
    */

    const sectionTitles = {
        estadisticas: 'Estadísticas',
        casas: 'Estadísticas de casas',
        dominios: 'Estadísticas de dominios',
    };

    function showSection(id, button) {
        document
            .querySelectorAll('.panel-section')
            .forEach(section => {
                section.classList.remove('active');
            });

        document
            .querySelectorAll('.nav-item')
            .forEach(navItem => {
                navItem.classList.remove('active');
            });

        const section = document.getElementById(`sec-${id}`);

        if (!section) {
            return;
        }

        section.classList.add('active');
        button.classList.add('active');

        document.getElementById('topbarTitle').textContent =
            sectionTitles[id] || 'Panel administrativo';

        document
            .getElementById('adminSidebar')
            .classList.remove('open');
    }

    /*
    |--------------------------------------------------------------------------
    | Menú móvil
    |--------------------------------------------------------------------------
    */

    const adminSidebar = document.getElementById('adminSidebar');
    const adminHamburger = document.getElementById('adminHamburger');

    adminHamburger.addEventListener('click', function () {
        adminSidebar.classList.toggle('open');
    });

    document.addEventListener('click', function (event) {
        const sidebarEstaAbierto =
            adminSidebar.classList.contains('open');

        const clicDentroDelSidebar =
            adminSidebar.contains(event.target);

        const clicEnHamburguesa =
            adminHamburger.contains(event.target);

        if (
            sidebarEstaAbierto &&
            !clicDentroDelSidebar &&
            !clicEnHamburguesa
        ) {
            adminSidebar.classList.remove('open');
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Buscadores de tablas
    |--------------------------------------------------------------------------
    */

    function configurarBuscador(inputId, tableId) {
        const input = document.getElementById(inputId);
        const table = document.getElementById(tableId);

        if (!input || !table) {
            return;
        }

        input.addEventListener('input', function () {
            const searchValue = input.value
                .toLowerCase()
                .trim();

            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(function (row) {
                const rowText = row.textContent
                    .toLowerCase()
                    .trim();

                row.style.display = rowText.includes(searchValue)
                    ? ''
                    : 'none';
            });
        });
    }

    configurarBuscador('buscarCasa', 'tablaCasas');
    configurarBuscador('buscarDominio', 'tablaDominios');
</script>

</body>
</html>