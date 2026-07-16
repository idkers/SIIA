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

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<style>
  .nav-links{
    flex:1;
    display:flex;
    justify-content:center;
    gap:3rem;
}

.nav-links a{
    color:#B0A898;
    text-decoration:none;
    font-size:.88rem;
    letter-spacing:.08em;
    text-transform:uppercase;
    transition:.25s;
}

.nav-links a:hover{
    color:#E8C96A;
}
    .nav-auth  { display:flex; align-items:center; gap:.75rem; }
    .hamburger { display:none; background:none; border:none; cursor:pointer;
                 padding:.25rem; flex-direction:column; gap:5px; }
    .hamburger span { display:block; width:22px; height:2px; background:#C8A84B; border-radius:2px; }
    .mobile-menu { display:none; flex-direction:column; gap:0;
                   position:fixed; left:0; right:0; top:0; z-index:99;
                   max-height:calc(100vh - 70px); overflow-y:auto;
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
<nav style="
    display:flex;
    align-items:center;
    padding:1.6rem 2rem;
    background:rgba(6,6,15,.6);
    backdrop-filter:blur(12px);
    -webkit-backdrop-filter:blur(12px);
    position:sticky;
    top:0;
    z-index:100;
">

    <img src="{{ asset('imagenes/isotipo_dorado.webp') }}"
         alt="UTL"
         style="height:2.6rem;">

    <div class="nav-links" style="
        flex:1;
        display:flex;
        justify-content:center;
        gap:3rem;
    ">
        <a href="{{ route('welcome') }}">Inicio</a>
        <a href="{{ route('quiz') }}">Quiz</a>
        <a href="{{ route('recorrido') }}">Recorrido</a>
        <a href="{{ route('dominios') }}">Dominios</a>
        <a href="{{ route('casas') }}">Casas</a>
        <a href="{{ route('ingresar') }}">Ingresar</a>
    </div>

    <button class="hamburger"
            id="hamburgerBtn"
            aria-label="Abrir menú">
        <span></span>
        <span></span>
        <span></span>
    </button>

</nav>

<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('welcome') }}">Inicio</a>
    <a href="{{ route('quiz') }}">Quiz</a>
    <a href="{{ route('recorrido') }}">Recorrido</a>
    <a href="{{ route('dominios') }}">Dominios</a>
    <a href="{{ route('casas') }}">Casas</a>
    <a href="{{ route('ingresar') }}" style="color:#E8C96A;">Ingresar</a>
</div>

