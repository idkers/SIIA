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
                'slug'        => 'ingenierias',
                'nombre'      => 'Ingenierías',
                'nombre_casa' => 'AURELION',
                'color'       => '#075E56',
                'descripcion' => 'Carreras enfocadas en la optimización de sistemas, procesos industriales y sostenibilidad.',
                'imagen'      => 'imagenes/dominios/Ingenierias.webp',
            ],
            [
                'slug'        => 'tecnologias-de-la-informacion',
                'nombre'      => 'Tecnologías de la Información',
                'nombre_casa' => 'NEXORIA',
                'color'       => '#420FDB',
                'descripcion' => 'Carreras enfocadas en el desarrollo tecnológico y la innovación digital.',
                'imagen'      => 'imagenes/dominios/Tecnologias_de_la_Informacion.webp',
            ],
            [
                'slug'        => 'ingenierias-industriales',
                'nombre'      => 'Ingenierías Industriales',
                'nombre_casa' => 'VALTORIS',
                'color'       => '#CC7135',
                'descripcion' => 'Carreras orientadas a la mejora de procesos productivos.',
                'imagen'      => 'imagenes/dominios/Ingenieria_Industrial.webp',
            ],
            [
                'slug'        => 'mecatronicas',
                'nombre'      => 'Mecatrónicas',
                'nombre_casa' => 'MECHARIS',
                'color'       => '#A81E1E',
                'descripcion' => 'Integración de automatización, robótica y sistemas inteligentes.',
                'imagen'      => 'imagenes/dominios/mecatronicaBaseSinTextura.webp',
            ],
            [
                'slug'        => 'licenciaturas',
                'nombre'      => 'Licenciaturas',
                'nombre_casa' => 'ELYRIA',
                'color'       => '#B89A10',
                'descripcion' => 'Formación profesional enfocada en servicios, negocios y gestión.',
                'imagen'      => 'imagenes/dominios/Licenciaturas.webp',
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