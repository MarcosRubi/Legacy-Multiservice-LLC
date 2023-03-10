<?php
require_once '../../func/validateSession.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar Cotización</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">
    <!-- CodeMirror -->
    <link rel="stylesheet" href="../../plugins/codemirror/codemirror.css">
    <link rel="stylesheet" href="../../plugins/codemirror/theme/monokai.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-left:0px;">
            <!-- Main content -->

            <section class="content">

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">Cotizaciones</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <!-- Fecha Desde -->
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Desde:</label>
                                                <div class="input-group date" id="datefrom" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#datefrom">
                                                    <div class="input-group-append" data-target="#datefrom"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fecha Desde -->
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Hasta:</label>
                                                <div class="input-group date" id="dateto" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#dateto">
                                                    <div class="input-group-append" data-target="#dateto"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 pl-3">
                                            <div class="form-group">
                                                <label>Buscar por:</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="radio1"
                                                        checked="">
                                                    <label class="form-check-label">Fecha ingresada</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="radio1">
                                                    <label class="form-check-label">Fecha de ida</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="radio1">
                                                    <label class="form-check-label">Fecha de regreso</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary font-weight-bold btn-block" onclick="javascript:obtenerResultados();">Retraer reporte</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                </div>

            </section>
            <!-- /.content -->
        </div>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="../../plugins/select2/js/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- Summernote -->
    <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- CodeMirror -->
    <script src="../../plugins/codemirror/codemirror.js"></script>
    <script src="../../plugins/codemirror/mode/css/css.js"></script>
    <script src="../../plugins/codemirror/mode/xml/xml.js"></script>
    <script src="../../plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>

    <!-- Page specific script -->
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            // Summernote
            $('#summernote').summernote()

            //Date picker
            $('#datefrom').datetimepicker({
                format: 'DD/MM/YYYY'
            });
            $('#dateto').datetimepicker({
                format: 'DD/MM/YYYY'
            });
        })
    </script>
    <script>
        function nuevoCliente() {
            window.open('../forms/nuevo-cliente/', 'Nuevo Cliente', 'width=400,height=1000')
        }
        function nuevoClientev2() {
            window.open('../forms/cliente/frmNuevo.php', 'Nuevo Cliente', 'width=2000,height=400')
        }
        
        function obtenerResultados() {
            window.close();
            window.open('./frmResultados.php', 'Resultados de búsqueda', 'width=1400,height=600')
        }
        
    </script>

</body>

</html>