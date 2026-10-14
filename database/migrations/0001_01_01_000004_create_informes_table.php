<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informes', function (Blueprint $table) {
            $table->id();
            $table->string('paciente', 200);
            $table->string('nombre_padre', 150)->nullable();
            $table->string('grado_estudios_padre', 100)->nullable();
            $table->string('ocupacion_padre', 150)->nullable();
            $table->integer('edad_padre')->nullable();
            $table->string('nombre_madre', 150)->nullable();
            $table->string('grado_estudios_madre', 100)->nullable();
            $table->string('ocupacion_madre', 150)->nullable();
            $table->integer('edad_madre')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->text('domicilio')->nullable();
            $table->text('prueba_aplicada')->nullable();
            $table->date('fecha_aplicacion')->nullable();
            $table->text('aplicadora')->nullable();
            $table->text('motivo_evaluacion')->nullable();
            $table->text('hc_gestacion')->nullable();
            $table->text('hc_talla_nacer')->nullable();
            $table->text('hc_peso')->nullable();
            $table->text('hc_apgar')->nullable();
            $table->text('hc_alergias')->nullable();
            $table->text('hc_diagnostico')->nullable();
            $table->text('res_lenguaje')->nullable();
            $table->text('res_anatomico')->nullable();
            $table->text('res_discriminacion')->nullable();
            $table->text('res_fonetica_auditiva')->nullable();
            $table->text('res_lenguaje_espontaneo')->nullable();
            $table->text('res_nivel_lenguaje')->nullable();
            $table->text('res_conducta_valoracion')->nullable();
            $table->text('des_cognitivo')->nullable();
            $table->text('des_motor')->nullable();
            $table->text('des_social')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('ind_clinicas')->nullable();
            $table->text('ind_familiares')->nullable();
            $table->text('ind_adolescencia')->nullable();
            $table->text('ind_escolares')->nullable();
            $table->text('ind_rehabilitadores')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informes');
    }
};
