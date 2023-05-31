<?php
require_once '../../func/validateSession.php';
require_once '../../bd/bd.php';
require_once '../../class/Cotizaciones.php';
require_once '../../class/Ajustes.php';

$Obj_Cotizaciones = new Cotizaciones();
$Obj_Ajustes = new Ajustes();


$Res_Cotizaciones = $Obj_Cotizaciones->listarTodo();

if (isset($_POST['txtFechaInicio'])) {
    $FechaInicio = $Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaInicio']);
    $FechaFin = $Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaFin']);

    if ($FechaInicio === $FechaFin) {
        $Res_Cotizaciones = $Obj_Cotizaciones->ObtenerCotizacionesDeUnDia($FechaInicio, $_POST['rdbTipo']);
    } else {
        $Res_Cotizaciones = $Obj_Cotizaciones->ObtenerCotizacionesPorFechaIngresada($FechaInicio, $FechaFin, $_POST['rdbTipo']);
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resultados de cotizaciones</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-left:0px;">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="pt-3">
                                    <?php if (isset($_POST['txtFechaInicio'])) { ?>
                                        Cotizaciones encontradas de: <strong>
                                            <?= $_POST['txtFechaInicio'] ?></strong> a <strong><?= $_POST['txtFechaFin'] ?></strong>
                                    <?php } else {
                                        echo "ÚLtimas cotizaciones realizadas";
                                    }; ?>
                                </p>
                                <div>
                                    <button class="btn btn-primary btn-lg" onclick="javascript:cerrarVentana();">Cerrar</button>
                                </div>
                            </div>
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="cotizaciones" class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="text-center">
                                                <th>ID</th>
                                                <th>Cliente</th>
                                                <th>PNR(s)</th>
                                                <th>Comentario</th>
                                                <th>Acción</th>
                                                <th>Fecha</th>
                                                <th>Ingresada</th>
                                                <th>Agencia</th>
                                                <th>Agente</th>
                                                <th>Origen</th>
                                                <th>Destino</th>
                                                <th>Ida</th>
                                                <th>Regreso</th>
                                                <th># de Boletos</th>
                                                <th>MAX</th>
                                                <th>$ Cotizado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($DatosCotizaciones = $Res_Cotizaciones->fetch_assoc()) { ?>
                                                <tr>
                                                    <td><a href="#" onclick="javascript:abrirFormDetalles('<?= $_SESSION['path'] . '/cotizaciones/detalles.php?id=' . $DatosCotizaciones['IdCotizacion'] ?>')"><?= $DatosCotizaciones['IdCotizacion'] ?></a></td>
                                                    <td><a href="#" onclick="javascript:mostrarDatosCliente('<?= $DatosCotizaciones['IdCliente'] ?>')"> <?= $DatosCotizaciones['PrimerNombre'] . " " . $DatosCotizaciones['SegundoNombre'] . " " . $DatosCotizaciones['Apellido'] ?></a></td>
                                                    <td><?= $DatosCotizaciones['Pnr'] ?></td>
                                                    <td><?= $DatosCotizaciones['Comentario'] ?></td>
                                                    <td><?= $DatosCotizaciones['Accion'] ?></td>
                                                    <td><?= $DatosCotizaciones['Fecha'] !== '0000-00-00' && $Obj_Ajustes->FechaInvertir($DatosCotizaciones['Fecha']) ?></td>
                                                    <td><?= $Obj_Ajustes->FechaInvertir(substr($DatosCotizaciones['FechaCreado'], 0, -9)) . " " . substr($DatosCotizaciones['FechaCreado'], 10, 20) . " " .  $DatosCotizaciones['HoraCreado'] ?></td>
                                                    <td><?= $DatosCotizaciones['Agencia'] ?></td>
                                                    <td><?= $DatosCotizaciones['Agente'] ?></td>
                                                    <td><?= $DatosCotizaciones['Origen'] ?></td>
                                                    <td><?= $DatosCotizaciones['Destino'] ?></td>
                                                    <td><?= $DatosCotizaciones['Ida'] !== '0000-00-00' ? $Obj_Ajustes->FechaInvertir($DatosCotizaciones['Ida']) : '' ?></td>
                                                    <td><?= $DatosCotizaciones['Regreso'] !== '0000-00-00' ? $Obj_Ajustes->FechaInvertir($DatosCotizaciones['Regreso']) : '' ?></td>
                                                    <td><?= $DatosCotizaciones['NumeroBoletos'] ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosCotizaciones['Max']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosCotizaciones['Cotizado']) ?></td>
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
        </div>
        <!-- /.content-wrapper -->

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
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            window.resizeTo(2000, 800)
            $('#cotizaciones').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $('tr').click(function() {
                $(this).find('td a').addClass('text-white');
                $(this).addClass('bg-success');
            });
        });
    </script>
    <script>
        function abrirFormDetalles(url) {
            window.open(url, 'Detalles cotización', 'width=1000,height=1000')
        }

        function cerrarVentana() {
            window.close();
        }

        function mostrarDatosCliente(id) {
            window.opener.location.href = "<?= $_SESSION['path'] . 'cliente/?id=' ?>" + id;
        }
    </script>
</body>

</html>