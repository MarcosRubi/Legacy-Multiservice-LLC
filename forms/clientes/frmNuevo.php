<?php
require_once '../../func/validateSession.php';

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo Cliente</title>

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
                    <form action="./insertar.php" method="POST" class="card card-info" id="frmNuevo">
                        <div class="card-header">
                            <h3 class="card-title w-100 font-weight-bold text-center">Agregar nuevo cliente</h3>
                        </div>
                        <div class="card-body">
                            <!-- Apellido -->
                            <div class="form-group">
                                <label>Apellido</label>
                                <input type="text" class="form-control" placeholder="Apellido ..." name="txtApellido">
                            </div>
                            <!-- Segundo nombre -->
                            <div class="form-group">
                                <label>Segundo nombre</label>
                                <input type="text" class="form-control" placeholder="Segundo nombre ..." name="txtSegundoNombre">
                            </div>
                            <!-- Primer nombre -->
                            <div class="form-group">
                                <label>Primer nombre</label>
                                <input type="text" class="form-control" placeholder="Primer nombre ..." name="txtPrimerNombre">
                            </div>
                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Teléfono:</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" data-inputmask='"mask": "(999) 9999-9999"' placeholder="(516) 1234-5678" data-mask name="txtTelefono">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- Dirección -->
                            <div class="form-group">
                                <label>Dirección</label>
                                <input type="text" class="form-control" placeholder="Main Street 1234 ..." name="txtDireccion">
                            </div>
                            <!-- Date dd/mm/yyyy -->
                            <div class="form-group">
                                <label>Fecha de nacimiento:</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaNacimiento">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Agregar</button>
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
            $('#datemask').inputmask('dd-mm-yyy', {
                'placeholder': 'dd-mm-yyy'
            })
            $('#datemask2').inputmask('dd-mm-yyy', {
                'placeholder': 'dd-mm-yyy'
            })
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