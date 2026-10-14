<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recomendacion extends Model
{
    protected $table = 'recomendaciones';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = null;

    protected $fillable = [
        'madre',
        'padre',
        'paciente',
        'escuela_procedencia',
        'grado',
        'recomendacion',
        'notas',
    ];
}
