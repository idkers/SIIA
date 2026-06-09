@extends('layouts.app')
@section('title', 'Quiz — SIIA')

@section('content')

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
<nav style="display:flex;align-items:center;justify-content:space-between;
            padding:.75rem 1.5rem;border:1px solid #ccc;border-radius:6px;
            margin-bottom:1.5rem;background:#f9f9f9;">
    <span style="font-weight:700;font-size:.95rem;color:#333;">UTL</span>
    <div style="display:flex;gap:1.5rem;">
        <a href="{{ route('welcome') }}"  style="font-size:.85rem;color:#555;text-decoration:none;">Inicio</a>
        <a href="{{ route('quiz') }}"     style="font-size:.85rem;color:#333;text-decoration:none;font-weight:600;">Quiz</a>
        <a href="{{ route('recorrido') }}" style="font-size:.85rem;color:#555;text-decoration:none;">Recorrido</a>
        <a href="{{ route('dominios') }}"  style="font-size:.85rem;color:#555;text-decoration:none;">Dominios</a>
        <a href="{{ route('casas') }}"     style="font-size:.85rem;color:#555;text-decoration:none;">Casas</a>
    </div>
    <div style="display:flex;align-items:center;gap:.75rem;">
        <a href="#" style="font-size:.85rem;color:#555;text-decoration:none;
                   border:1px solid #bbb;padding:.3rem .9rem;border-radius:4px;">
            Ingresar
        </a>
        <div style="width:32px;height:32px;border-radius:50%;background:#ddd;border:1px solid #bbb;"></div>
    </div>
</nav>

{{-- ═══ ETAPAS ═══════════════════════════════════════════════════════════════ --}}

{{-- ETAPA 1: Inicio del quiz --}}
<div id="stage-1" class="stage">

    <section style="display:grid;grid-template-columns:1fr 1fr;
                    border:1px solid #ccc;border-radius:6px;
                    overflow:hidden;margin-bottom:1.5rem;min-height:320px;">

        <div style="padding:2rem;display:flex;flex-direction:column;
                    justify-content:center;gap:1rem;
                    border-right:1px solid #ccc;background:#fff;">

            <div style="width:160px;height:60px;background:#e8e8e8;
                        border:1px dashed #999;border-radius:4px;
                        display:flex;align-items:center;justify-content:center;
                        font-size:.75rem;color:#888;">
                [ Logo / Título SIIA ]
            </div>

            <p style="font-size:.7rem;text-transform:uppercase;letter-spacing:.1em;color:#999;margin:0;">
                Orientación
            </p>

            <h1 style="font-size:1.4rem;font-weight:700;color:#222;margin:0;line-height:1.3;">
                Descubre tu casa académica
            </h1>

            <p style="font-size:.85rem;color:#555;max-width:300px;line-height:1.6;margin:0;">
                La garrita seleccionadora analizará las características de tu perfil intelectual,
                para revelar la casa cuya filosofía y competencias convergen con tu trayectoria.
            </p>

            <div>
                <button onclick="goToStage(2)"
                        style="padding:.45rem 1.4rem;border:1px solid #333;border-radius:4px;
                               font-size:.85rem;font-weight:600;color:#333;
                               background:#fff;cursor:pointer;">
                    Iniciar navegación
                </button>
            </div>
        </div>

        <div style="background:#f0f0f0;display:flex;align-items:center;
                    justify-content:center;min-height:280px;">
            <div style="width:200px;height:220px;background:#ddd;
                        border:1px dashed #999;border-radius:4px;
                        display:flex;flex-direction:column;align-items:center;
                        justify-content:center;gap:.4rem;
                        font-size:.75rem;color:#888;text-align:center;padding:1rem;">
                <span style="font-size:1.8rem;"></span>
                [ Imagen de garrita ]
            </div>
        </div>
    </section>

</div>

{{-- ETAPA 2: Pregunta --}}
<div id="stage-2" class="stage" style="display:none;">

    <section style="border:1px solid #ccc;border-radius:6px;
                    padding:2.5rem 2rem;margin-bottom:1.5rem;background:#fff;
                    display:flex;flex-direction:column;align-items:center;gap:1.5rem;
                    min-height:420px;position:relative;">

        <div style="position:absolute;top:1rem;right:1.5rem;
                    font-size:.65rem;color:#bbb;letter-spacing:.06em;text-align:right;line-height:1.7;">
            Fondo cósmico con<br>transparencia /<br>partículas animadas
        </div>

        <div style="text-align:center;">
            <div style="font-size:1.1rem;font-weight:700;color:#333;letter-spacing:.05em;">SIIA</div>
            <p style="font-size:.65rem;text-transform:uppercase;letter-spacing:.15em;color:#aaa;margin:.2rem 0 0;">[Pregunta]</p>
        </div>

        <div style="display:flex;align-items:center;gap:1.5rem;">
            <button style="width:34px;height:34px;border:1px solid #ccc;background:#fff;
                           border-radius:50%;font-size:1.1rem;color:#555;cursor:pointer;">‹</button>

            <div style="width:200px;height:200px;background:#e8e8e8;
                        border:1px dashed #bbb;border-radius:4px;
                        display:flex;align-items:center;justify-content:center;
                        font-size:.75rem;color:#999;text-align:center;padding:1rem;">
                [ Imagen de<br>referencia ]
            </div>

            <button style="width:34px;height:34px;border:1px solid #ccc;background:#fff;
                           border-radius:50%;font-size:1.1rem;color:#555;cursor:pointer;">›</button>
        </div>

        <p style="font-size:.7rem;text-transform:uppercase;letter-spacing:.12em;color:#bbb;margin:0;">[Opción]</p>

        <button onclick="goToStage(3)"
                style="padding:.45rem 1.8rem;border:1px solid #333;border-radius:4px;
                       font-size:.85rem;font-weight:600;color:#333;
                       background:#fff;cursor:pointer;">
            Siguiente
        </button>
    </section>

