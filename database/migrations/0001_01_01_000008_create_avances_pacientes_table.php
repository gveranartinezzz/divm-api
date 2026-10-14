<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avances_pacientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->date('fecha_sesion');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->enum('estatus_sesion', ['Asistió', 'Falta Justificada', 'Falta Injustificada', 'Cancelada'])->default('Asistió');
            $table->text('actividades_realizadas')->nullable();
            $table->text('observaciones_comportamiento')->nullable();
            $table->text('logros_obtenidos')->nullable();
            $table->text('tareas_o_recomendaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avances_pacientes');
    }
};
