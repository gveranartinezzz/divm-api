<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre', 100);
            $table->string('apaterno', 100);
            $table->string('amaterno', 100);
            $table->string('correo', 100)->unique();
            $table->string('password', 255);
            $table->string('codigo_verificacion', 6)->nullable();
            $table->boolean('dos_factores_activado')->default(false);
            $table->enum('rol', ['Administrador', 'Personal'])->default('Personal');
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->dateTime('fecha_codigo')->nullable();
            $table->rememberToken();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
