@extends('layouts.app')
@section('title', 'Ingresar — NOVA')

@section('content')

<style>
    *, *::before, *::after { box-sizing: border-box; }

    /* ── Layout ── */
    .login-page {
        min-height: calc(100vh - 88px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1.25rem;
        background: transparent;
        position: relative;
        overflow: hidden;
    }

    /* Fondo decorativo */
    .login-page::before {
        content: '';
        position: absolute;
        top: -200px; right: -200px;
        width: 600px; height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(200,168,75,.06) 0%, transparent 70%);
        pointer-events: none;
    }
    .login-page::after {
        content: '';
        position: absolute;
        bottom: -150px; left: -150px;
        width: 500px; height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(66,15,219,.05) 0%, transparent 70%);
        pointer-events: none;
    }

    /* ── Card ── */
    .login-card {
        background: #14141F;
        border: 1px solid rgba(200,168,75,.2);
        border-radius: 20px;
        width: 100%;
        max-width: 440px;
        padding: 2.75rem 2.5rem;
        position: relative;
        z-index: 1;
        box-shadow: 0 0 60px rgba(0,0,0,.4);
    }

    /* Franja dorada superior */
    .login-card::before {
        content: '';
        position: absolute;
        top: 0; left: 2rem; right: 2rem;
        height: 2px;
        background: linear-gradient(to right, transparent, #C8A84B, transparent);
        border-radius: 2px;
    }

    /* ── Logo ── */
    .login-logo {
        display: flex;
        justify-content: center;
        margin-bottom: 1.75rem;
    }
    .login-logo img {
        height: 3.5rem;
        width: auto;
    }

    /* ── Títulos ── */
    .login-title {
        font-family: 'Headland One', serif;
        color: #FFFFFF;
        font-size: 1.5rem;
        text-align: center;
        margin: 0 0 .35rem;
        letter-spacing: .04em;
    }
    .login-subtitle {
        color: #707085;
        font-size: .8rem;
        text-align: center;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin: 0 0 2rem;
    }

    /* ── Formulario ── */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: .45rem;
        margin-bottom: 1.25rem;
    }
    .form-label {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: #B0A898;
    }

    .input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-icon {
        position: absolute;
        left: .9rem;
        color: #4A3560;
        display: flex;
        align-items: center;
        pointer-events: none;
        transition: color .2s;
    }
    .form-input {
        width: 100%;
        background: #0D0D1A;
        border: 1px solid #2B1F3D;
        border-radius: 8px;
        padding: .75rem .9rem .75rem 2.6rem;
        color: #F0EAD8;
        font-size: .92rem;
        font-family: inherit;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
    .form-input::placeholder { color: #3D3550; }
    .form-input:focus {
        border-color: #C8A84B;
        box-shadow: 0 0 0 3px rgba(200,168,75,.1);
    }
    .form-input:focus + .input-focus-icon,
    .input-wrap:focus-within .input-icon { color: #C8A84B; }

    /* Toggle contraseña */
    .toggle-pass {
        position: absolute;
        right: .9rem;
        background: none;
        border: none;
        color: #4A3560;
        cursor: pointer;
        display: flex;
        align-items: center;
        padding: 0;
        transition: color .2s;
    }
    .toggle-pass:hover { color: #C8A84B; }

    /* Nota de dominio */
    .domain-hint {
        font-size: .75rem;
        color: #4A3560;
        margin-top: .3rem;
        padding-left: .25rem;
    }
    .domain-hint span {
        color: #8D6627;
        font-style: italic;
    }

    /* Error */
    .field-error {
        font-size: .75rem;
        color: #E05252;
        margin-top: .3rem;
        padding-left: .25rem;
        display: none;
    }
    .field-error.visible { display: block; }
    .form-input.error { border-color: #E05252; }
    .form-input.error:focus { box-shadow: 0 0 0 3px rgba(224,82,82,.1); }

    /* ── Botón principal ── */
    .btn-login {
        width: 100%;
        padding: .9rem;
        background: linear-gradient(135deg, #C6A050, #8D6627);
        border: none;
        border-radius: 8px;
        color: #1A1000;
        font-size: 1rem;
        font-weight: 700;
        font-family: inherit;
        letter-spacing: .04em;
        cursor: pointer;
        transition: opacity .2s, transform .15s;
        margin-top: .5rem;
    }
    .btn-login:hover  { opacity: .9; }
    .btn-login:active { transform: scale(.98); }

    /* ── Divisor ── */
    .divider {
        display: flex;
        align-items: center;
        gap: .75rem;
        margin: 1.5rem 0;
    }
    .divider::before, .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #2B1F3D;
    }
    .divider span {
        font-size: .72rem;
        color: #4A3560;
        text-transform: uppercase;
        letter-spacing: .1em;
        white-space: nowrap;
    }

    /* ── Registro ── */
    .register-prompt {
        text-align: center;
        font-size: .83rem;
        color: #707085;
    }
    .register-prompt a {
        color: #E8C96A;
        text-decoration: none;
        font-weight: 600;
    }
    .register-prompt a:hover { color: #fff; }

    /* ── Info alumno nuevo ── */
    .new-student-note {
        margin-top: 1.5rem;
        padding: .85rem 1rem;
        background: rgba(200,168,75,.05);
        border: 1px solid rgba(200,168,75,.12);
        border-radius: 8px;
        font-size: .78rem;
        color: #707085;
        line-height: 1.6;
        text-align: center;
    }
    .new-student-note strong { color: #C8A84B; }

    /* ── Footer ── */
    #footer-casas {
        padding: 3rem 4rem;
        background: #06060F;
        border-top: 1px solid #2B1F3D;
    }
    #footer-casas-grid {
        display: flex; justify-content:space-around; flex-wrap:wrap; gap:3rem;
    }

    @media (max-width: 600px) {
        .login-card { padding: 2rem 1.5rem; }
        #footer-casas { padding: 2.5rem 1.25rem; }
        #footer-casas-grid { flex-direction:column; gap:2rem; }
        #footer-casas-grid > div { max-width:100% !important; }
    }
</style>

{{-- ═══ NAVBAR ══════════════════════════════════════════════════════════════ --}}
@include('partials.navbar')

{{-- ═══ LOGIN ═══════════════════════════════════════════════════════════════ --}}
<div class="login-page">
    <div class="login-card">

        {{-- Logo --}}
        <div class="login-logo">
            <img src="{{ asset('imagenes/isotipo_dorado.webp') }}" alt="UTL SIIA">
        </div>

        <h1 class="login-title">Bienvenido de vuelta</h1>
        <p class="login-subtitle">Navegador de Orientación Vocacional y Aptitudes</p>

        {{-- Mensajes de error del servidor --}}
        @if(session('error'))
        <div style="background:rgba(224,82,82,.1);border:1px solid rgba(224,82,82,.3);
                    border-radius:8px;padding:.75rem 1rem;margin-bottom:1.25rem;
                    font-size:.83rem;color:#E05252;text-align:center;">
            {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div style="background:rgba(75,200,100,.1);border:1px solid rgba(75,200,100,.3);
                    border-radius:8px;padding:.75rem 1rem;margin-bottom:1.25rem;
                    font-size:.83rem;color:#4BC864;text-align:center;">
            {{ session('success') }}
        </div>
        @endif

        {{-- Formulario --}}
        <form method="POST" action="{{ route('ingresar.post') }}" onsubmit="return validarLogin(event);">
            @csrf

            {{-- Correo --}}
            <div class="form-group">
                <label class="form-label" for="email">Correo</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </span>
                    <input type="text"
                           id="email"
                           name="email"
                           class="form-input @error('email') error @enderror"
                           placeholder="12345@gmail.com"
                           value="{{ old('email') }}"
                           autocomplete="username"
                           inputmode="email">
                </div>
                <p class="domain-hint">
                    Solo se permite correos <span>webmail o institucionales</span>
                </p>
                <span class="field-error @error('email') visible @enderror" id="emailError">
                    @error('email') {{ $message }} @else Ingresa tu correo personal o correo institucional válido. @enderror
                </span>
            </div>

            {{-- Contraseña --}}
            <div class="form-group">
                <label class="form-label" for="password">Contraseña</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                    <input type="password"
                           id="password"
                           name="password"
                           class="form-input @error('password') error @enderror"
                           placeholder="••••••••"
                           autocomplete="current-password">
                    <button type="button" class="toggle-pass"
                            onclick="togglePassword()" aria-label="Mostrar contraseña">
                        <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <span class="field-error @error('password') visible @enderror" id="passError">
                    @error('password') {{ $message }} @else Ingresa tu contraseña. @enderror
                </span>
            </div>

            <div style="display:flex;align-items:center;justify-content:space-between;
                        margin-bottom:1.25rem;flex-wrap:wrap;gap:.5rem;">

                {{-- Enlace a recuperar contraseña (futura implementación) --}}
                <a href="#"
                   style="font-size:.8rem;color:#8D6627;text-decoration:none;
                          letter-spacing:.04em;"
                   onclick="alert('Contacta a soporte: comunicacionutl@utleon.edu.mx'); return false;">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <button type="submit" class="btn-login">
                Ingresar
            </button>

        </form>

        <div class="divider"><span>o</span></div>

        <p class="register-prompt">
            ¿Aún no tienes cuenta?
            <a href="{{ route('registrar') }}">Regístrate aquí</a>
        </p>

    </div>
</div>

{{-- ═══ FOOTER ════════════════════════════════════════════════════════════ --}}
@include('partials.footer')

@endsection

@push('extra-js')
<script>
    // Hamburger
    const btn  = document.getElementById('hamburgerBtn');
    const menu = document.getElementById('mobileMenu');
    const navEl = btn.closest('nav');
    function posicionarMenuMovil() {
        if (navEl) menu.style.top = navEl.getBoundingClientRect().bottom + 'px';
    }
    btn.addEventListener('click', () => {
        posicionarMenuMovil();
        menu.classList.toggle('open');
        btn.setAttribute('aria-expanded', menu.classList.contains('open'));
    });
    document.addEventListener('click', e => {
        if (!btn.contains(e.target) && !menu.contains(e.target))
            menu.classList.remove('open');
    });
    window.addEventListener('resize', posicionarMenuMovil);
    window.addEventListener('scroll', () => {
        if (menu.classList.contains('open')) posicionarMenuMovil();
    });

    // Toggle contraseña
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                <line x1="1" y1="1" x2="23" y2="23"/>`;
        } else {
            input.type = 'password';
            icon.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>`;
        }
    }

    // Validación del correo: acepta matrícula (6-10 dígitos) o cualquier correo válido
    function validarLogin(e) {
        let valido = true;
        const emailInput = document.getElementById('email');
        const passInput  = document.getElementById('password');
        const emailError = document.getElementById('emailError');
        const passError  = document.getElementById('passError');

        // Reset
        emailInput.classList.remove('error');
        passInput.classList.remove('error');
        emailError.classList.remove('visible');
        passError.classList.remove('visible');

        const val = emailInput.value.trim();

        // Acepta: solo números (matrícula) O cualquier correo válido
        // (gmail, outlook, hotmail, institucional @utleon.edu.mx, etc.)
        const esMatricula = /^\d{6,10}$/.test(val);
        const esCorreo    = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i.test(val);

        if (!esMatricula && !esCorreo) {
            emailInput.classList.add('error');
            emailError.textContent = '@gmail.com, @utleon.edu.mx, @outlook.com, etc.';
            emailError.classList.add('visible');
            valido = false;
        }

        if (!passInput.value) {
            passInput.classList.add('error');
            passError.textContent = 'Ingresa tu contraseña.';
            passError.classList.add('visible');
            valido = false;
        }

        // Si solo pusieron matrícula, convertir a correo antes de enviar
        if (valido && esMatricula) {
            emailInput.value = val + '@utleon.edu.mx';
        }

        return valido;
    }
</script>
@endpush