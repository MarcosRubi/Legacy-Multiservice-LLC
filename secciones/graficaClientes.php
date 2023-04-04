<?php
require_once '../func/validateSession.php';
require_once '../bd/bd.php';
require_once '../class/Empleados.php';
require_once '../class/Clientes.php';

$Obj_Empleados = new Empleados();
$Obj_Clientes = new Clientes();

$Res_Empleados = $Obj_Empleados->ListarEmpleados();

$empleados = '';
$agentes = [];
$TotalPorEmpleado = '[';


while ($DatosEmpleado = $Res_Empleados->fetch_assoc()) {
    $empleados .= "'" . $DatosEmpleado['NombreEmpleado'] . "',";


    $Res_Clientes = $Obj_Clientes->cantidadClientesPorEmpleado($DatosEmpleado['IdEmpleado']);
    $TotalPorEmpleado .=  intval($Res_Clientes->fetch_assoc()['total_clientes']) . ',';
}

$TotalPorEmpleado .= ']';


?>


<div class="card-body">
    <canvas id="clientesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
</div>

<script>
        $(function() {
            //-------------
            //- DONUT CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var clientesChartCanvas = $('#clientesChart').get(0).getContext('2d')
            var donutData = {
                labels: [
                    <?=$empleados?>
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
            new Chart(clientesChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })

        })
    </script>