<?php
require_once '../func/validateSession.php';

if ($_SESSION['IdRole'] !== 2) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

require_once '../bd/bd.php';
require_once '../bd/bd.php';
require_once '../class/Facturas.php';
require_once '../class/Ajustes.php';

$Obj_Facturas = new Facturas();
$Obj_Ajustes = new Ajustes();

$Res_FacturasPorMes = $Obj_Facturas->obtenerTotalesPorMesFacturas();
$Res_FacturasPorMesActual = $Obj_Facturas->obtenerTotalesDelMesActual();
$Res_FacturasPorSemanaActual = $Obj_Facturas->obtenerTotalesPorSemana();
$Res_FacturasPorDiaActual = $Obj_Facturas->obtenerTotalesDiaActual();
$Res_FacturasPorFechaPersonalizada = $Obj_Facturas->obtenerTotalesFechaPersonalizada($Obj_Ajustes->FechaInvertirGuardar($_POST['formData']['txtFechaInicio']), $Obj_Ajustes->FechaInvertirGuardar($_POST['formData']['txtFechaFin']));
$CantidadSemanas = intval($Obj_Ajustes->ObtenerCantidadSemanasMesActual()->fetch_assoc()['semanas_del_mes_actual']);


$ingresosPorMes = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
$ingresosSemanaActual = [0, 0, 0, 0, 0, 0, 0];
$ingresosDiaActual = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
$ingresosMesActual = [0, 0, 0, 0, 0, 0];
$ingresosFechaPersonalizada = [];

if ($_POST['formData']['txtFechaInicio'] !== '') {
    $ingresosFechaPersonalizada[0] = $Res_FacturasPorFechaPersonalizada->fetch_assoc()['Total'];
}

// Obtiene el número de días en el mes de abril del 2023
$num_dias = date('t');

// Itera sobre todos los días del mes y obtiene el número de la semana para cada día
$semanas = array();
for ($dia = 1; $dia <= $num_dias; $dia++) {
    $semana = date('W', strtotime(date('Y-m') . "-$dia"));
    if (!in_array($semana, $semanas)) {
        $semanas[] = $semana;
    }
}

$ultimoElemento = end($semanas);

$semanas[] = number_format($ultimoElemento + 1);

