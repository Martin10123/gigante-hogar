<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestador_id')->constrained('users')->cascadeOnDelete();
            $table->string('descripcion');
            $table->date('fecha');
            $table->unsignedInteger('cupos_totales');
            $table->unsignedInteger('cupos_disponibles');
            $table->timestamps();

            $table->index(['prestador_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};