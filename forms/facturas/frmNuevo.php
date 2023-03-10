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
    <title>Nueva Factura</title>

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
                            <h3 class="card-title w-100 font-weight-bold text-center">Agregar nueva factura</h3>
                        </div>
                        <form action="./insertar.php" method="post" class="card-body" id="frmNuevo">
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
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo">
                                            <option selected="selected" value="1">Opci??n 1</option>
                                            <option value="2">Opci??n 2</option>
                                            <option value="3">Opci??n 3</option>
                                            <option value="4">Opci??n 4</option>
                                            <option value="5">Opci??n 5</option>
                                        </select>
                                    </div>
                                    <!-- Valor -->
                                    <div class="form-group mx-1 container-fluid">
                                        <label>Valor</label>
                                        <input type="text" class="form-control" placeholder="0.0" name="txtValor">
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <!-- Descripci??n -->
                                    <div class="form-group">
                                        <label>Descripci??n</label>
                                        <textarea id="summernote" name="txtDescripcion">
                                            Escribe <em>la</em> <u>descripci??n</u> <strong>aqu??</strong>
                                        </textarea>
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
                                                            <input type="text" class="form-control" placeholder="0.0" name="txtEfectivo">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right align-middle">Cr??dito</td>
                                                    <td>
                                                        <!-- Valor -->
                                                        <div class="form-group mx-1 container-fluid">
                                                            <input type="text" class="form-control" placeholder="0.0" name="txtCreditoValor">
                                                        </div>
                                                        <div class="form-group mx-1 container-fluid">
                                                            <input type="text" class="form-control" placeholder="??ltimos 4" data-inputmask="'mask': ['9999']" data-mask name="txtCreditoNumero">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right align-middle">Cheque</td>
                                                    <td>
                                                        <!-- Valor -->
                                                        <div class="form-group mx-1 container-fluid mb-0">
                                                            <input type="text" class="form-control" placeholder="0.0" name="txtCheque">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right align-middle">Banco</td>
                                                    <td>
                                                        <!-- Valor -->
                                                        <div class="form-group mx-1 container-fluid mb-0">
                                                            <input type="text" class="form-control" placeholder="0.0" name="txtBanco">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right align-middle">Cup??n</td>
                                                    <td>
                                                        <!-- Valor -->
                                                        <div class="form-group mx-1 container-fluid mb-0">
                                                            <input type="text" class="form-control" placeholder="0.0" name="txtCupon">
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
                                            Escribe <em>la</em> <u>comentario</u> <strong>aqu??</strong>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <input type="text" class="form-control d-none" value="<?= $_GET['id'] ?>" name="txtIdCliente" readonly>
                            <!-- /.form group -->
                            <div class="form-group pr-1 mt-3">
                                <button class="btn btn-primary btn-block btn-lg" type="submit">Agregar factura</button>
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
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $('[data-mask]').inputmask()
            // Summernote
            $('#summernote').summernote()
            $('#comentario').summernote()
        })
    </script>
    <script>
        $(function() {
            $('#frmNuevo').validate({
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
    <?php
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'valor') {
        echo $_SESSION['error-registro'] ?>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'Introduzca un valor.'
            })
        </script>
    <?php
        unset($_SESSION['error-registro']);
    }
    ?>
    <?php
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'pago') {
        echo $_SESSION['error-registro'] ?>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000
            });
            Toast.fire({
                icon: 'error',
                title: 'Selecciona una forma de pago e introduzca la cantidad.'
            })
        </script>
    <?php
        unset($_SESSION['error-registro']);
    }
    ?>
    <?php
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'numeroTarjetaVacio') {
        echo $_SESSION['error-registro'] ?>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000
            });
            Toast.fire({
                icon: 'error',
                title: 'El pago con tarjeta de cr??dito debe ingresar los 4 n??meros finales de la tarjeta.'
            })
        </script>
    <?php
        unset($_SESSION['error-registro']);
    }
    ?>
    <?php
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'numeroTarjetaNoCompleto') {
        echo $_SESSION['error-registro'] ?>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000
            });
            Toast.fire({
                icon: 'error',
                title: 'Rellene los 4 n??meros de la tarjeta de cr??dito.'
            })
        </script>
    <?php
        unset($_SESSION['error-registro']);
    }
    ?>
    <script>
        function closeForm() {
            window.close()
        }
    </script>
</body>

</html>