while ($valor = $Res_FacturasPorMesActual->fetch_assoc()) {
    $semana_valor = $valor['Semana'];

    for ($i = 0; $i < ($CantidadSemanas); $i++) {
        if (intval($semanas[$i]) === intval($semana_valor)) {
            $ingresosMesActual[$i] = $valor['Total'] + $valor['Balance'];
        }
    }
}
while ($valor = $Res_FacturasPorMes->fetch_assoc()) {
    if ($valor['Mes'] === '1') {
        $ingresosPorMes[0] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['Mes'] === '2') {
        $ingresosPorMes[1] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['Mes'] === '3') {
        $ingresosPorMes[2] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['Mes'] === '4') {
        $ingresosPorMes[3] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['Mes'] === '5') {
        $ingresosPorMes[4] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['Mes'] === '6') {
        $ingresosPorMes[5] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['Mes'] === '7') {
        $ingresosPorMes[6] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['Mes'] === '8') {
        $ingresosPorMes[7] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['Mes'] === '9') {
        $ingresosPorMes[8] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['Mes'] === '10') {
        $ingresosPorMes[9] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['Mes'] === '11') {
        $ingresosPorMes[10] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['Mes'] === '12') {
        $ingresosPorMes[11] = $valor['Total'] + $valor['Balance'];
    }
}
while ($valor = $Res_FacturasPorSemanaActual->fetch_assoc()) {
    if ($valor['DiaSemana'] === '1') {
        $ingresosSemanaActual[0] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['DiaSemana'] === '2') {
        $ingresosSemanaActual[1] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['DiaSemana'] === '3') {
        $ingresosSemanaActual[2] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['DiaSemana'] === '4') {
        $ingresosSemanaActual[3] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['DiaSemana'] === '5') {
        $ingresosSemanaActual[4] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['DiaSemana'] === '6') {
        $ingresosSemanaActual[5] = $valor['Total'] + $valor['Balance'];
    }
    if ($valor['DiaSemana'] === '7') {
        $ingresosSemanaActual[6] = $valor['Total'] + $valor['Balance'];
    }
}
while ($valor = $Res_FacturasPorDiaActual->fetch_assoc()) {
    if ($valor['Hora_Rango'] === '8:00-8:59') {
        $ingresosDiaActual[0] = doubleval($valor['Total']) + doubleval($valor['Balance']);
    }
    if ($valor['Hora_Rango'] === '9:00-9:59') {
        $ingresosDiaActual[1] = doubleval($valor['Total']) + doubleval($valor['Balance']);
    }
    if ($valor['Hora_Rango'] === '10:00-10:59') {
        $ingresosDiaActual[2] = doubleval($valor['Total']) + doubleval($valor['Balance']);
    }
    if ($valor['Hora_Rango'] === '11:00-11:59') {
        $ingresosDiaActual[3] = doubleval($valor['Total']) + doubleval($valor['Balance']);
    }
    if ($valor['Hora_Rango'] === '12:00-12:59') {
        $ingresosDiaActual[4] = doubleval($valor['Total']) + doubleval($valor['Balance']);
    }
    if ($valor['Hora_Rango'] === '1:00-1:59') {
        $ingresosDiaActual[5] = doubleval($valor['Total']) + doubleval($valor['Balance']);
    }
    if ($valor['Hora_Rango'] === '2:00-2:59') {
        $ingresosDiaActual[6] = doubleval($valor['Total']) + doubleval($valor['Balance']);
    }
    if ($valor['Hora_Rango'] === '3:00-3:59') {
        $ingresosDiaActual[7] = doubleval($valor['Total']) + doubleval($valor['Balance']);
    }
    if ($valor['Hora_Rango'] === '4:00-4:59') {
        $ingresosDiaActual[8] = doubleval($valor['Total']) + doubleval($valor['Balance']);
    }
    if ($valor['Hora_Rango'] === '5:00-5:59') {
        $ingresosDiaActual[9] = doubleval($valor['Total']) + doubleval($valor['Balance']);
    }
    if ($valor['Hora_Rango'] === '18:00-18:59') {
        $ingresosDiaActual[10] = doubleval($valor['Total']) + doubleval($valor['Balance']);
    }
    if ($valor['Hora_Rango'] === '19:00-23:59') {
        $ingresosDiaActual[11] = doubleval($valor['Total']) + doubleval($valor['Balance']);
    }
}

?>

<div class="chart">
    <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
</div>

