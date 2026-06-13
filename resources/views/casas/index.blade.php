@extends('layouts.app')
@section('title', 'Casas — SIIA')

@section('content')

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<nav style="display:flex;align-items:center;justify-content:space-between;
            padding:.75rem 2rem;
            background:#06060F;
            border-bottom:1px solid #2B1F3D;
            margin-bottom:0;">
    <span style="font-weight:700;font-size:1rem;color:#C8A84B;
                 letter-spacing:.12em;font-family:'Headland One',serif;">
        UTL
    </span>
    <div style="display:flex;gap:2rem;">
        <a href="{{ route('welcome') }}"  style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Inicio</a>
        <a href="{{ route('quiz') }}"     style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Quiz</a>
        <a href="{{ route('recorrido') }}"style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Recorrido</a>
        <a href="{{ route('dominios') }}" style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Dominios</a>
        <a href="{{ route('casas') }}"    style="font-size:.82rem;color:#E8C96A;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Casas</a>
    </div>
    <div style="display:flex;align-items:center;gap:.75rem;">
        <a href="#" style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Ingresar</a>
        <div style="width:32px;height:32px;border-radius:50%;background:#2B1F3D;border:1px solid #6B5020;"></div>
    </div>
</nav>

{{-- ═══ ENCABEZADO ════════════════════════════════════════════════════════ --}}
<section style="
    padding:5rem 2rem;
    text-align:center;
    background:linear-gradient(180deg,#06060F,#0D0D1A);
    border-bottom:1px solid rgba(200,168,75,.15);
">
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
<br>
@php
$casas = [

    // ── INGENIERÍAS ──────────────────────────────────────────────────────
    [
        'imagen'  => 'img/casas/logistica.jpeg',
        'nombre'  => 'Ingeniería en Logística',
        'dominio' => 'Ingenierías',
        'color'   => '#0057B8',
        'frase'   => 'Organización y eficiencia',
        'valores' => ['Responsabilidad', 'Organización', 'Eficiencia'],
        'desc'    => 'Te gusta planear, coordinar recursos y optimizar procesos.',
    ],
    [
        'imagen'  => 'img/casas/mantenimiento.jpg',
        'nombre'  => 'Ingeniería en Mantenimiento Industrial',
        'dominio' => 'Ingenierías',
        'color'   => '#003A5D',
        'frase'   => 'Mantén el sistema en marcha',
        'valores' => ['Compromiso', 'Precisión', 'Responsabilidad'],
        'desc'    => 'Diagnóstico y mantenimiento de maquinaria industrial.',
    ],
    [
        'imagen'  => 'img/casas/ambiental.jpg',
        'nombre'  => 'Ingeniería Ambiental y Sustentabilidad',
        'dominio' => 'Ingenierías',
        'color'   => '#43B02A',
        'frase'   => 'Innovar para cuidar el planeta',
        'valores' => ['Ética', 'Compromiso', 'Responsabilidad Social'],
        'desc'    => 'Desarrollo de soluciones ambientales sostenibles.',
    ],

    // ── TECNOLOGÍAS DE LA INFORMACIÓN ────────────────────────────────────
    [
        'imagen'  => 'img/casas/entornos.jpg',
        'nombre'  => 'Entornos Virtuales y Negocios Digitales',
        'dominio' => 'Tecnologías de la Información',
        'color'   => '#6B3FA0',
        'frase'   => 'Crear experiencias digitales',
        'valores' => ['Creatividad', 'Innovación', 'Adaptación'],
        'desc'    => 'Desarrollo de productos digitales interactivos.',
    ],
    [
        'imagen'  => 'img/casas/ciencia.jpg',
        'nombre'  => 'Ciencia de Datos',
        'dominio' => 'Tecnologías de la Información',
        'color'   => '#2E6F95',
        'frase'   => 'Los datos cuentan historias',
        'valores' => ['Objetividad', 'Precisión', 'Pensamiento Crítico'],
        'desc'    => 'Interpretación y análisis de datos.',
    ],
    [
        'imagen'  => 'img/casas/software.png',
        'nombre'  => 'Desarrollo de Software',
        'dominio' => 'Tecnologías de la Información',
        'color'   => '#2563EB',
        'frase'   => 'Construye el futuro',
        'valores' => ['Innovación', 'Perseverancia', 'Aprendizaje Continuo'],
        'desc'    => 'Creación de aplicaciones y sistemas.',
    ],
    [
        'imagen'  => 'img/casas/redes.jpg',
        'nombre'  => 'Infraestructura de Redes',
        'dominio' => 'Tecnologías de la Información',
        'color'   => '#0EA5A4',
        'frase'   => 'Todo conectado',
        'valores' => ['Responsabilidad', 'Orden', 'Seguridad'],
        'desc'    => 'Administración de redes y servidores.',
    ],
    [
        'imagen'  => 'img/casas/ia.jpg',
        'nombre'  => 'Inteligencia Artificial',
        'dominio' => 'Tecnologías de la Información',
        'color'   => '#8A2BE2',
        'frase'   => 'Piensa diferente',
        'valores' => ['Creatividad', 'Innovación', 'Pensamiento Crítico'],
        'desc'    => 'Desarrollo de soluciones inteligentes.',
    ],

    // ── INGENIERÍA INDUSTRIAL ─────────────────────────────────────────────
    [
        'imagen'  => 'img/casas/automotriz.jpg',
        'nombre'  => 'Automotriz',
        'dominio' => 'Ingeniería Industrial',
        'color'   => '#DC2626',
        'frase'   => 'Optimizar la industria',
        'valores' => ['Eficiencia', 'Liderazgo', 'Compromiso'],
        'desc'    => 'Mejora de procesos automotrices.',
    ],
    [
        'imagen'  => 'img/casas/productivos.png',
        'nombre'  => 'Procesos Productivos',
        'dominio' => 'Ingeniería Industrial',
        'color'   => '#ED8B00',
        'frase'   => 'Mejora continua',
        'valores' => ['Orden', 'Eficiencia', 'Mejora Continua'],
        'desc'    => 'Gestión de operaciones industriales.',
    ],
    [
        'imagen'  => 'img/casas/plasticos.jpg',
        'nombre'  => 'Moldeo de Plásticos',
        'dominio' => 'Ingeniería Industrial',
        'color'   => '#9C3D0C',
        'frase'   => 'Innovar con materiales',
        'valores' => ['Precisión', 'Responsabilidad', 'Innovación'],
        'desc'    => 'Diseño y fabricación de productos plásticos.',
    ],
    [
        'imagen'  => 'img/casas/calzado.jpg',
        'nombre'  => 'Calzado',
        'dominio' => 'Ingeniería Industrial',
        'color'   => '#C46210',
        'frase'   => 'Diseño y producción',
        'valores' => ['Creatividad', 'Calidad', 'Trabajo en Equipo'],
        'desc'    => 'Industria del calzado y manufactura.',
    ],

    // ── MECATRÓNICA ───────────────────────────────────────────────────────
    [
        'imagen'  => 'img/casas/manufactura.jpg',
        'nombre'  => 'Manufactura Flexible',
        'dominio' => 'Mecatrónica',
        'color'   => '#7C3AED',
        'frase'   => 'Automatiza el futuro',
        'valores' => ['Innovación', 'Precisión', 'Creatividad'],
        'desc'    => 'Sistemas automatizados de producción.',
    ],
    [
        'imagen'  => 'img/casas/optomecatronica.jpg',
        'nombre'  => 'Optomecatrónica',
        'dominio' => 'Mecatrónica',
        'color'   => '#A50034',
        'frase'   => 'Tecnología de precisión',
        'valores' => ['Precisión', 'Responsabilidad', 'Innovación'],
        'desc'    => 'Sistemas ópticos y electrónicos.',
    ],
    [
        'imagen'  => 'img/casas/automatizacion.jpg',
        'nombre'  => 'Automatización',
        'dominio' => 'Mecatrónica',
        'color'   => '#FF3B30',
        'frase'   => 'Control inteligente',
        'valores' => ['Eficiencia', 'Compromiso', 'Innovación'],
        'desc'    => 'Automatización de procesos industriales.',
    ],

    // ── LICENCIATURAS ─────────────────────────────────────────────────────
    [
        'imagen'  => 'img/casas/gastronomia.jpg',
        'nombre'  => 'Gastronomía',
        'dominio' => 'Licenciaturas',
        'color'   => '#EBA42D',
        'frase'   => 'Crear experiencias',
        'valores' => ['Servicio', 'Creatividad', 'Disciplina'],
        'desc'    => 'Experiencias culinarias y hospitalidad.',
    ],
    [
        'imagen'  => 'img/casas/administracion.jpg',
        'nombre'  => 'Administración',
        'dominio' => 'Licenciaturas',
        'color'   => '#1F3D2B',
        'frase'   => 'Dirigir con estrategia',
        'valores' => ['Liderazgo', 'Responsabilidad', 'Ética'],
        'desc'    => 'Gestión de empresas y recursos.',
    ],
    [
        'imagen'  => 'img/casas/turismo.png',
        'nombre'  => 'Turismo',
        'dominio' => 'Licenciaturas',
        'color'   => '#00A3E0',
        'frase'   => 'Conectar culturas',
        'valores' => ['Servicio', 'Empatía', 'Creatividad'],
        'desc'    => 'Experiencias turísticas y culturales.',
    ],
    [
        'imagen'  => 'img/casas/mercadotecnia.jpg',
        'nombre'  => 'Innovación de Negocios y Mercadotecnia',
        'dominio' => 'Licenciaturas',
        'color'   => '#E4007C',
        'frase'   => 'Impulsar ideas',
        'valores' => ['Innovación', 'Liderazgo', 'Comunicación'],
        'desc'    => 'Marketing y desarrollo de negocios.',
    ],

];
@endphp

{{-- ═══ FILTROS ════════════════════════════════════════════════════════════ --}}
<style>
    .filtro-btn {
        font-size:.78rem;
        color:#B0A898;
        border:1px solid rgba(200,168,75,.2);
        padding:.35rem 1rem;
        border-radius:50px;
        background:transparent;
        cursor:pointer;
        letter-spacing:.06em;
        transition: border-color .2s, color .2s, background .2s;
        font-family:inherit;
    }
    .filtro-btn:hover,
    .filtro-btn.activo {
        border-color:#C8A84B;
        color:#E8C96A;
        background:rgba(200,168,75,.08);
    }
    .casa-card {
        background:#14141F;
        border:1px solid rgba(200,168,75,.15);
        border-radius:18px;
        overflow:hidden;
        transition: border-color .35s ease, box-shadow .35s ease;
        display:flex;
        flex-direction:column;
    }
    .casa-card:hover {
        border-color: rgba(200,168,75,.85);
        box-shadow: 0 0 0 1px rgba(200,168,75,.4), 0 0 18px rgba(200,168,75,.18);
    }
</style>

<section style="max-width:1400px;margin:0 auto 2rem;padding:0 2rem;">
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;">
        <span style="font-size:.72rem;text-transform:uppercase;letter-spacing:.12em;color:#707085;margin-right:.25rem;">Filtrar:</span>
        <button class="filtro-btn activo" onclick="filtrar(this,'Todos')">Todos</button>
        <button class="filtro-btn" onclick="filtrar(this,'Ingenierías')">Ingenierías</button>
        <button class="filtro-btn" onclick="filtrar(this,'Tecnologías de la Información')">Tecnologías de la Información</button>
        <button class="filtro-btn" onclick="filtrar(this,'Ingeniería Industrial')">Ingeniería Industrial</button>
        <button class="filtro-btn" onclick="filtrar(this,'Mecatrónica')">Mecatrónica</button>
        <button class="filtro-btn" onclick="filtrar(this,'Licenciaturas')">Licenciaturas</button>
    </div>
</section>

{{-- ═══ GRID DE CASAS ══════════════════════════════════════════════════════ --}}
<section style="max-width:1400px;margin:auto;padding:0 2rem 4rem;">

    <div id="casasGrid" style="
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
        gap:1.5rem;
    ">

        @foreach($casas as $casa)

        <div class="casa-card" data-dominio="{{ $casa['dominio'] }}">

            <div style="height:8px;background:{{ $casa['color'] }};"></div>

            <div style="padding:1.5rem;display:flex;flex-direction:column;height:100%;">

                {{-- NO MODIFICAR (AQUÍ VA EL ESCUDO) --}}
                {{-- ESCUDO / IMAGEN --}}
                <div style="
                    width:100%;
                    aspect-ratio:1;
                    border-radius:12px;
                    overflow:hidden;
                    margin-bottom:1.5rem;
                ">
                    @if(!empty($casa['imagen']))
                        <img
                            src="{{ asset($casa['imagen']) }}"
                            alt="{{ $casa['nombre'] }}"
                            style="width:100%;height:100%;object-fit:cover;"
                        >
                    @else
                        <div style="
                            width:100%;height:100%;
                            background:#1D1D2B;
                            border:1px dashed rgba(255,255,255,.15);
                            border-radius:12px;
                            display:flex;align-items:center;justify-content:center;
                        "></div>
                    @endif
                </div>

                <p style="
                    font-size:.7rem;
                    text-transform:uppercase;
                    letter-spacing:.12em;
                    color:#707085;
                    margin-bottom:.4rem;
                ">{{ $casa['dominio'] }}</p>

                <h3 style="
                    color:#FFFFFF;
                    font-size:1.05rem;
                    margin-bottom:.4rem;
                    font-family:'Headland One',serif;
                ">{{ $casa['nombre'] }}</h3>

                <p style="
                    color:#C8A84B;
                    font-size:.82rem;
                    font-style:italic;
                    margin-bottom:.9rem;
                ">{{ $casa['frase'] }}</p>

                <p style="
                    color:#B0A898;
                    line-height:1.7;
                    font-size:.9rem;
                    margin-bottom:1.5rem;
                    flex-grow:1;
                ">{{ $casa['desc'] }}</p>

                <div style="display:flex;flex-wrap:wrap;gap:.5rem;">
                    @foreach($casa['valores'] as $v)
                    <span style="
                        background:rgba(255,255,255,.04);
                        border:1px solid rgba(255,255,255,.08);
                        color:#F0EAD8;
                        padding:.4rem .75rem;
                        border-radius:50px;
                        font-size:.72rem;
                    ">{{ $v }}</span>
                    @endforeach
                </div>

            </div>

        </div>

        @endforeach

    </div>

</section>

{{-- ═══ CTA ═══════════════════════════════════════════════════════════════ --}}
<section style="
    padding:5rem 2rem;
    text-align:center;
    background:#0D0D1A;
    border-top:1px solid rgba(200,168,75,.12);
    border-bottom:1px solid rgba(200,168,75,.12);
">
    <h2 style="color:#FFFFFF;font-family:'Headland One',serif;margin-bottom:1rem;">
        Descubre tu casa académica
    </h2>
    <p style="max-width:650px;margin:auto auto 2rem;color:#F0EAD8;line-height:1.8;">
        Realiza el cuestionario SIIA y descubre qué casa y qué dominio
        representan mejor tus intereses, habilidades y forma de aprender.
    </p>
    <a href="{{ route('quiz') }}" style="
        display:inline-block;
        background:#C6A050;
        color:#06060F;
        text-decoration:none;
        padding:.9rem 2rem;
        border-radius:8px;
        font-weight:700;
    ">Realizar Test</a>
</section>

{{-- ═══ FOOTER ════════════════════════════════════════════════════════════ --}}
<footer style="padding:3rem 4rem;background:#06060F;border-top:1px solid #2B1F3D;">
    <div style="display:flex;justify-content:space-around;flex-wrap:wrap;gap:3rem;">
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
    <div style="margin-top:2.5rem;border-top:1px solid rgba(200,168,75,.15);padding-top:1.5rem;text-align:center;color:#707085;font-size:.8rem;letter-spacing:.08em;">
        © {{ date('Y') }} SIIA · Sistema Integral de Identidad Académica
    </div>
</footer>

@endsection

@section('extra-js')
<script>
function filtrar(btn, dominio) {
    document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
    btn.classList.add('activo');

    document.querySelectorAll('.casa-card').forEach(card => {
        const coincide = dominio === 'Todos' || card.dataset.dominio === dominio;
        card.style.display = coincide ? 'flex' : 'none';
    });
}
</script>
@endsection