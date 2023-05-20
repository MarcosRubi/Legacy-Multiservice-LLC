<?php
require_once '../func/validateSession.php';
require_once '../bd/bd.php';
require_once '../class/Clientes.php';
require_once '../class/Recordatorios.php';
require_once '../class/Ajustes.php';

$Obj_clientes = new Clientes();
$Obj_recordatorios = new Recordatorios();
$Obj_ajustes = new Ajustes();

$Res_Clientes = $Obj_clientes->listarTodo();
$Res_recordatorios = $Obj_recordatorios->listarRecordatorios($_SESSION['IdEmpleado']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recordatorios | Legacy Multiservice LLC</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
    <!-- CodeMirror -->
    <link rel="stylesheet" href="../plugins/codemirror/codemirror.css">
    <link rel="stylesheet" href="../plugins/codemirror/theme/monokai.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include_once '../secciones/navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include_once '../secciones/mainSidebarContainer.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->

            <section class="content">

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card card-outline card-info collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Recordatorios</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="../forms/recordatorios/insertar.php" method="post" id="frmRecordatorios">
                                    <div class="row">
                                        <!-- Título -->
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Título</label>
                                                <input type="text" class="form-control" placeholder="Título ..." name="txtTitulo">
                                            </div>
                                        </div>
                                        <!-- Cliente -->
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Cliente</label>
                                                <select class="form-control select2" style="width: 100%;" name="txtIdCliente">
                                                    <option value="1" selected>Sin asignar cliente</option>
                                                    <?php while ($DatosClientes = $Res_Clientes->fetch_assoc()) { ?>
                                                        <option value="<?= $DatosClientes['IdCliente'] ?>"><?= $DatosClientes['PrimerNombre'] . " " . $DatosClientes['SegundoNombre']  . " " .  $DatosClientes['Apellido'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Fecha -->
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label>Fecha y Hora:</label>
                                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime" name="txtFecha">
                                                    <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Estado -->
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <select class="form-control select2" style="width: 100%;" name="txtEstado">
                                                    <option selected="selected">Pendiente</option>
                                                    <option>En Proceso</option>
                                                    <option>Realizado</option>
                                                    <option>Cancelado</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Descripción</label>
                                                <textarea id="summernote" name="txtDescripcion">

                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary font-weight-bold btn-block">Agregar nuevo
                                        recordatorio</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Recordatorios creados</h3>
                            </div>
                            <!-- ./card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Título</th>
                                            <th>Cliente</th>
                                            <th>Fecha y Hora</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($Res_recordatorios as $key => $DatosRecordatorio) { ?>
                                            <tr data-widget="expandable-table" aria-expanded="false">
                                                <td><?= $DatosRecordatorio['IdRecordatorio'] ?></td>
                                                <td><?= $DatosRecordatorio['Titulo'] ?></td>
                                                <td><?php
                                                    if (intval($DatosRecordatorio['IdCliente']) === 1) {
                                                        echo "Sin cliente asignado";
                                                    } else {
                                                        echo $DatosRecordatorio['PrimerNombre'] . " " . $DatosRecordatorio['SegundoNombre'] . " " . $DatosRecordatorio['Apellido'];
                                                    } ?></td>
                                                <td><?= $Obj_ajustes->FechaInvertir($DatosRecordatorio['Fecha']) . " " . $DatosRecordatorio['Hora'] ?></td>
                                                <td><?= $DatosRecordatorio['Estado'] ?></td>
                                                <td class="d-flex align-center justify-content-around">
                                                    <a href="#" title="Completado"><i class="fa fa-check fa-lg mx-1" onclick="javascript:EstadoCompletado(<?= $DatosRecordatorio['IdRecordatorio'] ?>);"></i></a>
                                                    <a href="#" title="Editar" onclick="javascript:EditarRecordatorio(<?= $DatosRecordatorio['IdRecordatorio'] ?>);"><i class="fa fa-edit fa-lg mx-1"></i></a>
                                                    <a href="#" title="Eliminar" onclick="javascript:EstadoEliminar(<?= $DatosRecordatorio['IdRecordatorio'] ?>);"><i class="fa fa-trash fa-lg mx-1"></i></a>
                                                </td>
                                            </tr>
                                            <tr class="expandable-body">
                                                <td colspan="6">
                                                    <p>
                                                        <?= $DatosRecordatorio['Descripcion'] ?>
                                                    </p>
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
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include_once '../secciones/footer.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="../plugins/select2/js/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="../plugins/moment/moment.min.js"></script>
    <script src="../plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- Summernote -->
    <script src="../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- CodeMirror -->
    <script src="../plugins/codemirror/codemirror.js"></script>
    <script src="../plugins/codemirror/mode/css/css.js"></script>
    <script src="../plugins/codemirror/mode/xml/xml.js"></script>
    <script src="../plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <!-- jquery-validation -->
    <script src="../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>

    <!-- Page specific script -->
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            // Summernote
            $('#summernote').summernote()

            //Date and time picker
            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                $('#reservationdatetime').datetimepicker({
                    icons: {
                        time: 'far fa-clock'
                    },
                    format: 'DD-MM-YYYY hh:mm A'

                });
            <?php } else { ?>
                $('#reservationdatetime').datetimepicker({
                    icons: {
                        time: 'far fa-clock'
                    },
                    format: 'MM-DD-YYYY hh:mm A'

                });
            <?php  } ?>
        })

        $(function() {
            $('#frmRecordatorios').validate({
                rules: {
                    txtTitulo: {
                        required: true
                    },
                    txtFecha: {
                        required: true
                    }
                },
                messages: {
                    txtTitulo: {
                        required: "El título es obligatorio",
                    },
                    txtFecha: {
                        required: "La fecha y hora son obligatorios"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            document.querySelectorAll('.card-body')[1].childNodes[0].remove()

        })
    </script>
    <script>
        function EstadoEliminar(id) {
            let confirmacion = confirm("¿Está seguro que desea eliminar el recordatorio?");

            if (confirmacion) {
                window.location.href = '<?= $_SESSION['path'] ?>forms/recordatorios/actualizar.php?id=' + id + '&accion=eliminar'
            }
        }

        function EditarRecordatorio(id) {}

        function EstadoCompletado(id) {
            let confirmacion = confirm("¿Está seguro que desea marcarlo como completado?");

            if (confirmacion) {
                window.location.href = '<?= $_SESSION['path'] ?>forms/recordatorios/actualizar.php?id=' + id + '&accion=completar'
            }
        }
    </script>
    <script>
        <?php require_once '../func/Mensajes.php'; ?>
    </script>

</body>

</html>