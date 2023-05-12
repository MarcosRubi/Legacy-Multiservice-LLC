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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
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

                                <!-- <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i>
                                    </button>
                                </div> -->
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="./frmResultados.php" id="frmBuscar">
                                    <div class="row">
                                        <!-- Fecha Desde -->
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Desde:</label>
                                                <div class="input-group date" id="datefrom" data-target-input="nearest">
                                                    <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                        <input type="text" class="form-control datetimepicker-input" data-target="#datefrom" data-inputmask-alias="datetime" placeholder="dd-mm-yyyy" name="txtFechaInicio">
                                                    <?php } ?>
                                                    <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                        <input type="text" class="form-control datetimepicker-input" data-target="#datefrom" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaInicio">
                                                    <?php } ?>
                                                    <div class="input-group-append" data-target="#datefrom" data-toggle="datetimepicker">
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
                                                    <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                        <input type="text" class="form-control datetimepicker-input" data-target="#dateto" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaFin">
                                                    <?php } ?>
                                                    <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                        <input type="text" class="form-control datetimepicker-input" data-target="#dateto" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaFin">
                                                    <?php } ?>
                                                    <div class="input-group-append" data-target="#dateto" data-toggle="datetimepicker">
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
                                                    <input class="form-check-input" type="radio" name="rdbTipo" checked="" value="FechaCreado">
                                                    <label class="form-check-label">Fecha ingresada</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="rdbTipo" value="Ida">
                                                    <label class="form-check-label">Fecha de ida</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="rdbTipo" value="Regreso">
                                                    <label class="form-check-label">Fecha de regreso</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary font-weight-bold btn-block">Retraer reporte</button>
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
    <!-- InputMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- jquery-validation -->
    <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>

    <!-- Page specific script -->
    <script>
        $(function() {
            //Phone Number
            $('[data-mask]').inputmask()

            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                //Date picker
                $('#datefrom').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
            <?php } ?>
            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                //Date picker
                $('#datefrom').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
            <?php } ?>

        })
    </script>
    <script>
        $(function() {
            $('#frmBuscar').validate({
                rules: {
                    txtFechaInicio: {
                        required: true
                    },
                    txtFechaFin: {
                        required: true
                    }
                },
                messages: {
                    txtFechaInicio: {
                        required: "Este campo es obligatorio",
                    },
                    txtFechaFin: {
                        required: "Este campo es obligatorio",
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
        })
    </script>

</body>

</html>