<?php
require_once '../func/validateSession.php';
require_once '../bd/bd.php';
require_once '../class/Clientes.php';
require_once '../class/Ajustes.php';

$Obj_Clientes = new Clientes();
$Obj_Ajustes = new Ajustes();

$Res_Clientes = $Obj_Clientes->listarTodo();

if (isset($_GET['s'])) {
    $Res_Clientes = $Obj_Clientes->buscarCliente($_GET['s']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar Cliente | Legacy Multiservice LLC</title>

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
                                            <h3 class='card-title'>Clientes encontrados para: <strong><?= $_GET['s'] ?></strong></h3>
                                            <a href="./" class="btn btn-primary">Listar todo</a>
                                        </div>
                                    <?php } else {
                                        echo "<h3 class='card-title'>Últimos clientes creados</h3>";
                                    }
                                    ?>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="logs" class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="text-center">
                                                <th>ID</th>
                                                <th>Apellido</th>
                                                <th>Segundo Nombre</th>
                                                <th>Primer Nombre</th>
                                                <th>Número De Teléfono</th>
                                                <th style="max-width:1rem;">Dirección</th>
                                                <th>Fecha de Nac.</th>
                                                <th>Boletos</th>
                                                <th>Facturas</th>
                                                <th>Cotizaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($DatosCliente = $Res_Clientes->fetch_assoc()) { ?>
                                                <tr>
                                                    <td><a href="<?= $_SESSION['path'] ?>cliente/?id=<?= $DatosCliente['IdCliente'] ?>"><?= $DatosCliente['IdCliente'] ?></a></td>
                                                    <td><?= $DatosCliente['Apellido'] ?></td>
                                                    <td><?= $DatosCliente['SegundoNombre'] ?></td>
                                                    <td><?= $DatosCliente['PrimerNombre'] ?></td>
                                                    <td><?= $DatosCliente['Telefono'] ?></td>
                                                    <td style="text-overflow:ellipsis;"><?= $DatosCliente['Direccion'] ?></td>
                                                    <td><?= $DatosCliente['FechaNacimiento'] !== '0000-00-00' ? $Obj_Ajustes->FechaInvertir($DatosCliente['FechaNacimiento']) : '' ?></td>
                                                    <td>
                                                        <div class="d-flex justify-content-around">
                                                            <a class="btn btn-sm mx-1 btn-primary" title="Agregar" onclick="javascript:nuevoBoleto(<?= $DatosCliente['IdCliente'] ?>);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a href="#" class="btn btn-sm mx-1 btn-primary" title="Listar" onclick="javascript:listarBoletos(<?= $DatosCliente['IdCliente'] ?>);">
                                                                <i class="fa fa-list"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-around">
                                                            <a class="btn btn-sm mx-1 bg-success" title="Agregar" onclick="javascript:nuevaFactura(<?= $DatosCliente['IdCliente'] . ',\'' .  $DatosCliente['PrimerNombre'] . '\',\'' . $DatosCliente['Apellido'] . '\'' ?>);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a class="btn btn-sm mx-1 bg-success" title="Listar" onclick="javascript:listarFacturas(<?= $DatosCliente['IdCliente'] ?>);">
                                                                <i class="fa fa-list"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-around">
                                                            <a class="btn btn-sm mx-1 bg-info" title="Agregar" onclick="javascript:nuevaCotizacion(<?= $DatosCliente['IdCliente'] . ',\'' .  $DatosCliente['PrimerNombre'] . '\',\'' . $DatosCliente['Apellido'] . '\'' ?>);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a class="btn btn-sm mx-1 bg-info" title="Listar" onclick="javascript:listarCotizaciones(<?= $DatosCliente['IdCliente'] ?>);">
                                                                <i class="fa fa-list"></i>
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
        function nuevaCotizacion(id, primerNombre, apellido) {
            window.open('<?= $_SESSION['path'] ?>forms/cotizaciones/frmNuevo.php?id=' + id + '&nombre=' + primerNombre + ' ' + apellido, 'Nueva Cotización', 'width=400,height=1000')
        }

        function nuevoBoleto(id) {
            window.open('<?= $_SESSION['path'] ?>forms/boletos/frmNuevo.php?id=' + id, 'Nuevo Boleto', 'width=2000,height=2000')
        }

        function nuevaFactura(id, primerNombre, apellido) {
            window.open('<?= $_SESSION['path'] ?>forms/facturas/frmNuevo.php?id=' + id + '&nombre=' + primerNombre + ' ' + apellido, 'Nueva Factura', 'width=1000,height=2000')
        }

        function listarBoletos(id) {
            window.open('<?= $_SESSION['path'] ?>forms/boletos/listar.php?id=' + id, 'Boletos', 'width=2000,height=2000')
        }

        function listarCotizaciones(id) {
            window.open('<?= $_SESSION['path'] ?>forms/cotizaciones/listar.php?id=' + id, 'Cotizaciones', 'width=2000,height=2000')
        }

        function listarFacturas(id) {
            window.open('<?= $_SESSION['path'] ?>forms/facturas/listar.php?id=' + id, 'Facturas', 'width=2000,height=2000')
        }
    </script>
    <script>
        <?php require_once '../func/Mensajes.php'; ?>
    </script>

</body>

</html>