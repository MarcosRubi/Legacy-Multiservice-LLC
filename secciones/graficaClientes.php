<?php
require_once '../func/validateSession.php';

if ($_SESSION['IdRole'] !== 2) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

require_once '../bd/bd.php';
require_once '../class/Empleados.php';
require_once '../class/Clientes.php';
require_once '../class/Ajustes.php';

$Obj_Empleados = new Empleados();
$Obj_Clientes = new Clientes();
$Obj_Ajustes = new Ajustes();

$Res_Empleados = $Obj_Empleados->ListarEmpleados();

$empleados = '';
$agentes = [];
$TotalPorEmpleado = '[';

while ($DatosEmpleado = $Res_Empleados->fetch_assoc()) {
    $empleados .= "'" . $DatosEmpleado['NombreEmpleado'] . "',";


    $Res_Clientes = $Obj_Clientes->cantidadClientesPorEmpleadoDiaActual($DatosEmpleado['Agente']);
    if ($_POST['filter'] === 'week') {
        $Res_Clientes = $Obj_Clientes->cantidadClientesPorEmpleadoSemanaActual($DatosEmpleado['Agente']);
    }
    if ($_POST['filter'] === 'month') {
        $Res_Clientes = $Obj_Clientes->cantidadClientesPorEmpleadoMesActual($DatosEmpleado['Agente']);
    }
    if ($_POST['filter'] === 'year') {
        $Res_Clientes = $Obj_Clientes->cantidadClientesPorEmpleadoAnioActual($DatosEmpleado['Agente']);
    }
    if ($_POST['filter'] === 'personal') {
        $Res_Clientes = $Obj_Clientes->cantidadClientesPorEmpleadoPersonalizado($DatosEmpleado['Agente'], $Obj_Ajustes->FechaInvertirGuardar($_POST['formData']['txtFechaInicio']), $Obj_Ajustes->FechaInvertirGuardar($_POST['formData']['txtFechaFin']));
    }

    @$TotalPorEmpleado .=  intval($Res_Clientes->fetch_assoc()['total_clientes']) . ',';
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
    echo "<h5 class='position-absolute' style='top: 50%;left: 50%;transform: translate(-50%, -50%);'>No hay clientes creados.<h5>";
}

?>


<div class="card-body">
    <canvas id="clientesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
</div>

<script>
    $(function() {
        var clientesChartCanvas = $('#clientesChart').get(0).getContext('2d')
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

        new Chart(clientesChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        })

    })
</script>