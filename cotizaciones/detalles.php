<?php
require_once '../func/validateSession.php';
require_once '../class/Ajustes.php';

$Obj_Ajustes = new Ajustes();

if (!isset($_GET['id'])) {
    echo "<script>window.close(); window.location.replace('" . $_SESSION['path'] . "buscar-cliente/');</script>";
    return;
}
require_once '../bd/bd.php';
require_once '../class/Cotizaciones.php';

$Obj_Cotizaciones = new Cotizaciones();

$Res_Cotizaciones = $Obj_Cotizaciones->buscarPorId($_GET['id']);
$DatosCotizacion = $Res_Cotizaciones->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalles de cotización</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
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
                            <div class="card">
                                <div class="card-header text-center">
                                    <h3>Detalles de cotización #<?= $_GET['id'] ?> </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td class="align-middle"># Cliente</td>
                                                <td>
                                                    <!-- Valor -->
                                                    <div class="form-group mx-1 container-fluid mb-0">
                                                        <input type="text" class="form-control" value="<?= "(" . $DatosCotizacion['IdCliente'] . ") " . $DatosCotizacion['PrimerNombre'] . " " . $DatosCotizacion['Apellido'] ?>" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle">Teléfono</td>
                                                <td>
                                                    <!-- Valor -->
                                                    <div class="form-group mx-1 container-fluid mb-0">
                                                        <input type="text" class="form-control" value="<?= $DatosCotizacion['Telefono'] ?>" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle">Creado</td>
                                                <td>
                                                    <!-- Valor -->
                                                    <div class="form-group mx-1 container-fluid mb-0">
                                                        <input type="text" class="form-control" value="<?=$Obj_Ajustes->FechaInvertir(substr($DatosCotizacion['FechaCreado'], 0, -9))?>" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle">PNR(s)</td>
                                                <td>
                                                    <!-- Valor -->
                                                    <div class="form-group mx-1 container-fluid mb-0">
                                                        <input type="text" class="form-control" value="<?= $DatosCotizacion['Pnr'] ?>" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle" style="max-width:5rem;">Fecha de ida <?php if($DatosCotizacion['Regreso'] !== '0000-00-00'){echo " / Fecha de regreso"; } ?> </td>
                                                <td>
                                                    <!-- Valor -->
                                                    <div class="form-group mx-1 container-fluid mb-0">
                                                        <input type="text" class="form-control" value="<?php echo $Obj_Ajustes->FechaInvertir($DatosCotizacion['Ida']);  if($DatosCotizacion['Regreso'] !== '0000-00-00'){echo " / " . $Obj_Ajustes->FechaInvertir($DatosCotizacion['Regreso']);} ?>" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle">Origen / Destino</td>
                                                <td>
                                                    <!-- Valor -->
                                                    <div class="form-group mx-1 container-fluid mb-0">
                                                        <input type="text" class="form-control" value="<?= $DatosCotizacion['Origen'] . " / " . $DatosCotizacion['Destino'] ?>" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle">Comentario</td>
                                                <td>
                                                    <!-- Valor -->
                                                    <div class="form-group mx-1 container-fluid mb-0">
                                                        <input type="text" class="form-control" value="<?= $DatosCotizacion['Comentario'] ?>" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="logs" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Creado</th>
                                                <th>Agente</th>
                                                <th>Agencia</th>
                                                <th>Comentario</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= $DatosCotizacion['FechaCreado'] . " " . $DatosCotizacion['HoraCreado']  ?></td>
                                                <td><?= $DatosCotizacion['Agente'] ?></td>
                                                <td><?= $DatosCotizacion['Agencia'] ?></td>
                                                <td><?= $DatosCotizacion['Comentario'] ?></td>
                                                <td><?= $DatosCotizacion['Accion'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
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
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $('#logs').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <script>
        function cerrarVentana() {
            window.close();
        }
    </script>
</body>

</html>