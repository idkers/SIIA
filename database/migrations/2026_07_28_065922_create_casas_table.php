<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::create('casas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dominio_id')
                ->constrained('dominios')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('nombre');
            $table->string('nombre_casa');
            $table->string('imagen')->nullable();
            $table->string('color', 7);
            $table->string('frase');
            $table->json('valores');
            $table->text('descripcion');
            $table->longText('oferta');
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('casas');
    }
};