<?php

namespace Database\Seeders;

use App\Models\Casa;
use App\Models\Dominio;
use Illuminate\Database\Seeder;

class CasaSeeder extends Seeder
{
    /**
     * Carga las 20 casas académicas iniciales.
     */
    public function run(): void
    {
        $dominios = Dominio::query()
            ->pluck('id', 'slug');

        $casas = [
            // INGENIERÍAS
            [
                'dominio_id' => $dominios['ingenierias'],
                'nombre' => 'Logística',
                'nombre_casa' => 'NAVENTOR',
                'imagen' => 'imagenes/casas/logistica.jpeg',
                'color' => '#0057B8',
                'frase' => 'Toda ruta tiene un destino',
                'valores' => [
                    'Responsabilidad',
                    'Organización',
                    'Eficiencia',
                ],
                'descripcion' => 'Te gusta planear, coordinar recursos y optimizar procesos.',
                'oferta' => 'Diseño de Redes Logísticas: Crearás sistemas complejos de distribución que conectan empresas con clientes eficientemente, Economía Circular: Aprenderás modelos sostenibles que minimizan residuos en la cadena de suministro, Operación de Flotas y Terminales: Gestionarás flota de vehículos y centros de distribución de manera óptima, Tendencias en la Cadena de Suministros: Te mantendrás actualizado en tecnologías emergentes como blockchain y IoT en logística, Investigación de Operaciones Logísticas: Optimizarás rutas costos y tiempo de entrega usando análisis cuantitativos',
                'link' => 'https://www.utleon.edu.mx/carrera/TM',
            ],
            [
                'dominio_id' => $dominios['ingenierias'],
                'nombre' => 'Mantenimiento Industrial',
                'nombre_casa' => 'ENGRAVIA',
                'imagen' => 'imagenes/casas/mantenimiento.webp',
                'color' => '#003A5D',
                'frase' => 'La excelencia se construye cada día',
                'valores' => [
                    'Compromiso',
                    'Precisión',
                    'Responsabilidad',
                ],
                'descripcion' => 'Diagnóstico y mantenimiento de maquinaria industrial.',
                'oferta' => 'Mantenimiento Predictivo Mecánico: Utilizarás sensores y análisis para predecir fallos antes de que ocurran, Técnicas TPM y RCM: Aplicarás metodologías avanzadas de mantenimiento para máxima disponibilidad, Ensayos Destructivos y No Destructivos: Aprenderás a evaluar la integridad de materiales sin dañarlos, Automatización y Robótica: Implementarás sistemas automáticos para tareas de mantenimiento complejas, Gestión Estratégica para Mantenimiento: Dirigirás departamentos de mantenimiento en grandes operaciones industriales',
                'link' => 'https://www.utleon.edu.mx/carrera/MI',
            ],
            [
                'dominio_id' => $dominios['ingenierias'],
                'nombre' => 'Ambiental y Sustentabilidad',
                'nombre_casa' => 'SYLVARA',
                'imagen' => 'imagenes/casas/ambiental.webp',
                'color' => '#43B02A',
                'frase' => 'Proteger hoy para transformar mañana',
                'valores' => [
                    'Ética',
                    'Compromiso',
                    'Responsabilidad Social',
                ],
                'descripcion' => 'Desarrollo de soluciones ambientales sostenibles.',
                'oferta' => 'Gestión de Recursos Hídricos: Protegerás y gestionarás el agua recurso vital para comunidades y empresas, Gestión Integral de Residuos: Crearás sistemas para reducir reutilizar y reciclar residuos sólidos, Tecnología para el Tratamiento de Agua: Diseñarás plantas de tratamiento que purifican agua contaminada, Energías Alternativas: Desarrollarás proyectos de energía solar eólica e hidroeléctrica sostenible, Evaluación de Impacto Ambiental: Analizarás cómo proyectos afectan el medio ambiente y propondrás soluciones',
                'link' => 'https://www.utleon.edu.mx/carrera/GA',
            ],

            // TECNOLOGÍAS DE LA INFORMACIÓN
            [
                'dominio_id' => $dominios['tecnologias-de-la-informacion'],
                'nombre' => 'Entornos Virtuales y Negocios Digitales',
                'nombre_casa' => 'NEXARIS',
                'imagen' => 'imagenes/casas/entornos.webp',
                'color' => '#6B3FA0',
                'frase' => 'Imaginar es crear',
                'valores' => [
                    'Creatividad',
                    'Innovación',
                    'Adaptación',
                ],
                'descripcion' => 'Desarrollo de productos digitales interactivos.',
                'oferta' => 'Programación de Video Juegos: Crearás juegos interactivos usando motores profesionales como Unity o Unreal Engine, Aplicaciones para Realidad Virtual y Aumentada: Desarrollarás experiencias inmersivas y aplicaciones de realidad mixta, Animación Avanzada y Efectos Visuales: Dominarás técnicas cinematográficas y efectos visuales profesionales, Mercadotecnia Digital: Aprenderás a posicionar negocios en internet mediante estrategias digitales, Diseño Digital y Producción Audiovisual: Crearás contenido multimedia profesional para web redes sociales y plataformas digitales',
                'link' => 'https://www.utleon.edu.mx/carrera/EVN',
            ],
            [
                'dominio_id' => $dominios['tecnologias-de-la-informacion'],
                'nombre' => 'Ciencia de Datos',
                'nombre_casa' => 'DATHEON',
                'imagen' => 'imagenes/casas/datos.webp',
                'color' => '#2E6F95',
                'frase' => 'Los datos cuentan historias',
                'valores' => [
                    'Objetividad',
                    'Precisión',
                    'Pensamiento Crítico',
                ],
                'descripcion' => 'Interpretación y análisis de datos.',
                'oferta' => 'Ciencia de Datos: Analizarás grandes volúmenes de datos para extraer información que impulse decisiones empresariales, Visualización de Datos: Crearás gráficos y dashboards que comunican datos complejos de forma clara, Aprendizaje Computacional: Entrenarás modelos que aprenden patrones en datos para hacer predicciones, Métodos Estadísticos: Aplicarás técnicas estadísticas avanzadas para análisis profundo de información, Servicios en la Nube: Utilizarás plataformas cloud para procesar y analizar datos a escala empresarial',
                'link' => 'https://www.utleon.edu.mx/carrera/CD',
            ],
            [
                'dominio_id' => $dominios['tecnologias-de-la-informacion'],
                'nombre' => 'Desarrollo de Software Multiplataforma',
                'nombre_casa' => 'CODARIS',
                'imagen' => 'imagenes/casas/software.webp',
                'color' => '#2563EB',
                'frase' => 'Cada línea construye el futuro',
                'valores' => [
                    'Innovación',
                    'Perseverancia',
                    'Aprendizaje Continuo',
                ],
                'descripcion' => 'Creación de aplicaciones y sistemas.',
                'oferta' => 'Desarrollo de Aplicaciones Móviles: Crearás aplicaciones para iOS y Android que resuelven problemas reales, Aplicaciones Web Orientada a Servicios: Desarrollarás servicios web escalables y robustos para empresas, Bases de Datos Avanzadas: Diseñarás sistemas de almacenamiento de datos eficientes y seguros, Estándares y Métricas para el Desarrollo de Software: Aprenderás mejores prácticas para crear software de calidad profesional, Programación Móvil Avanzada: Dominarás tecnologías avanzadas para crear apps móviles con funcionalidades complejas',
                'link' => 'https://www.utleon.edu.mx/carrera/DSM',
            ],
            [
                'dominio_id' => $dominios['tecnologias-de-la-informacion'],
                'nombre' => 'Infraestructura de Redes Digitales',
                'nombre_casa' => 'HEXANET',
                'imagen' => 'imagenes/casas/redes.webp',
                'color' => '#0EA5A4',
                'frase' => 'Conectar es avanzar',
                'valores' => [
                    'Responsabilidad',
                    'Orden',
                    'Seguridad',
                ],
                'descripcion' => 'Administración de redes y servidores.',
                'oferta' => 'Cómputo en la Nube: Aprenderás a gestionar servidores almacenamiento y aplicaciones en infraestructura en la nube, Seguridad en Redes: Te especializarás en proteger sistemas contra ciberataques y vulnerabilidades, Administración de Redes Empresariales: Diseñarás y administrarás redes complejas para grandes organizaciones, Centro de Datos: Aprenderás a construir y mantener infraestructuras de datos de alto rendimiento, Internet de las Cosas: Conectarás dispositivos inteligentes para crear soluciones IoT innovadoras',
                'link' => 'https://www.utleon.edu.mx/carrera/IRD',
            ],
            [
                'dominio_id' => $dominios['tecnologias-de-la-informacion'],
                'nombre' => 'Inteligencia Artificial',
                'nombre_casa' => 'SYNTHERA',
                'imagen' => 'imagenes/casas/ia.webp',
                'color' => '#8A2BE2',
                'frase' => 'Pensar más allá de los límites',
                'valores' => [
                    'Creatividad',
                    'Innovación',
                    'Pensamiento Crítico',
                ],
                'descripcion' => 'Desarrollo de soluciones inteligentes.',
                'oferta' => 'Aprendizaje Profundo (Deep Learning): Entrenarás redes neuronales para resolver problemas complejos como visión por computadora, Aprendizaje de Máquina: Crearás algoritmos que aprenden de datos para hacer predicciones y decisiones inteligentes, Minería de Datos y Texto: Extraerás información valiosa de grandes volúmenes de datos no estructurados, Visión por Computadora: Desarrollarás sistemas que pueden ver y analizar imágenes y videos, Sistemas Inteligentes: Crearás aplicaciones que piensan y se adaptan como un experto humano',
                'link' => 'https://www.utleon.edu.mx/carrera/IA',
            ],

            // INGENIERÍAS INDUSTRIALES
            [
                'dominio_id' => $dominios['ingenierias-industriales'],
                'nombre' => 'Automotriz',
                'nombre_casa' => 'PISTORIA',
                'imagen' => 'imagenes/casas/automotriz.webp',
                'color' => '#DC2626',
                'frase' => 'Movimiento con propósito',
                'valores' => [
                    'Eficiencia',
                    'Liderazgo',
                    'Compromiso',
                ],
                'descripcion' => 'Mejora de procesos automotrices.',
                'oferta' => 'Manufactura Esbelta: Aprenderás a eliminar desperdicios en procesos para maximizar eficiencia y calidad, Investigación de Operaciones: Optimizarás procesos empresariales usando técnicas matemáticas y análisis de datos, 6 SIGMA: Te especializarás en metodologías de mejora continua para alcanzar excelencia operacional, Simulación de Procesos: Modelarás y probarás procesos antes de implementarlos para minimizar riesgos, Administración del Mantenimiento: Crearás estrategias para mantener equipos en óptimo funcionamiento',
                'link' => 'https://www.utleon.edu.mx/carrera/AT',
            ],
            [
                'dominio_id' => $dominios['ingenierias-industriales'],
                'nombre' => 'Procesos Productivos',
                'nombre_casa' => 'OPERION',
                'imagen' => 'imagenes/casas/productivos.webp',
                'color' => '#ED8B00',
                'frase' => 'La mejora nunca termina',
                'valores' => [
                    'Orden',
                    'Eficiencia',
                    'Mejora Continua',
                ],
                'descripcion' => 'Gestión de operaciones industriales.',
                'oferta' => 'Manufactura Esbelta: Aprenderás a eliminar desperdicios en procesos para maximizar eficiencia y calidad, Investigación de Operaciones: Optimizarás procesos empresariales usando técnicas matemáticas y análisis de datos, 6 SIGMA: Te especializarás en metodologías de mejora continua para alcanzar excelencia operacional, Simulación de Procesos: Modelarás y probarás procesos antes de implementarlos para minimizar riesgos, Administración del Mantenimiento: Crearás estrategias para mantener equipos en óptimo funcionamiento',
                'link' => 'https://www.utleon.edu.mx/carrera/PP',
            ],
            [
                'dominio_id' => $dominios['ingenierias-industriales'],
                'nombre' => 'Moldeo de Plásticos',
                'nombre_casa' => 'POLYMOR',
                'imagen' => 'imagenes/casas/plasticos.webp',
                'color' => '#9C3D0C',
                'frase' => 'La forma sigue a la innovación',
                'valores' => [
                    'Precisión',
                    'Responsabilidad',
                    'Innovación',
                ],
                'descripcion' => 'Diseño y fabricación de productos plásticos.',
                'oferta' => 'Manufactura Esbelta: Aprenderás a eliminar desperdicios en procesos para maximizar eficiencia y calidad, Investigación de Operaciones: Optimizarás procesos empresariales usando técnicas matemáticas y análisis de datos, 6 SIGMA: Te especializarás en metodologías de mejora continua para alcanzar excelencia operacional, Simulación de Procesos: Modelarás y probarás procesos antes de implementarlos para minimizar riesgos, Administración del Mantenimiento: Crearás estrategias para mantener equipos en óptimo funcionamiento',
                'link' => 'https://www.utleon.edu.mx/carrera/MP',
            ],
            [
                'dominio_id' => $dominios['ingenierias-industriales'],
                'nombre' => 'Gestión y Productividad de Calzado',
                'nombre_casa' => 'SENDORIA',
                'imagen' => 'imagenes/casas/calzado.webp',
                'color' => '#C46210',
                'frase' => 'Cada paso deja huella',
                'valores' => [
                    'Creatividad',
                    'Calidad',
                    'Trabajo en Equipo',
                ],
                'descripcion' => 'Industria del calzado y manufactura.',
                'oferta' => 'Manufactura Esbelta: Aprenderás a eliminar desperdicios en procesos para maximizar eficiencia y calidad, Investigación de Operaciones: Optimizarás procesos empresariales usando técnicas matemáticas y análisis de datos, 6 SIGMA: Te especializarás en metodologías de mejora continua para alcanzar excelencia operacional, Simulación de Procesos: Modelarás y probarás procesos antes de implementarlos para minimizar riesgos, Administración del Mantenimiento: Crearás estrategias para mantener equipos en óptimo funcionamiento',
                'link' => 'https://www.utleon.edu.mx/carrera/GPC',
            ],
            [
                'dominio_id' => $dominios['ingenierias-industriales'],
                'nombre' => 'Electromovilidad',
                'nombre_casa' => 'ENERION',
                'imagen' => 'imagenes/casas/electro.webp',
                'color' => '#FFEE00',
                'frase' => 'La innovación mueve el futuro',
                'valores' => [
                    'Innovación',
                    'Responsabilidad',
                    'Compromiso con la Sustentabilidad',
                ],
                'descripcion' => 'Desarrollo de soluciones tecnológicas para una movilidad sustentable.',
                'oferta' => 'Vehículos Eléctricos: Aprenderás tecnología de batería motores eléctricos y sistemas de propulsión limpia, Fuentes de Energía: Estudiarás sistemas de carga almacenamiento de energía y tecnologías alternativas, Diagnóstico en Sistemas de Electromoción: Dominarás herramientas para diagnosticar y reparar vehículos eléctricos, Seguridad Eléctrica en Sistemas de Electromovilidad: Garantizarás prácticas seguras en alta tensión y sistemas de batería, Mantenimiento a Sistemas de Electromovilidad: Te especializarás en mantener infraestructuras de carga y vehículos eléctricos',
                'link' => 'https://www.utleon.edu.mx/carrera/IDI',
            ],

            // MECATRÓNICAS
            [
                'dominio_id' => $dominios['mecatronicas'],
                'nombre' => 'Manufactura Flexible',
                'nombre_casa' => 'FLEXION',
                'imagen' => 'imagenes/casas/manufactura.webp',
                'color' => '#7C3AED',
                'frase' => 'Adaptarse es evolucionar',
                'valores' => [
                    'Innovación',
                    'Precisión',
                    'Creatividad',
                ],
                'descripcion' => 'Sistemas automatizados de producción.',
                'oferta' => 'Robótica: Diseñarás y programarás robots industriales para automatizar procesos de manufactura, Controladores Lógicos Programables (PLC): Programarás sistemas de control automatizados para máquinas industriales, Manufactura Asistida por Computadora (CAM): Crearás programas para máquinas de corte y producción controladas por computadora, Sistemas CAM CNC: Dominarás máquinas de control numérico para precisión extrema en manufactura, Sistemas de Manufactura Flexible: Diseñarás sistemas adaptables que pueden producir diferentes productos eficientemente',
                'link' => 'https://www.utleon.edu.mx/carrera/LSMF',
            ],
            [
                'dominio_id' => $dominios['mecatronicas'],
                'nombre' => 'Optomecatrónica',
                'nombre_casa' => 'PRISMARA',
                'imagen' => 'imagenes/casas/optomecatronica.webp',
                'color' => '#A50034',
                'frase' => 'La precisión guía el camino',
                'valores' => [
                    'Precisión',
                    'Responsabilidad',
                    'Innovación',
                ],
                'descripcion' => 'Sistemas ópticos y electrónicos.',
                'oferta' => 'Láseres: Aprenderás a utilizar tecnología láser en aplicaciones industriales y médicas, Metrología Óptica: Dominarás técnicas precisas de medición usando luz y sistemas ópticos avanzados, Principios de Óptica: Entenderás cómo funcionan los sistemas ópticos para aplicaciones tecnológicas, Programación de Robots Industriales: Crearás programas sofisticados para robots que requieren precisión extrema, Ingeniería de Control: Diseñarás sistemas de control automático para máquinas precisas',
                'link' => 'https://www.utleon.edu.mx/carreras/OP',
            ],
            [
                'dominio_id' => $dominios['mecatronicas'],
                'nombre' => 'Automatización',
                'nombre_casa' => 'AUTRON',
                'imagen' => 'imagenes/casas/automatizacion.webp',
                'color' => '#FF3B30',
                'frase' => 'La eficiencia es inteligencia aplicada',
                'valores' => [
                    'Eficiencia',
                    'Compromiso',
                    'Innovación',
                ],
                'descripcion' => 'Automatización de procesos industriales.',
                'oferta' => 'Sistemas Neumáticos e Hidráulicos: Diseñarás sistemas de fluidos para activar máquinas y equipos automáticos, Instrumentación Industrial: Instalarás y calibrarás sensores y equipos de medición en procesos industriales, Implementación de Sistemas Automáticos: Crearás soluciones completas de automatización para fábricas inteligentes, Sistemas Embebidos: Programarás microcontroladores para controlar dispositivos autónomos, Control Avanzado: Diseñarás algoritmos de control sofisticados para sistemas complejos',
                'link' => 'https://www.utleon.edu.mx/carrera/AU',
            ],

            // LICENCIATURAS
            [
                'dominio_id' => $dominios['licenciaturas'],
                'nombre' => 'Gastronomía',
                'nombre_casa' => 'FLAMORIA',
                'imagen' => 'imagenes/casas/gastronomia2.webp',
                'color' => '#EBA42D',
                'frase' => 'Crear experiencias para recordar',
                'valores' => [
                    'Servicio',
                    'Creatividad',
                    'Disciplina',
                ],
                'descripcion' => 'Experiencias culinarias y hospitalidad.',
                'oferta' => 'Cocina Mexicana I y II: Te especializarás en la gastronomía tradicional mexicana sus técnicas y sabores autóctonos, Cocina Europea: Aprenderás técnicas clásicas europeas y crearás platillos de alta cocina, Cocina Contemporánea: Dominarás tendencias culinarias modernas e innovadoras para crear experiencias únicas, Mixología: Te convertirás en experto en la preparación de cócteles bebidas y combinaciones creativas, Desarrollo de Negocios Gastronómicos: Crearás y gestionarás tu propio restaurante cafetería o negocio culinario exitoso',
                'link' => 'https://www.utleon.edu.mx/carrera/GST',
            ],
            [
                'dominio_id' => $dominios['licenciaturas'],
                'nombre' => 'Administración',
                'nombre_casa' => 'LAUREON',
                'imagen' => 'imagenes/casas/administracion.webp',
                'color' => '#1F3D2B',
                'frase' => 'Liderar para construir',
                'valores' => [
                    'Liderazgo',
                    'Responsabilidad',
                    'Ética',
                ],
                'descripcion' => 'Gestión de empresas y recursos.',
                'oferta' => 'Gestión del Capital Humano: Aprenderás a dirigir y desarrollar el talento humano dentro de las organizaciones clave para cualquier empresa, Liderazgo de Equipos de Alto Desempeño: Desarrollarás habilidades para motivar y guiar equipos hacia objetivos comunes con excelencia, Dirección Estratégica: Estudiarás cómo formular y ejecutar estrategias empresariales que garanticen el crecimiento y competitividad, Finanzas Corporativas: Aprenderás a gestionar los recursos financieros de una empresa para maximizar su valor, Consultoría Empresarial: Desarrollarás proyectos de mejora organizacional como consultor especializado',
                'link' => 'https://www.utleon.edu.mx/carrera/GCH',
            ],
            [
                'dominio_id' => $dominios['licenciaturas'],
                'nombre' => 'Turismo',
                'nombre_casa' => 'GLOBARIS',
                'imagen' => 'imagenes/casas/turismo.webp',
                'color' => '#00A3E0',
                'frase' => 'Descubrir conecta culturas',
                'valores' => [
                    'Servicio',
                    'Empatía',
                    'Creatividad',
                ],
                'descripcion' => 'Experiencias turísticas y culturales.',
                'oferta' => 'Diseño de Experiencias Turísticas: Crearás experiencias memorables para turistas combinando cultura naturaleza y entretenimiento, Destinos Turísticos Inteligentes: Aprenderás a desarrollar destinos innovadores que utilizan tecnología para mejorar la experiencia, Turismo Cultural y de Naturaleza: Te especializarás en promocionar el patrimonio cultural e histórico de regiones, Dirección y Logística de Eventos: Planificarás y ejecutarás eventos turísticos de gran escala como congresos y festivales, Mercadotecnia Internacional: Aprenderás a promover destinos turísticos a nivel mundial con estrategias globales',
                'link' => 'https://www.utleon.edu.mx/carrera/TU',
            ],
            [
                'dominio_id' => $dominios['licenciaturas'],
                'nombre' => 'Negocios y Mercadotecnia',
                'nombre_casa' => 'NOVARIS',
                'imagen' => 'imagenes/casas/mercadotecnia.webp',
                'color' => '#E4007C',
                'frase' => 'Las ideas iluminan el cambio',
                'valores' => [
                    'Innovación',
                    'Liderazgo',
                    'Comunicación',
                ],
                'descripcion' => 'Marketing y desarrollo de negocios.',
                'oferta' => 'Mercadotecnia Digital I y II: Dominarás estrategias digitales redes sociales y herramientas online para conectar con clientes, Inteligencia de Mercados: Aprenderás a analizar datos de mercado para tomar decisiones comerciales informadas, Desarrollo de Nuevos Productos: Crearás productos innovadores que satisfagan necesidades del mercado actual, Comportamiento del Consumidor: Entenderás cómo piensan y actúan los clientes para diseñar mejores estrategias de venta, Plan de Negocios: Desarrollarás un plan completo para lanzar tu propia empresa o proyecto empresarial',
                'link' => 'https://www.utleon.edu.mx/carrera/MT',
            ],
        ];

        foreach ($casas as $casa) {
            Casa::updateOrCreate(
                ['nombre' => $casa['nombre']],
                $casa
            );
        }
    }
}