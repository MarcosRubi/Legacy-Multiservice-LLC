<?php
require_once '../../func/validateSession.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporte diario</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <style>
        .dropdown-item:hover {
            background-color: #555;
        }

        .dropdown-item.active:hover {
            background-color: #007bff;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include_once '../../secciones/navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include_once '../../secciones/mainSidebarContainer.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper pt-3">
            <?php include_once '../../secciones/resumenEstadisticas.php'; ?>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- LINE CHART -->
                        <div class="col-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title" id="title">Ingresos mensuales</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-wrench"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right bg-dark" role="menu">
                                                <a href="#" class="dropdown-item" onclick="javascript:changeTime(event,'year')">Este año</a>
                                                <a href="#" class="dropdown-item" onclick="javascript:changeTime(event,'month')">Este mes</a>
                                                <a href="#" class="dropdown-item" onclick="javascript:changeTime(event,'week')">Esta semana</a>
                                                <a href="#" class="dropdown-item active" onclick="javascript:changeTime(event,'now')">Hoy</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" id="result">

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="d-flex justify-content-center col-12 mt-3">
                            <!-- DONUT CHART -->
                            <div class="card card-danger col mx-2 p-0">
                                <div class="card-header">
                                    <h3 class="card-title">Cotizaciones realizadas</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="resultCotizaciones"></div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <!-- PIE CHART -->
                            <div class="card card-info col mx-2 p-0">
                                <div class="card-header">
                                    <h3 class="card-title">Boletos creados</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="boletosChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <!-- /.card -->
                        <div class="d-flex justify-content-center col-12 mt-3">

                            <!-- PIE CHART -->
                            <div class="card card-warning col mx-2 p-0">
                                <div class="card-header">
                                    <h3 class="card-title">Clientes creados</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="clientesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <!-- PIE CHART -->
                            <div class="card card-success col mx-2 p-0">
                                <div class="card-header">
                                    <h3 class="card-title">Facturas creadas</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="facturasChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.col (RIGHT) -->
                </div>
                <!-- /.row -->
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include_once '../../secciones/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="../../plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            //-------------
            //- DONUT CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var clientesChartCanvas = $('#clientesChart').get(0).getContext('2d')
            var donutData = {
                labels: [
                    'Chrome',
                    'IE',
                    'FireFox',
                    'Safari',
                    'Opera',
                    'Navigator',
                ],
                datasets: [{
                    data: [700, 500, 400, 600, 300, 100],
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

            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var boletosChartCanvas = $('#boletosChart').get(0).getContext('2d')
            var facturasChartCanvas = $('#facturasChart').get(0).getContext('2d')
            var pieData = donutData;
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(boletosChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })
            new Chart(facturasChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })

        })
    </script>
    <script>
        $.ajax({
            url: '../../secciones/graficaPastelCotizaciones.php',
            method: 'POST',
            success: function(response) {
                $('#resultCotizaciones').html(response);
            }
        });
    </script>
    <script>
        const MONTHS = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre']

        const numeroDeSemana = fecha => {
            const DIA_EN_MILISEGUNDOS = 1000 * 60 * 60 * 24,
                DIAS_QUE_TIENE_UNA_SEMANA = 7,
                JUEVES = 4;
            fecha = new Date(Date.UTC(fecha.getFullYear(), fecha.getMonth(), fecha.getDate()));
            let diaDeLaSemana = fecha.getUTCDay(); // Domingo es 0, sábado es 6
            if (diaDeLaSemana === 0) {
                diaDeLaSemana = 7;
            }
            fecha.setUTCDate(fecha.getUTCDate() - diaDeLaSemana + JUEVES);
            const inicioDelAño = new Date(Date.UTC(fecha.getUTCFullYear(), 0, 1));
            const diferenciaDeFechasEnMilisegundos = fecha - inicioDelAño;
            return Math.ceil(((diferenciaDeFechasEnMilisegundos / DIA_EN_MILISEGUNDOS) + 1) / DIAS_QUE_TIENE_UNA_SEMANA);
        };

        changeTime(null, 'now');


        function changeTime(e, filter) {

            $.ajax({
                url: '../../secciones/tablaIngresos.php',
                method: 'POST',
                data: {
                    filter
                },
                success: function(response) {
                    $('#result').html(response);
                }
            });

            let title = document.getElementById('title')
            let date = new Date();

            title.innerHTML = 'Ingresos mensuales' + ' del ' + date.getFullYear()

            e ? document.querySelector('.dropdown-item.active').classList.remove('active') : ''
            if (filter) {
                filter === 'year' ? title.innerHTML = 'Ingresos mensuales' + ' del ' + date.getFullYear() : ''
                filter === 'month' ? title.innerHTML = 'Ingresos para el mes de ' + MONTHS[date.getMonth()] + ' del ' + date.getFullYear() : ''
                filter === 'week' ? title.innerHTML = 'Ingresos para la semana #' + numeroDeSemana(new Date()) + ' del ' + date.getFullYear() : ''
                filter === 'now' ? title.innerHTML = 'Ingresos del día ' + date.getDate() + ' de ' + MONTHS[date.getMonth()] + ' del ' + date.getFullYear() : ''
            }
            e?.target.classList.add('active');
        };
    </script>
    <!-- Page specific script -->

    <script>
        <?php require_once '../../func/Mensajes.php'; ?>
    </script>
</body>

</html>