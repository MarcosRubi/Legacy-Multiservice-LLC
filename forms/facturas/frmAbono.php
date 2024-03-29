<?php
require_once '../../func/validateSession.php';
require_once '../../bd/bd.php';
require_once '../../class/OpcionesTablas.php';


if (!isset($_GET['factura']) || !isset($_GET['nombre']) || !isset($_GET['cliente'])) {
    echo "<script>history.go(-1)</script>";
    return;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo Abono</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
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
                            <h3 class="card-title w-100 font-weight-bold text-center">Agregar nueva abono</h3>
                        </div>
                        <form action="./insertar-abono.php" method="post" class="card-body" id="frmNuevoAbono">
                            <div class="px-2 mb-3 rounded" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                                <div class="d-flex pt-3">
                                    <!-- Cliente -->
                                    <div class="form-group mx-1 container-fluid">
                                        <label>Cliente</label>
                                        <input type="text" class="form-control" value="<?= $_GET['nombre'] ?>" readonly>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1 container-fluid">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" name="txtIdTipo" disabled>
                                            <option value="3" selected>DEP01 - Abono</option>
                                        </select>
                                    </div>
                                    <!-- Valor -->
                                    <div class="form-group mx-1 container-fluid">
                                        <label>Valor</label>
                                        <input type="number" class="form-control" placeholder="0.0" name="txtValor">
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 p-3 rounded" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30%">Forma de pago</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-right align-middle">Efectivo</td>
                                                    <td>
                                                        <!-- Valor -->
                                                        <div class="form-group mx-1 container-fluid mb-0">
                                                            <input type="number" class="form-control" placeholder="0.0" name="txtEfectivo">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right align-middle">Crédito</td>
                                                    <td>
                                                        <!-- Valor -->
                                                        <div class="form-group mx-1 container-fluid">
                                                            <input type="number" class="form-control" placeholder="0.0" name="txtCreditoValor">
                                                        </div>
                                                        <div class="form-group mx-1 container-fluid">
                                                            <input type="text" class="form-control" placeholder="Últimos 4" data-inputmask="'mask': ['9999']" data-mask name="txtCreditoNumero">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right align-middle">Cheque</td>
                                                    <td>
                                                        <!-- Valor -->
                                                        <div class="form-group mx-1 container-fluid mb-0">
                                                            <input type="number" class="form-control" placeholder="0.0" name="txtCheque">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right align-middle">Banco</td>
                                                    <td>
                                                        <!-- Valor -->
                                                        <div class="form-group mx-1 container-fluid mb-0">
                                                            <input type="number" class="form-control" placeholder="0.0" name="txtBanco">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right align-middle">Cupón</td>
                                                    <td>
                                                        <!-- Valor -->
                                                        <div class="form-group mx-1 container-fluid mb-0">
                                                            <input type="number" class="form-control" placeholder="0.0" name="txtCupon">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <div class="px-2 mb-3 p-3 rounded" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                                <div class="d-flex">
                                    <!-- Comentario -->
                                    <div class="form-group">
                                        <label>Comentario</label>
                                        <textarea id="comentario" name="txtComentario">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <input type="text" class="form-control d-none" value="<?= $_GET['cliente'] ?>" name="txtIdCliente" readonly>
                            <input type="text" class="form-control d-none" value="<?= $_GET['factura'] ?>" name="txtIdFactura" readonly>
                            <!-- /.form group -->
                            <div class="form-group pr-1 mt-3">
                                <button class="btn btn-primary btn-block btn-lg" type="submit">Agregar abono</button>
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
    <!-- Summernote -->
    <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- jquery-validation -->
    <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- Select2 -->
    <script src="../../plugins/select2/js/select2.full.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $('[data-mask]').inputmask()
            // Summernote
            $('#summernote').summernote()
            $('#comentario').summernote()

            $('.select2').select2()
        })
    </script>
    <script>
        $(function() {
            $('#frmNuevoAbono').validate({
                rules: {
                    txtValor: {
                        required: true
                    }
                },
                messages: {
                    txtValor: {
                        required: "El valor es obligatorio",
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
    </script>
</body>

</html>