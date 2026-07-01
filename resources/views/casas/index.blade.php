@extends('layouts.app')
@section('title', 'Casas — NOVA')

@section('content')

<style>
    .nav-links-casas { display:flex; gap:2rem; }
    .nav-auth-casas  { display:flex; align-items:center; gap:.75rem; }
    .hamburger-casas { display:none; background:none; border:none; cursor:pointer;
                       padding:.25rem; flex-direction:column; gap:5px; }
    .hamburger-casas span { display:block; width:22px; height:2px;
                            background:#C8A84B; border-radius:2px; }
    .mobile-menu-casas { display:none; flex-direction:column;
                         background:rgba(6,6,15,0.97); padding:.5rem 0; }
    .mobile-menu-casas a { display:block; padding:.75rem 2rem; font-size:.85rem;
                           color:#B0A898; text-decoration:none; letter-spacing:.08em;
                           text-transform:uppercase;
                           border-bottom:1px solid rgba(43,31,61,0.4); }
    .mobile-menu-casas a:last-child { border-bottom:none; }
    .mobile-menu-casas.open { display:flex; }

    @media (max-width: 768px) {
        .nav-links-casas { display:none !important; }
        .nav-auth-casas  { display:none !important; }
        .hamburger-casas { display:flex !important; }
        .casas-header-section { padding:3rem 1.25rem !important; }
        .casas-header-section h1 { font-size:2rem !important; }
        .filtros-section { padding:0 1rem !important; }
        .filtro-btn { font-size:.72rem !important; padding:.3rem .7rem !important; }
        .casas-cta { padding:3rem 1.25rem !important; }
        .casas-cta h2 { font-size:1.6rem !important; }
        .casas-cta a  { width:100%; box-sizing:border-box; text-align:center; display:block !important; }
    }

    #casasGrid {
        display:grid;
        grid-template-columns:repeat(3, 1fr);
        gap:1.5rem;
    }
    @media (max-width: 900px) {
        #casasGrid { grid-template-columns:repeat(2,1fr); }
    }
    @media (max-width: 500px) {
        #casasGrid { grid-template-columns:1fr; }
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
        background:#14141F; border:1px solid rgba(200,168,75,.15);
        border-radius:18px; overflow:hidden;
        transition:border-color .35s ease, box-shadow .35s ease;
        display:flex; flex-direction:column;
    }
    .casa-card:hover {
        border-color:rgba(200,168,75,.85);
        box-shadow:0 0 0 1px rgba(200,168,75,.4), 0 0 18px rgba(200,168,75,.18);
    }
    .casa-card.oculta { display:none !important; }
    .casa-card-body { padding:1.5rem; display:flex; flex-direction:column; height:100%; }

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
    .modal-label { font-size:.68rem; text-transform:uppercase; letter-spacing:.14em; color:#707085; margin-bottom:.25rem; }
    .modal-title { font-family:'Headland One',serif; color:#FFFFFF; font-size:1.4rem; margin-bottom:.3rem; }
    .modal-dominio { color:#C8A84B; font-size:.82rem; margin-bottom:1.5rem; }
    .modal-section-title {
        font-size:.72rem; text-transform:uppercase; letter-spacing:.12em; color:#C8A84B;
        border-bottom:1px solid rgba(200,168,75,.2); padding-bottom:.4rem; margin-bottom:.8rem;
    }
    .modal-oferta-text { margin-bottom:1.75rem; }
    .modal-link { font-size:.85rem; color:#B0A898; line-height:1.7; }
    .modal-link a { color:#E8C96A; text-decoration:underline; word-break:break-all; }
    .modal-link a:hover { color:#fff; }
    .btn-ver-mas {
        margin-top:1rem; width:100%; padding:.6rem 0; border-radius:8px;
        border:1px solid rgba(200,168,75,.4); background:transparent;
        color:#E8C96A; font-size:.82rem; letter-spacing:.08em;
        cursor:pointer; transition:background .2s,color .2s; font-family:inherit;
    }
    .btn-ver-mas:hover { background:rgba(200,168,75,.12); color:#fff; }

    /* Lista de oferta educativa en columnas */
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
        .modal-oferta-list { grid-template-columns: 1fr; }
    }

    #footer-casas-grid { display:flex; justify-content:space-around; flex-wrap:wrap; gap:3rem; }
</style>

{{-- NAVBAR --}}
<nav style="display:flex;align-items:center;justify-content:space-between;
            padding:1.6rem 1.75rem;
            background:rgba(6,6,15,0.6);
            backdrop-filter:blur(12px);
            -webkit-backdrop-filter:blur(12px);
            position:sticky;top:0;z-index:100;isolation:isolate;">
<img src="{{ asset('imagenes/isotipo_dorado.webp') }}"
     alt="UTL"
     style="height:2.6rem;width:auto;display:block;">
    <div class="nav-links-casas">
        <a href="{{ route('welcome') }}"   style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Inicio</a>
        <a href="{{ route('quiz') }}"      style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Quiz</a>
        <a href="{{ route('recorrido') }}" style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Recorrido</a>
        <a href="{{ route('dominios') }}"  style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Dominios</a>
        <a href="{{ route('casas') }}"     style="font-size:.82rem;color:#E8C96A;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Casas</a>
    </div>
    <div class="nav-auth-casas">
        <a href="#" style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Ingresar</a>
    </div>
    <button class="hamburger-casas" id="hamburgerCasas" aria-label="Abrir menú" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>
</nav>

<div class="mobile-menu-casas" id="mobileCasas">
    <a href="{{ route('welcome') }}">Inicio</a>
    <a href="{{ route('quiz') }}">Quiz</a>
    <a href="{{ route('recorrido') }}">Recorrido</a>
    <a href="{{ route('dominios') }}">Dominios</a>
    <a href="{{ route('casas') }}" style="color:#E8C96A;">Casas</a>
    <a href="#">Ingresar</a>
</div>

{{-- ENCABEZADO --}}
<section class="casas-header-section"
         style="padding:5rem 2rem;text-align:center;
                background:linear-gradient(180deg,#06060F,#0D0D1A);
                border-bottom:1px solid rgba(200,168,75,.15);">
    <p style="color:#E8C96A;text-transform:uppercase;letter-spacing:.2em;font-size:.75rem;margin-bottom:.8rem;">
        Sistema Integral de Identidad Académica
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

@php
$casas = [

    // ── INGENIERÍAS ──────────────────────────────────────────────────────
    [
        'imagen'   => 'imagenes/casas/logistica.jpeg',
        'nombre'   => 'Logística',
        'dominio'  => 'Ingenierías',
        'color'    => '#0057B8',
        'frase'    => 'Toda ruta tiene un destino',
        'valores'  => ['Responsabilidad', 'Organización', 'Eficiencia'],
        'desc'     => 'Te gusta planear, coordinar recursos y optimizar procesos.',
        'oferta'   => 'Fundamentos de la Cadena de Suministro, Gestión de Almacén, Logística de Abastecimiento, Costos y Presupuestos Logísticos, Tráfico y Sistemas de Transporte, Administración y Control de Inventarios, Sistemas de Transporte Carretero, Sistemas de Transporte Ferroviario, Sistemas de Transporte Aéreo y Marítimo, Diseño de Redes Logísticas, Investigación de Operaciones Logísticas, Logística de Producción, Administración de Operaciones Logísticas, Gestión de Comercio Internacional, Operación de Flotas y Terminales, Simulación de Procesos Logísticos',
        'link'     => 'https://www.utleon.edu.mx/carrera/TM',
    ],
    [
        'imagen'   => 'imagenes/casas/mantenimiento.jpg',
        'nombre'   => 'Mantenimiento Industrial',
        'dominio'  => 'Ingenierías',
        'color'    => '#003A5D',
        'frase'    => 'La excelencia se construye cada día',
        'valores'  => ['Compromiso', 'Precisión', 'Responsabilidad'],
        'desc'     => 'Diagnóstico y mantenimiento de maquinaria industrial.',
        'oferta'   => 'Seguridad Industrial, Gestión y Administración del Mantenimiento, Termodinámica y Sistemas Térmicos, Electrónica Analógica y Digital, Máquinas y Mecanismos, Sistemas Eléctricos e Instalaciones Eléctricas, Sistemas Neumáticos e Hidráulicos, Automatización, Robótica y Redes Industriales, Mantenimiento Predictivo Mecánico, Técnicas TPM (Mantenimiento Productivo Total) y RCM, Ensayos Destructivos y No Destructivos, Manufactura Asistida por Computadora, Visualización y Control de Procesos',
        'link'     => 'https://www.utleon.edu.mx/carrera/MI',
    ],
    [
        'imagen'   => 'imagenes/casas/ambiental.webp',
        'nombre'   => 'Ambiental y Sustentabilidad',
        'dominio'  => 'Ingenierías',
        'color'    => '#43B02A',
        'frase'    => 'Proteger hoy para transformar mañana',
        'valores'  => ['Ética', 'Compromiso', 'Responsabilidad Social'],
        'desc'     => 'Desarrollo de soluciones ambientales sostenibles.',
        'oferta'   => 'Legislación Ambiental, Química Inorgánica, Química Orgánica, Química Ambiental, Microbiología Ambiental, Gestión de Recursos Hídricos, Gestión Integral de Residuos, Seguridad Laboral y Salud Ocupacional, Sistemas de Gestión Ambiental y de Calidad, Evaluación de Impacto Ambiental, Gestión de la Calidad del Aire, Manejo y Conservación de Suelo, Gestión y Auditoría Ambiental y Laboral, Operaciones Unitarias, Producción Sustentable, Sistema de Información Geográfica y Ordenamiento Territorial, Procesos de Adaptación al Cambio Climático, Bioprocesos Ambientales, Energías Alternativas, Evaluación de Riesgo, Tecnología para el Tratamiento de Agua',
        'link'     => 'https://www.utleon.edu.mx/carrera/GA',
    ],

    // ── TECNOLOGÍAS DE LA INFORMACIÓN ────────────────────────────────────
    [
        'imagen'   => 'imagenes/casas/entornos.jpg',
        'nombre'   => 'Entornos Virtuales y Negocios Digitales',
        'dominio'  => 'Tecnologías de la Información',
        'color'    => '#6B3FA0',
        'frase'    => 'Imaginar es crear',
        'valores'  => ['Creatividad', 'Innovación', 'Adaptación'],
        'desc'     => 'Desarrollo de productos digitales interactivos.',
        'oferta'   => 'Fundamentos de Programación, Programación Estructurada, Programación Orientada a Objetos, Aplicaciones Web, Frameworks para Desarrollo Web, Aplicaciones WEB progresivas, Diseño Digital y Producción Audiovisual, Modelado y Animación Digital, Animación Avanzada y Efectos Visuales, Aplicaciones para Realidad Virtual, Aplicaciones para Realidad Aumentada, Programación de Video Juegos, Mercadotecnia Digital, Fundamentos de Inteligencia Artificial, Programación para Inteligencia Artificial, Ciencia de Datos, Internet de las Cosas, Tecnologías Disruptivas, Seguridad informática, Informática Forense',
        'link'     => 'https://www.utleon.edu.mx/carrera/EVN',
    ],
    [
        'imagen'   => 'imagenes/casas/datos.png',
        'nombre'   => 'Ciencia de Datos',
        'dominio'  => 'Tecnologías de la Información',
        'color'    => '#2E6F95',
        'frase'    => 'Los datos cuentan historias',
        'valores'  => ['Objetividad', 'Precisión', 'Pensamiento Crítico'],
        'desc'     => 'Interpretación y análisis de datos.',
        'oferta'   => 'Aprendizaje Computacional, Procesamiento de Información, Programación de Lenguajes Especializados, Programación Lógica y Funcional, Computo de Alto Rendimiento, Servicios en la Nube, Visualización de Datos, Ética y Legislación en Tecnologías de la Información, Métodos Estadísticos, Seguridad Informática, Administraciñon de Servidores, Base de Datos Avanzadas, Electrónica Digital, Ciencia de Datos, Contenedores de Software, Internet de las Cosas, Tecnologías Disruptivas',
        'link'     => 'https://www.utleon.edu.mx/carrera/CD',
    ],
    [
        'imagen'   => 'imagenes/casas/software.png',
        'nombre'   => 'Desarrollo de Software',
        'dominio'  => 'Tecnologías de la Información',
        'color'    => '#2563EB',
        'frase'    => 'Cada línea construye el futuro',
        'valores'  => ['Innovación', 'Perseverancia', 'Aprendizaje Continuo'],
        'desc'     => 'Creación de aplicaciones y sistemas.',
        'oferta'   => 'Análisis y Diseño de Software, Aplicaciones Web, Desarrollo de Aplicaciones Móviles, Estructura de Datos, Aplicaciones Web Orientada a Servicios, Base de Datos Avanzada, Estándares y Métricas para el Desarrollo de Software, Bases de Datos en la Nube, Habilidades Gerenciales, Seguridad Informática, Administración de Servidores, Electrónica Digital, Programación Móvil Avanzada, Frameworks para el Desarrollo Multiplataforma, Tecnologías Disruptivas',
        'link'     => 'https://www.utleon.edu.mx/carrera/DSM',
    ],
    [
        'imagen'   => 'imagenes/casas/redes.jpg',
        'nombre'   => 'Infraestructura de Redes Digitales',
        'dominio'  => 'Tecnologías de la Información',
        'color'    => '#0EA5A4',
        'frase'    => 'Conectar es avanzar',
        'valores'  => ['Responsabilidad', 'Orden', 'Seguridad'],
        'desc'     => 'Administración de redes y servidores.',
        'oferta'   => 'Centro de Datos, Escabilidad de Redes, Programación de Redes, Cómputo en la Nube, Conexión de Redes WAN, Seguridad en Redes, Administración de Redes Empresariales, Administración de Servidores, Electrónica Digital, Administración Avanzada de Servidores, Ciencia de Datos',
        'link'     => 'https://www.utleon.edu.mx/carrera/IRD',
    ],
    [
        'imagen'   => 'imagenes/casas/ia.jpg',
        'nombre'   => 'Inteligencia Artificial',
        'dominio'  => 'Tecnologías de la Información',
        'color'    => '#8A2BE2',
        'frase'    => 'Pensar más allá de los límites',
        'valores'  => ['Creatividad', 'Innovación', 'Pensamiento Crítico'],
        'desc'     => 'Desarrollo de soluciones inteligentes.',
        'oferta'   => 'Aprendizaje Profundo Deep Learning, Motodología No Code, Sistemas de Optimización, Sistemas Embebidos, Aprendizaje de Maquina, Fundamentos de Visión por Computadora, Minería de Datos, Minería de Texto, Análisis de Regresión, Programación para Inteligencia Artificial, Sistemas Inteligentes',
        'link'     => 'https://www.utleon.edu.mx/carrera/IA',
    ],

    // ── INGENIERÍA INDUSTRIAL ─────────────────────────────────────────────
    [
        'imagen'   => 'imagenes/casas/automotriz.jpg',
        'nombre'   => 'Automotriz',
        'dominio'  => 'Ingeniería Industrial',
        'color'    => '#DC2626',
        'frase'    => 'Movimiento con propósito',
        'valores'  => ['Eficiencia', 'Liderazgo', 'Compromiso'],
        'desc'     => 'Mejora de procesos automotrices.',
        'oferta'   => 'Diseño Asistido por Computadora, Herramientas Avanzadas de Calidad, Hidráulica y Neumática Industrial, Procesos de Manufactura de Autopartes Plásticas, Fundamentos de Manufactura Esbelta, Procesos de Manufacttura de Autopartes Metálicas, Sistema CAM, Automatización y Control de Procesos, Ingeniería de Planta, Investigación de Operaciones, Tópicos de Nuevas Tecnologías de Manufactura, 6 SIGMA, Diseño del Producto, Logístca, Sistemas de Gestión de la Calidad, Administración del Manteniimiento, Legislación Industrial',
        'link'     => 'https://www.utleon.edu.mx/carrera/AT',
    ],
    [
        'imagen'   => 'imagenes/casas/productivos.png',
        'nombre'   => 'Procesos Productivos',
        'dominio'  => 'Ingeniería Industrial',
        'color'    => '#ED8B00',
        'frase'    => 'La mejora nunca termina',
        'valores'  => ['Orden', 'Eficiencia', 'Mejora Continua'],
        'desc'     => 'Gestión de operaciones industriales.',
        'oferta'   => 'Administración y Control de la Calidad, Ingeniería Económica, Tecnologías de Transformación de Materiales, Administración y Control de Operaciones, Gestión Ambiental en Procesos Industriales, Sistemas de Manufactura Aplicada, Sistemas de Gestión de la Calidad, Administración del Mantenimiento, Administración Industrial y de Servicios, Legislación  Industrial, Manufactura Integrada por Computadora, Simulación de Procesos',
        'link'     => 'https://www.utleon.edu.mx/carrera/PP',
    ],
    [
        'imagen'   => 'imagenes/casas/plasticos.jpg',
        'nombre'   => 'Moldeo de Plásticos',
        'dominio'  => 'Ingeniería Industrial',
        'color'    => '#9C3D0C',
        'frase'    => 'La forma sigue a la innovación',
        'valores'  => ['Precisión', 'Responsabilidad', 'Innovación'],
        'desc'     => 'Diseño y fabricación de productos plásticos.',
        'oferta'   => 'Caracterización de Polímeros, Diseño de Productos Plásticos, Estructura y Propiedad de los Polímeros y los Acero, Transformación de Productos Plásticos, Moldes, Reciclado de Polimeros, Sistemas de Gestión de la Calidad, Administración del Mantenimiento, Manufactura Integrada por Computadora',
        'link'     => 'https://www.utleon.edu.mx/carrera/MP',
    ],
    [
        'imagen'   => 'imagenes/casas/calzado.jpg',
        'nombre'   => 'Gestión y Productividad de Calzado',
        'dominio'  => 'Ingeniería Industrial',
        'color'    => '#C46210',
        'frase'    => 'Cada paso deja huella',
        'valores'  => ['Creatividad', 'Calidad', 'Trabajo en Equipo'],
        'desc'     => 'Industria del calzado y manufactura.',
        'oferta'   => 'Dirección de Operaciones, Diseño de Calzado, Manufactura de Calzado, Planeación y Control de la Producción, Control de Calidad para el Calzado, Automatización y Control de Procesos, Tópicos de Nuevas Tecnologías de Manufactuura Diseño del Producto, Evaluación y Administración de Proyectos, Sistemas de Gestión de la Calidad, Administración del Mantenimiento, Manufactura Integrada por Coomputadora',
        'link'     => 'https://www.utleon.edu.mx/carrera/GPC',
    ],

    // ── MECATRÓNICA ───────────────────────────────────────────────────────
    [
        'imagen'   => 'imagenes/casas/manufactura.jpg',
        'nombre'   => 'Manufactura Flexible',
        'dominio'  => 'Mecatrónica',
        'color'    => '#7C3AED',
        'frase'    => 'Adaptarse es evolucionar',
        'valores'  => ['Innovación', 'Precisión', 'Creatividad'],
        'desc'     => 'Sistemas automatizados de producción.',
        'oferta'   => 'Control de Motores Eléctricos, Estructura y Propiedades de los Materiales, Robótica, Control de Procesos de Manufactura, Controladores Lógicos Programables, Manufacrura Asistida por Computadora, Análisis de Mecanismos, Cinemática y Dinámica de Robots, Instrumentación Virtual, Modelado y Simulación de Sistemas, Sistemas Embebidos, Diseño de Sistemas Mecatrónicos, Diseño Mecánico, Ingeniería de Control, Programación de Robots Industriales, Sistemas CAM CNC, Control Avanzado, Manufactura Flexible, Sistemas Eléctricos Industriales',
        'link'     => 'https://www.utleon.edu.mx/carrera/LSMF',
    ],
    [
        'imagen'   => 'imagenes/casas/optomecatronica.jpg',
        'nombre'   => 'Optomecatrónica',
        'dominio'  => 'Mecatrónica',
        'color'    => '#A50034',
        'frase'    => 'La precisión guía el camino',
        'valores'  => ['Precisión', 'Responsabilidad', 'Innovación'],
        'desc'     => 'Sistemas ópticos y electrónicos.',
        'oferta'   => 'Control de Motores Eléctricos, Controladores Lógicos Programables, Principios de Óptica, Programación Estructurada, Láseres, Metrología Óptica, Procesos de Manufactura, Análisis de Mecanismos, Cinemática y Dinámica de Robots, Modelado y Simulación de Sistemas, Sistemas Embebidos, Diseño de Sistemas Mecatrónicos, Diseño Mecánico, Programación de Robots Industriales, Sistemas CAM CNC, Sistemas Eléctricos Industriales',
        'link'     => 'https://www.utleon.edu.mx/carreras/OP',
    ],
    [
        'imagen'   => 'imagenes/casas/automatizacion.jpg',
        'nombre'   => 'Automatización',
        'dominio'  => 'Mecatrónica',
        'color'    => '#FF3B30',
        'frase'    => 'La eficiencia es inteligencia aplicada',
        'valores'  => ['Eficiencia', 'Compromiso', 'Innovación'],
        'desc'     => 'Automatización de procesos industriales.',
        'oferta'   => 'Control de Motores Eléctricos, Estructura y Propiedades de los Materiales, Instrumentración Industrial, Sistemas Neumáticos e Hidráulicos, Controladores Lógicos Programables, Implementación de Sistemas Automáticos, Procesos de Manufactura, Análisis de Mecanismos, Cinemática y Dinámica de Robots, Intrumentración Virtual, Modelado y Simulación de Sistemas, Sistemas Embebidos, Diseño Asistido por Computadora, Diseño de Sistemas Mecatrónicos, Diseño Mecánico, Ingeniería de Control, Programación de Robots Industriales, Sistemas CAM CNC, Administración de Mantenimiento, Control Avanzado',
        'link'     => 'https://www.utleon.edu.mx/carrera/AU',
    ],

    // ── LICENCIATURAS ─────────────────────────────────────────────────────
    [
        'imagen'   => 'imagenes/casas/gastronomia.jpg',
        'nombre'   => 'Gastronomía',
        'dominio'  => 'Licenciaturas',
        'color'    => '#EBA42D',
        'frase'    => 'Crear experiencias para recordar',
        'valores'  => ['Servicio', 'Creatividad', 'Disciplina'],
        'desc'     => 'Experiencias culinarias y hospitalidad.',
        'oferta'   => 'Bases Culinaria, Fundamentos de Nutrición, Panadería, Pastelería, Operación de Bar, Administración de Alimentos y Bebidas, Francés, Vitivinicultura, Mercadotecnia de Servicios Gatronómicos, Repostería, Conformación de Menús, Logística de Eventos, Cocina Asiática, Cocina Mexicana, Contabilidad, Patrimonio Gastrónomico de México, Cocina Europea, Bebidas Destiladas Mexicanas, Cocina Contemporánea, Cocina Regional, Mixología, Desarrollo de Negocios Gastronómicos',
        'link'     => 'https://www.utleon.edu.mx/carrera/GST',
    ],
    [
        'imagen'   => 'imagenes/casas/administracion.jpg',
        'nombre'   => 'Administración ',
        'dominio'  => 'Licenciaturas',
        'color'    => '#1F3D2B',
        'frase'    => 'Liderar para construir',
        'valores'  => ['Liderazgo', 'Responsabilidad', 'Ética'],
        'desc'     => 'Gestión de empresas y recursos.',
        'oferta'   => 'Marco Legal de las Organizaciones, Contabilidad, Derecho Corporativo, Habilidades Socioemocionales y Manejo de Conflictos, Microeconomía, Análisis Financiero, Macroeconomía, Comportamiento Organizacional, Gestión del Capital Humano, Legislación Laboral, Sueldos y Salarios, Desarrollo Organizacional, Seguridad e Higiene Laboral, Administración de la Producción, Gestión del Talento Humano, Mercadotecnia Estratégica, Tecnologías aplicadas a los Negocios, Dirección Estratégica, Modelos de Negocios, Comercio y Logística Internacional, Finanzas Corporativas',
        'link'     => 'https://www.utleon.edu.mx/carrera/GCH',
    ],
    [
        'imagen'   => 'imagenes/casas/turismo.png',
        'nombre'   => 'Turismo',
        'dominio'  => 'Licenciaturas',
        'color'    => '#00A3E0',
        'frase'    => 'Descubrir conecta culturas',
        'valores'  => ['Servicio', 'Empatía', 'Creatividad'],
        'desc'     => 'Experiencias turísticas y culturales.',
        'oferta'   => 'Fundamentos de Economía, Geografía y Patrimonio, Administración, Servicios de Alimentos y Bebidas, Servicios de Viaje y Transportación, Sustentabilidad en el Turismo, Contabilidad, Gestión de la Calidad, Hospitalidad y Alojamiento, Diagnóstico Turístico, Mercadotecnia y Comercialización, Operación de Servicios de Hospedaje, Turismo Cultural y de Naturaleza, Animación Turística y Sociocultural, Diseño de Experiencias Turísticas, Plan de Negocios, Desarrollo Regional, Economía para el Turismo, Gestión y Planificación Turística, Consultoría Turística, Tendencias del Turismo, Destinos Turísticos Inteligentes',
        'link'     => 'https://www.utleon.edu.mx/carrera/TU',
    ],
    [
        'imagen'   => 'imagenes/casas/mercadotecnia.jpg',
        'nombre'   => 'Negocios y Mercadotecnia',
        'dominio'  => 'Licenciaturas',
        'color'    => '#E4007C',
        'frase'    => 'Las ideas iluminan el cambio',
        'valores'  => ['Innovación', 'Liderazgo', 'Comunicación'],
        'desc'     => 'Marketing y desarrollo de negocios.',
        'oferta'   => 'Fundamentos de Administración y Entorno Empresarial, Informática, Mercadotecnia, Comportamiento del Consumidor, Contabilidad para Negocios, Economía, Estadística, Estrategias de Producto y Precio, Legislación Comercial, Sistema de Investigación de Mercados, Logística y Distribución, Mercadotecnia de Servicios, Mercadotecnia Digital, Mercadotecnia Estratégica, Desarrollo de Nuevos Productos, Mercadotecnia Internacional, Tendencias del Mercado y Consumidor Global, Inteligencia de Mercados, Cadena de Suministro, Cultura Emprendedora, Comunicación Integral de la Mercadotecnia',
        'link'     => 'https://www.utleon.edu.mx/carrera/MT',
    ],
];
@endphp

{{-- FILTROS --}}
<section class="filtros-section" style="max-width:1400px;margin:0 auto 2rem;padding:0 2rem;">
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;">
        <span style="font-size:.72rem;text-transform:uppercase;letter-spacing:.12em;color:#707085;margin-right:.25rem;">Filtrar:</span>
        <button class="filtro-btn activo" onclick="filtrar(this,'Todos')">Todos</button>
        <button class="filtro-btn" onclick="filtrar(this,'Ingenierías')">Ingenierías</button>
        <button class="filtro-btn" onclick="filtrar(this,'Tecnologías de la Información')">Tec. Información</button>
        <button class="filtro-btn" onclick="filtrar(this,'Ingeniería Industrial')">Ing. Industrial</button>
        <button class="filtro-btn" onclick="filtrar(this,'Mecatrónica')">Mecatrónica</button>
        <button class="filtro-btn" onclick="filtrar(this,'Licenciaturas')">Licenciaturas</button>
    </div>
</section>

{{-- GRID --}}
<section class="casas-grid-section" style="max-width:1400px;margin:auto;padding:0 2rem 4rem;">
    <div id="casasGrid">
        @foreach($casas as $casa)
        <div class="casa-card" data-dominio="{{ $casa['dominio'] }}">
            <div style="height:8px;background:{{ $casa['color'] }};"></div>
            <div class="casa-card-body">
                <div class="casa-img-wrap"
                     style="width:100%;aspect-ratio:1;border-radius:12px;overflow:hidden;margin-bottom:1.5rem;">
                    @if(!empty($casa['imagen']))
                        <img src="{{ asset($casa['imagen']) }}" alt="{{ $casa['nombre'] }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div style="width:100%;height:100%;background:#1D1D2B;
                                    border:1px dashed rgba(255,255,255,.15);border-radius:12px;"></div>
                    @endif
                </div>
                <p style="font-size:.7rem;text-transform:uppercase;letter-spacing:.12em;color:#707085;margin-bottom:.4rem;">{{ $casa['dominio'] }}</p>
                <h3 style="color:#FFFFFF;font-size:1.05rem;margin-bottom:.4rem;font-family:'Headland One',serif;">{{ $casa['nombre'] }}</h3>
                <p style="color:#C8A84B;font-size:.82rem;font-style:italic;margin-bottom:.9rem;">{{ $casa['frase'] }}</p>
                <p style="color:#B0A898;line-height:1.7;font-size:.9rem;margin-bottom:1.5rem;flex-grow:1;">{{ $casa['desc'] }}</p>
                <div style="display:flex;flex-wrap:wrap;gap:.5rem;">
                    @foreach($casa['valores'] as $v)
                    <span style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);
                                 color:#F0EAD8;padding:.4rem .75rem;border-radius:50px;font-size:.72rem;">{{ $v }}</span>
                    @endforeach
                </div>

                {{-- BOTÓN VER MÁS --}}
                <button class="btn-ver-mas"
                    onclick="abrirModal(
                        '{{ addslashes($casa['nombre']) }}',
                        '{{ addslashes($casa['dominio']) }}',
                        '{{ addslashes($casa['oferta']) }}',
                        '{{ addslashes($casa['link']) }}',
                        '{{ $casa['color'] }}'
                    )">
                    Ver más
                </button>

            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- MODAL --}}
<div class="modal-overlay" id="modalOverlay" onclick="cerrarModalOverlay(event)">
    <div class="modal-box" id="modalBox">
        <div class="modal-header-bar" id="modalHeaderBar"></div>
        <div class="modal-body">
            <button class="modal-close" onclick="cerrarModal()">&#x2715;</button>
            <p class="modal-label">Casa Académica</p>
            <h2 class="modal-title" id="modalNombre"></h2>
            <p class="modal-dominio" id="modalDominio"></p>
            <p class="modal-section-title">Plan de Estudios</p>
            <div class="modal-oferta-text" id="modalOferta"></div>
            <p class="modal-section-title">Más Información</p>
            <p class="modal-link">
                Para más información visita la página oficial de la UTL:
                <a id="modalLink" href="#" target="_blank"></a>
            </p>
        </div>
    </div>
</div>

{{-- CTA --}}
<section class="casas-cta"
         style="padding:5rem 2rem;text-align:center;background:#0D0D1A;
                border-top:1px solid rgba(200,168,75,.12);border-bottom:1px solid rgba(200,168,75,.12);">
    <h2 style="color:#FFFFFF;font-family:'Headland One',serif;margin-bottom:1rem;">
        Descubre tu casa académica
    </h2>
    <p style="max-width:650px;margin:auto auto 2rem;color:#F0EAD8;line-height:1.8;">
        Realiza el cuestionario SIIA y descubre qué casa y qué dominio
        representan mejor tus intereses, habilidades y forma de aprender.
    </p>
    <a href="{{ route('quiz') }}"
       style="display:inline-block;background:#C6A050;color:#06060F;
              text-decoration:none;padding:.9rem 2rem;border-radius:8px;font-weight:700;">
        Realizar Test
    </a>
</section>

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
        © {{ date('Y') }} NOVA · Navegador de Orientación Vocacional y Aptitudes
    </div>
</footer>

@endsection

@push('extra-js')
<script>
// ── FILTROS ──────────────────────────────────────────────────────────────────
function filtrar(btn, dominio) {
    document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
    btn.classList.add('activo');
    document.querySelectorAll('.casa-card').forEach(card => {
        const coincide = dominio === 'Todos' || card.dataset.dominio === dominio;
        if (coincide) {
            card.classList.remove('oculta');
        } else {
            card.classList.add('oculta');
        }
    });
}

// ── MODAL ────────────────────────────────────────────────────────────────────
function abrirModal(nombre, dominio, oferta, link, color) {
    document.getElementById('modalNombre').textContent  = nombre;
    document.getElementById('modalDominio').textContent = dominio;
    document.getElementById('modalHeaderBar').style.background = color;

    // Convertir la cadena de oferta en lista visual en columnas
    const materias = oferta
        .split(',')
        .map(m => m.trim())
        .filter(m => m.length > 0);

    const ul = document.createElement('ul');
    ul.className = 'modal-oferta-list';
    materias.forEach(materia => {
        const li = document.createElement('li');
        li.textContent = materia;
        ul.appendChild(li);
    });

    const contenedor = document.getElementById('modalOferta');
    contenedor.innerHTML = '';
    contenedor.appendChild(ul);

    const linkEl = document.getElementById('modalLink');
    linkEl.href        = link;
    linkEl.textContent = link;

    document.getElementById('modalOverlay').classList.add('abierto');
    document.body.style.overflow = 'hidden';
}

function cerrarModal() {
    document.getElementById('modalOverlay').classList.remove('abierto');
    document.body.style.overflow = '';
}

function cerrarModalOverlay(e) {
    if (e.target === document.getElementById('modalOverlay')) cerrarModal();
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModal(); });
</script>
@endpush