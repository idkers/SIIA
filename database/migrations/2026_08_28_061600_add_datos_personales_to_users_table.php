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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('edad')->nullable()->after('email');
            $table->string('lugar_residencia')->nullable()->after('edad');
            $table->string('preparatoria')->nullable()->after('lugar_residencia');
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'edad',
                'lugar_residencia',
                'preparatoria',
            ]);
        });
    }
};