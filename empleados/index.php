<?php
require_once '../func/validateSession.php';

if ($_SESSION['IdRole'] !== 2) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

require_once '../bd/bd.php';
require_once '../class/Empleados.php';
require_once '../class/Ajustes.php';

$Obj_Empleados = new Empleados();
$Obj_Ajustes = new Ajustes();

$Res_Empleados = $Obj_Empleados->listarTodo();

if (isset($_GET['s'])) {
    $Res_Empleados = $Obj_Empleados->buscarEmpleado($_GET['s']);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Empleados | Legacy Multiservice LLC</title>

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
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <style>
        .img-user {
            border-radius: 50%;
            max-width: 5rem;
            cursor: pointer;
            margin: .5rem;
            opacity: 1;
        }

        .img-user.no-opacity {
            opacity: 1;
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
                                            <h3 class='card-title'>Empleados encontrados para: <strong><?= $_GET['s'] ?></strong></h3>
                                            <a href="./" class="btn btn-primary">Listar todo</a>
                                        </div>
                                    <?php } else {
                                        echo "<h3 class='card-title'>Lista de empleados</h3>";
                                    }
                                    ?>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="logs" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Rol</th>
                                                <th>Avatar</th>
                                                <th>Agencia</th>
                                                <th>Agente</th>
                                                <th>Formato de fecha</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($DatosEmpleado = $Res_Empleados->fetch_assoc()) { ?>
                                                <tr>
                                                    <td><?= $DatosEmpleado['NombreEmpleado'] ?></td>
                                                    <td><?= $DatosEmpleado['Email'] ?></td>
                                                    <td><?= $DatosEmpleado['NombreRol'] ?></td>
                                                    <td>
                                                        <img src="../<?= $DatosEmpleado['UrlFoto'] ?>" alt="" class="img-user no-opacity">
                                                    </td>
                                                    <td><?= $DatosEmpleado['Agencia'] ?></td>
                                                    <td><?= $DatosEmpleado['Agente'] ?></td>
                                                    <td><?= $DatosEmpleado['FormatoFecha'] ?></td>
                                                    <td>
                                                        <div class="d-flex justify-content-around">
                                                            <a class="btn btn-md mx-1 bg-lightblue" title="Editar" onclick="javascript:abrirFormEditar(<?= $DatosEmpleado['IdEmpleado'] ?>);">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a class="btn btn-md mx-1 bg-orange" title="Restablecer contraseña" onclick="javascript:restablecerContrasenna(<?= $DatosEmpleado['IdEmpleado'] ?>);">
                                                                <i class="fa fa-key"></i>
                                                            </a>
                                                            <a class="btn btn-md mx-1 bg-danger" title="Eliminar" onclick="javascript:eliminarEmpleado(<?= $DatosEmpleado['IdEmpleado'] ?>);">
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
        function abrirFormEditar(id) {
            window.open('<?= $_SESSION['path'] ?>forms/empleados/frmEditar.php?id=' + id, 'Editar empleado', 'width=1000,height=1000')
        }
        function restablecerContrasenna(id) {
            window.open('<?= $_SESSION['path'] ?>forms/empleados/frmRestablecer.php?id=' + id, 'Restablecer contraseña', 'width=500,height=500')
        }

        function eliminarEmpleado(id) {
            let confirmacion = confirm("¿Está seguro que desea eliminar este empleado?");

            if (confirmacion) {
                window.location.href = '<?= $_SESSION['path'] ?>forms/empleados/eliminar.php?id=' + id
            }
        }
    </script>
    <script>
        <?php require_once '../func/Mensajes.php'; ?>
    </script>

</body>

</html>