</div>

{{-- ETAPA 3: Procesando --}}
<div id="stage-3" class="stage" style="display:none;">

    <section style="border:1px solid #ccc;border-radius:6px;
                    padding:2.5rem 2rem;margin-bottom:1.5rem;background:#fff;
                    display:flex;flex-direction:column;align-items:center;gap:1.5rem;
                    min-height:420px;position:relative;">

        <div style="position:absolute;top:1rem;right:1.5rem;
                    font-size:.65rem;color:#bbb;letter-spacing:.06em;text-align:right;line-height:1.7;">
            Fondo cósmico con<br>transparencia /<br>partículas animadas
        </div>

        <div style="font-size:1.1rem;font-weight:700;color:#333;letter-spacing:.05em;">SIIA</div>

        <p style="font-size:.8rem;color:#888;letter-spacing:.08em;text-align:center;margin:0;">
            La garrita está seleccionando<br>tu camino…
        </p>

        <div style="width:220px;height:220px;background:#e8e8e8;
                    border:1px dashed #bbb;border-radius:4px;
                    display:flex;flex-direction:column;align-items:center;
                    justify-content:center;gap:.4rem;
                    font-size:.75rem;color:#999;text-align:center;padding:1rem;">
            <span style="font-size:2rem;"></span>
            [ Imagen de garrita<br>[Animada] ]
        </div>

        <button onclick="goToStage(4)"
                style="padding:.45rem 1.8rem;border:1px solid #333;border-radius:4px;
                       font-size:.85rem;font-weight:600;color:#333;
                       background:#fff;cursor:pointer;">
            Siguiente
        </button>
    </section>

</div>

{{-- ETAPA 4: Resultado --}}
<div id="stage-4" class="stage" style="display:none;">

    <section style="display:grid;grid-template-columns:1fr 1fr;
                    border:1px solid #ccc;border-radius:6px;
                    overflow:hidden;margin-bottom:1.5rem;min-height:320px;">

        <div style="background:#f0f0f0;display:flex;align-items:center;
                    justify-content:center;min-height:280px;">
            <div style="width:220px;height:240px;background:#ddd;
                        border:1px dashed #999;border-radius:4px;
                        display:flex;flex-direction:column;align-items:center;
                        justify-content:center;gap:.4rem;
                        font-size:.75rem;color:#888;text-align:center;padding:1rem;">
                <span style="font-size:1.8rem;">🛡</span>
                [ Logo de<br>casa resultante ]
            </div>
        </div>

        <div style="padding:2rem;display:flex;flex-direction:column;
                    justify-content:center;gap:.9rem;
                    border-left:1px solid #ccc;background:#fff;">

            <div style="font-size:1.1rem;font-weight:700;color:#333;letter-spacing:.05em;">SIIA</div>

            <p style="font-size:.75rem;color:#999;text-transform:uppercase;letter-spacing:.1em;margin:0;">
                Las características de tu perfil apuntan hacia:
            </p>

            <h2 style="font-size:1.8rem;font-weight:700;color:#222;margin:0;letter-spacing:.06em;">
                CASA X
            </h2>

            <p style="font-size:.9rem;color:#777;font-style:italic;margin:0;">
                "Frase representativa"
            </p>

            <p style="font-size:.8rem;color:#666;line-height:1.6;margin:0;max-width:280px;">
                Ejemplo: 
            </p>

            <div style="display:flex;gap:.75rem;">
                <a href="{{ route('welcome') }}"
                   style="padding:.45rem 1.2rem;border:1px solid #333;border-radius:4px;
                          font-size:.85rem;font-weight:600;color:#333;
                          text-decoration:none;background:#fff;">
                    Inicio
                </a>
                <button onclick="goToStage(1)"
                        style="padding:.45rem 1.2rem;border:1px solid #aaa;border-radius:4px;
                               font-size:.85rem;color:#555;background:#fff;cursor:pointer;">
                    Repetir
                </button>
            </div>
        </div>
    </section>

</div>

{{-- ═══ FOOTER PLACEHOLDER ════════════════════════════════════════════════ --}}
<footer style="border:1px solid #ccc;border-radius:6px;
               padding:2rem;background:#f0f0f0;text-align:center;
               color:#aaa;font-size:.85rem;letter-spacing:.08em;">
    [ FOOTER ]
</footer>

@endsection

@section('extra-js')
<script>
function goToStage(n) {
    document.querySelectorAll('.stage').forEach(s => s.style.display = 'none');
    document.getElementById('stage-' + n).style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endsection