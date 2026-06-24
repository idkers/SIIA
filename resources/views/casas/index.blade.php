@extends('layouts.app')
@section('title', 'Casas — SIIA')

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
        border-radius:20px; max-width:540px; width:100%;
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
    .modal-oferta-text { color:#F0EAD8; line-height:1.8; font-size:.92rem; margin-bottom:1.75rem; }
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

    #footer-casas-grid { display:flex; justify-content:space-around; flex-wrap:wrap; gap:3rem; }
</style>

{{-- NAVBAR --}}
<nav style="display:flex;align-items:center;justify-content:space-between;
            padding:.75rem 2rem;background:rgba(6,6,15,0.6);
            backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);
            position:sticky;top:0;z-index:100;isolation:isolate;">
    <span style="font-weight:700;font-size:1.4rem;color:#C8A84B;
                 letter-spacing:.12em;font-family:'Headland One',serif;">UTL</span>
    <div class="nav-links-casas">
        <a href="{{ route('welcome') }}"   style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Inicio</a>
        <a href="{{ route('quiz') }}"      style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Quiz</a>
        <a href="{{ route('recorrido') }}" style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Recorrido</a>
        <a href="{{ route('dominios') }}"  style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Dominios</a>
        <a href="{{ route('casas') }}"     style="font-size:.82rem;color:#E8C96A;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Casas</a>
    </div>
    <div class="nav-auth-casas">
        <a href="#" style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Ingresar</a>
        <div style="width:32px;height:32px;border-radius:50%;background:#4A3560;border:1px solid #6B5080;"></div>
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
    ['imagen'=>'imagenes/casas/logistica.jpeg','nombre'=>'Ingeniería en Logística','dominio'=>'Ingenierías','color'=>'#0057B8','frase'=>'Organización y eficiencia','valores'=>['Responsabilidad','Organización','Eficiencia'],'desc'=>'Te gusta planear, coordinar recursos y optimizar procesos.','oferta'=>'Agrega aquí la oferta educativa de Ingeniería en Logística.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/mantenimiento.jpg','nombre'=>'Ingeniería en Mantenimiento Industrial','dominio'=>'Ingenierías','color'=>'#003A5D','frase'=>'Mantén el sistema en marcha','valores'=>['Compromiso','Precisión','Responsabilidad'],'desc'=>'Diagnóstico y mantenimiento de maquinaria industrial.','oferta'=>'Agrega aquí la oferta educativa de Ingeniería en Mantenimiento Industrial.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/ambiental.jpg','nombre'=>'Ingeniería Ambiental y Sustentabilidad','dominio'=>'Ingenierías','color'=>'#43B02A','frase'=>'Innovar para cuidar el planeta','valores'=>['Ética','Compromiso','Responsabilidad Social'],'desc'=>'Desarrollo de soluciones ambientales sostenibles.','oferta'=>'Agrega aquí la oferta educativa de Ingeniería Ambiental y Sustentabilidad.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/entornos.jpg','nombre'=>'Entornos Virtuales y Negocios Digitales','dominio'=>'Tecnologías de la Información','color'=>'#6B3FA0','frase'=>'Crear experiencias digitales','valores'=>['Creatividad','Innovación','Adaptación'],'desc'=>'Desarrollo de productos digitales interactivos.','oferta'=>'Agrega aquí la oferta educativa de Entornos Virtuales y Negocios Digitales.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/datos.png','nombre'=>'Ciencia de Datos','dominio'=>'Tecnologías de la Información','color'=>'#2E6F95','frase'=>'Los datos cuentan historias','valores'=>['Objetividad','Precisión','Pensamiento Crítico'],'desc'=>'Interpretación y análisis de datos.','oferta'=>'Agrega aquí la oferta educativa de Ciencia de Datos.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/software.png','nombre'=>'Desarrollo de Software','dominio'=>'Tecnologías de la Información','color'=>'#2563EB','frase'=>'Construye el futuro','valores'=>['Innovación','Perseverancia','Aprendizaje Continuo'],'desc'=>'Creación de aplicaciones y sistemas.','oferta'=>'Agrega aquí la oferta educativa de Desarrollo de Software.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/redes.jpg','nombre'=>'Infraestructura de Redes','dominio'=>'Tecnologías de la Información','color'=>'#0EA5A4','frase'=>'Todo conectado','valores'=>['Responsabilidad','Orden','Seguridad'],'desc'=>'Administración de redes y servidores.','oferta'=>'Agrega aquí la oferta educativa de Infraestructura de Redes.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/ia.jpg','nombre'=>'Inteligencia Artificial','dominio'=>'Tecnologías de la Información','color'=>'#8A2BE2','frase'=>'Piensa diferente','valores'=>['Creatividad','Innovación','Pensamiento Crítico'],'desc'=>'Desarrollo de soluciones inteligentes.','oferta'=>'Agrega aquí la oferta educativa de Inteligencia Artificial.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/automotriz.jpg','nombre'=>'Automotriz','dominio'=>'Ingeniería Industrial','color'=>'#DC2626','frase'=>'Optimizar la industria','valores'=>['Eficiencia','Liderazgo','Compromiso'],'desc'=>'Mejora de procesos automotrices.','oferta'=>'Agrega aquí la oferta educativa de Automotriz.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/productivos.png','nombre'=>'Procesos Productivos','dominio'=>'Ingeniería Industrial','color'=>'#ED8B00','frase'=>'Mejora continua','valores'=>['Orden','Eficiencia','Mejora Continua'],'desc'=>'Gestión de operaciones industriales.','oferta'=>'Agrega aquí la oferta educativa de Procesos Productivos.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/plasticos.jpg','nombre'=>'Moldeo de Plásticos','dominio'=>'Ingeniería Industrial','color'=>'#9C3D0C','frase'=>'Innovar con materiales','valores'=>['Precisión','Responsabilidad','Innovación'],'desc'=>'Diseño y fabricación de productos plásticos.','oferta'=>'Agrega aquí la oferta educativa de Moldeo de Plásticos.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/calzado.jpg','nombre'=>'Calzado','dominio'=>'Ingeniería Industrial','color'=>'#C46210','frase'=>'Diseño y producción','valores'=>['Creatividad','Calidad','Trabajo en Equipo'],'desc'=>'Industria del calzado y manufactura.','oferta'=>'Agrega aquí la oferta educativa de Calzado.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/manufactura.jpg','nombre'=>'Manufactura Flexible','dominio'=>'Mecatrónica','color'=>'#7C3AED','frase'=>'Automatiza el futuro','valores'=>['Innovación','Precisión','Creatividad'],'desc'=>'Sistemas automatizados de producción.','oferta'=>'Agrega aquí la oferta educativa de Manufactura Flexible.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/optomecatronica.jpg','nombre'=>'Optomecatrónica','dominio'=>'Mecatrónica','color'=>'#A50034','frase'=>'Tecnología de precisión','valores'=>['Precisión','Responsabilidad','Innovación'],'desc'=>'Sistemas ópticos y electrónicos.','oferta'=>'Agrega aquí la oferta educativa de Optomecatrónica.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/automatizacion.jpg','nombre'=>'Automatización','dominio'=>'Mecatrónica','color'=>'#FF3B30','frase'=>'Control inteligente','valores'=>['Eficiencia','Compromiso','Innovación'],'desc'=>'Automatización de procesos industriales.','oferta'=>'Agrega aquí la oferta educativa de Automatización.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/gastronomia.jpg','nombre'=>'Gastronomía','dominio'=>'Licenciaturas','color'=>'#EBA42D','frase'=>'Crear experiencias','valores'=>['Servicio','Creatividad','Disciplina'],'desc'=>'Experiencias culinarias y hospitalidad.','oferta'=>'Agrega aquí la oferta educativa de Gastronomía.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/administracion.jpg','nombre'=>'Administración','dominio'=>'Licenciaturas','color'=>'#1F3D2B','frase'=>'Dirigir con estrategia','valores'=>['Liderazgo','Responsabilidad','Ética'],'desc'=>'Gestión de empresas y recursos.','oferta'=>'Agrega aquí la oferta educativa de Administración.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/turismo.png','nombre'=>'Turismo','dominio'=>'Licenciaturas','color'=>'#00A3E0','frase'=>'Conectar culturas','valores'=>['Servicio','Empatía','Creatividad'],'desc'=>'Experiencias turísticas y culturales.','oferta'=>'Agrega aquí la oferta educativa de Turismo.','link'=>'https://www.utleon.edu.mx/'],
    ['imagen'=>'imagenes/casas/mercadotecnia.jpg','nombre'=>'Innovación de Negocios y Mercadotecnia','dominio'=>'Licenciaturas','color'=>'#E4007C','frase'=>'Impulsar ideas','valores'=>['Innovación','Liderazgo','Comunicación'],'desc'=>'Marketing y desarrollo de negocios.','oferta'=>'Agrega aquí la oferta educativa de Innovación de Negocios y Mercadotecnia.','link'=>'https://www.utleon.edu.mx/'],
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
                {{-- data-attributes evitan problemas con comillas y caracteres especiales --}}
                <button class="btn-ver-mas"
                        data-nombre="{{ $casa['nombre'] }}"
                        data-dominio="{{ $casa['dominio'] }}"
                        data-oferta="{{ $casa['oferta'] }}"
                        data-link="{{ $casa['link'] }}"
                        data-color="{{ $casa['color'] }}"
                        onclick="abrirModalDesdeBtn(this)">
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
            <p class="modal-section-title">Oferta Educativa</p>
            <p class="modal-oferta-text" id="modalOferta"></p>
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

