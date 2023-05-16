<?php
require_once '../../func/validateSession.php';
require_once '../../bd/bd.php';
require_once '../../class/Ajustes.php';
require_once '../../class/Boletos.php';

if ($_SESSION['IdRole'] >= 3) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

$Obj_Ajustes = new Ajustes();
$Obj_Boletos = new Boletos();

$Res_BoletosListado = $Obj_Boletos->listarTodo();

if (isset($_GET['s'])) {
    $Res_BoletosListado = $Obj_Boletos->buscarBoleto($_GET['s']);
}

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
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
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
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <!-- <h2 class="text-center display-4">Buscar Cliente</h2>
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form method="get">
                                <div class="input-group">
                                    <input type="search" class="form-control form-control-lg" placeholder="Buscar..." autofocus name="s">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-lg btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <span class="text-gray">Puedes buscar por cualquier parámetro de la tabla</span>
                        </div>
                    </div> -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <?php
                                    if (isset($_GET['s']) && $_GET['s'] !== "") { ?>
                                        <div class="d-flex justify-content-between mb-2 mt-3">
                                            <h3 class='card-title'>Boletos encontrados para: <strong><?= $_GET['s'] ?></strong></h3>
                                            <a href="./" class="btn btn-primary">Listar todo</a>
                                        </div>
                                    <?php } else {
                                        echo "<h3 class='card-title'>Últimos boletos creados</h3>";
                                    }
                                    ?>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="boletos-logs" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th># Boleto</th>
                                                <th>Nombre del pasajero</th>
                                                <th>Aerolínea</th>
                                                <th>Origen</th>
                                                <th>Destino</th>
                                                <th>Fecha Ida</th>
                                                <th>Fecha Regreso</th>
                                                <th>Forma de pago</th>
                                                <th>Precio</th>
                                                <th>Base</th>
                                                <th>Tax</th>
                                                <th>FM</th>
                                                <th>IATA</th>
                                                <?php if ($_SESSION['IdRole'] <= 3) { ?>
                                                    <th>&nbsp;</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($Res_BoletosListado as $key => $DatosBoleto) {
                                            ?>
                                                <tr>
                                                    <td><?= $DatosBoleto['NumeroBoletos'] ?></td>
                                                    <td><?= $DatosBoleto['NombrePasajero'] ?></td>
                                                    <td><?= $DatosBoleto['Aerolinea'] ?></td>
                                                    <td><?= $DatosBoleto['Origen'] ?></td>
                                                    <td><?= $DatosBoleto['Destino'] ?></td>
                                                    <td><?= $DatosBoleto['FechaIda'] === '0000-00-00' ? '' : $Obj_Ajustes->FechaInvertir($DatosBoleto['FechaIda']) ?></td>
                                                    <td><?= $DatosBoleto['FechaRegreso'] === '0000-00-00' ? '' : $Obj_Ajustes->FechaInvertir($DatosBoleto['FechaRegreso']) ?></td>
                                                    <td><?= $DatosBoleto['FormaPago'] ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosBoleto['Precio']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosBoleto['Base']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosBoleto['Tax']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosBoleto['Fm']) ?></td>
                                                    <td><?= $DatosBoleto['NombreIata'] ?></td>
                                                    <?php if ($_SESSION['IdRole'] <= 3) { ?>
                                                        <td class="d-flex">
                                                            <a class="btn btn-md mx-1 btn-primary" title="Editar" onclick="javascript:editarBoleto(<?= $DatosBoleto['IdBoleto'] ?>);">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a class="btn btn-md mx-1 bg-danger" title="Eliminar" onclick="javascript:eliminarBoleto(<?= $DatosBoleto['IdBoleto'] ?>);">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    <?php  } ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>

                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
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
            $('#boletos-logs').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
        changeTime(null, 'year');

        function eliminarBoleto(id) {
            let confirmacion = confirm("¿Está seguro que desea eliminar el boleto? Esto puede eliminar o modificar los datos de la factura.");

            if (confirmacion) {
                window.location.href = '<?= $_SESSION['path'] ?>forms/boletos/eliminar.php?id=' + id
            }
        }

        function editarBoleto(id) {
            let confirmacion = confirm("¿Está seguro que desea editar el boleto? Esto puede modificar la factura o demás boletos.");

            if (confirmacion) {
                window.open('<?= $_SESSION['path'] ?>boletos/detalles.php?id=' + id, "Editar boleto", "width=2000,height=2000")
            }
        }


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