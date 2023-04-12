<?php
if (!isset($_GET['id'])) {
    echo "<script>window.location.replace('" . $_SESSION['path'] . "');</script>";
    return;
}

require_once '../../func/validateSession.php';

if ($_SESSION['IdRole'] > 3) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

require_once '../../bd/bd.php';
require_once '../../class/Clientes.php';
require_once '../../class/Ajustes.php';


if(!isset($_GET['id'])){
    echo "<script>window.location.replace('" . $_SESSION['path'] . "');</script>";
    return;
}


$Obj_Clientes = new Clientes();
$Obj_Ajustes = new Ajustes();


$Res_Clientes = $Obj_Clientes->buscarPorId($_GET['id']);
$DatosCliente = $Res_Clientes->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Cliente</title>

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
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper d-flex justify-content-center pt-3">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <form action="./editar.php" method="POST" class="card card-info" id="frmNuevo">
                        <div class="card-header">
                            <h3 class="card-title w-100 font-weight-bold text-center">Editar cliente</h3>
                        </div>
                        <div class="card-body ">
                            <div class="d-flex flex-column flex-xl-row">
                                <!-- Primer nombre -->
                                <div class="form-group mx-1">
                                    <label>Primer nombre</label>
                                    <input type="text" class="form-control" placeholder="Primer nombre ..." name="txtPrimerNombre" value="<?=$DatosCliente['PrimerNombre'] ?>">
                                </div>
                                <!-- Segundo nombre -->
                                <div class="form-group mx-1">
                                    <label>Segundo nombre</label>
                                    <input type="text" class="form-control" placeholder="Segundo nombre ..." name="txtSegundoNombre" value="<?=$DatosCliente['SegundoNombre']?>" >
                                </div>
                                <!-- Apellido -->
                                <div class="form-group mx-1">
                                    <label>Apellido</label>
                                    <input type="text" class="form-control" placeholder="Apellido ..." name="txtApellido" value="<?=$DatosCliente['Apellido']?>">
                                </div>
                                <!-- phone mask -->
                                <div class="form-group mx-1">
                                    <label>Teléfono:</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" data-inputmask='"mask": "(999) 9999-9999"' placeholder="(XXX) XXXX-XXXX" data-mask name="txtTelefono" onkeypress="javascript:typeNumber();" value="<?=$DatosCliente['Telefono']?>">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-xl-row">
                                <!-- Código postal -->
                                <div class="form-group mx-1">
                                    <label>Código postal</label>
                                    <input type="text" class="form-control" placeholder="Código postal ..." name="txtCp" value="<?=$DatosCliente['Cp']?>">
                                </div>
                                <!-- Ciudad -->
                                <div class="form-group mx-1">
                                    <label>Ciudad</label>
                                    <input type="text" class="form-control" placeholder="Ciudad ..." name="txtCiudad" value="<?=$DatosCliente['Ciudad']?>">
                                </div>
                                <!-- Provincia -->
                                <div class="form-group mx-1">
                                    <label>Provincia</label>
                                    <input type="text" class="form-control" placeholder="Provincia ..." name="txtProvincia" value="<?=$DatosCliente['Provincia']?>">
                                </div>
                                <!-- Date dd/mm/yyyy -->
                                <div class="form-group mx-1">
                                    <label>Fecha de nacimiento:</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaNacimiento" value="<?php $Obj_Ajustes->FechaInvertir($DatosCliente['FechaNacimiento'])?>">
                                        <?php } ?>
                                        <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaNacimiento" value="<?php $Obj_Ajustes->FechaInvertir($DatosCliente['FechaNacimiento'])?>">
                                        <?php } ?>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <input type="hidden" name="IdCliente" value="<?=$DatosCliente['IdCliente']?>">
                            <div class="form-group">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Actualizar datos del cliente</button>
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
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            //Phone Number
            $('[data-mask]').inputmask()
        })
    </script>
    <script>
        $(function() {
            $('#frmNuevo').validate({
                rules: {
                    txtApellido: {
                        required: true
                    },
                    txtPrimerNombre: {
                        required: true
                    },
                    txtTelefono: {
                        required: true
                    },
                },
                messages: {
                    txtApellido: {
                        required: "El apellido es obligatorio",
                    },
                    txtPrimerNombre: {
                        required: "El primer nombre es obligatorio",
                    },
                    txtTelefono: {
                        required: "El teléfono es obligatorio",
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