<?php
require_once '../func/validateSession.php';
require_once '../bd/bd.php';
require_once '../class/Clientes.php';
require_once '../class/Ajustes.php';

$Obj_Clientes = new Clientes();
$Obj_Ajustes = new Ajustes();


if (!isset($_GET['id'])) {
    echo "<script>window.location.replace('" . $_SESSION['path'] . "buscar-cliente/');</script>";
    return;
}
$Res_Clientes = $Obj_Clientes->buscarPorId($_GET['id']);
$DatosCliente = $Res_Clientes->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio | Legacy Multiservice LLC</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <style>
        #logs_wrapper .row:last-child {
            display: none !important;
        }

        #list-results {
            font-size: 14px;
        }
    </style>
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
                    <?php if ($DatosCliente['Eliminado'] === 'N') { ?>
                        <h3 class='display-5'>Datos de: <strong><?= $DatosCliente['PrimerNombre'] . " " . $DatosCliente['SegundoNombre'] . " " . $DatosCliente['Apellido'] ?></strong></h3>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class='display-5'>Información personal</h5>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="logs" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Cliente</th>
                                                    <th>Número De Teléfono</th>
                                                    <th>Dirección</th>
                                                    <th>Fecha de Nac.</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?= $DatosCliente['IdCliente'] ?></td>
                                                    <td><?= $DatosCliente['PrimerNombre'] . " " . $DatosCliente['SegundoNombre'] . " " . $DatosCliente['Apellido']  ?></td>
                                                    <td><?= $DatosCliente['Telefono'] ?></td>
                                                    <td><?php echo $DatosCliente['Cp'];
                                                        if ($DatosCliente['Ciudad'] !== '') {
                                                            echo ", " .  $DatosCliente['Ciudad'];
                                                        }
                                                        if ($DatosCliente['Provincia'] !== '') {
                                                            echo ", " . $DatosCliente['Provincia'];
                                                        } ?>
                                                    </td>
                                                    <td><?php if ($DatosCliente['FechaNacimiento'] !== '0000-00-00') {
                                                            echo $Obj_Ajustes->FechaInvertir($DatosCliente['FechaNacimiento']);
                                                        } ?></td>
                                                    <td>
                                                        <div class="d-flex justify-content-around">
                                                            <a class="btn btn-sm mx-1 btn-primary" title="Editar" onclick="javascript:editarCliente(<?= $DatosCliente['IdCliente'] ?>);">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <?php if ($_SESSION['IdRole'] <= 3) { ?>
                                                                <a href="#" class="btn btn-sm mx-1 btn-primary" title="Eliminar" onclick="javascript:eliminarCliente(<?= $DatosCliente['IdCliente'] ?>);">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            <?php } ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>


                            <!-- /.col -->
                        </div>
                    <?php } else {
                        echo '<div class="d-flex justify-content-center align-middle" style="height:90vh"><div class="d-flex justify-content-center flex-column">';
                        echo '<h1 class=" mt-5 font-weight-bold">Lo sentimos, este cliente no existe o ha sido eliminado</h1>';
                        echo '<a href="' . $_SESSION['path'] . '" class="btn btn-primary btn-lg">Ir a inicio</a>';
                        echo '</div></div>';
                    } ?>
                </div>

                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="display-5">Información adicional</h5>
                        </div>
                        <div class="card-body">
                            <form action="./actualizar-informacion.php" method="POST">
                                <div class="col">
                                    <div class="form-group">
                                        <textarea id="summernote" name="txtInformacion">
                                        <?= $DatosCliente['Informacion'] ?>
                                        </textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="IdCliente" value="<?= $DatosCliente['IdCliente'] ?>">
                                <input type="hidden" name="NombreCliente" value="<?= $DatosCliente['PrimerNombre'] . " " . $DatosCliente['SegundoNombre'] . " " . $DatosCliente['Apellido'] ?>">
                                <button class="btn btn-primary btn-lg font-weight-bold btn-block">Actualizar información</button>
                            </form>
                        </div>
                    </div>
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
    <!-- Summernote -->
    <script src="../plugins/summernote/summernote-bs4.min.js"></script>
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
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
        $(function() {
            $('#list-results').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });

            // Summernote
            $('#summernote').summernote()
        });
    </script>
    <script>
        function nuevaCotizacion() {
            window.open('<?= $_SESSION['path'] ?>forms/cotizaciones/frmNuevo.php', 'Nueva Cotización', 'width=400,height=1000')
        }

        function nuevoBoleto() {
            window.open('<?= $_SESSION['path'] ?>forms/boletos/frmNuevo.php', 'Nuevo Boleto', 'width=2000,height=2000')
        }

        function nuevaFactura() {
            window.open('<?= $_SESSION['path'] ?>forms/facturas/frmNuevo.php', 'Nueva Factura', 'width=1000,height=2000')
        }

        function listarBoletos() {
            window.open('<?= $_SESSION['path'] ?>forms/boletos/listar.php', 'Boletos', 'width=2000,height=2000')
        }

        function listarCotizaciones() {
            window.open('<?= $_SESSION['path'] ?>forms/cotizaciones/listar.php', 'Cotizaciones', 'width=2000,height=2000')
        }

        function listarFacturas() {
            window.open('<?= $_SESSION['path'] ?>forms/facturas/listar.php', 'Facturas', 'width=2000,height=2000')
        }

        function editarCliente(id) {
            window.open('<?= $_SESSION['path'] ?>forms/clientes/frmEditar.php?id=' + id, 'Editar Cliente', 'width=1200,height=500')
        }

        function eliminarCliente(id) {
            let confirmacion = confirm("¿Está seguro que desea eliminar este cliente?");

            if (confirmacion) {
                window.location.href = '<?= $_SESSION['path'] ?>forms/clientes/eliminar.php?id=' + id
            }
        }
    </script>
    <script>
        <?php require_once '../func/Mensajes.php'; ?>
    </script>
</body>

</html>