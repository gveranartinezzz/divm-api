<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'nombre',
        'fecha_nacimiento',
        'direccion',
        'edad',
        'diagnostico',
        'estatus',
        'motivo_consulta',
        'escolarizado',
        'madre',
        'padre',
        'access_token',
        'qr_path',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_registro' => 'datetime',
    ];

    public function avances()
    {
        return $this->hasMany(AvancePaciente::class, 'paciente_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('estatus', 'Activo');
    }
}
