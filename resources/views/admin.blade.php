<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo — NOVA</title>
    <link href="https://fonts.googleapis.com/css2?family=Headland+One&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold:      #C8A84B;
            --gold-lt:   #E8C96A;
            --gold-dk:   #8D6627;
            --bg:        #06060F;
            --bg2:       #0D0D1A;
            --bg3:       #14141F;
            --border:    rgba(200,168,75,.18);
            --border-hi: rgba(200,168,75,.55);
            --text:      #F0EAD8;
            --text-muted:#B0A898;
            --sidebar-w: 240px;
        }

        html, body { height: 100%; background: var(--bg); color: var(--text);
                     font-family: system-ui, -apple-system, sans-serif; }

        /* ═══ LAYOUT ═══════════════════════════════════════════════════ */
        .admin-wrap { display: flex; min-height: 100vh; }

        /* ─── SIDEBAR ─────────────────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--bg2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
            transition: transform .3s;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-logo img { height: 2rem; width: auto; }

        .sidebar-logo span {
            font-family: 'Headland One', serif;
            color: var(--gold);
            font-size: 1.1rem;
            letter-spacing: .08em;
        }

        .sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; }

        .nav-section-label {
            font-size: .62rem;
            text-transform: uppercase;
            letter-spacing: .15em;
            color: #4A4060;
            padding: .85rem 1.25rem .35rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .7rem 1.25rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: .85rem;
            letter-spacing: .03em;
            border-left: 3px solid transparent;
            transition: background .15s, color .15s, border-color .15s;
            cursor: pointer;
            background: none;
            border-top: none;
            border-right: none;
            border-bottom: none;
            width: 100%;
            text-align: left;
        }

        .nav-item:hover { background: rgba(200,168,75,.06); color: var(--gold-lt); }

        .nav-item.active {
            background: rgba(200,168,75,.1);
            color: var(--gold-lt);
            border-left-color: var(--gold);
        }

        .nav-item svg { flex-shrink: 0; opacity: .7; }
        .nav-item.active svg, .nav-item:hover svg { opacity: 1; }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--border);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: .6rem;
            width: 100%;
            padding: .65rem 1rem;
            background: rgba(224,82,82,.08);
            border: 1px solid rgba(224,82,82,.25);
            border-radius: 6px;
            color: #E05252;
            font-size: .82rem;
            cursor: pointer;
            transition: background .2s;
            font-family: inherit;
        }
        .btn-logout:hover { background: rgba(224,82,82,.18); }

        /* ─── MAIN ────────────────────────────────────────────────────── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ─── TOPBAR ──────────────────────────────────────────────────── */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2rem;
            background: rgba(13,13,26,.8);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 40;
            backdrop-filter: blur(12px);
        }

        .topbar-title {
            font-family: 'Headland One', serif;
            font-size: 1.15rem;
            color: var(--text);
            letter-spacing: .04em;
        }

        .topbar-badge {
            font-size: .72rem;
            background: rgba(200,168,75,.12);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: .25rem .75rem;
            color: var(--gold);
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        /* hamburger móvil */
        .hamburger-admin {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: .25rem;
            flex-direction: column;
            gap: 5px;
        }
        .hamburger-admin span { display:block;width:22px;height:2px;background:var(--gold);border-radius:2px; }

        /* ─── CONTENIDO ───────────────────────────────────────────────── */
        .content { flex: 1; padding: 2rem; overflow-x: hidden; }

        /* Secciones ocultas por defecto */
        .panel-section { display: none; }
        .panel-section.active { display: block; }

        /* ─── STAT CARDS ──────────────────────────────────────────────── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 10px;
            background: rgba(200,168,75,.1);
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .stat-val { font-size: 2rem; font-weight: 700; color: var(--gold-lt); line-height: 1; }
        .stat-label { font-size: .78rem; color: var(--text-muted); margin-top: .25rem; text-transform: uppercase; letter-spacing: .08em; }

        /* ─── CHART CARDS ─────────────────────────────────────────────── */
        .chart-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
        }

        .chart-card.full { grid-column: 1 / -1; }

        .card-title {
            font-family: 'Headland One', serif;
            font-size: .95rem;
            color: var(--text);
            margin-bottom: 1.25rem;
            letter-spacing: .04em;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .card-title::before {
            content: '';
            display: block;
            width: 3px;
            height: 1rem;
            background: var(--gold);
            border-radius: 2px;
        }

        .chart-wrap { position: relative; height: 280px; }

        /* ─── TABLAS ──────────────────────────────────────────────────── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .85rem;
        }

        .data-table th {
            text-align: left;
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: var(--gold);
            padding: .6rem .85rem;
            border-bottom: 1px solid var(--border);
            font-weight: 600;
        }

        .data-table td {
            padding: .75rem .85rem;
            color: var(--text-muted);
            border-bottom: 1px solid rgba(43,31,61,.4);
            vertical-align: middle;
        }

        .data-table tr:last-child td { border-bottom: none; }
        .data-table tr:hover td { background: rgba(200,168,75,.04); color: var(--text); }

        .badge-dom {
            font-size: .68rem;
            padding: 2px 8px;
            border-radius: 20px;
            border: 1px solid var(--border);
            color: var(--gold);
            background: rgba(200,168,75,.08);
        }

        /* ─── BARRA DE PROGRESO ───────────────────────────────────────── */
        .progress-bar-wrap { display: flex; align-items: center; gap: .75rem; }
        .progress-track { flex: 1; height: 6px; background: var(--bg2); border-radius: 3px; overflow: hidden; }
        .progress-fill  { height: 100%; border-radius: 3px; background: linear-gradient(to right, var(--gold-dk), var(--gold)); transition: width .6s ease; }
        .progress-val   { font-size: .78rem; color: var(--gold-lt); min-width: 2.5rem; text-align: right; }

        /* ─── GESTIÓN (preguntas / casas / dominios) ──────────────────── */
        .mgmt-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .mgmt-search {
            padding: .55rem 1rem;
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--text);
            font-size: .85rem;
            font-family: inherit;
            outline: none;
            width: 260px;
            transition: border-color .2s;
        }
        .mgmt-search:focus { border-color: var(--gold); }
        .mgmt-search::placeholder { color: #3D3550; }

        .btn-primary {
            padding: .55rem 1.25rem;
            background: linear-gradient(135deg, #C6A050, #8D6627);
            border: none;
            border-radius: 6px;
            color: #1A1000;
            font-size: .82rem;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            letter-spacing: .04em;
            transition: opacity .2s;
        }
        .btn-primary:hover { opacity: .88; }

        .btn-sm {
            padding: .3rem .75rem;
            border-radius: 5px;
            font-size: .72rem;
            cursor: pointer;
            font-family: inherit;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text-muted);
            transition: background .15s, color .15s;
        }
        .btn-sm:hover { background: rgba(200,168,75,.1); color: var(--gold-lt); }
        .btn-sm.danger { border-color: rgba(224,82,82,.3); color: #E05252; }
        .btn-sm.danger:hover { background: rgba(224,82,82,.1); }

        .color-dot {
            display: inline-block;
            width: 10px; height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* ─── EMPTY STATE ─────────────────────────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
            font-size: .88rem;
        }

        /* ═══ RESPONSIVE ════════════════════════════════════════════════ */
        @media (max-width: 900px) {
            .stat-grid  { grid-template-columns: repeat(2, 1fr); }
            .chart-grid { grid-template-columns: 1fr; }
            .chart-card.full { grid-column: 1; }
        }

        @media (max-width: 768px) {
            :root { --sidebar-w: 0px; }

            .sidebar {
                transform: translateX(-240px);
                width: 240px;
            }
            .sidebar.open { transform: translateX(0); }

            .main { margin-left: 0; }

            .hamburger-admin { display: flex !important; }

            .stat-grid { grid-template-columns: 1fr; }
            .content   { padding: 1.25rem 1rem; }
            .topbar    { padding: .85rem 1.25rem; }

            .mgmt-search { width: 100%; }
            .mgmt-toolbar { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<div class="admin-wrap">

    {{-- ═══ SIDEBAR ═══════════════════════════════════════════════════ --}}
    <aside class="sidebar" id="adminSidebar">

        <div class="sidebar-logo">
            <img src="{{ asset('imagenes/isotipo_dorado.webp') }}" alt="UTL">
            <span>NOVA Admin</span>
        </div>

        <nav class="sidebar-nav">

            <div class="nav-section-label">Panel</div>

            <button class="nav-item active" onclick="showSection('estadisticas', this)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
                    <line x1="6" y1="20" x2="6" y2="14"/>
                </svg>
                Estadísticas
            </button>

            <div class="nav-section-label">Gestión</div>

            <button class="nav-item" onclick="showSection('preguntas', this)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                Gestión Preguntas
            </button>

            <button class="nav-item" onclick="showSection('casas', this)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Gestión Casas
            </button>

            <button class="nav-item" onclick="showSection('dominios', this)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>
                </svg>
                Gestión Dominios
            </button>

        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Cerrar sesión
                </button>
            </form>
        </div>

    </aside>

    {{-- ═══ MAIN ═══════════════════════════════════════════════════════ --}}
    <div class="main">

        {{-- Topbar --}}
        <header class="topbar">
            <div style="display:flex;align-items:center;gap:1rem;">
                <button class="hamburger-admin" id="adminHamburger" aria-label="Menú">
                    <span></span><span></span><span></span>
                </button>
                <h1 class="topbar-title" id="topbarTitle">Estadísticas</h1>
            </div>
            <span class="topbar-badge">Admin</span>
        </header>

        {{-- Contenido --}}
        <main class="content">

            {{-- ══════════════════════════════════════════════════════════
                 SECCIÓN: ESTADÍSTICAS
                 ══════════════════════════════════════════════════════════ --}}
            <section class="panel-section active" id="sec-estadisticas">

                {{-- Stat cards --}}
                <div class="stat-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#C8A84B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <div>
                            <div class="stat-val">{{ $totalAlumnos }}</div>
                            <div class="stat-label">Total alumnos</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4BC864" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        </div>
                        <div>
                            <div class="stat-val" style="color:#4BC864;">{{ $totalConCasa }}</div>
                            <div class="stat-label">Con casa asignada</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#E8C96A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                        </div>
                        <div>
                            <div class="stat-val" style="color:#E8C96A;">{{ $totalSinCasa }}</div>
                            <div class="stat-label">Sin casa aún</div>
                        </div>
                    </div>
                </div>

                {{-- Gráficas --}}
                <div class="chart-grid">

                    {{-- Casas más asignadas --}}
                    <div class="chart-card full">
                        <div class="card-title">Casas más asignadas</div>
                        <div class="chart-wrap">
                            <canvas id="chartCasas"></canvas>
                        </div>
                    </div>

                    {{-- Resultados por carrera --}}
                    <div class="chart-card full">
                        <div class="card-title">Resultados por carrera</div>
                        <div class="chart-wrap" style="height:320px;">
                            <canvas id="chartCarreras"></canvas>
                        </div>
                    </div>

                    {{-- Afinidad por dominio --}}
                    <div class="chart-card full">
                        <div class="card-title">Afinidad por dominio</div>
                        <div class="chart-wrap" style="height:220px;">
                            <canvas id="chartDominios"></canvas>
                        </div>
                    </div>

                </div>

                {{-- Tabla: top casas --}}
                <div class="chart-card">
                    <div class="card-title">Gráficas generales — Top Casas</div>
                    @if($casasMasAsignadas->count())
                    @php $maxCasa = $casasMasAsignadas->first()->total; @endphp
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Casa</th>
                                <th>Alumnos</th>
                                <th style="width:40%;">Distribución</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($casasMasAsignadas->take(10) as $i => $row)
                            <tr>
                                <td style="color:#4A3560;font-size:.75rem;">{{ $i+1 }}</td>
                                <td style="color:var(--text);font-weight:600;">{{ $row->casa }}</td>
                                <td style="color:var(--gold-lt);">{{ $row->total }}</td>
                                <td>
                                    <div class="progress-bar-wrap">
                                        <div class="progress-track">
                                            <div class="progress-fill" style="width:{{ round(($row->total / $maxCasa)*100) }}%"></div>
                                        </div>
                                        <span class="progress-val">{{ round(($row->total / $totalConCasa)*100) }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">No hay datos de casas asignadas todavía.</div>
                    @endif
                </div>

            </section>

            {{-- ══════════════════════════════════════════════════════════
                 SECCIÓN: GESTIÓN PREGUNTAS
                 ══════════════════════════════════════════════════════════ --}}
            <section class="panel-section" id="sec-preguntas">
                <div class="chart-card">
                    <div class="mgmt-toolbar">
                        <input type="text" class="mgmt-search" placeholder="Buscar pregunta..."
                               oninput="filtrarTabla(this,'tablaPreguntas')">
                        <button class="btn-primary" onclick="alert('Próximamente: formulario para agregar pregunta.')">
                            + Nueva pregunta
                        </button>
                    </div>

                    @if(isset($preguntas) && $preguntas->count())
                    <table class="data-table" id="tablaPreguntas">
                        <thead>
                            <tr>
                                <th>Orden</th>
                                <th>Pregunta</th>
                                <th>Casa asociada</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($preguntas as $p)
                            <tr>
                                <td style="color:#4A3560;">{{ $p->orden ?? '—' }}</td>
                                <td style="color:var(--text);max-width:400px;">{{ $p->texto ?? $p->pregunta ?? '—' }}</td>
                                <td><span class="badge-dom">{{ $p->casa ?? '—' }}</span></td>
                                <td style="display:flex;gap:.4rem;">
                                    <button class="btn-sm">Editar</button>
                                    <button class="btn-sm danger">Eliminar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">No hay preguntas registradas en la base de datos.<br>
                        <small style="color:#4A3560;font-size:.78rem;">Verifica que la tabla <code>preguntas</code> existe y tiene datos.</small>
                    </div>
                    @endif
                </div>
            </section>

            {{-- ══════════════════════════════════════════════════════════
                 SECCIÓN: GESTIÓN CASAS
                 ══════════════════════════════════════════════════════════ --}}
            <section class="panel-section" id="sec-casas">
                <div class="chart-card">
                    <div class="mgmt-toolbar">
                        <input type="text" class="mgmt-search" placeholder="Buscar casa..."
                               oninput="filtrarTabla(this,'tablaCasas')">
                        <button class="btn-primary" onclick="alert('Próximamente: formulario para agregar casa.')">
                            + Nueva casa
                        </button>
                    </div>

                    @if(isset($casas) && $casas->count())
                    <table class="data-table" id="tablaCasas">
                        <thead>
                            <tr>
                                <th>Color</th>
                                <th>Nombre</th>
                                <th>Dominio</th>
                                <th>Carrera</th>
                                <th>Alumnos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($casas as $c)
                            @php
                                $count = $casasMasAsignadas->firstWhere('casa', $c->nombre)?->total ?? 0;
                            @endphp
                            <tr>
                                <td>
                                    <span class="color-dot" style="background:{{ $c->color ?? '#C8A84B' }};"></span>
                                </td>
                                <td style="color:var(--text);font-weight:600;">{{ $c->nombre }}</td>
                                <td><span class="badge-dom">{{ $c->dominio ?? '—' }}</span></td>
                                <td style="color:var(--text-muted);">{{ $c->carrera ?? '—' }}</td>
                                <td style="color:var(--gold-lt);">{{ $count }}</td>
                                <td style="display:flex;gap:.4rem;">
                                    <button class="btn-sm">Editar</button>
                                    <button class="btn-sm danger">Eliminar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">No hay casas registradas en la base de datos.<br>
                        <small style="color:#4A3560;font-size:.78rem;">Verifica que la tabla <code>casas</code> existe y tiene datos.</small>
                    </div>
                    @endif
                </div>
            </section>

            {{-- ══════════════════════════════════════════════════════════
                 SECCIÓN: GESTIÓN DOMINIOS
                 ══════════════════════════════════════════════════════════ --}}
            <section class="panel-section" id="sec-dominios">
                <div class="chart-card">
                    <div class="mgmt-toolbar">
                        <input type="text" class="mgmt-search" placeholder="Buscar dominio..."
                               oninput="filtrarTabla(this,'tablaDominios')">
                        <button class="btn-primary" onclick="alert('Próximamente: formulario para agregar dominio.')">
                            + Nuevo dominio
                        </button>
                    </div>

                    @if(isset($dominios) && $dominios->count())
                    <table class="data-table" id="tablaDominios">
                        <thead>
                            <tr>
                                <th>Color</th>
                                <th>Nombre</th>
                                <th>Carreras</th>
                                <th>Afinidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dominios as $d)
                            <tr>
                                <td><span class="color-dot" style="background:{{ $d->color ?? '#C8A84B' }};"></span></td>
                                <td style="color:var(--text);font-weight:600;">{{ $d->nombre }}</td>
                                <td style="color:var(--text-muted);font-size:.8rem;">{{ $d->carreras ?? '—' }}</td>
                                <td style="color:var(--gold-lt);">{{ $afinidadDominio[$d->nombre] ?? 0 }}</td>
                                <td style="display:flex;gap:.4rem;">
                                    <button class="btn-sm">Editar</button>
                                    <button class="btn-sm danger">Eliminar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">No hay dominios registrados en la base de datos.<br>
                        <small style="color:#4A3560;font-size:.78rem;">Verifica que la tabla <code>dominios</code> existe y tiene datos.</small>
                    </div>
                    @endif
                </div>
            </section>

        </main>
    </div>{{-- /main --}}

</div>{{-- /admin-wrap --}}

<script>
// ── Navegación entre secciones ────────────────────────────────────────
const sectionTitles = {
    estadisticas: 'Estadísticas',
    preguntas:    'Gestión Preguntas',
    casas:        'Gestión Casas',
    dominios:     'Gestión Dominios',
};

function showSection(id, btn) {
    document.querySelectorAll('.panel-section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    document.getElementById('sec-' + id).classList.add('active');
    btn.classList.add('active');
    document.getElementById('topbarTitle').textContent = sectionTitles[id] || id;
    // cierra sidebar en móvil
    document.getElementById('adminSidebar').classList.remove('open');
}

// ── Hamburger ────────────────────────────────────────────────────────
document.getElementById('adminHamburger').addEventListener('click', () => {
    document.getElementById('adminSidebar').classList.toggle('open');
});
document.addEventListener('click', e => {
    const sb  = document.getElementById('adminSidebar');
    const hbg = document.getElementById('adminHamburger');
    if (sb.classList.contains('open') && !sb.contains(e.target) && !hbg.contains(e.target))
        sb.classList.remove('open');
});

// ── Filtrar tablas ───────────────────────────────────────────────────
function filtrarTabla(input, tableId) {
    const q = input.value.toLowerCase();
    document.querySelectorAll('#' + tableId + ' tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}

// ── Chart.js — configuración común ───────────────────────────────────
const chartDefaults = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: false },
        tooltip: {
            backgroundColor: '#14141F',
            borderColor: 'rgba(200,168,75,.35)',
            borderWidth: 1,
            titleColor: '#E8C96A',
            bodyColor: '#B0A898',
        }
    },
    scales: {
        x: {
            ticks: { color: '#707085', font: { size: 11 } },
            grid:  { color: 'rgba(43,31,61,.4)' },
        },
        y: {
            ticks: { color: '#707085', font: { size: 11 }, stepSize: 1 },
            grid:  { color: 'rgba(43,31,61,.4)' },
            beginAtZero: true,
        }
    }
};

// ── Datos desde Laravel ───────────────────────────────────────────────
const casasLabels  = @json($casasMasAsignadas->pluck('casa'));
const casasTotales = @json($casasMasAsignadas->pluck('total'));

const carrerasLabels  = @json($resultadosPorCarrera->pluck('carrera'));
const carrerasTotales = @json($resultadosPorCarrera->pluck('total'));

const dominiosLabels  = @json(array_keys($afinidadDominio));
const dominiosTotales = @json(array_values($afinidadDominio));

// Paleta de barras (cíclica)
const barColors = [
    '#C8A84B','#8D6627','#E8C96A','#6B5020',
    '#A07030','#D4A855','#7A5015','#F0C060',
];

function makeBar(id, labels, data) {
    const ctx = document.getElementById(id);
    if (!ctx) return;
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                data,
                backgroundColor: labels.map((_, i) => barColors[i % barColors.length] + 'CC'),
                borderColor:     labels.map((_, i) => barColors[i % barColors.length]),
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: { ...chartDefaults }
    });
}

makeBar('chartCasas',     casasLabels,     casasTotales);
makeBar('chartCarreras',  carrerasLabels,  carrerasTotales);
makeBar('chartDominios',  dominiosLabels,  dominiosTotales);

// ── Animación de barras de progreso ──────────────────────────────────
setTimeout(() => {
    document.querySelectorAll('.progress-fill').forEach(el => {
        const w = el.style.width;
        el.style.width = '0';
        setTimeout(() => el.style.width = w, 100);
    });
}, 200);
</script>

</body>
</html>