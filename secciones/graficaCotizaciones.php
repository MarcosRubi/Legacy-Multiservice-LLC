<?php
require_once '../func/validateSession.php';

if ($_SESSION['IdRole'] !== 2) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

require_once '../bd/bd.php';
require_once '../class/Empleados.php';
require_once '../class/Cotizaciones.php';

$Obj_Empleados = new Empleados();
$Obj_Cotizaciones = new Cotizaciones();
$Res_Empleados = $Obj_Empleados->ListarEmpleados();


$empleados = '';
$agentes = [];
$TotalPorEmpleado = '[';


while ($DatosEmpleado = $Res_Empleados->fetch_assoc()) {
    $empleados .= "'" . $DatosEmpleado['NombreEmpleado'] . "',";


    $Res_Cotizaciones = $Obj_Cotizaciones->cantidadCotizacionesPorEmpleadoDiaActual($DatosEmpleado['Agente']);
    if ($_POST['filter'] === 'week') {
        $Res_Cotizaciones = $Obj_Cotizaciones->cantidadCotizacionesPorEmpleadoSemanaActual($DatosEmpleado['Agente']);
    }
    if ($_POST['filter'] === 'month') {
        $Res_Cotizaciones = $Obj_Cotizaciones->cantidadCotizacionesPorEmpleadoMesActual($DatosEmpleado['Agente']);
    }
    if ($_POST['filter'] === 'year') {
        $Res_Cotizaciones = $Obj_Cotizaciones->cantidadCotizacionesPorEmpleadoAnioActual($DatosEmpleado['Agente']);
    }

    @$TotalPorEmpleado .=  intval($Res_Cotizaciones->fetch_assoc()['total_cotizaciones']) . ',';
}

$TotalPorEmpleado .= ']';



$string = str_replace(array('[', ']'), '', $TotalPorEmpleado);
$array = explode(',', $string);
$array = array_map('intval', $array);

// Eliminar todos los elementos que no son 0
$array_filtered = array_filter($array, function ($value) {
    return $value !== 0;
});

// Si el tamaño del array filtrado es 0, entonces todos los elementos son 0
if (count($array_filtered) === 0) {
    echo "<h5 class='position-absolute' style='top: 50%;left: 50%;transform: translate(-50%, -50%);'>No hay cotizaciones creadas.<h5>";
}
?>



<div class="card-body">
    <canvas id="cotizacionesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
</div>

<script>
    $(function() {
        var cotizacionesChartCanvas = $('#cotizacionesChart').get(0).getContext('2d')
        var donutData = {
            labels: [
                <?= $empleados ?>
            ],
            datasets: [{
                data: <?= $TotalPorEmpleado ?>,
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            }]
        }
        var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        new Chart(cotizacionesChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        })
    })
</script>