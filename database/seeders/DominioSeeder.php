<?php

namespace Database\Seeders;

use App\Models\Dominio;
use Illuminate\Database\Seeder;

class DominioSeeder extends Seeder
{
    /**
     * Carga los dominios académicos iniciales.
     */
    public function run(): void
    {
        $dominios = [
            [
                'slug' => 'ingenierias',
                'nombre' => 'Ingenierías',
                'nombre_casa' => 'AURELION',
                'color' => '#075E56',
                'imagen' => 'imagenes/dominios/Ingenierias.webp',
                'descripcion' => 'Carreras enfocadas en la optimización de sistemas, procesos industriales y sostenibilidad.',
            ],
            [
                'slug' => 'tecnologias-de-la-informacion',
                'nombre' => 'Tecnologías de la Información',
                'nombre_casa' => 'NEXORIA',
                'color' => '#420FDB',
                'imagen' => 'imagenes/dominios/Tecnologias_de_la_Informacion.webp',
                'descripcion' => 'Carreras enfocadas en el desarrollo tecnológico y la innovación digital.',
            ],
            [
                'slug' => 'ingenierias-industriales',
                'nombre' => 'Ingenierías Industriales',
                'nombre_casa' => 'VALTORIS',
                'color' => '#CC7135',
                'imagen' => 'imagenes/dominios/Ingenieria_Industrial.webp',
                'descripcion' => 'Carreras orientadas a la mejora de procesos productivos.',
            ],
            [
                'slug' => 'mecatronicas',
                'nombre' => 'Mecatrónicas',
                'nombre_casa' => 'MECHARIS',
                'color' => '#A81E1E',
                'imagen' => 'imagenes/dominios/mecatronicaBaseSinTextura.webp',
                'descripcion' => 'Integración de automatización, robótica y sistemas inteligentes.',
            ],
            [
                'slug' => 'licenciaturas',
                'nombre' => 'Licenciaturas',
                'nombre_casa' => 'ELYRIA',
                'color' => '#B89A10',
                'imagen' => 'imagenes/dominios/Licenciaturas.webp',
                'descripcion' => 'Formación profesional enfocada en servicios, negocios y gestión.',
            ],
        ];

        foreach ($dominios as $dominio) {
            Dominio::updateOrCreate(
                ['slug' => $dominio['slug']],
                $dominio
            );
        }
    }
}