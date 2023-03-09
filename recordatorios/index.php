<?php
require_once '../func/validateSession.php';
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
                                <form>
                                    <div class="row">
                                        <!-- Cliente -->
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Cliente</label>
                                                <input type="text" class="form-control" placeholder="John Doe ...">
                                            </div>
                                        </div>
                                        <!-- Fecha -->
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label>Fecha y Hora:</label>
                                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime">
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
                                                <select class="form-control select2" style="width: 100%;">
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
                                                <textarea id="summernote">
                                                    Escribe <em>tu</em> <u>recordatorio</u> <strong>aquí</strong>
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
                                            <th>Cliente</th>
                                            <th>Fecha y Hora</th>
                                            <th>Estado</th>
                                            <th>Descripción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr data-widget="expandable-table" aria-expanded="true">
                                            <td>183</td>
                                            <td>John Doe</td>
                                            <td>11-7-2014</td>
                                            <td>Approved</td>
                                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.
                                            </td>
                                            <td class="d-flex align-center justify-content-around">
                                                <a href="#" title="Completado"><i class="fa fa-check fa-lg mx-1"></i></a>
                                                <a href="#" title="Editar"><i class="fa fa-edit fa-lg mx-1"></i></a>
                                                <a href="#" title="Eliminar"><i class="fa fa-trash fa-lg mx-1"></i></a>
                                            </td>
                                        </tr>
                                        <tr class="expandable-body">
                                            <td colspan="6">
                                                <p>
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry. Lorem Ipsum has been the industry's standard dummy text
                                                    ever since the 1500s, when an unknown printer took a galley of type
                                                    and scrambled it to make a type specimen book. It has survived not
                                                    only five centuries, but also the leap into electronic typesetting,
                                                    remaining essentially unchanged. It was popularised in the 1960s
                                                    with the release of Letraset sheets containing Lorem Ipsum passages,
                                                    and more recently with desktop publishing software like Aldus
                                                    PageMaker including versions of Lorem Ipsum.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>219</td>
                                            <td>Alexander Pierce</td>
                                            <td>11-7-2014</td>
                                            <td>Pending</td>
                                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.
                                            </td>
                                            <td class="d-flex align-center justify-content-around">
                                                <a href="#" title="Completado"><i class="fa fa-check fa-lg mx-1"></i></a>
                                                <a href="#" title="Editar"><i class="fa fa-edit fa-lg mx-1"></i></a>
                                                <a href="#" title="Eliminar"><i class="fa fa-trash fa-lg mx-1"></i></a>
                                            </td>
                                        </tr>
                                        <tr class="expandable-body">
                                            <td colspan="6">
                                                <p>
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry. Lorem Ipsum has been the industry's standard dummy text
                                                    ever since the 1500s, when an unknown printer took a galley of type
                                                    and scrambled it to make a type specimen book. It has survived not
                                                    only five centuries, but also the leap into electronic typesetting,
                                                    remaining essentially unchanged. It was popularised in the 1960s
                                                    with the release of Letraset sheets containing Lorem Ipsum passages,
                                                    and more recently with desktop publishing software like Aldus
                                                    PageMaker including versions of Lorem Ipsum.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>657</td>
                                            <td>Alexander Pierce</td>
                                            <td>11-7-2014</td>
                                            <td>Approved</td>
                                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.
                                            </td>
                                            <td class="d-flex align-center justify-content-around">
                                                <a href="#" title="Completado"><i class="fa fa-check fa-lg mx-1"></i></a>
                                                <a href="#" title="Editar"><i class="fa fa-edit fa-lg mx-1"></i></a>
                                                <a href="#" title="Eliminar"><i class="fa fa-trash fa-lg mx-1"></i></a>
                                            </td>
                                        </tr>
                                        <tr class="expandable-body">
                                            <td colspan="6">
                                                <p>
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry. Lorem Ipsum has been the industry's standard dummy text
                                                    ever since the 1500s, when an unknown printer took a galley of type
                                                    and scrambled it to make a type specimen book. It has survived not
                                                    only five centuries, but also the leap into electronic typesetting,
                                                    remaining essentially unchanged. It was popularised in the 1960s
                                                    with the release of Letraset sheets containing Lorem Ipsum passages,
                                                    and more recently with desktop publishing software like Aldus
                                                    PageMaker including versions of Lorem Ipsum.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>175</td>
                                            <td>Mike Doe</td>
                                            <td>11-7-2014</td>
                                            <td>Denied</td>
                                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.
                                            </td>
                                            <td class="d-flex align-center justify-content-around">
                                                <a href="#" title="Completado"><i class="fa fa-check fa-lg mx-1"></i></a>
                                                <a href="#" title="Editar"><i class="fa fa-edit fa-lg mx-1"></i></a>
                                                <a href="#" title="Eliminar"><i class="fa fa-trash fa-lg mx-1"></i></a>
                                            </td>
                                        </tr>
                                        <tr class="expandable-body">
                                            <td colspan="6">
                                                <p>
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry. Lorem Ipsum has been the industry's standard dummy text
                                                    ever since the 1500s, when an unknown printer took a galley of type
                                                    and scrambled it to make a type specimen book. It has survived not
                                                    only five centuries, but also the leap into electronic typesetting,
                                                    remaining essentially unchanged. It was popularised in the 1960s
                                                    with the release of Letraset sheets containing Lorem Ipsum passages,
                                                    and more recently with desktop publishing software like Aldus
                                                    PageMaker including versions of Lorem Ipsum.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>134</td>
                                            <td>Jim Doe</td>
                                            <td>11-7-2014</td>
                                            <td>Approved</td>
                                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.
                                            </td>
                                            <td class="d-flex align-center justify-content-around">
                                                <a href="#" title="Completado"><i class="fa fa-check fa-lg mx-1"></i></a>
                                                <a href="#" title="Editar"><i class="fa fa-edit fa-lg mx-1"></i></a>
                                                <a href="#" title="Eliminar"><i class="fa fa-trash fa-lg mx-1"></i></a>
                                            </td>
                                        </tr>
                                        <tr class="expandable-body">
                                            <td colspan="6">
                                                <p>
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry. Lorem Ipsum has been the industry's standard dummy text
                                                    ever since the 1500s, when an unknown printer took a galley of type
                                                    and scrambled it to make a type specimen book. It has survived not
                                                    only five centuries, but also the leap into electronic typesetting,
                                                    remaining essentially unchanged. It was popularised in the 1960s
                                                    with the release of Letraset sheets containing Lorem Ipsum passages,
                                                    and more recently with desktop publishing software like Aldus
                                                    PageMaker including versions of Lorem Ipsum.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>494</td>
                                            <td>Victoria Doe</td>
                                            <td>11-7-2014</td>
                                            <td>Pending</td>
                                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.
                                            </td>
                                            <td class="d-flex align-center justify-content-around">
                                                <a href="#" title="Completado"><i class="fa fa-check fa-lg mx-1"></i></a>
                                                <a href="#" title="Editar"><i class="fa fa-edit fa-lg mx-1"></i></a>
                                                <a href="#" title="Eliminar"><i class="fa fa-trash fa-lg mx-1"></i></a>
                                            </td>
                                        </tr>
                                        <tr class="expandable-body">
                                            <td colspan="6">
                                                <p>
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry. Lorem Ipsum has been the industry's standard dummy text
                                                    ever since the 1500s, when an unknown printer took a galley of type
                                                    and scrambled it to make a type specimen book. It has survived not
                                                    only five centuries, but also the leap into electronic typesetting,
                                                    remaining essentially unchanged. It was popularised in the 1960s
                                                    with the release of Letraset sheets containing Lorem Ipsum passages,
                                                    and more recently with desktop publishing software like Aldus
                                                    PageMaker including versions of Lorem Ipsum.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>832</td>
                                            <td>Michael Doe</td>
                                            <td>11-7-2014</td>
                                            <td>Approved</td>
                                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.
                                            </td>
                                            <td class="d-flex align-center justify-content-around">
                                                <a href="#" title="Completado"><i class="fa fa-check fa-lg mx-1"></i></a>
                                                <a href="#" title="Editar"><i class="fa fa-edit fa-lg mx-1"></i></a>
                                                <a href="#" title="Eliminar"><i class="fa fa-trash fa-lg mx-1"></i></a>
                                            </td>
                                        </tr>
                                        <tr class="expandable-body">
                                            <td colspan="6">
                                                <p>
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry. Lorem Ipsum has been the industry's standard dummy text
                                                    ever since the 1500s, when an unknown printer took a galley of type
                                                    and scrambled it to make a type specimen book. It has survived not
                                                    only five centuries, but also the leap into electronic typesetting,
                                                    remaining essentially unchanged. It was popularised in the 1960s
                                                    with the release of Letraset sheets containing Lorem Ipsum passages,
                                                    and more recently with desktop publishing software like Aldus
                                                    PageMaker including versions of Lorem Ipsum.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>982</td>
                                            <td>Rocky Doe</td>
                                            <td>11-7-2014</td>
                                            <td>Denied</td>
                                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.
                                            </td>
                                            <td class="d-flex align-center justify-content-around">
                                                <a href="#" title="Completado"><i class="fa fa-check fa-lg mx-1"></i></a>
                                                <a href="#" title="Editar"><i class="fa fa-edit fa-lg mx-1"></i></a>
                                                <a href="#" title="Eliminar"><i class="fa fa-trash fa-lg mx-1"></i></a>
                                            </td>
                                        </tr>
                                        <tr class="expandable-body">
                                            <td colspan="6">
                                                <p>
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry. Lorem Ipsum has been the industry's standard dummy text
                                                    ever since the 1500s, when an unknown printer took a galley of type
                                                    and scrambled it to make a type specimen book. It has survived not
                                                    only five centuries, but also the leap into electronic typesetting,
                                                    remaining essentially unchanged. It was popularised in the 1960s
                                                    with the release of Letraset sheets containing Lorem Ipsum passages,
                                                    and more recently with desktop publishing software like Aldus
                                                    PageMaker including versions of Lorem Ipsum.
                                                </p>
                                            </td>
                                        </tr>
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
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                },
                format: 'DD/MM/YYYY hh:mm A'
            });
        })
    </script>

</body>

</html>