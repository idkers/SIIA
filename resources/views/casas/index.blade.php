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
        <a href="{{ route('welcome') }}"      style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Inicio</a>
        <a href="{{ route('quiz') }}"          style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Quiz</a>
        <a href="{{ route('recorrido') }}"     style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Recorrido</a>
        <a href="{{ route('dominios') }}"      style="font-size:.82rem;color:#B0A898;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Dominios</a>
        <a href="{{ route('casas') }}"         style="font-size:.82rem;color:#E8C96A;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;">Casas</a>
    </div>
    <div style="display:flex;align-items:center;gap:.75rem;">
        <a href="#"
           style="font-size:.82rem;color:#B0A898;text-decoration:none;
                  letter-spacing:.08em;text-transform:uppercase;">
            Ingresar
        </a>
        <div style="width:32px;height:32px;border-radius:50%;
                    background:#2B1F3D;border:1px solid #6B5020;"></div>
    </div>
</nav>

{{-- ═══ ENCABEZADO ════════════════════════════════════════════════════════ --}}
<section style="border:1px solid #ccc;border-radius:6px;
                padding:2rem;margin-bottom:1.5rem;background:#fff;text-align:center;">
    <p style="font-size:.7rem;text-transform:uppercase;letter-spacing:.1em;color:#999;margin-bottom:.3rem;">
        Identidad Académica
    </p>
    <h1 style="font-size:1.5rem;font-weight:700;color:#222;margin-bottom:.6rem;">
        Las Casas de la UTL
    </h1>
    <p style="font-size:.85rem;color:#666;max-width:460px;margin:0 auto;line-height:1.6;">
        Cada casa representa una constelación de valores, competencias y filosofías académicas.
        Descubre cuál resuena con tu trayectoria intelectual.
    </p>
</section>


{{-- ═══ FILTROS ════════════════════════════════════════════════════════════ --}}
<div style="display:flex;gap:.5rem;margin-bottom:1.2rem;flex-wrap:wrap;align-items:center;">
    <span style="font-size:.7rem;text-transform:uppercase;letter-spacing:.1em;color:#aaa;margin-right:.3rem;">Filtrar:</span>
    <button style="font-size:.78rem;color:#222;border:1px solid #333;padding:.3rem .9rem;border-radius:4px;background:#fff;cursor:pointer;">Todos</button>
    <button style="font-size:.78rem;color:#777;border:1px solid #ddd;padding:.3rem .9rem;border-radius:4px;background:#f9f9f9;cursor:pointer;">Ingenierías</button>
    <button style="font-size:.78rem;color:#777;border:1px solid #ddd;padding:.3rem .9rem;border-radius:4px;background:#f9f9f9;cursor:pointer;">Tecnologías de la Información</button>
    <button style="font-size:.78rem;color:#777;border:1px solid #ddd;padding:.3rem .9rem;border-radius:4px;background:#f9f9f9;cursor:pointer;">Ingeniería Industrial</button>
   <button style="font-size:.78rem;color:#777;border:1px solid #ddd;padding:.3rem .9rem;border-radius:4px;background:#f9f9f9;cursor:pointer;">Mecatrónica</button>
    <button style="font-size:.78rem;color:#777;border:1px solid #ddd;padding:.3rem .9rem;border-radius:4px;background:#f9f9f9;cursor:pointer;">Licenciaturas</button>
</div>

