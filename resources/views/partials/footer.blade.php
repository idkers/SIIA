{{-- FOOTER --}}
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

    .footer-acerca-link {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        margin-top: 1rem;
        color: #E8C96A;
        text-decoration: none;
        font-size: .85rem;
        letter-spacing: .04em;
        border-bottom: 1px solid rgba(200,168,75,.35);
        padding-bottom: 2px;
        transition: color .2s, border-color .2s;
    }
    .footer-acerca-link:hover {
        color: #fff;
        border-color: #fff;
    }

    @media (max-width: 600px) {
        #footer-casas {
            padding: 2.5rem 1.25rem;
        }

        #footer-casas-grid {
            flex-direction: column;
            gap: 2rem;
        }

        #footer-casas-grid > div {
            max-width: 100% !important;
        }

        #footer-casas-grid h3 {
            font-size: 1.1rem !important;
        }
    }
</style>

<footer id="footer-casas">
    <div id="footer-casas-grid">
        <div style="text-align:left;max-width:400px;">
            <h3 style="
                font-family:'Headland One',serif;
                color:#C8A84B;
                margin-bottom:1rem;
                font-size:1.4rem;
            ">
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
            <h3 style="
                font-family:'Headland One',serif;
                color:#C8A84B;
                margin-bottom:1rem;
                font-size:1.4rem;
            ">
                Sobre NOVA
            </h3>

            <p style="color:#F0EAD8;line-height:1.8;margin:0;">
                Navegador de Orientación Vocacional y Aptitudes de la UTL.
                Descubre la casa académica que mejor representa tus
                intereses, habilidades y visión profesional a través de
                un quiz interactivo.
            </p>

            <a href="{{ route('acerca') }}" class="footer-acerca-link">
                Conoce más acerca de la página
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
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
        © {{ date('Y') }} NOVA · Navegador de Orientación Vocacional y Aptitudes
    </div>
</footer>