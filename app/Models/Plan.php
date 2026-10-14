<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'planes';
    public $timestamps = false;

    protected $fillable = [
        'paciente',
        'padre',
        'madre',
        'terapia_comunicativa',
        'terapia_sensorial',
        'terapia_aprendizaje',
        'terapia_ocupacional',
        'terapia_atencion_concentracion',
        'terapia_educacion_emocional',
    ];
}
