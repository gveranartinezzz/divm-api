<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->date('fecha_nacimiento')->nullable();
            $table->text('direccion')->nullable();
            $table->integer('edad');
            $table->string('diagnostico')->nullable();
            $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
            $table->text('motivo_consulta')->nullable();
            $table->enum('escolarizado', ['Sí', 'No'])->default('No');
            $table->string('madre', 150)->nullable();
            $table->string('padre', 150)->nullable();
            $table->dateTime('fecha_registro')->useCurrent();
            $table->string('access_token', 100)->nullable();
            $table->string('qr_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
