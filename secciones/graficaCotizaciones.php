<?php
require_once '../func/validateSession.php';
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


    $Res_Cotizaciones = $Obj_Cotizaciones->cantidadCotizacionesPorEmpleado($DatosEmpleado['Agente']);
    $TotalPorEmpleado .=  intval($Res_Cotizaciones->fetch_assoc()['total_cotizaciones']) . ',';
}

$TotalPorEmpleado .= ']';


?>



<div class="card-body">
    <canvas id="cotizacionesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
</div>

<script>
    $(function() {
        //-------------
        //- DONUT CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
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
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(cotizacionesChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        })
    })
</script>