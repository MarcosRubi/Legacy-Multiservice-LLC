<?php
require_once '../../func/validateSession.php';

if ($_SESSION['IdRole'] !== 2) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

require_once '../../bd/bd.php';
require_once '../../class/Empleados.php';
require_once '../../class/Ajustes.php';

$Obj_Empleados = new Empleados();
$Obj_Ajustes = new Ajustes();

$Res_Empleados = $Obj_Empleados->buscarPorId($_GET['id']);

$DatosEmpleado = $Res_Empleados->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restablecer Contraseña</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-body">
                <h3 class="login-box-msg">Restablecer contraseña</h3>
                <form action="./restablecer-contrasenna.php" method="post" id="frmRestablecer">
                    <div class="form-group">
                        <label for="passwordAdmin">Contraseña de <?= $_SESSION['NombreEmpleado'] ?></label>
                        <input type="password" class="form-control" name="passwordAdmin" placeholder="Contraseña" id="passwordAdmin">
                    </div>
                    <div class="form-group mt-4">
                        <label for="passwordEmplead">Nueva contraseña para <?= $DatosEmpleado['NombreEmpleado'] ?> </label>
                        <input type="password" class="form-control" name="passwordEmpleado" placeholder="contraseña" id="passwordEmpleado">
                    </div>
                    <input type="hidden" name="IdEmpleado" value="<?= $DatosEmpleado['IdEmpleado'] ?>">
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Restablecer contraseña</button>
                            <button type="reset" class="btn btn-secondary btn-block" onclick="javascript:window.close();">Cancelar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jquery-validation -->
    <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <script>
        $(function() {
            $('#frmRestablecer').validate({
                rules: {
                    passwordEmpleado: {
                        required: true,
                        minlength: 8
                    },
                    passwordAdmin: {
                        required: true,
                        minlength: 8
                    }
                },
                messages: {
                    passwordAdmin: {
                        required: "Ingrese su contraseña",
                        minlength: "La contraseña debe tener al menos 8 carácteres"
                    },
                    passwordEmpleado: {
                        required: "Ingrese la nueva contraseña de <?= $DatosEmpleado['NombreEmpleado'] ?>",
                        minlength: "La contraseña debe tener al menos 8 carácteres"
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
</body>

</html>