{{-- ENCABEZADO --}}
<section class="casas-header-section"
         style="padding:5rem 2rem;text-align:center;
                background:
              
                url('{{ asset('imagenes/casas/hero-casas.png') }}');
                background-size:cover;
                background-position:center;
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
        'oferta'   => 'Diseño de Redes Logísticas: Crearás sistemas complejos de distribución que conectan empresas con clientes eficientemente, Economía Circular: Aprenderás modelos sostenibles que minimizan residuos en la cadena de suministro, Operación de Flotas y Terminales: Gestionarás flota de vehículos y centros de distribución de manera óptima, Tendencias en la Cadena de Suministros: Te mantendrás actualizado en tecnologías emergentes como blockchain y IoT en logística, Investigación de Operaciones Logísticas: Optimizarás rutas costos y tiempo de entrega usando análisis cuantitativos',
        'link'     => 'https://www.utleon.edu.mx/carrera/TM',
        'nombrecasa' => 'NAVENTOR',
    ],
    [
        'imagen'   => 'imagenes/casas/mantenimiento.webp',
        'nombre'   => 'Mantenimiento Industrial',
        'dominio'  => 'Ingenierías',
        'color'    => '#003A5D',
        'frase'    => 'La excelencia se construye cada día',
        'valores'  => ['Compromiso', 'Precisión', 'Responsabilidad'],
        'desc'     => 'Diagnóstico y mantenimiento de maquinaria industrial.',
        'oferta'   => 'Mantenimiento Predictivo Mecánico: Utilizarás sensores y análisis para predecir fallos antes de que ocurran, Técnicas TPM y RCM: Aplicarás metodologías avanzadas de mantenimiento para máxima disponibilida, Ensayos Destructivos y No Destructivos: Aprenderás a evaluar la integridad de materiales sin dañarlos, Automatización y Robótica: Implementarás sistemas automáticos para tareas de mantenimiento complejas, Gestión Estratégica para Mantenimiento: Dirigirás departamentos de mantenimiento en grandes operaciones industriales',
        'link'     => 'https://www.utleon.edu.mx/carrera/MI',
        'nombrecasa' => 'ENGRAVIA',
    ],
    [
        'imagen'   => 'imagenes/casas/ambiental.webp',
        'nombre'   => 'Ambiental y Sustentabilidad',
        'dominio'  => 'Ingenierías',
        'color'    => '#43B02A',
        'frase'    => 'Proteger hoy para transformar mañana',
        'valores'  => ['Ética', 'Compromiso', 'Responsabilidad Social'],
        'desc'     => 'Desarrollo de soluciones ambientales sostenibles.',
        'oferta'   => 'Gestión de Recursos Hídricos: Protegerás y gestionarás el agua recurso vital para comunidades y empresas, Gestión Integral de Residuos: Crearás sistemas para reducir reutilizar y reciclar residuos sólidos, Tecnología para el Tratamiento de Agua: Diseñarás plantas de tratamiento que purifican agua contaminada, Energías Alternativas: Desarrollarás proyectos de energía solar eólica e hidroeléctrica sostenible, Evaluación de Impacto Ambiental: Analizarás cómo proyectos afectan el medio ambiente y propondrás soluciones',
        'link'     => 'https://www.utleon.edu.mx/carrera/GA',
        'nombrecasa' => 'SYLVARA',
    ],
    
    // ── TECNOLOGÍAS DE LA INFORMACIÓN ────────────────────────────────────
    [
        'imagen'   => 'imagenes/casas/entornos.webp',
        'nombre'   => 'Entornos Virtuales y Negocios Digitales',
        'dominio'  => 'Tecnologías de la Información',
        'color'    => '#6B3FA0',
        'frase'    => 'Imaginar es crear',
        'valores'  => ['Creatividad', 'Innovación', 'Adaptación'],
        'desc'     => 'Desarrollo de productos digitales interactivos.',
        'oferta'   => 'Programación de Video Juegos: Crearás juegos interactivos usando motores profesionales como Unity o Unreal Engine, Aplicaciones para Realidad Virtual y Aumentada: Desarrollarás experiencias inmersivas y aplicaciones de realidad mixta, Animación Avanzada y Efectos Visuales: Dominarás técnicas cinematográficas y efectos visuales profesionales, Mercadotecnia Digital: Aprenderás a posicionar negocios en internet mediante estrategias digitales, Diseño Digital y Producción Audiovisual: Crearás contenido multimedia profesional para web redes sociales y plataformas digitales',
        'link'     => 'https://www.utleon.edu.mx/carrera/EVN',
        'nombrecasa' => 'NEXARIS',
    ],
    [
        'imagen'   => 'imagenes/casas/datos.webp',
        'nombre'   => 'Ciencia de Datos',
        'dominio'  => 'Tecnologías de la Información',
        'color'    => '#2E6F95',
        'frase'    => 'Los datos cuentan historias',
        'valores'  => ['Objetividad', 'Precisión', 'Pensamiento Crítico'],
        'desc'     => 'Interpretación y análisis de datos.',
        'oferta'   => 'Ciencia de Datos: Analizarás grandes volúmenes de datos para extraer información que impulse decisiones empresariales, Visualización de Datos: Crearás gráficos y dashboards que comunican datos complejos de forma clara, Aprendizaje Computacional: Entrenarás modelos que aprenden patrones en datos para hacer predicciones, Métodos Estadísticos: Aplicarás técnicas estadísticas avanzadas para análisis profundo de información, Servicios en la Nube: Utilizarás plataformas cloud para procesar y analizar datos a escala empresarial',
        'link'     => 'https://www.utleon.edu.mx/carrera/CD',
        'nombrecasa' => 'DATHEON',
    ],
    [
        'imagen'   => 'imagenes/casas/software.webp',
        'nombre'   => 'Desarrollo de Software Multiplataforma',
        'dominio'  => 'Tecnologías de la Información',
        'color'    => '#2563EB',
        'frase'    => 'Cada línea construye el futuro',
        'valores'  => ['Innovación', 'Perseverancia', 'Aprendizaje Continuo'],
        'desc'     => 'Creación de aplicaciones y sistemas.',
        'oferta'   => 'Desarrollo de Aplicaciones Móviles: Crearás aplicaciones para iOS y Android que resuelven problemas reales, Aplicaciones Web Orientada a Servicios: Desarrollarás servicios web escalables y robustos para empresas, Bases de Datos Avanzadas: Diseñarás sistemas de almacenamiento de datos eficientes y seguros, Estándares y Métricas para el Desarrollo de Software: Aprenderás mejores prácticas para crear software de calidad profesional, Programación Móvil Avanzada: Dominarás tecnologías avanzadas para crear apps móviles con funcionalidades complejas',
        'link'     => 'https://www.utleon.edu.mx/carrera/DSM',
        'nombrecasa' => 'CODARIS',
    ],
    [
        'imagen'   => 'imagenes/casas/redes.webp',
        'nombre'   => 'Infraestructura de Redes Digitales',
        'dominio'  => 'Tecnologías de la Información',
        'color'    => '#0EA5A4',
        'frase'    => 'Conectar es avanzar',
        'valores'  => ['Responsabilidad', 'Orden', 'Seguridad'],
        'desc'     => 'Administración de redes y servidores.',
        'oferta'   => 'Cómputo en la Nube: Aprenderás a gestionar servidores almacenamiento y aplicaciones en infraestructura en la nube, Seguridad en Redes: Te especializarás en proteger sistemas contra ciberataques y vulnerabilidades, Administración de Redes Empresariales: Diseñarás y administrarás redes complejas para grandes organizaciones, Centro de Datos: Aprenderás a construir y mantener infraestructuras de datos de alto rendimiento, Internet de las Cosas: Conectarás dispositivos inteligentes para crear soluciones IoT innovadoras',
        'link'     => 'https://www.utleon.edu.mx/carrera/IRD',
        'nombrecasa' => 'HEXANET',
    ],
    [
        'imagen'   => 'imagenes/casas/ia.webp',
        'nombre'   => 'Inteligencia Artificial',
        'dominio'  => 'Tecnologías de la Información',
        'color'    => '#8A2BE2',
        'frase'    => 'Pensar más allá de los límites',
        'valores'  => ['Creatividad', 'Innovación', 'Pensamiento Crítico'],
        'desc'     => 'Desarrollo de soluciones inteligentes.',
        'oferta'   => 'Aprendizaje Profundo (Deep Learning): Entrenarás redes neuronales para resolver problemas complejos como visión por computadora, Aprendizaje de Máquina: Crearás algoritmos que aprenden de datos para hacer predicciones y decisiones inteligentes, Minería de Datos y Texto: Extraerás información valiosa de grandes volúmenes de datos no estructurados, Visión por Computadora: Desarrollarás sistemas que pueden "ver" y analizar imágenes y videos, Sistemas Inteligentes: Crearás aplicaciones que piensan y se adaptan como un experto humano',
        'link'     => 'https://www.utleon.edu.mx/carrera/IA',
        'nombrecasa' => 'SYNTHERA',
    ],

    // ── INGENIERÍA INDUSTRIAL ─────────────────────────────────────────────
    [
        'imagen'   => 'imagenes/casas/automotriz.webp',
        'nombre'   => 'Automotriz',
        'dominio'  => 'Ingeniería Industrial',
        'color'    => '#DC2626',
        'frase'    => 'Movimiento con propósito',
        'valores'  => ['Eficiencia', 'Liderazgo', 'Compromiso'],
        'desc'     => 'Mejora de procesos automotrices.',
        'oferta'   => 'Manufactura Esbelta: Aprenderás a eliminar desperdicios en procesos para maximizar eficiencia y calidad, Investigación de Operaciones: Optimizarás procesos empresariales usando técnicas matemáticas y análisis de datos, 6 SIGMA: Te especializarás en metodologías de mejora continua para alcanzar excelencia operacional, Simulación de Procesos: Modelarás y probarás procesos antes de implementarlos para minimizar riesgos, Administración del Mantenimiento: Crearás estrategias para mantener equipos en óptimo funcionamiento',
        'link'     => 'https://www.utleon.edu.mx/carrera/AT',
        'nombrecasa' => 'PISTORIA',
    ],
    [
        'imagen'   => 'imagenes/casas/productivos.webp',
        'nombre'   => 'Procesos Productivos',
        'dominio'  => 'Ingeniería Industrial',
        'color'    => '#ED8B00',
        'frase'    => 'La mejora nunca termina',
        'valores'  => ['Orden', 'Eficiencia', 'Mejora Continua'],
        'desc'     => 'Gestión de operaciones industriales.',
        'oferta'   => 'Manufactura Esbelta: Aprenderás a eliminar desperdicios en procesos para maximizar eficiencia y calidad, Investigación de Operaciones: Optimizarás procesos empresariales usando técnicas matemáticas y análisis de datos, 6 SIGMA: Te especializarás en metodologías de mejora continua para alcanzar excelencia operacional, Simulación de Procesos: Modelarás y probarás procesos antes de implementarlos para minimizar riesgos, Administración del Mantenimiento: Crearás estrategias para mantener equipos en óptimo funcionamiento',
        'link'     => 'https://www.utleon.edu.mx/carrera/PP',
        'nombrecasa' => 'OPERION',
    ],
    [
        'imagen'   => 'imagenes/casas/plasticos.webp',
        'nombre'   => 'Moldeo de Plásticos',
        'dominio'  => 'Ingeniería Industrial',
        'color'    => '#9C3D0C',
        'frase'    => 'La forma sigue a la innovación',
        'valores'  => ['Precisión', 'Responsabilidad', 'Innovación'],
        'desc'     => 'Diseño y fabricación de productos plásticos.',
        'oferta'   => 'Manufactura Esbelta: Aprenderás a eliminar desperdicios en procesos para maximizar eficiencia y calidad, Investigación de Operaciones: Optimizarás procesos empresariales usando técnicas matemáticas y análisis de datos, 6 SIGMA: Te especializarás en metodologías de mejora continua para alcanzar excelencia operacional, Simulación de Procesos: Modelarás y probarás procesos antes de implementarlos para minimizar riesgos, Administración del Mantenimiento: Crearás estrategias para mantener equipos en óptimo funcionamiento',
        'link'     => 'https://www.utleon.edu.mx/carrera/MP',
        'nombrecasa' => 'POLYMOR',
    ],
    [
        'imagen'   => 'imagenes/casas/calzado.webp',
        'nombre'   => 'Gestión y Productividad de Calzado',
        'dominio'  => 'Ingeniería Industrial',
        'color'    => '#C46210',
        'frase'    => 'Cada paso deja huella',
        'valores'  => ['Creatividad', 'Calidad', 'Trabajo en Equipo'],
        'desc'     => 'Industria del calzado y manufactura.',
        'oferta'   => 'Manufactura Esbelta: Aprenderás a eliminar desperdicios en procesos para maximizar eficiencia y calidad, Investigación de Operaciones: Optimizarás procesos empresariales usando técnicas matemáticas y análisis de datos, 6 SIGMA: Te especializarás en metodologías de mejora continua para alcanzar excelencia operacional, Simulación de Procesos: Modelarás y probarás procesos antes de implementarlos para minimizar riesgos, Administración del Mantenimiento: Crearás estrategias para mantener equipos en óptimo funcionamiento',
        'link'     => 'https://www.utleon.edu.mx/carrera/GPC',
        'nombrecasa' => 'SENDORIA',
    ],
    [
        'imagen'   => 'imagenes/casas/electro.webp',
        'nombre'   => 'Electromovilidad',
        'dominio'  => 'Ingeniería Industrial',
        'color'    => '#FFEE00',
        'frase'    => 'La innovación mueve el futuro',
        'valores'  => ['Innovación', 'Responsabilidad', 'Compromiso con la Sustentabilidad'],
        'desc'     => 'Desarrollo de soluciones tecnológicas para una movilidad sustentable.',
        'oferta'   => 'Vehículos Eléctricos: Aprenderás tecnología de batería motores eléctricos y sistemas de propulsión limpia, Fuentes de Energía: Estudiarás sistemas de carga almacenamiento de energía y tecnologías alternativas, Diagnóstico en Sistemas de Electromoción: Dominarás herramientas para diagnosticar y reparar vehículos eléctricos, Seguridad Eléctrica en Sistemas de Electromovilidad: Garantizarás prácticas seguras en alta tensión y sistemas de batería, Mantenimiento a Sistemas de Electromovilidad: Te especializarás en mantener infraestructuras de carga y vehículos eléctricos',
        'link'     => 'https://www.utleon.edu.mx/carrera/IDI',
        'nombrecasa' => 'ENERION',
    ],

    // ── MECATRÓNICA ───────────────────────────────────────────────────────
    [
        'imagen'   => 'imagenes/casas/manufactura.webp',
        'nombre'   => 'Manufactura Flexible',
        'dominio'  => 'Mecatrónica',
        'color'    => '#7C3AED',
        'frase'    => 'Adaptarse es evolucionar',
        'valores'  => ['Innovación', 'Precisión', 'Creatividad'],
        'desc'     => 'Sistemas automatizados de producción.',
        'oferta'   => 'Robótica: Diseñarás y programarás robots industriales para automatizar procesos de manufactura, Controladores Lógicos Programables (PLC): Programarás sistemas de control automatizados para máquinas industriales, Manufactura Asistida por Computadora (CAM): Crearás programas para máquinas de corte y producción controladas por computadora, Sistemas CAM CNC: Dominarás máquinas de control numérico para precisión extrema en manufactura, Sistemas de Manufactura Flexible: Diseñarás sistemas adaptables que pueden producir diferentes productos eficientemente',
        'link'     => 'https://www.utleon.edu.mx/carrera/LSMF',
        'nombrecasa' => 'FLEXION',
    ],
    [
        'imagen'   => 'imagenes/casas/optomecatronica.webp',
        'nombre'   => 'Optomecatrónica',
        'dominio'  => 'Mecatrónica',
        'color'    => '#A50034',
        'frase'    => 'La precisión guía el camino',
        'valores'  => ['Precisión', 'Responsabilidad', 'Innovación'],
        'desc'     => 'Sistemas ópticos y electrónicos.',
        'oferta'   => 'Láseres: Aprenderás a utilizar tecnología láser en aplicaciones industriales y médicas, Metrología Óptica: Dominarás técnicas precisas de medición usando luz y sistemas ópticos avanzados, Principios de Óptica: Entenderás cómo funcionan los sistemas ópticos para aplicaciones tecnológicas, Programación de Robots Industriales: Crearás programas sofisticados para robots que requieren precisión extrema, Ingeniería de Control: Diseñarás sistemas de control automático para máquinas precisas',
        'link'     => 'https://www.utleon.edu.mx/carreras/OP',
        'nombrecasa' => 'PRISMARA',
    ],
    [
        'imagen'   => 'imagenes/casas/automatizacion.webp',
        'nombre'   => 'Automatización',
        'dominio'  => 'Mecatrónica',
        'color'    => '#FF3B30',
        'frase'    => 'La eficiencia es inteligencia aplicada',
        'valores'  => ['Eficiencia', 'Compromiso', 'Innovación'],
        'desc'     => 'Automatización de procesos industriales.',
        'oferta'   => 'Sistemas Neumáticos e Hidráulicos: Diseñarás sistemas de fluidos para activar máquinas y equipos automáticos, Instrumentación Industrial: Instalarás y calibrarás sensores y equipos de medición en procesos industriales, Implementación de Sistemas Automáticos: Crearás soluciones completas de automatización para fábricas inteligentes, Sistemas Embebidos: Programarás microcontroladores para controlar dispositivos autónomos, Control Avanzado: Diseñarás algoritmos de control sofisticados para sistemas complejos',
        'link'     => 'https://www.utleon.edu.mx/carrera/AU',
        'nombrecasa' => 'AUTRON',
    ],

    // ── LICENCIATURAS ─────────────────────────────────────────────────────
    [
        'imagen'   => 'imagenes/casas/gastronomia2.webp',
        'nombre'   => 'Gastronomía',
        'dominio'  => 'Licenciaturas',
        'color'    => '#EBA42D',
        'frase'    => 'Crear experiencias para recordar',
        'valores'  => ['Servicio', 'Creatividad', 'Disciplina'],
        'desc'     => 'Experiencias culinarias y hospitalidad.',
        'oferta'   => 'Cocina Mexicana I y II: Te especializarás en la gastronomía tradicional mexicana sus técnicas y sabores autóctonos, Cocina Europea: Aprenderás técnicas clásicas europeas y crearás platillos de alta cocina, Cocina Contemporánea: Dominarás tendencias culinarias modernas e innovadoras para crear experiencias únicas, Mixología: Te convertirás en experto en la preparación de cócteles bebidas y combinaciones creativas, Desarrollo de Negocios Gastronómicos: Crearás y gestionarás tu propio restaurante cafetería o negocio culinario exitoso',
        'link'     => 'https://www.utleon.edu.mx/carrera/GST',
        'nombrecasa' => 'FLAMORIA',
    ],
    [
        'imagen'   => 'imagenes/casas/administracion.webp',
        'nombre'   => 'Administración ',
        'dominio'  => 'Licenciaturas',
        'color'    => '#1F3D2B',
        'frase'    => 'Liderar para construir',
        'valores'  => ['Liderazgo', 'Responsabilidad', 'Ética'],
        'desc'     => 'Gestión de empresas y recursos.',
        'oferta'   => 'Gestión del Capital Humano: Aprenderás a dirigir y desarrollar el talento humano dentro de las organizaciones clave para cualquier empresa, Liderazgo de Equipos de Alto Desempeño: Desarrollarás habilidades para motivar y guiar equipos hacia objetivos comunes con excelencia, Dirección Estratégica: Estudiarás cómo formular y ejecutar estrategias empresariales que garanticen el crecimiento y competitividad, Finanzas Corporativas: Aprenderás a gestionar los recursos financieros de una empresa para maximizar su valor, Consultoría Empresarial: Desarrollarás proyectos de mejora organizacional como consultor especializado',
        'link'     => 'https://www.utleon.edu.mx/carrera/GCH',
        'nombrecasa' => 'LAUREON',
    ],
    [
        'imagen'   => 'imagenes/casas/turismo.webp',
        'nombre'   => 'Turismo',
        'dominio'  => 'Licenciaturas',
        'color'    => '#00A3E0',
        'frase'    => 'Descubrir conecta culturas',
        'valores'  => ['Servicio', 'Empatía', 'Creatividad'],
        'desc'     => 'Experiencias turísticas y culturales.',
        'oferta'   => 'Diseño de Experiencias Turísticas: Crearás experiencias memorable para turistas combinando cultura naturaleza y entretenimiento, Destinos Turísticos Inteligentes: Aprenderás a desarrollar destinos innovadores que utilizan tecnología para mejorar la experiencia, Turismo Cultural y de Naturaleza: Te especializarás en promocionar el patrimonio cultural e histórico de regiones, Dirección y Logística de Eventos: Planificarás y ejecutarás eventos turísticos de gran escala como congresos y festivales, Mercadotecnia Internacional: Aprenderás a promover destinos turísticos a nivel mundial con estrategias globales',
        'link'     => 'https://www.utleon.edu.mx/carrera/TU',
        'nombrecasa' => 'GLOBARIS',
    ],
    [
        'imagen'   => 'imagenes/casas/mercadotecnia.webp',
        'nombre'   => 'Negocios y Mercadotecnia',
        'dominio'  => 'Licenciaturas',
        'color'    => '#E4007C',
        'frase'    => 'Las ideas iluminan el cambio',
        'valores'  => ['Innovación', 'Liderazgo', 'Comunicación'],
        'desc'     => 'Marketing y desarrollo de negocios.',
        'oferta'   => 'Mercadotecnia Digital I y II: Dominarás estrategias digitales redes sociales y herramientas online para conectar con clientes, Inteligencia de Mercados: Aprenderás a analizar datos de mercado para tomar decisiones comerciales informadas, Desarrollo de Nuevos Productos: Crearás productos innovadores que satisfagan necesidades del mercado actual, Comportamiento del Consumidor: Entenderás cómo piensan y actúan los clientes para diseñar mejores estrategias de venta, Plan de Negocios: Desarrollarás un plan completo para lanzar tu propia empresa o proyecto empresarial',
        'link'     => 'https://www.utleon.edu.mx/carrera/MT',
        'nombrecasa' => 'NOVARIS',
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
<style>
    #casasGrid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.5rem;
    align-items: stretch;
    justify-content: start; /* evita que las cards se estiren si sobra espacio en la última fila */
}

