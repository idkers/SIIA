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
        Schema::create('resultados', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('dominio_id')
                ->constrained('dominios')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('casa_id')
                ->constrained('casas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->decimal('porcentaje', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultados');
    }
};