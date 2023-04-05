<?php
require_once '../func/validateSession.php';
require_once '../bd/bd.php';
require_once '../class/Facturas.php';
require_once '../class/Ajustes.php';

$Obj_Facturas = new Facturas();
$Obj_Ajustes = new Ajustes();

$Res_Facturas = $Obj_Facturas->listarTodo();

if (isset($_GET['s'])) {
    $Res_Facturas = $Obj_Facturas->buscarFactura($_GET['s']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar Factura | Legacy Multiservice LLC</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include_once '../secciones/navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include_once '../secciones/mainSidebarContainer.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper pt-3">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <!-- <h2 class="text-center display-4">Buscar Factura</h2>
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
                                            <h3 class='card-title'>Facturas encontradas para: <strong><?= $_GET['s'] ?></strong></h3>
                                            <a href="./" class="btn btn-primary">Listar todo</a>
                                        </div>
                                    <?php } else {
                                        echo "<h3 class='card-title'>Últimas facturas creadas</h3>";
                                    }
                                    ?>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="logs" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Cliente</th>
                                                <th>Valor</th>
                                                <th>Balance</th>
                                                <th>Creado</th>
                                                <th colspan="5" class="text-center">Formas de pago</th>
                                                <th>Comentario</th>
                                                <th>Tipo factura</th>
                                                <th>Agente</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($DatosFactura = $Res_Facturas->fetch_assoc()) { ?>
                                                <tr>
                                                    <td><a href="#" onclick="javascript:abrirFormDetalles(<?= $DatosFactura['IdFactura'] ?>);"><?= $DatosFactura['IdFactura'] ?></a></td>
                                                    <td><?= $DatosFactura['PrimerNombre'] . " " . $DatosFactura['SegundoNombre'] . " " . $DatosFactura['Apellido']  ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosFactura['Valor']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosFactura['Balance']) ?></td>
                                                    <td><?= $Obj_Ajustes->FechaInvertir(substr($DatosFactura['Creado'], 0, -9)) . " " . substr($DatosFactura['Creado'], 10, 20) . " " .  $DatosFactura['CreadoTimestamp'] ?></td>
                                                    <td><?= "<strong>Efectivo:</strong> " . $Obj_Ajustes->FormatoDinero($DatosFactura['Efectivo']) ?></td>
                                                    <td><?= "<strong>Crédito:</strong> " . $Obj_Ajustes->FormatoDinero($DatosFactura['CreditoValor']) ?></td>
                                                    <td><?= "<strong>Banco:</strong> " . $Obj_Ajustes->FormatoDinero($DatosFactura['Banco']) ?></td>
                                                    <td><?= "<strong>Cupon:</strong> " . $Obj_Ajustes->FormatoDinero($DatosFactura['Cupon']) ?></td>
                                                    <td><?= "<strong>Cheque:</strong> " . $Obj_Ajustes->FormatoDinero($DatosFactura['Cheque']) ?></td>
                                                    <td><?= $DatosFactura['Comentario'] ?></td>
                                                    <td><?= $DatosFactura['Tipo'] ?></td>
                                                    <td><?= $DatosFactura['Agente'] ?></td>
                                                    <td>
                                                        <div class="d-flex justify-content-around">
                                                            <a class="btn btn-sm mx-1 bg-lightblue" title="Editar" onclick="javascript:nuevaCotizacion(<?= $DatosFactura['IdFactura'] ?>);">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a class="btn btn-sm mx-1 bg-danger" title="Listar" onclick="javascript:listarCotizaciones(<?= $DatosFactura['IdFactura'] ?>);">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
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

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <?php include_once '../secciones/footer.php'; ?>
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
    <!-- SweetAlert2 -->
    <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $('#logs').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <script>

        function abrirFormDetalles(id) {
            window.open('<?= $_SESSION['path'] ?>facturas/detalles.php?id=' + id, 'Facturas', 'width=1000,height=1000')
        }
    </script>
    <script>
        <?php require_once '../func/Mensajes.php'; ?>
    </script>

</body>

</html>