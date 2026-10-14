<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformeValoracion extends Model
{
    protected $table = 'informes_valoracion';

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'id_paciente',
        'id_usuario',
        'prueba_aplicada',
        'aplicadora',
        'motivo_evaluacion',
        'hc_gestacion',
        'hc_talla_nacer',
        'hc_diagnostico',
        'des_cognitivo',
        'des_motor',
        'des_social',
        'res_lenguaje',
        'res_conducta_valoracion',
        'ind_escolares',
        'ind_clinicas',
        'ind_familiares',
        'ind_rehabilitadores',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
