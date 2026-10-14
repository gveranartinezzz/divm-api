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
        <div class="barra">REPORTE DE AVANCE DE SESIÓN</div>
    </header>

    <footer>Página <span class="page-number"></span></footer>

    <main>
        <div class="seccion">Datos generales</div>
        <table class="datos">
            <tr><td class="label">Paciente:</td><td class="valor">{{ $d->paciente->nombre ?? '' }}</td></tr>
            <tr><td class="label">Especialista:</td><td class="valor">{{ $d->usuario->nombre_completo ?? '' }}</td></tr>
            <tr><td class="label">Fecha de sesión:</td><td class="valor">{{ optional($d->fecha_sesion)->format('d/m/Y') }}</td></tr>
            <tr>
                <td class="label">Horario:</td>
                <td class="valor">
                    {{ $d->hora_inicio ? \Illuminate\Support\Carbon::parse($d->hora_inicio)->format('H:i') : '' }} hrs
                    a
                    {{ $d->hora_fin ? \Illuminate\Support\Carbon::parse($d->hora_fin)->format('H:i') : '' }} hrs
                </td>
            </tr>
            <tr><td class="label">Estatus de la sesión:</td><td class="valor">{{ $d->estatus_sesion }}</td></tr>
        </table>

        <div class="seccion">Actividades realizadas</div>
        <table class="datos">
            <tr><td class="valor">{{ $d->actividades_realizadas }}</td></tr>
        </table>

        <div class="seccion">Observaciones de comportamiento</div>
        <table class="datos">
            <tr><td class="valor">{{ $d->observaciones_comportamiento }}</td></tr>
        </table>

        <div class="seccion">Logros obtenidos</div>
        <table class="datos">
            <tr><td class="valor">{{ $d->logros_obtenidos }}</td></tr>
        </table>

        <div class="seccion">Tareas / recomendaciones</div>
        <table class="datos">
            <tr><td class="valor">{{ $d->tareas_o_recomendaciones }}</td></tr>
        </table>
    </main>
</body>
</html>
