<?php
require_once '../func/validateSession.php';
require_once '../bd/bd.php';
require_once '../class/Ajustes.php';

$Obj_Ajustes = new Ajustes();

if (!isset($_GET['id'])) {
    echo "<script>window.close(); window.location.replace('" . $_SESSION['path'] . "buscar-cliente/');</script>";
    return;
}
require_once '../class/Cotizaciones.php';
require_once '../class/Movimientos.php';

$Obj_Cotizaciones = new Cotizaciones();
$Obj_Movimientos = new Movimientos();

$Res_Cotizaciones = $Obj_Cotizaciones->buscarPorId($_GET['id']);
$DatosCotizacion = $Res_Cotizaciones->fetch_assoc();

$Res_Movimientos = $Obj_Movimientos->listarMovimientos($_GET['id']);


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
    <!-- summernote -->
    <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
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
                                                        <input type="text" class="form-control" value="<?= $Obj_Ajustes->FechaInvertir(substr($DatosCotizacion['FechaCreado'], 0, -9)) ?>" readonly>
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
                                                <td class="align-middle" style="max-width:5rem;">Fecha de ida <?php if ($DatosCotizacion['Regreso'] !== '0000-00-00') {
                                                                                                                    echo " / Fecha de regreso";
                                                                                                                } ?> </td>
                                                <td>
                                                    <!-- Valor -->
                                                    <div class="form-group mx-1 container-fluid mb-0">
                                                        <input type="text" class="form-control" value="<?php echo $Obj_Ajustes->FechaInvertir($DatosCotizacion['Ida']);
                                                                                                        if ($DatosCotizacion['Regreso'] !== '0000-00-00') {
                                                                                                            echo " / " . $Obj_Ajustes->FechaInvertir($DatosCotizacion['Regreso']);
                                                                                                        } ?>" readonly>
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
                                <div class="card-header d-flex justify-content-center">
                                    <button class="btn btn-primary btn-lg btn-block p-3 px-5 font-weight-bold" onclick="javascript:showForm();">Crear nuevo movimiento</button>
                                </div>
                                <form action="./insertar-movimiento.php" class="m-3 d-none" id="formMovimientos" method="post">
                                    <!-- Comentario -->
                                    <div class="form-group">
                                        <label>Comentario</label>
                                        <textarea id="comentario" name="txtComentario">
                                            Escribe <em>tu</em> <u>comentario</u> <strong>aquí</strong>
                                        </textarea>
                                    </div>
                                    <!-- Accion -->
                                    <div class="form-group mt-5">
                                        <label>Acción</label>
                                        <textarea id="accion" name="txtAccion">
                                            Escribe <em>la</em> <u>acción</u> <strong>aquí</strong>
                                        </textarea>
                                    </div>
                                    <input type="hidden" name="IdCotizacion" value="<?= $_GET['id']; ?>">
                                    <div class="form-group pr-1 mt-3">
                                        <button class="btn btn-primary btn-block btn-lg" type="submit">Guardar</button>
                                    </div>
                                    <div class="form-group pl-1">
                                        <button class="btn btn-block text-center" type="reset" onclick="javascript:hideForm();">Cancelar</button>
                                    </div>
                                </form>
                                <div class="card-body">
                                    <table id="logs" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Creado</th>
                                                <th>Agente</th>
                                                <th>Agencia</th>
                                                <th>Comentario</th>
                                                <th>Acción</th>
                                                <?php if ($_SESSION['NombreRol'] === 'Administrador') { ?>
                                                    <th></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($DatosMovimientos = $Res_Movimientos->fetch_assoc()) {
                                            ?>
                                                <tr>
                                                    <td><?= $Obj_Ajustes->FechaInvertir(substr($DatosMovimientos['Creado'], 0, -9)) . " " . substr($DatosMovimientos['Creado'], 10, 20) . " " . $DatosMovimientos['CreadoTimesTamp']  ?></td>
                                                    <td><?= $DatosMovimientos['Agente'] ?></td>
                                                    <td><?= $DatosMovimientos['Agencia'] ?></td>
                                                    <td><?= $DatosMovimientos['Comentario'] ?></td>
                                                    <td><?= $DatosMovimientos['Accion'] ?></td>
                                                    <?php if ($_SESSION['NombreRol'] === 'Administrador') { ?>
                                                        <td style="width:1rem;">
                                                            <a href="#" title="Eliminar" onclick="javascript:eliminarMovimiento(<?= $DatosMovimientos['IdMovimiento'] ?>)"><i class="fa fa-trash fa-lg"></i></a>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
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
    <!-- Summernote -->
    <script src="../plugins/summernote/summernote-bs4.min.js"></script>
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
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });

        $(function() {
            // Summernote
            $('#comentario').summernote()
            $('#accion').summernote()
        })
    </script>
    <script>
        let form = document.getElementById('formMovimientos');

        function cerrarVentana() {
            window.close();
        }

        function showForm() {
            form.classList.remove('d-none');
        }

        function hideForm() {
            form.classList.add('d-none');
        }

        function eliminarMovimiento(id) {
            let confirmacion = confirm("¿Está seguro que desea eliminar el movimiento?");

            if (confirmacion) {
                window.location.href = './eliminar-movimiento.php?id=' + id
            }
        }
    </script>
    <script>
        <?php require_once '../func/Mensajes.php'; ?>
    </script>
</body>

</html>