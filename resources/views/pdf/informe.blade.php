<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<style>
    @page { margin: 115px 30px 60px 30px; }
    body { font-family: Arial, sans-serif; color: #333; font-size: 10px; }
    header {
        position: fixed; top: -105px; left: 0; right: 0; height: 105px; text-align: center;
    }
    header h1 { color: #54063e; font-size: 18px; margin: 4px 0 0 0; }
    header h2 { color: #54063e; font-size: 12px; font-weight: normal; margin: 2px 0; }
    header .barra {
        background: #c5005a; color: #fff; padding: 6px 0;
        font-weight: bold; font-size: 12px; letter-spacing: 1px; margin-top: 6px;
    }
    footer {
        position: fixed; bottom: -45px; left: 0; right: 0; height: 40px;
        text-align: center; color: #969696; font-size: 8px; font-style: italic;
    }
    .seccion {
        background: #f5f5f5; color: #c5005a; font-weight: bold;
        font-size: 10px; padding: 5px 6px; margin: 10px 0 6px 0;
    }
    table.datos { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
    table.datos td { padding: 3px 4px; vertical-align: top; }
    table.datos td.label { font-weight: bold; color: #323232; width: 170px; }
    table.datos td.valor { color: #333; }
    .page-number:before { content: counter(page); }
</style>
</head>
<body>
    <header>
        <h1>CENTRO DIVM</h1>
        <h2>Educación Especial</h2>
        <div class="barra">INFORME DE VALORACIÓN</div>
    </header>

    <footer>Página <span class="page-number"></span></footer>

    <main>
        <div class="seccion">Datos del paciente</div>
        <table class="datos">
            <tr><td class="label">Paciente:</td><td class="valor">{{ $d->paciente }}</td></tr>
            <tr><td class="label">Fecha de nacimiento:</td><td class="valor">{{ optional($d->fecha_nacimiento)->format('d/m/Y') }}</td></tr>
            <tr><td class="label">Domicilio:</td><td class="valor">{{ $d->domicilio }}</td></tr>
        </table>

        <div class="seccion">Datos de los padres</div>
        <table class="datos">
            <tr><td class="label">Nombre del padre:</td><td class="valor">{{ $d->nombre_padre }} ({{ $d->edad_padre }} años)</td></tr>
            <tr><td class="label">Escolaridad / Ocupación:</td><td class="valor">{{ $d->grado_estudios_padre }} — {{ $d->ocupacion_padre }}</td></tr>
            <tr><td class="label">Nombre de la madre:</td><td class="valor">{{ $d->nombre_madre }} ({{ $d->edad_madre }} años)</td></tr>
            <tr><td class="label">Escolaridad / Ocupación:</td><td class="valor">{{ $d->grado_estudios_madre }} — {{ $d->ocupacion_madre }}</td></tr>
        </table>

        <div class="seccion">Evaluación</div>
        <table class="datos">
            <tr><td class="label">Prueba aplicada:</td><td class="valor">{{ $d->prueba_aplicada }}</td></tr>
            <tr><td class="label">Fecha de aplicación:</td><td class="valor">{{ optional($d->fecha_aplicacion)->format('d/m/Y') }}</td></tr>
            <tr><td class="label">Aplicadora:</td><td class="valor">{{ $d->aplicadora }}</td></tr>
            <tr><td class="label">Motivo de evaluación:</td><td class="valor">{{ $d->motivo_evaluacion }}</td></tr>
        </table>

        <div class="seccion">Historia clínica</div>
        <table class="datos">
            <tr><td class="label">Gestación:</td><td class="valor">{{ $d->hc_gestacion }}</td></tr>
            <tr><td class="label">Talla al nacer:</td><td class="valor">{{ $d->hc_talla_nacer }}</td></tr>
            <tr><td class="label">Peso:</td><td class="valor">{{ $d->hc_peso }}</td></tr>
            <tr><td class="label">APGAR:</td><td class="valor">{{ $d->hc_apgar }}</td></tr>
            <tr><td class="label">Alergias:</td><td class="valor">{{ $d->hc_alergias }}</td></tr>
            <tr><td class="label">Diagnóstico:</td><td class="valor">{{ $d->hc_diagnostico }}</td></tr>
        </table>

        <div class="seccion">Resultados</div>
        <table class="datos">
            <tr><td class="label">Lenguaje:</td><td class="valor">{{ $d->res_lenguaje }}</td></tr>
            <tr><td class="label">Anatómico:</td><td class="valor">{{ $d->res_anatomico }}</td></tr>
            <tr><td class="label">Discriminación:</td><td class="valor">{{ $d->res_discriminacion }}</td></tr>
            <tr><td class="label">Fonética auditiva:</td><td class="valor">{{ $d->res_fonetica_auditiva }}</td></tr>
            <tr><td class="label">Lenguaje espontáneo:</td><td class="valor">{{ $d->res_lenguaje_espontaneo }}</td></tr>
            <tr><td class="label">Nivel de lenguaje:</td><td class="valor">{{ $d->res_nivel_lenguaje }}</td></tr>
            <tr><td class="label">Conducta en valoración:</td><td class="valor">{{ $d->res_conducta_valoracion }}</td></tr>
        </table>

        <div class="seccion">Desarrollo</div>
        <table class="datos">
            <tr><td class="label">Cognitivo:</td><td class="valor">{{ $d->des_cognitivo }}</td></tr>
            <tr><td class="label">Motor:</td><td class="valor">{{ $d->des_motor }}</td></tr>
            <tr><td class="label">Social:</td><td class="valor">{{ $d->des_social }}</td></tr>
            <tr><td class="label">Observaciones:</td><td class="valor">{{ $d->observaciones }}</td></tr>
        </table>

        <div class="seccion">Indicaciones</div>
        <table class="datos">
            <tr><td class="label">Clínicas:</td><td class="valor">{{ $d->ind_clinicas }}</td></tr>
            <tr><td class="label">Familiares:</td><td class="valor">{{ $d->ind_familiares }}</td></tr>
            <tr><td class="label">Adolescencia:</td><td class="valor">{{ $d->ind_adolescencia }}</td></tr>
            <tr><td class="label">Escolares:</td><td class="valor">{{ $d->ind_escolares }}</td></tr>
            <tr><td class="label">Rehabilitadoras:</td><td class="valor">{{ $d->ind_rehabilitadores }}</td></tr>
        </table>
    </main>
</body>
</html>
