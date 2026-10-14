<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    protected $table = 'informes';
    public $timestamps = false;

    protected $fillable = [
        'paciente',
        'nombre_padre',
        'grado_estudios_padre',
        'ocupacion_padre',
        'edad_padre',
        'nombre_madre',
        'grado_estudios_madre',
        'ocupacion_madre',
        'edad_madre',
        'fecha_nacimiento',
        'domicilio',
        'prueba_aplicada',
        'fecha_aplicacion',
        'aplicadora',
        'motivo_evaluacion',
        'hc_gestacion',
        'hc_talla_nacer',
        'hc_peso',
        'hc_apgar',
        'hc_alergias',
        'hc_diagnostico',
        'res_lenguaje',
        'res_anatomico',
        'res_discriminacion',
        'res_fonetica_auditiva',
        'res_lenguaje_espontaneo',
        'res_nivel_lenguaje',
        'res_conducta_valoracion',
        'des_cognitivo',
        'des_motor',
        'des_social',
        'observaciones',
        'ind_clinicas',
        'ind_familiares',
        'ind_adolescencia',
        'ind_escolares',
        'ind_rehabilitadores',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_aplicacion' => 'date',
    ];
}
