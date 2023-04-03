<?php
require_once '../../func/validateSession.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporte de boletos | Legacy Multiservice LLC</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
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

<body class="hold-transition sidebar-mini layout-fixed">
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
                        <!-- /.col (LEFT) -->
                        <div class="col">
                            <!-- LINE CHART -->
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
                                                <a href="#" class="dropdown-item active" onclick="javascript:changeTime(event,'year')">Este año</a>
                                                <a href="#" class="dropdown-item" onclick="javascript:changeTime(event,'month')">Este mes</a>
                                                <a href="#" class="dropdown-item" onclick="javascript:changeTime(event,'week')">Esta semana</a>
                                                <a href="#" class="dropdown-item" onclick="javascript:changeTime(event,'now')">Hoy</a>
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
                        <!-- /.col (RIGHT) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
            <!-- /.card -->

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

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- ChartJS -->
    <script src="../../plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
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

        $(function() {
            $('#logs').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
            changeTime();
        });


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