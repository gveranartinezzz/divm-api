<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recomendaciones', function (Blueprint $table) {
            $table->id();
            $table->string('madre', 150);
            $table->string('padre', 150);
            $table->string('paciente', 150);
            $table->string('escuela_procedencia')->nullable();
            $table->enum('grado', ['Estancia', 'Preescolar', 'Primaria', 'Secundaria', 'Preparatoria', 'Universidad'])->nullable();
            $table->text('recomendacion');
            $table->text('notas')->nullable();
            $table->dateTime('fecha_creacion')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recomendaciones');
    }
};