{{-- FOOTER --}}
<footer id="footer-casas" style="padding:3rem 4rem;background:#06060F;border-top:1px solid #2B1F3D;">
    <div id="footer-casas-grid">
        <div style="text-align:left;max-width:400px;">
            <h3 style="font-family:'Headland One',serif;color:#C8A84B;margin-bottom:1rem;font-size:1.4rem;">
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
            <h3 style="font-family:'Headland One',serif;color:#C8A84B;margin-bottom:1rem;font-size:1.4rem;">
                Desarrolladores del Proyecto
            </h3>
            <p style="color:#F0EAD8;line-height:2;margin:0;">
                <strong>Citlalli Méndez</strong><br>citlallialejandrams@gmail.com<br><br>
                <strong>Miryam Muñoz</strong><br>miryammunoz26@gmail.com<br><br>
                <strong>Carlo Flores</strong><br>carlofernandoflores2006@gmail.com
            </p>
        </div>
    </div>
    <div style="margin-top:2.5rem;border-top:1px solid rgba(200,168,75,.15);
                padding-top:1.5rem;text-align:center;color:#707085;font-size:.8rem;letter-spacing:.08em;">
        © {{ date('Y') }} SIIA · Sistema Integral de Identidad Académica
    </div>
</footer>

@endsection

