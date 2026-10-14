<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planes', function (Blueprint $table) {
            $table->id();
            $table->string('paciente', 200)->nullable();
            $table->string('padre', 100)->nullable();
            $table->string('madre', 100)->nullable();
            $table->text('terapia_comunicativa')->nullable();
            $table->text('terapia_sensorial')->nullable();
            $table->text('terapia_aprendizaje')->nullable();
            $table->text('terapia_ocupacional')->nullable();
            $table->text('terapia_atencion_concentracion')->nullable();
            $table->text('terapia_educacion_emocional')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planes');
    }
};
