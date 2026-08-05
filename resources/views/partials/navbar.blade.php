<style>
    .siia-navbar {
        display: flex;
        align-items: center;
        padding: 1.6rem 2rem;
        background: rgba(6, 6, 15, .6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .siia-navbar-logo {
        height: 2.6rem;
        flex-shrink: 0;
    }

    .siia-navbar-links {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 2.4rem;
    }

    .siia-navbar-links a,
    .siia-navbar-button {
        color: #B0A898;
        text-decoration: none;
        font-size: .88rem;
        letter-spacing: .08em;
        text-transform: uppercase;
        transition: color .25s;
    }

    .siia-navbar-links a:hover,
    .siia-navbar-links a.activo,
    .siia-navbar-button:hover {
        color: #E8C96A;
    }

    .siia-navbar-user {
        color: #E8C96A;
        font-size: .82rem;
        letter-spacing: .05em;
        white-space: nowrap;
    }

    .siia-navbar-house {
        display: flex;
        align-items: center;
        gap: .55rem;
        color: #E8C96A;
        white-space: nowrap;
    }

    .siia-navbar-house-img {
        width: 34px;
        height: 34px;
        object-fit: contain;
        border-radius: 50%;
        background: rgba(13, 13, 26, .8);
        border: 1px solid rgba(200, 168, 75, .35);
        padding: 3px;
        box-sizing: border-box;
    }

    .siia-navbar-house-name {
        color: #E8C96A;
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .siia-navbar-form {
        display: inline;
        margin: 0;
    }

    .siia-navbar-button {
        background: none;
        border: none;
        padding: 0;
        font-family: inherit;
        cursor: pointer;
    }

    .siia-hamburger {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        padding: .25rem;
        flex-direction: column;
        gap: 5px;
    }

    .siia-hamburger span {
        display: block;
        width: 22px;
        height: 2px;
        background: #C8A84B;
        border-radius: 2px;
    }

    .siia-mobile-menu {
        display: none;
        flex-direction: column;
        gap: 0;
        position: fixed;
        left: 0;
        right: 0;
        top: 0;
        z-index: 99;
        max-height: calc(100vh - 70px);
        overflow-y: auto;
        background: rgba(6, 6, 15, .97);
        padding: .5rem 0;
    }

    .siia-mobile-menu.open {
        display: flex;
    }

    .siia-mobile-menu a,
    .siia-mobile-button,
    .siia-mobile-user {
        display: block;
        width: 100%;
        padding: .75rem 2rem;
        font-size: .85rem;
        color: #B0A898;
        text-decoration: none;
        letter-spacing: .08em;
        text-transform: uppercase;
        border: none;
        border-bottom: 1px solid rgba(43, 31, 61, .4);
        background: transparent;
        font-family: inherit;
        text-align: left;
        box-sizing: border-box;
    }

    .siia-mobile-menu a.activo {
        color: #E8C96A;
    }

    .siia-mobile-button {
        cursor: pointer;
    }

    .siia-mobile-button:hover {
        color: #E8C96A;
    }

    .siia-mobile-user {
        color: #E8C96A;
        cursor: default;
    }

    .siia-mobile-house {
        display: flex;
        align-items: center;
        gap: .75rem;
        width: 100%;
        padding: .75rem 2rem;
        border-bottom: 1px solid rgba(43, 31, 61, .4);
        box-sizing: border-box;
    }

    .siia-mobile-house-img {
        width: 42px;
        height: 42px;
        object-fit: contain;
        border-radius: 50%;
        background: rgba(13, 13, 26, .8);
        border: 1px solid rgba(200, 168, 75, .35);
        padding: 4px;
        box-sizing: border-box;
        flex-shrink: 0;
    }

    .siia-mobile-house-info {
        display: flex;
        flex-direction: column;
        gap: .15rem;
    }

    .siia-mobile-house-label {
        color: #707085;
        font-size: .62rem;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .siia-mobile-house-name {
        color: #E8C96A;
        font-size: .85rem;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .siia-mobile-form {
        margin: 0;
    }

    .siia-mobile-menu > :last-child,
    .siia-mobile-menu > form:last-child .siia-mobile-button {
        border-bottom: none;
    }

    @media (max-width: 1150px) {
        .siia-navbar-links {
            gap: 1.4rem;
        }

        .siia-navbar-links a,
        .siia-navbar-button {
            font-size: .78rem;
        }

        .siia-navbar-user {
            font-size: .75rem;
        }

        .siia-navbar-house-name {
            font-size: .7rem;
        }

        .siia-navbar-house-img {
            width: 31px;
            height: 31px;
        }
    }

    @media (max-width: 900px) {
        .siia-navbar-links {
            gap: 1rem;
        }

        .siia-navbar-links a,
        .siia-navbar-button {
            font-size: .72rem;
        }

        .siia-navbar-house-name {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .siia-navbar {
            padding: .75rem 1rem;
        }

        .siia-navbar-links {
            display: none !important;
        }

        .siia-hamburger {
            display: flex !important;
            margin-left: auto;
        }
    }
</style>

@php
    $resultadoNavbar = null;

    if (auth()->check()) {
        $resultadoNavbar = auth()
            ->user()
            ->resultado()
            ->with('casa')
            ->first();
    }
@endphp

<nav class="siia-navbar" id="siiaNavbar">
    <a href="{{ route('welcome') }}" aria-label="Ir al inicio">
        <img
            src="{{ asset('imagenes/isotipo_dorado.webp') }}"
            alt="UTL"
            class="siia-navbar-logo"
        >
    </a>

    <div class="siia-navbar-links">

        {{-- Saludo de bienvenida: extremo izquierdo del menú --}}
        @auth
            <span class="siia-navbar-user">
                Hola, {{ auth()->user()->name }}
            </span>
        @endauth

        <a
            href="{{ route('welcome') }}"
            class="{{ request()->routeIs('welcome') ? 'activo' : '' }}"
        >
            Inicio
        </a>

        @guest
            <a
                href="{{ route('quiz') }}"
                class="{{ request()->routeIs('quiz') ? 'activo' : '' }}"
            >
                Quiz
            </a>
        @endguest

        @auth
            @if(!$resultadoNavbar)
                <a
                    href="{{ route('quiz') }}"
                    class="{{ request()->routeIs('quiz') ? 'activo' : '' }}"
                >
                    Quiz
                </a>
            @endif
        @endauth

        <a
            href="{{ route('recorrido') }}"
            class="{{ request()->routeIs('recorrido') ? 'activo' : '' }}"
        >
            Recorrido
        </a>

        <a
            href="{{ route('dominios') }}"
            class="{{ request()->routeIs('dominios') ? 'activo' : '' }}"
        >
            Dominios
        </a>

        <a
            href="{{ route('casas') }}"
            class="{{ request()->routeIs('casas') ? 'activo' : '' }}"
        >
            Casas
        </a>

        @guest
            <a
                href="{{ route('ingresar') }}"
                class="{{ request()->routeIs('ingresar') ? 'activo' : '' }}"
            >
                Ingresar
            </a>

            <a
                href="{{ route('registrar') }}"
                class="{{ request()->routeIs('registrar') ? 'activo' : '' }}"
            >
                Registrarse
            </a>
        @endguest

        @auth
            @if(auth()->user()->rol === 'admin')
                <a
                    href="{{ route('admin') }}"
                    class="{{ request()->routeIs('admin') ? 'activo' : '' }}"
                >
                    Panel
                </a>
            @endif

            {{-- Casa: entre "Casas" y "Cerrar sesión", extremo derecho --}}
            @if($resultadoNavbar && $resultadoNavbar->casa)
                <div class="siia-navbar-house">
                    <img
                        src="{{ asset($resultadoNavbar->casa->imagen) }}"
                        alt="{{ $resultadoNavbar->casa->nombre_casa }}"
                        class="siia-navbar-house-img"
                    >

                    <span class="siia-navbar-house-name">
                        {{ $resultadoNavbar->casa->nombre_casa }}
                    </span>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('salir') }}"
                class="siia-navbar-form"
            >
                @csrf

                <button
                    type="submit"
                    class="siia-navbar-button"
                >
                    Cerrar sesión
                </button>
            </form>
        @endauth
    </div>

    <button
        type="button"
        class="siia-hamburger"
        id="siiaHamburgerBtn"
        aria-label="Abrir menú"
        aria-expanded="false"
        aria-controls="siiaMobileMenu"
    >
        <span></span>
        <span></span>
        <span></span>
    </button>
</nav>

<div class="siia-mobile-menu" id="siiaMobileMenu">

    {{-- Saludo de bienvenida --}}
    @auth
        <span class="siia-mobile-user">
            Hola, {{ auth()->user()->name }}
        </span>

         {{-- Casa--}}
        @if($resultadoNavbar && $resultadoNavbar->casa)
            <div class="siia-mobile-house">
                <img
                    src="{{ asset($resultadoNavbar->casa->imagen) }}"
                    alt="{{ $resultadoNavbar->casa->nombre_casa }}"
                    class="siia-mobile-house-img"
                >

                <div class="siia-mobile-house-info">
                    <span class="siia-mobile-house-label">
                        Tu casa
                    </span>

                    <span class="siia-mobile-house-name">
                        {{ $resultadoNavbar->casa->nombre_casa }}
                    </span>
                </div>
            </div>
        @endif

    @endauth

    <a
        href="{{ route('welcome') }}"
        class="{{ request()->routeIs('welcome') ? 'activo' : '' }}"
    >
        Inicio
    </a>

    @guest
        <a
            href="{{ route('quiz') }}"
            class="{{ request()->routeIs('quiz') ? 'activo' : '' }}"
        >
            Quiz
        </a>
    @endguest

    @auth
        @if(!$resultadoNavbar)
            <a
                href="{{ route('quiz') }}"
                class="{{ request()->routeIs('quiz') ? 'activo' : '' }}"
            >
                Quiz
            </a>
        @endif
    @endauth

    <a
        href="{{ route('recorrido') }}"
        class="{{ request()->routeIs('recorrido') ? 'activo' : '' }}"
    >
        Recorrido
    </a>

    <a
        href="{{ route('dominios') }}"
        class="{{ request()->routeIs('dominios') ? 'activo' : '' }}"
    >
        Dominios
    </a>

    <a
        href="{{ route('casas') }}"
        class="{{ request()->routeIs('casas') ? 'activo' : '' }}"
    >
        Casas
    </a>

    @guest
        <a
            href="{{ route('ingresar') }}"
            class="{{ request()->routeIs('ingresar') ? 'activo' : '' }}"
        >
            Ingresar
        </a>

        <a
            href="{{ route('registrar') }}"
            class="{{ request()->routeIs('registrar') ? 'activo' : '' }}"
        >
            Registrarse
        </a>
    @endguest

    @auth
       

        @if(auth()->user()->rol === 'admin')
            <a
                href="{{ route('admin') }}"
                class="{{ request()->routeIs('admin') ? 'activo' : '' }}"
            >
                Panel administrativo
            </a>
        @endif

        <form
            method="POST"
            action="{{ route('salir') }}"
            class="siia-mobile-form"
        >
            @csrf

            <button
                type="submit"
                class="siia-mobile-button"
            >
                Cerrar sesión
            </button>
        </form>
    @endauth
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const hamburgerBtn = document.getElementById('siiaHamburgerBtn');
        const mobileMenu = document.getElementById('siiaMobileMenu');
        const navbar = document.getElementById('siiaNavbar');

        if (!hamburgerBtn || !mobileMenu || !navbar) {
            return;
        }

        function posicionarMenuMovil() {
            mobileMenu.style.top =
                navbar.getBoundingClientRect().bottom + 'px';
        }

        function cerrarMenuMovil() {
            mobileMenu.classList.remove('open');
            hamburgerBtn.setAttribute('aria-expanded', 'false');
        }

        hamburgerBtn.addEventListener('click', (event) => {
            event.stopPropagation();

            posicionarMenuMovil();
            mobileMenu.classList.toggle('open');

            hamburgerBtn.setAttribute(
                'aria-expanded',
                mobileMenu.classList.contains('open')
            );
        });

        document.addEventListener('click', (event) => {
            if (
                !hamburgerBtn.contains(event.target) &&
                !mobileMenu.contains(event.target)
            ) {
                cerrarMenuMovil();
            }
        });

        mobileMenu.querySelectorAll('a').forEach((enlace) => {
            enlace.addEventListener('click', cerrarMenuMovil);
        });

        window.addEventListener('resize', () => {
            posicionarMenuMovil();

            if (window.innerWidth > 768) {
                cerrarMenuMovil();
            }
        });

        window.addEventListener('scroll', () => {
            if (mobileMenu.classList.contains('open')) {
                posicionarMenuMovil();
            }
        });
    });
</script>