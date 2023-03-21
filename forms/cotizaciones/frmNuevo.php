<?php
require_once '../../func/validateSession.php';

if (!isset($_GET['id']) && !isset($_GET['nombre'])) {
    echo "<script>window.location.replace('" . $_SESSION['path'] . "buscar-cliente/');</script>";
    return;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nueva Cotización</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper d-flex justify-content-center pt-3">
        <!-- Main content -->
        <div class="content py-3 mx-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title w-100 font-weight-bold text-center">Agregar nueva cotización</h3>
                        </div>
                        <form action="./insertar.php" method="post" class="card-body" id="frmNuevo">
                            <div class="d-flex flex-column flex-xl-row">
                                <!-- Cliente -->
                                <div class="form-group mx-1">
                                    <label>Cliente</label>
                                    <input type="text" class="form-control" disabled value="<?= $_GET['nombre'] ?>">
                                </div>
                                <!-- PNR(s) -->
                                <div class="form-group mx-1">
                                    <label>PNR(s)</label>
                                    <input type="text" class="form-control" placeholder="PNR(s) ..." name="txtPnr">
                                </div>
                                <!-- Comentario -->
                                <div class="form-group mx-1">
                                    <label>Comentario</label>
                                    <input type="text" class="form-control" placeholder="Comentario ..." name="txtComentario">
                                </div>
                                <!-- Acción -->
                                <div class="form-group mx-1">
                                    <label>Acción</label>
                                    <input type="text" class="form-control" placeholder="Acción ..." name="txtAccion">
                                </div>
                                <!-- Fecha dd-mm-yyyy -->
                                <div class="form-group mx-1">
                                    <label>Fecha:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFecha">
                                        <?php } ?>
                                        <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFecha">
                                        <?php } ?>
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <!-- Agencia -->
                                <div class="form-group mx-1">
                                    <label>Agencia</label>
                                    <input type="text" class="form-control" placeholder="Agencia ..." name="txtAgencia" value="<?= $_SESSION['Agencia'] ?>">
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-xl-row">
                                <!-- Agente -->
                                <div class="form-group mx-1">
                                    <label>Agente</label>
                                    <input type="text" class="form-control" placeholder="Agente ..." name="txtAgente" value="<?= $_SESSION['Agente'] ?>">
                                </div>
                                <!-- Origen -->
                                <div class="form-group mx-1">
                                    <label>Origen</label>
                                    <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen">
                                </div>
                                <!-- Destino -->
                                <div class="form-group mx-1">
                                    <label>Destino</label>
                                    <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino">
                                </div>
                                <!-- Fecha Ida -->
                                <div class="form-group mx-1">
                                        <label>Ida:</label>
                                        <div class="input-group date" id="ida" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#ida" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtIda">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#ida" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtIda">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#ida" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- Fecha Regreso -->
                                <div class="form-group mx-1">
                                        <label>Regreso:</label>
                                        <div class="input-group date" id="regreso" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#regreso" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtRegreso">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#regreso" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtRegreso">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#regreso" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- # Boletos -->
                                <div class="form-group mx-1">
                                    <label># Boletos</label>
                                    <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtNumeroBoletos" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                </div>
                                <!-- Cotizado -->
                                <div class="form-group mx-1">
                                    <label>Cotizado</label>
                                    <input type="text" class="form-control" placeholder="Cotizado ..." name="txtCotizado">
                                </div>
                                <!-- MAX -->
                                <div class="form-group mx-1">
                                    <label>MAX</label>
                                    <input type="text" class="form-control" placeholder="Max ..." name="txtMax">
                                </div>
                                <input type="text" class="form-control d-none" name="IdCliente" value="<?= $_GET['id'] ?>">
                            </div>
                            <!-- /.form group -->
                            <div class="form-group pr-1">
                                <button class="btn btn-primary btn-block btn-lg" type="submit">Agregar</button>
                            </div>
                            <div class="form-group pl-1">
                                <button class="btn btn-block text-center" type="reset" onclick="javascript:closeForm();">Cancelar</button>
                            </div>
                        </form>
                        <!-- /.form group -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- InputMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- jquery-validation -->
    <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Select2 -->
    <script src="../../plugins/select2/js/select2.full.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $('[data-mask]').inputmask()
        })
    </script>
    <script>
        $(function() {
            $('#frmNuevo').validate({
                rules: {
                    txtPnr: {
                        required: true
                    },
                    txtAgencia: {
                        required: true
                    },
                    txtAgente: {
                        required: true
                    },
                    txtOrigen: {
                        required: true
                    },
                    txtDestino: {
                        required: true
                    },
                    txtIda: {
                        required: true
                    },
                    txtNumeroBoletos: {
                        required: true
                    },
                },
                messages: {
                    txtPnr: {
                        required: "El PNR es obligatorio",
                    },
                    txtAgencia: {
                        required: "El nombre de agencia es obligatorio",
                    },
                    txtAgente: {
                        required: "El nombre del agente es obligatorio",
                    },
                    txtOrigen: {
                        required: "El lugar de origen es obligatorio",
                    },
                    txtDestino: {
                        required: "El lugar de destino es obligatorio",
                    },
                    txtIda: {
                        required: "La fecha de ida es obligatorio",
                    },
                    txtRegreso: {
                        required: "La fecha de regreso es obligatorio",
                    },
                    txtNumeroBoletos: {
                        required: "El número de boleto es obligatorio",
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
    <script>
        <?php require_once '../../func/Mensajes.php'; ?>
    </script>
    <script>
        function closeForm() {
            window.close()
        }
        <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
            $('#ida').datetimepicker({
                format: 'DD-MM-YYYY'
            });
            $('#regreso').datetimepicker({
                format: 'DD-MM-YYYY'
            });
        <?php  } ?>

        <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
            $('#ida').datetimepicker({
                format: 'MM-DD-YYYY'
            });
            $('#regreso').datetimepicker({
                format: 'MM-DD-YYYY'
            });
        <?php  } ?>
    </script>
</body>

</html>