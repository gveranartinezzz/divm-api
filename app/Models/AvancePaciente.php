<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvancePaciente extends Model
{
    protected $table = 'avances_pacientes';

    protected $fillable = [
        'paciente_id',
        'usuario_id',
        'fecha_sesion',
        'hora_inicio',
        'hora_fin',
        'estatus_sesion',
        'actividades_realizadas',
        'observaciones_comportamiento',
        'logros_obtenidos',
        'tareas_o_recomendaciones',
    ];

    protected $casts = [
        'fecha_sesion' => 'date',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
}