{{-- ═══ GRID DE CASAS ══════════════════════════════════════════════════════ --}}
@php
$casas = [

['','Ingeniería en Logística','Ingenierías',
'Organización y eficiencia',
['Responsabilidad','Organización','Eficiencia'],
'Te gusta planear, coordinar recursos y optimizar procesos.'],

['','Ingeniería en Mantenimiento Industrial','Ingenierías',
'Mantén el sistema en marcha',
['Compromiso','Precisión','Responsabilidad'],
'Diagnóstico y mantenimiento de maquinaria industrial.'],

['','Ingeniería Ambiental y Sustentabilidad','Ingenierías',
'Innovar para cuidar el planeta',
['Ética','Compromiso','Responsabilidad Social'],
'Desarrollo de soluciones ambientales sostenibles.'],

['','Entornos Virtuales y Negocios Digitales','Tecnologías de la Información',
'Crear experiencias digitales',
['Creatividad','Innovación','Adaptación'],
'Desarrollo de productos digitales interactivos.'],

['','Ciencia de Datos','Tecnologías de la Información',
'Los datos cuentan historias',
['Objetividad','Precisión','Pensamiento Crítico'],
'Interpretación y análisis de datos.'],

['','Desarrollo de Software','Tecnologías de la Información',
'Construye el futuro',
['Innovación','Perseverancia','Aprendizaje Continuo'],
'Creación de aplicaciones y sistemas.'],

['','Infraestructura de Redes','Tecnologías de la Información',
'Todo conectado',
['Responsabilidad','Orden','Seguridad'],
'Administración de redes y servidores.'],

['','Inteligencia Artificial','Tecnologías de la Información',
'Piensa diferente',
['Creatividad','Innovación','Pensamiento Crítico'],
'Desarrollo de soluciones inteligentes.'],

['','Automotriz','Ingeniería Industrial',
'Optimizar la industria',
['Eficiencia','Liderazgo','Compromiso'],
'Mejora de procesos automotrices.'],

['','Procesos Productivos','Ingeniería Industrial',
'Mejora continua',
['Orden','Eficiencia','Mejora Continua'],
'Gestión de operaciones industriales.'],

['','Moldeo de Plásticos','Ingeniería Industrial',
'Innovar con materiales',
['Precisión','Responsabilidad','Innovación'],
'Diseño y fabricación de productos plásticos.'],

['','Calzado','Ingeniería Industrial',
'Diseño y producción',
['Creatividad','Calidad','Trabajo en Equipo'],
'Industria del calzado y manufactura.'],

['','Manufactura Flexible','Mecatrónica',
'Automatiza el futuro',
['Innovación','Precisión','Creatividad'],
'Sistemas automatizados de producción.'],

['','Optomecatrónica','Mecatrónica',
'Tecnología de precisión',
['Precisión','Responsabilidad','Innovación'],
'Sistemas ópticos y electrónicos.'],

['','Automatización','Mecatrónica',
'Control inteligente',
['Eficiencia','Compromiso','Innovación'],
'Automatización de procesos industriales.'],

['','Gastronomía','Licenciaturas',
'Crear experiencias',
['Servicio','Creatividad','Disciplina'],
'Experiencias culinarias y hospitalidad.'],

['','Administración','Licenciaturas',
'Dirigir con estrategia',
['Liderazgo','Responsabilidad','Ética'],
'Gestión de empresas y recursos.'],

['','Turismo','Licenciaturas',
'Conectar culturas',
['Servicio','Empatía','Creatividad'],
'Experiencias turísticas y culturales.'],

['','Innovación de Negocios y Mercadotecnia','Licenciaturas',
'Impulsar ideas',
['Innovación','Liderazgo','Comunicación'],
'Marketing y desarrollo de negocios.']

];
@endphp

<section style="border:1px solid #ccc;border-radius:6px;
                padding:1.5rem;margin-bottom:1.5rem;background:#fff;">

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:.75rem;" id="casasGrid">
        @foreach($casas as $i => $casa)
        <div onclick="selectCasa({{ $i }})"
             id="casa-card-{{ $i }}"
             style="border:1px solid {{ $i===0?'#333':'#ccc' }};border-radius:6px;
                    padding:.75rem;background:{{ $i===0?'#f5f5f5':'#f9f9f9' }};
                    display:flex;flex-direction:column;gap:.5rem;cursor:pointer;
                    transition:border-color .15s;">

            <div style="width:100%;aspect-ratio:1;background:#e0e0e0;
                        border:1px dashed #bbb;border-radius:4px;
                        display:flex;align-items:center;justify-content:center;
                        font-size:.72rem;color:#999;text-align:center;padding:.5rem;">
                {{ $casa[0] }}<br>[ Escudo<br>{{ $casa[1] }} ]
            </div>

            <p style="font-size:.82rem;font-weight:700;color:#222;margin:0;">{{ $casa[1] }}</p>
            <p style="font-size:.75rem;color:#555;margin:0;">{{ $casa[2] }}</p>
            <p style="font-size:.72rem;color:#888;font-style:italic;margin:0;">{{ $casa[3] }}</p>

            <div style="display:flex;flex-wrap:wrap;gap:3px;">
                @foreach($casa[4] as $v)
                <span style="font-size:.65rem;padding:2px 6px;
                             border:1px solid #ccc;border-radius:20px;color:#666;">
                    {{ $v }}
                </span>
                @endforeach
            </div>

            <p style="font-size:.68rem;color:#999;line-height:1.4;margin:0;">{{ $casa[5] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ═══ CTA QUIZ ═══════════════════════════════════════════════════════════ --}}