.casa-card {
    display: flex;
    flex-direction: column;
    background: #14141F;
    border-radius: 12px;
    overflow: hidden;
    width: 100%;
    max-width: 280px; /* límite extra de seguridad para que no crezcan de más */
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

/* Tablet */
@media (max-width: 900px) {
    #casasGrid {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1.25rem;
    }
    .casa-card {
        max-width: 240px;
    }
}

/* Celular: 1 columna */
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
                <h4 style="color:#eedca7;font-size:1.05rem;margin-bottom:.2rem;font-family:'Headland One',serif;">{{ $casa['nombrecasa'] }}</h4>     
                <h3 style="color:#FFFFFF;font-size:1.05rem;margin-bottom:.4rem;font-family:'Headland One',serif;">{{ $casa['nombre'] }}</h3>
                <p style="color:#C8A84B;font-size:.82rem;font-style:italic;margin-bottom:.9rem;">{{ $casa['frase'] }}</p>
                <p style="color:#B0A898;line-height:1.7;font-size:.9rem;margin-bottom:1.5rem;flex-grow:1;">{{ $casa['desc'] }}</p>
                <div style="display:flex;flex-wrap:wrap;gap:.5rem;">
                    @foreach($casa['valores'] as $v)
                    <span style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);
                                 color:#F0EAD8;padding:.4rem .75rem;border-radius:50px;font-size:.72rem;">{{ $v }}</span>
                    @endforeach
                </div>
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
         style="padding:5rem 2rem;text-align:center;background: rgba(6,6,15,.45);
                border-top:1px solid rgba(200,168,75,.12);border-bottom:1px solid rgba(200,168,75,.12);">
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

// ── Menú hamburguesa ──
const hamburgerBtn = document.getElementById('hamburgerBtn');
const mobileMenu    = document.getElementById('mobileMenu');
const navEl         = hamburgerBtn.closest('nav');

function posicionarMenuMovil() {
    if (navEl) mobileMenu.style.top = navEl.getBoundingClientRect().bottom + 'px';
}
hamburgerBtn.addEventListener('click', () => {
    posicionarMenuMovil();
    mobileMenu.classList.toggle('open');
    hamburgerBtn.setAttribute('aria-expanded', mobileMenu.classList.contains('open'));
});
document.addEventListener('click', e => {
    if (!hamburgerBtn.contains(e.target) && !mobileMenu.contains(e.target))
        mobileMenu.classList.remove('open');
});
window.addEventListener('resize', posicionarMenuMovil);
window.addEventListener('scroll', () => {
    if (mobileMenu.classList.contains('open')) posicionarMenuMovil();
});
</script>
@endpush