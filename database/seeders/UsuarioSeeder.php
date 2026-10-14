<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Usuarios migrados del sistema original (divm.sql).
     * Las contraseñas del dump original estaban en texto plano; aquí se
     * insertan ya con Hash::make() (bcrypt), tal como lo hará AuthController.
     *
     * ⚠️ Cambia estas contraseñas en producción: son las mismas de prueba
     * que traía el proyecto original ('12345' / '123456').
     */
    public function run(): void
    {
        $usuarios = [
            ['nombre' => 'Guadalupe', 'apaterno' => 'Vera', 'amaterno' => 'Martínez', 'correo' => 'guadalupe.vera.divm@gmail.com', 'password' => '12345', 'rol' => 'Administrador'],
            ['nombre' => 'Leticia', 'apaterno' => 'García', 'amaterno' => 'López', 'correo' => 'leticia.garcia.divm@gmail.com', 'password' => '12345', 'rol' => 'Personal'],
            ['nombre' => 'Sistemas', 'apaterno' => 'DIVM', 'amaterno' => 'Puebla', 'correo' => 'soporte.divm@gmail.com', 'password' => '123456', 'rol' => 'Administrador'],
            ['nombre' => 'Gudalupe', 'apaterno' => 'Vera', 'amaterno' => 'Monroy', 'correo' => 'guadalupe22.divm@gmail.com', 'password' => '12345', 'rol' => 'Administrador'],
            ['nombre' => 'Alejandro', 'apaterno' => 'Gonzalez', 'amaterno' => 'Mendez', 'correo' => 'alejandro.divm@gmail.com', 'password' => '12345', 'rol' => 'Personal'],
        ];

        foreach ($usuarios as $u) {
            Usuario::updateOrCreate(
                ['correo' => $u['correo']],
                [
                    'nombre' => $u['nombre'],
                    'apaterno' => $u['apaterno'],
                    'amaterno' => $u['amaterno'],
                    'password' => Hash::make($u['password']),
                    'rol' => $u['rol'],
                    'estado' => 'Activo',
                    'dos_factores_activado' => true,
                ]
            );
        }
    }
}
