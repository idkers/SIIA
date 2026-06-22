<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Headland+One&family=Cinzel:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        nav {
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        footer {
            position: relative;
            z-index: 2;
            isolation: isolate;
        }

        @media (max-width: 768px) {
            nav {
                flex-wrap: wrap;
                gap: .75rem;
                padding: .75rem 1rem !important;
            }
            nav > div:first-of-type {
                order: 3;
                width: 100%;
                justify-content: center;
                gap: 1rem !important;
                flex-wrap: wrap;
            }
            #hero { height: auto !important; min-height: 100svh; }
            #hero > div:last-of-type {
                width: 100% !important;
                padding: 6rem 1.5rem 3rem !important;
                align-items: center !important;
            }
            #hero h1 { font-size: clamp(5rem,22vw,9rem) !important; }
            #hero p  { text-align: center !important; font-size:.85rem !important; }
            #hero > div:last-of-type > div {
                flex-direction: column !important;
                width: 100%;
            }
            #hero > div:last-of-type > div > a {
                text-align: center !important;
                width: 100% !important;
            }
            #identidad { padding: 2rem 1.25rem !important; }
            #identidad > div:first-of-type {
                flex-direction: column !important;
                align-items: center !important;
            }
            #dominios  { padding: 2rem 1.25rem !important; }
            #carousel  { grid-template-columns: 1fr !important; }
            footer     { padding: 2rem 1.25rem !important; }
            footer > div:first-of-type {
                flex-direction: column !important;
                align-items: center !important;
                text-align: center !important;
            }
            footer > div:first-of-type > div {
                text-align: center !important;
                max-width: 100% !important;
            }
        }

        @media (max-width: 1024px) {
            #hero > div:last-of-type { width: 65% !important; }
            #carousel { grid-template-columns: repeat(2,1fr) !important; }
            #dominios { padding: 2rem 1.5rem !important; }
        }
    </style>
</head>
<body style="background:#06060F;color:white;margin:0;padding:0;">

    <div>
        @yield('content')
    </div>

    @stack('extra-js')

</body>
</html>