@push('extra-js')
<script>
// NAVBAR
const hamburgerCasas = document.getElementById('hamburgerCasas');
const mobileCasas    = document.getElementById('mobileCasas');
hamburgerCasas.addEventListener('click', () => {
    mobileCasas.classList.toggle('open');
    hamburgerCasas.setAttribute('aria-expanded', mobileCasas.classList.contains('open'));
});
document.addEventListener('click', e => {
    if (!hamburgerCasas.contains(e.target) && !mobileCasas.contains(e.target))
        mobileCasas.classList.remove('open');
});

// FILTROS — normalización de acentos para comparación robusta
function normalizar(str) {
    return str.trim().toLowerCase()
              .normalize('NFD')
              .replace(/[\u0300-\u036f]/g, '');
}
function filtrar(btn, dominio) {
    document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
    btn.classList.add('activo');
    document.querySelectorAll('.casa-card').forEach(card => {
        const coincide = dominio === 'Todos' ||
                         normalizar(card.dataset.dominio) === normalizar(dominio);
        card.classList.toggle('oculta', !coincide);
    });
}

// MODAL — lee datos desde data-attributes (seguro con caracteres especiales)
function abrirModalDesdeBtn(btn) {
    document.getElementById('modalNombre').textContent          = btn.dataset.nombre;
    document.getElementById('modalDominio').textContent         = btn.dataset.dominio;
    document.getElementById('modalOferta').textContent          = btn.dataset.oferta;
    document.getElementById('modalHeaderBar').style.background  = btn.dataset.color;
    const linkEl       = document.getElementById('modalLink');
    linkEl.href        = btn.dataset.link;
    linkEl.textContent = btn.dataset.link;
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