<section style="border:1px solid #ccc;border-radius:6px;
                padding:2.5rem;margin-bottom:1.5rem;background:#fff;text-align:center;">
    <h2 style="font-size:1.2rem;font-weight:700;color:#222;margin-bottom:.6rem;">
        ¿Cuál es tu casa?
    </h2>
    <p style="font-size:.85rem;color:#666;max-width:380px;margin:0 auto 1.2rem;line-height:1.6;">
        Responde el quiz del astrolabio y descubre con precisión qué casa
        converge con tu perfil intelectual y profesional.
    </p>
    <a href="{{ route('quiz') }}"
       style="display:inline-block;padding:.5rem 2rem;
              border:1px solid #555;border-radius:4px;
              font-size:.9rem;font-weight:600;color:#333;
              text-decoration:none;background:#fff;">
        Tomar el quiz
    </a>
</section>

{{-- ═══ FOOTER PLACEHOLDER ════════════════════════════════════════════════ --}}
<footer style="
    padding:3rem 4rem;
    background:#06060F;
    border-top:1px solid #2B1F3D;
">

    <div style="
        display:flex;
        justify-content:space-around;
        flex-wrap:wrap;
        gap:3rem;
    ">

        <!-- Información UTL -->
        <div style="
            text-align:left;
            max-width:400px;
        ">

            <h3 style="
                font-family:'Headland One', serif;
                color:#C8A84B;
                margin-bottom:1rem;
                font-size:1.4rem;
            ">
                Universidad Tecnológica de León
            </h3>

            <p style="
                color:#F0EAD8;
                line-height:1.8;
                margin:0;
            ">
                Blvd. Universidad Tecnológica #225 Col. San Carlos<br>
                C.P. 37670 León, Gto. México<br><br>

                difusion@utleon.edu.mx<br><br>

                (477) 7 10 00 20
            </p>

        </div>

        <!-- Información del proyecto -->
        <div style="
            text-align:left;
            max-width:450px;
        ">

            <h3 style="
                font-family:'Headland One', serif;
                color:#C8A84B;
                margin-bottom:1rem;
                font-size:1.4rem;
            ">
                Desarrolladores del Proyecto
            </h3>

            <p style="
                color:#F0EAD8;
                line-height:2;
                margin:0;
            ">
                <strong>Citlalli Méndez</strong><br>
                citlallialejandrams@gmail.com
                <br><br>

                <strong>Miryam Muñoz</strong><br>
                miryammunoz26@gmail.com
                <br><br>

                <strong>Carlo Flores</strong><br>
                carlofernandoflores2006@gmail.com
            </p>

        </div>

    </div>

    <div style="
        margin-top:2.5rem;
        border-top:1px solid rgba(200,168,75,.15);
        padding-top:1.5rem;
        text-align:center;
        color:#707085;
        font-size:.8rem;
        letter-spacing:.08em;
    ">
        © {{ date('Y') }} SIIA · Sistema Integral de Identidad Académica
    </div>

</footer>

@endsection

@section('extra-js')
<script>

function selectCasa(idx) {
    // Update card styles
    casasData.forEach((_, i) => {
        const c = document.getElementById('casa-card-' + i);
        c.style.border     = i === idx ? '1px solid #333' : '1px solid #ccc';
        c.style.background = i === idx ? '#f5f5f5'       : '#f9f9f9';
    });

    const d = casasData[idx];

    // Update featured
    document.getElementById('feat-icon').textContent    = d.icon;
    document.getElementById('feat-escudo').textContent  = '[ Escudo ' + d.nombre + ' ]';
    document.getElementById('feat-dominio').textContent = 'Casa · ' + d.dominio;
    document.getElementById('feat-nombre').textContent  = d.nombre;
    document.getElementById('feat-frase').textContent   = d.frase;
    document.getElementById('feat-desc').textContent    = d.desc;
    document.getElementById('feat-s1').textContent      = d.s1;
    document.getElementById('feat-s2').textContent      = d.s2;
    document.getElementById('feat-s3').textContent      = d.s3;

    const vals = document.getElementById('feat-valores');
    vals.innerHTML = d.valores.map(v =>
        `<span style="font-size:.72rem;padding:2px 9px;border:1px solid #ccc;border-radius:20px;color:#666;">${v}</span>`
    ).join('');

    document.getElementById('featured').scrollIntoView({ behavior:'smooth', block:'nearest' });
}
</script>
@endsection