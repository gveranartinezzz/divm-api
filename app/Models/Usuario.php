<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * La tabla real hereda el nombre y la llave primaria del sistema original.
     */
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apaterno',
        'amaterno',
        'correo',
        'password',
        'codigo_verificacion',
        'dos_factores_activado',
        'rol',
        'estado',
        'fecha_codigo',
    ];

    protected $hidden = [
        'password',
        'codigo_verificacion',
        'remember_token',
    ];

    protected $casts = [
        'dos_factores_activado' => 'boolean',
        'fecha_codigo' => 'datetime',
        'password' => 'hashed',
    ];

    /** Nombre de usuario para Laravel Auth (usamos correo en vez de "email"). */
    public function username(): string
    {
        return 'correo';
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombre} {$this->apaterno} {$this->amaterno}");
    }

    public function esAdministrador(): bool
    {
        return $this->rol === 'Administrador';
    }

    public function avances()
    {
        return $this->hasMany(AvancePaciente::class, 'usuario_id', 'id_usuario');
    }

    public function horarios()
    {
        return $this->hasMany(HorarioAtencion::class, 'id_usuario', 'id_usuario');
    }
}