<script>
    $(function() {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        let areaChartData = {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Facturas',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [
                    <?= $ingresosPorMes[0] ?>,
                    <?= $ingresosPorMes[1] ?>,
                    <?= $ingresosPorMes[2] ?>,
                    <?= $ingresosPorMes[3] ?>,
                    <?= $ingresosPorMes[4] ?>,
                    <?= $ingresosPorMes[5] ?>,
                    <?= $ingresosPorMes[6] ?>,
                    <?= $ingresosPorMes[7] ?>,
                    <?= $ingresosPorMes[8] ?>,
                    <?= $ingresosPorMes[9] ?>,
                    <?= $ingresosPorMes[10] ?>,
                    <?= $ingresosPorMes[11] ?>,
                ]
            }]
        }

        <?php if (isset($_POST['filter']) && $_POST['filter'] === 'month') { ?>
            areaChartData = {
                labels: ['Semana 01', 'Semana 02', 'Semana 03', 'Semana 04',
                    <?php if ($CantidadSemanas > 4) {
                        echo "'Semana 05'";
                    } ?>,
                    <?php if ($CantidadSemanas > 5) {
                        echo "'Semana 06'";
                    } ?>
                ],
                datasets: [{
                    label: 'Facturas',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [
                        <?= $ingresosMesActual[0] ?>,
                        <?= $ingresosMesActual[1] ?>,
                        <?= $ingresosMesActual[2] ?>,
                        <?= $ingresosMesActual[3] ?>,
                        <?php if ($CantidadSemanas > 4) {
                            echo $ingresosMesActual[4] . ",";
                        } ?>
                        <?php if ($CantidadSemanas > 5) {
                            echo $ingresosMesActual[5];
                        } ?>,
                    ]
                }]
            }
        <?php } ?>
        <?php if (isset($_POST['filter']) && $_POST['filter'] === 'week') { ?>
            areaChartData = {
                labels: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                datasets: [{
                    label: 'Facturas',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [
                        <?php if (isset($ingresosSemanaActual[0])) {
                            echo $ingresosSemanaActual[0];
                        } else {
                            echo 0;
                        } ?>,
                        <?php if (isset($ingresosSemanaActual[1])) {
                            echo $ingresosSemanaActual[1];
                        } else {
                            echo 0;
                        } ?>,
                        <?php if (isset($ingresosSemanaActual[2])) {
                            echo $ingresosSemanaActual[2];
                        } else {
                            echo 0;
                        } ?>,
                        <?php if (isset($ingresosSemanaActual[3])) {
                            echo $ingresosSemanaActual[3];
                        } else {
                            echo 0;
                        } ?>,
                        <?php if (isset($ingresosSemanaActual[4])) {
                            echo $ingresosSemanaActual[4];
                        } else {
                            echo 0;
                        } ?>,
                        <?php if (isset($ingresosSemanaActual[5])) {
                            echo $ingresosSemanaActual[5];
                        } else {
                            echo 0;
                        } ?>,
                        <?php if (isset($ingresosSemanaActual[6])) {
                            echo $ingresosSemanaActual[6];
                        } else {
                            echo 0;
                        } ?>,
                    ]
                }]
            }
        <?php } ?>
        <?php if (isset($_POST['filter']) && $_POST['filter'] === 'year') { ?>
            areaChartData = {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                datasets: [{
                    label: 'Facturas',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [
                        <?= $ingresosPorMes[0] ?>,
                        <?= $ingresosPorMes[1] ?>,
                        <?= $ingresosPorMes[2] ?>,
                        <?= $ingresosPorMes[3] ?>,
                        <?= $ingresosPorMes[4] ?>,
                        <?= $ingresosPorMes[5] ?>,
                        <?= $ingresosPorMes[6] ?>,
                        <?= $ingresosPorMes[7] ?>,
                        <?= $ingresosPorMes[8] ?>,
                        <?= $ingresosPorMes[9] ?>,
                        <?= $ingresosPorMes[10] ?>,
                        <?= $ingresosPorMes[11] ?>,
                    ]
                }]
            }
        <?php } ?>
        <?php if (isset($_POST['filter']) && $_POST['filter'] === 'now') { ?>
            areaChartData = {
                labels: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00~23:59'],
                datasets: [{
                    label: 'Facturas',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [
                        <?= $ingresosDiaActual[0] ?>,
                        <?= $ingresosDiaActual[1] ?>,
                        <?= $ingresosDiaActual[2] ?>,
                        <?= $ingresosDiaActual[3] ?>,
                        <?= $ingresosDiaActual[4] ?>,
                        <?= $ingresosDiaActual[5] ?>,
                        <?= $ingresosDiaActual[6] ?>,
                        <?= $ingresosDiaActual[7] ?>,
                        <?= $ingresosDiaActual[8] ?>,
                        <?= $ingresosDiaActual[9] ?>,
                        <?= $ingresosDiaActual[10] ?>,
                        <?= $ingresosDiaActual[11] ?>,
                    ]
                }]
            }
        <?php } ?>
        <?php if (isset($_POST['filter']) && $_POST['filter'] === 'personal') { ?>
            areaChartData = {
                labels: [' ', '<?= $_POST['formData']['txtFechaInicio'] . ' al ' . $_POST['formData']['txtFechaFin'] ?>', ''],
                datasets: [{
                    label: 'Facturas',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [
                        <?= $ingresosFechaPersonalizada[0] ?>,
                        <?= $ingresosFechaPersonalizada[0] ?>,
                        <?= $ingresosFechaPersonalizada[0] ?>,
                    ]
                }]
            }
        <?php } ?>


        var areaChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false,
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: false,
                    }
                }]
            }
        }

        //-------------
        //- LINE CHART -
        //--------------
        var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
        var lineChartOptions = $.extend(true, {}, areaChartOptions)
        var lineChartData = $.extend(true, {}, areaChartData)
        lineChartData.datasets[0].fill = false;
        // lineChartData.datasets[1].fill = false;
        lineChartOptions.datasetFill = false

        var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
        })

    })
</script>