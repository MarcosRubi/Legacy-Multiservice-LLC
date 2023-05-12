<?php
require_once '../../func/validateSession.php';
require_once '../../bd/bd.php';
require_once '../../class/Empleados.php';

$Obj_Empleados = new Empleados();
$Res_Roles = $Obj_Empleados->listarRoles();

$Res_Empleado = $Obj_Empleados->buscarPorId($_GET['id']);

$DatosEmpleado = $Res_Empleado->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Empleado</title>

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
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <style>
        .img-user {
            border-radius: 50%;
            max-width: 5rem;
            cursor: pointer;
            margin: .5rem;
        }

        .img-user-container {
            display: flex;
            justify-content: center;
        }

        .img-user {
            opacity: .5;
        }

        .img-user-selected img {
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, #0d47a1 0px 0px 0px 3px;
            opacity: 1;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper d-flex justify-content-center pt-3">
        <!-- Main content -->
        <div class="content" style="min-width:90vw;">
            <div class="container-fluid">
                <div class="row">
                    <orm action="./editar.php" method="POST" class="card card-info" id="frmEditarEmpleado" style="min-width:90vw;" onsubmit="return validarFormulario();">
                        <div class="card-header">
                            <h3 class="card-title w-100 font-weight-bold text-center">Editar empleado</h3>
                        </div>
                        <div class="card-body ">
                            <div class="d-flex flex-column flex-xl-row">
                                <!-- Primer nombre -->
                                <div class="form-group container-fluid">
                                    <label>Nombre del empleado</label>
                                    <input type="text" class="form-control" placeholder="Nombre del empleado ..." name="txtNombreEmpleado" value="<?= $DatosEmpleado['NombreEmpleado'] ?>">
                                </div>
                                <!-- Rol -->
                                <div class="form-group container-fluid">
                                    <label>Cargo</label>
                                    <select class="form-control select2" style="width: 100%;" name="txtIdRole">
                                        <option value="<?= $DatosEmpleado['IdRole'] ?>"><?= $DatosEmpleado['NombreRol'] ?></option>
                                        <?php
                                        while ($Rol = $Res_Roles->fetch_assoc()) {
                                            if ($DatosEmpleado['IdRole'] !== $Rol['IdRole']) { ?>
                                                <option value="<?= $Rol['IdRole'] ?>"><?= $Rol['NombreRol'] ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                                <!-- Email -->
                                <div class="form-group container-fluid">
                                    <label>Email</label>
                                    <input type="email" class="form-control" placeholder="Email ..." name="txtEmail" value="<?= $DatosEmpleado['Email'] ?>">
                                </div>
                                <!-- Agencia -->
                                <div class="form-group container-fluid">
                                    <label>Agencia</label>
                                    <input type="text" class="form-control" placeholder="Agencia ..." name="txtAgencia" value="<?= $DatosEmpleado['Agencia'] ?>">
                                </div>
                                <!-- Agente -->
                                <div class="form-group container-fluid">
                                    <label>Agente</label>
                                    <input type="text" class="form-control" placeholder="Agente ..." name="txtAgente" value="<?= $DatosEmpleado['Agente'] ?>">
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-xl-row">

                                <div class="form-group container-fluid">
                                    <label>Seleccione un avatar</label>
                                    <div class="img-user-container">
                                        <label class="<?= strpos($DatosEmpleado['UrlFoto'], 'avatar1.png') !== false ? 'img-user-selected' : '' ?>">
                                            <input type="radio" name="rdbImg" value="1" <?= strpos($DatosEmpleado['UrlFoto'], 'avatar1.png') !== false ? 'checked=""' : '' ?> class="d-none">
                                            <img src="../../dist/img/avatar1.png" alt="..." class="img-user">
                                        </label>
                                        <label class="<?= strpos($DatosEmpleado['UrlFoto'], 'avatar2.png') !== false ? 'img-user-selected' : '' ?>">
                                            <input type="radio" name="rdbImg" value="2" <?= strpos($DatosEmpleado['UrlFoto'], 'avatar2.png') !== false ? 'checked=""' : '' ?> class="d-none">
                                            <img src="../../dist/img/avatar2.png" alt="..." class="img-user">
                                        </label>
                                        <label class="<?= strpos($DatosEmpleado['UrlFoto'], 'avatar3.png') !== false ? 'img-user-selected' : '' ?>">
                                            <input type="radio" name="rdbImg" value="3" <?= strpos($DatosEmpleado['UrlFoto'], 'avatar3.png') !== false ? 'checked=""' : '' ?> class="d-none">
                                            <img src="../../dist/img/avatar3.png" alt="..." class="img-user">
                                        </label>
                                        <label class="<?= strpos($DatosEmpleado['UrlFoto'], 'avatar4.png') !== false ? 'img-user-selected' : '' ?>">
                                            <input type="radio" name="rdbImg" value="4" <?= strpos($DatosEmpleado['UrlFoto'], 'avatar4.png') !== false ? 'checked=""' : '' ?> class="d-none">
                                            <img src="../../dist/img/avatar4.png" alt="..." class="img-user">
                                        </label>
                                        <label class="<?= strpos($DatosEmpleado['UrlFoto'], 'avatar5.png') !== false ? 'img-user-selected' : '' ?>">
                                            <input type="radio" name="rdbImg" value="5" <?= strpos($DatosEmpleado['UrlFoto'], 'avatar5.png') !== false ? 'checked=""' : '' ?> class="d-none">
                                            <img src="../../dist/img/avatar5.png" alt="..." class="img-user">
                                        </label>
                                        <label class="<?= strpos($DatosEmpleado['UrlFoto'], 'avatar6.png') !== false ? 'img-user-selected' : '' ?>">
                                            <input type="radio" name="rdbImg" value="6" <?= strpos($DatosEmpleado['UrlFoto'], 'avatar6.png') !== false ? 'checked=""' : '' ?> class="d-none">
                                            <img src="../../dist/img/avatar6.png" alt="..." class="img-user">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group container-fluid">
                                    <label>Formato de fecha</label>
                                    <div class="d-flex align-center">
                                        <div class="form-group clearfix mr-5">
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="dmy" name="rdbFormatoFecha" <?= $DatosEmpleado['FormatoFecha'] === 'dmy' ? 'checked' : '' ?> value="dmy">
                                                <label for="dmy">DD-MM-YYYY</label>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="mdy" name="rdbFormatoFecha" <?= $DatosEmpleado['FormatoFecha'] === 'mdy' ? 'checked' : '' ?> value="mdy">
                                                <label for="mdy">MM-DD-YYYY</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="IdEmpleado" value="<?= $DatosEmpleado['IdEmpleado'] ?>">
                        <label class="text-danger text-sm text-center mb-3">El empleado debe cerrar sesión y volver a ingresar para visualizar los cambios</label>
                        <div class="form-group">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Actualizar datos</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-block text-center" type="reset" onclick="javascript:closeForm();">Cancelar</button>
                        </div>
                </div>
                <!-- /.form group -->
                </form>
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
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            //Phone Number
            $('[data-mask]').inputmask()
        })
        $(document).ready(function() {
            $('input[type="radio"][name="rdbImg"]').click(function() {
                $('label').removeClass('img-user-selected');
                $(this).closest('label').addClass('img-user-selected');
            });
        });

        function validarFormulario() {
            var radios = document.getElementsByName('rdbImg');
            var imgSeleccionada = false;
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    imgSeleccionada = true;
                    break;
                }
            }
            if (!imgSeleccionada) {
                alert('Seleccione un avatar');
                return false;
            }
            return true;
        }
    </script>
    <script>
        $(function() {
            $('#frmEditarEmpleado').validate({
                rules: {
                    txtNombreEmpleado: {
                        required: true
                    },
                    txtAgencia: {
                        required: true
                    },
                    txtAgente: {
                        required: true
                    },
                    txtEmail: {
                        required: true,
                        email: true
                    },
                    txtContrasenna: {
                        required: true,
                        minlength: 8
                    }
                },
                messages: {
                    txtNombreEmpleado: {
                        required: "El nombre es obligatorio",
                    },
                    txtAgencia: {
                        required: "La agencia es obligatoria",
                    },
                    txtAgente: {
                        required: "El agente es obligatorio",
                    },
                    txtEmail: {
                        required: "El email es obligatorio",
                        email: "El correo no es válido"
                    },
                    txtContrasenna: {
                        required: "La contraseña es obligatoria",
                        minlength: "La contraseña debe tener al menos 8 caracteres"
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