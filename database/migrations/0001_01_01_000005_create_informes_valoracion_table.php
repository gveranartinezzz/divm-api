<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informes_valoracion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_paciente')->constrained('pacientes')->cascadeOnDelete();
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->string('prueba_aplicada');
            $table->string('aplicadora');
            $table->text('motivo_evaluacion');
            $table->text('hc_gestacion')->nullable();
            $table->string('hc_talla_nacer', 100)->nullable();
            $table->text('hc_diagnostico');
            $table->text('des_cognitivo');
            $table->text('des_motor');
            $table->text('des_social');
            $table->text('res_lenguaje');
            $table->text('res_conducta_valoracion');
            $table->text('ind_escolares')->nullable();
            $table->text('ind_clinicas')->nullable();
            $table->text('ind_familiares')->nullable();
            $table->text('ind_rehabilitadores')->nullable();
            $table->timestamp('fecha_registro')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informes_valoracion');
    }
};
