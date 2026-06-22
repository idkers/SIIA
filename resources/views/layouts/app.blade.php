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
        #siia-particles {
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
        }

        /* ── Layout base: body y contenedor crecen, footer al fondo ── */
        html { height: 100%; }
        body {
            min-height: 100vh;
            min-height: 100dvh; /* mejor soporte en móvil */
            display: flex;
            flex-direction: column;
            background: #06060F;
            color: white;
            margin: 0;
            padding: 0;
        }
        #siia-content {
            position: relative;
            z-index: 1;
            /* Crece para llenar el espacio disponible */
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
        }
        /* El footer dentro de #siia-content no crece */
        #siia-content > footer,
        #siia-content footer#footer-main {
            flex-shrink: 0;
            margin-top: auto; /* empuja hacia abajo si el contenido es corto */
        }

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