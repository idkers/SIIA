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
        /* ══════════════════════════════════════════════════════
           RESET Y BASE
           ══════════════════════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; }

        html { height: 100%; }

        body {
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            flex-direction: column;
            background: #06060F;
            color: #F0EAD8;
            margin: 0;
            padding: 0;
            font-family: system-ui, -apple-system, sans-serif;
            /* Evita scroll horizontal en móvil */
            overflow-x: hidden;
        }

        #siia-particles {
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
        }

        #siia-content {
            position: relative;
            z-index: 1;
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
            /* Nunca desborda horizontalmente */
            overflow-x: hidden;
            width: 100%;
        }

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
            flex-shrink: 0;
        }

        img { max-width: 100%; height: auto; }

        /* ══════════════════════════════════════════════════════
           NAVBAR GLOBAL — aplica a todas las páginas
           ══════════════════════════════════════════════════════ */
        .siia-nav {
            display: flex;
            align-items: center;
            padding: 1.1rem 2rem;
            background: rgba(6,6,15,0.65);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            position: sticky;
            top: 0;
            z-index: 100;
            isolation: isolate;
        }

        .siia-nav-logo {
            height: 2.4rem;
            width: auto;
            display: block;
            flex-shrink: 0;
        }

        .nav-links {
            flex: 1;
            display: flex;
            justify-content: center;
            gap: 2.5rem;
        }

        .nav-links a {
            color: #B0A898;
            text-decoration: none;
            font-size: .85rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            transition: color .2s;
            white-space: nowrap;
        }

        .nav-links a:hover,
        .nav-links a.active { color: #E8C96A; }

        .nav-auth {
            display: flex;
            align-items: center;
            gap: .75rem;
            flex-shrink: 0;
        }

        .nav-auth a {
            font-size: .85rem;
            color: #B0A898;
            text-decoration: none;
            letter-spacing: .08em;
            text-transform: uppercase;
            transition: color .2s;
        }

        .nav-auth a:hover { color: #E8C96A; }

        /* Hamburger */
        .hamburger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: .35rem;
            flex-direction: column;
            gap: 5px;
            margin-left: auto;
        }

        .hamburger span {
            display: block;
            width: 24px;
            height: 2px;
            background: #C8A84B;
            border-radius: 2px;
            transition: transform .3s, opacity .3s;
        }

        /* Menú móvil desplegable */
        .mobile-menu {
            display: none;
            flex-direction: column;
            background: rgba(6,6,15,0.98);
            border-bottom: 1px solid rgba(43,31,61,0.6);
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .mobile-menu a {
            display: block;
            padding: 1rem 1.5rem;
            font-size: .9rem;
            color: #B0A898;
            text-decoration: none;
            letter-spacing: .08em;
            text-transform: uppercase;
            border-bottom: 1px solid rgba(43,31,61,0.35);
            transition: background .15s, color .15s;
        }

        .mobile-menu a:last-child { border-bottom: none; }
        .mobile-menu a:hover, .mobile-menu a.active { color: #E8C96A; background: rgba(200,168,75,.05); }
        .mobile-menu.open { display: flex; }

        /* ══════════════════════════════════════════════════════
           FOOTER GLOBAL
           ══════════════════════════════════════════════════════ */
        .siia-footer {
            padding: 3rem 4rem;
            background: #06060F;
            border-top: 1px solid #2B1F3D;
        }

        .siia-footer-grid {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 3rem;
        }

        .siia-footer h3 {
            font-family: 'Headland One', serif;
            color: #C8A84B;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .siia-footer p {
            color: #F0EAD8;
            line-height: 1.8;
            margin: 0;
            font-size: .9rem;
        }

        .siia-footer-copy {
            margin-top: 2.5rem;
            border-top: 1px solid rgba(200,168,75,.15);
            padding-top: 1.5rem;
            text-align: center;
            color: #707085;
            font-size: .78rem;
            letter-spacing: .08em;
        }

        /* ══════════════════════════════════════════════════════
           TARJETAS / CARDS COMPARTIDAS
           ══════════════════════════════════════════════════════ */
        .casa-card, .dominio-card {
            background: #14141F;
            border: 1px solid rgba(200,168,75,.15);
            border-radius: 16px;
            overflow: hidden;
            transition: border-color .3s, box-shadow .3s;
        }

        .casa-card:hover, .dominio-card:hover {
            border-color: rgba(200,168,75,.7);
            box-shadow: 0 0 0 1px rgba(200,168,75,.3), 0 0 18px rgba(200,168,75,.12);
        }

        /* ══════════════════════════════════════════════════════
           BOTONES COMPARTIDOS
           ══════════════════════════════════════════════════════ */
        .btn-gold {
            display: inline-block;
            padding: .85rem 2.5rem;
            background: linear-gradient(135deg, #C6A050, #8D6627);
            border: none;
            border-radius: 6px;
            color: #1A1000;
            font-weight: 700;
            font-size: .95rem;
            letter-spacing: .04em;
            text-decoration: none;
            cursor: pointer;
            transition: opacity .2s, transform .15s;
            font-family: inherit;
        }

        .btn-gold:hover  { opacity: .9; }
        .btn-gold:active { transform: scale(.97); }

        .btn-outline {
            display: inline-block;
            padding: .85rem 2.5rem;
            border: 1px solid #7A6030;
            border-radius: 6px;
            color: #E8E0D0;
            background: transparent;
            font-size: .95rem;
            text-decoration: none;
            cursor: pointer;
            transition: border-color .2s, color .2s;
            font-family: inherit;
        }

        .btn-outline:hover { border-color: #C8A84B; color: #E8C96A; }

        /* ══════════════════════════════════════════════════════
           RESPONSIVE — TABLET ≤ 900px
           ══════════════════════════════════════════════════════ */
        @media (max-width: 900px) {
            .siia-footer { padding: 2.5rem 2rem; }
        }

        /* ══════════════════════════════════════════════════════
           RESPONSIVE — MÓVIL ≤ 768px
           ══════════════════════════════════════════════════════ */
        @media (max-width: 768px) {
            /* Navbar */
            .siia-nav { padding: .85rem 1.25rem; }
            .nav-links { display: none !important; }
            .nav-auth  { display: none !important; }
            .hamburger { display: flex !important; }

            /* Footer */
            .siia-footer { padding: 2.5rem 1.25rem; }
            .siia-footer-grid {
                flex-direction: column;
                gap: 2rem;
                align-items: flex-start;
            }
            .siia-footer-grid > div { max-width: 100% !important; }
            .siia-footer h3 { font-size: 1.1rem; }

            /* Botones full-width en mobile */
            .btn-gold, .btn-outline { width: 100%; text-align: center; }
        }

        /* ══════════════════════════════════════════════════════
           RESPONSIVE — MÓVIL ≤ 480px
           ══════════════════════════════════════════════════════ */
        @media (max-width: 480px) {
            .siia-nav-logo { height: 2rem; }
        }
    </style>
</head>
<body>

    <canvas id="siia-particles"></canvas>

    <div id="siia-content">
        @yield('content')
    </div>

    @stack('extra-js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
    <script>
    (function () {
        const canvas = document.getElementById('siia-particles');
        const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: false });
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.5));
        renderer.setSize(window.innerWidth, window.innerHeight);

        const scene  = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(65, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 6;

        const sprite = new THREE.CanvasTexture((() => {
            const c = document.createElement('canvas');
            c.width = c.height = 64;
            const ctx = c.getContext('2d');
            const grad = ctx.createRadialGradient(32,32,0, 32,32,32);
            grad.addColorStop(0,   'rgba(255,255,255,1)');
            grad.addColorStop(0.4, 'rgba(255,255,255,0.8)');
            grad.addColorStop(1,   'rgba(255,255,255,0)');
            ctx.fillStyle = grad;
            ctx.fillRect(0,0,64,64);
            return c;
        })());

        const starTypes = [
            { r:1.00, g:0.85, b:0.40, prob:0.30 },
            { r:1.00, g:0.78, b:0.35, prob:0.55 },
            { r:1.00, g:0.90, b:0.55, prob:0.70 },
            { r:1.00, g:0.70, b:0.25, prob:0.82 },
            { r:0.95, g:0.88, b:0.65, prob:0.90 },
            { r:0.80, g:0.65, b:1.00, prob:0.96 },
            { r:1.00, g:0.96, b:0.82, prob:1.00 },
        ];

        const N = 3000;
        const pos = new Float32Array(N * 3);
        const col = new Float32Array(N * 3);
        for (let i = 0; i < N; i++) {
            const spread = Math.random() < 0.35 ? 12 : 32;
            pos[i*3]   = (Math.random()-0.5) * spread;
            pos[i*3+1] = (Math.random()-0.5) * (spread * 0.6);
            pos[i*3+2] = (Math.random()-0.5) * 22;
            const t = Math.random();
            const type = starTypes.find(s => t < s.prob) || starTypes[0];
            const b = 0.7 + Math.random() * 0.3;
            col[i*3]=type.r*b; col[i*3+1]=type.g*b; col[i*3+2]=type.b*b;
        }
        const geo = new THREE.BufferGeometry();
        geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
        geo.setAttribute('color',    new THREE.BufferAttribute(col, 3));
        const stars = new THREE.Points(geo, new THREE.PointsMaterial({
            size: 0.045, vertexColors: true, transparent: true,
            opacity: 0.55, sizeAttenuation: true,
            map: sprite, depthWrite: false
        }));
        scene.add(stars);

        const bN = 120;
        const bPos = new Float32Array(bN * 3);
        const bCol = new Float32Array(bN * 3);
        const bPal = [[1.00,0.90,0.55],[1.00,0.80,0.40],[0.95,0.95,0.88],[0.80,0.65,1.00],[1.00,0.70,0.30]];
        for (let i = 0; i < bN; i++) {
            bPos[i*3]=(Math.random()-0.5)*30; bPos[i*3+1]=(Math.random()-0.5)*20; bPos[i*3+2]=(Math.random()-0.5)*15;
            const c = bPal[Math.floor(Math.random()*bPal.length)];
            bCol[i*3]=c[0]; bCol[i*3+1]=c[1]; bCol[i*3+2]=c[2];
        }
        const bGeo = new THREE.BufferGeometry();
        bGeo.setAttribute('position', new THREE.BufferAttribute(bPos, 3));
        bGeo.setAttribute('color',    new THREE.BufferAttribute(bCol, 3));
        const bright = new THREE.Points(bGeo, new THREE.PointsMaterial({
            size: 0.10, vertexColors: true, transparent: true,
            opacity: 0.95, sizeAttenuation: true,
            map: sprite, depthWrite: false
        }));
        scene.add(bright);

        let mx = 0, my = 0, t = 0;
        document.addEventListener('mousemove', e => {
            mx = (e.clientX / window.innerWidth  - 0.5) * 0.3;
            my = (e.clientY / window.innerHeight - 0.5) * 0.15;
        });

        (function animate() {
            requestAnimationFrame(animate);
            t += 0.008;
            stars.rotation.y  += 0.00008;
            stars.rotation.x  += 0.00004;
            bright.rotation.y += 0.00014;
            bright.rotation.x += 0.00007;
            bright.material.opacity = 0.45 + Math.sin(t * 0.6) * 0.15;
            camera.position.x += (mx - camera.position.x) * 0.012;
            camera.position.y += (-my - camera.position.y) * 0.012;
            renderer.render(scene, camera);
        })();

        window.addEventListener('resize', () => {
            renderer.setSize(window.innerWidth, window.innerHeight);
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
        });
    })();
    </script>

</body>
</html>