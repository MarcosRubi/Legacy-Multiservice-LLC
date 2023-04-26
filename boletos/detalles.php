<?php
require_once '../func/validateSession.php';
if (!isset($_GET['id'])) {
    echo "<script>history.go(-1);</script>";
    return;
}

$editar = false;
if ($_SESSION['IdRole'] <= 2) {
    $editar = true;
}

require_once '../bd/bd.php';
require_once '../class/Boletos.php';
require_once '../class/Ajustes.php';
require_once '../class/OpcionesTablas.php';

$Obj_Boletos = new Boletos();
$Obj_Ajustes = new Ajustes();
$Obj_OpcionesTablas = new OpcionesTablas();

$Res_Boleto = $Obj_Boletos->buscarPorId($_GET['id']);
$Res_OpcionesIatas = $Obj_OpcionesTablas->listarIatas();
$Res_OpcionesTipos = $Obj_OpcionesTablas->listarTipos();
$Res_OpcionesFormasPago = $Obj_OpcionesTablas->listarFormasPagos();


$DatosBoleto = $Res_Boleto->fetch_assoc();

$opcionesIatas = "";
while ($DatoTipoIata = $Res_OpcionesIatas->fetch_assoc()) {
    if ($DatoTipoIata['IdIata'] !== $DatosBoleto['IdIata']) {
        $opcionesIatas .= "<option value=" . $DatoTipoIata['IdIata'] . ">" . $DatoTipoIata['NombreIata'] . "</option>";
    }
}

$opcionesTipo = '';
while ($DatoTipos = $Res_OpcionesTipos->fetch_assoc()) {
    if ($DatoTipos['IdTipo'] !== $DatosBoleto['IdTipo']) {
        $opcionesTipo .= "<option value=" . $DatoTipos['IdTipo'] . ">" . $DatoTipos['NombreTipo'] . "</option>";
    }
}

$opcionesFormaPago = '';
while ($DatoFormaPago = $Res_OpcionesFormasPago->fetch_assoc()) {
    if ($DatoFormaPago['IdFormaPago'] !== $DatosBoleto['IdFormaPago']) {
        $opcionesFormaPago .= "<option value=" . $DatoFormaPago['IdFormaPago'] . ">" . $DatoFormaPago['FormaPago'] . "</option>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalles del Boleto</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <style>
        .form-control {
            display: inline-block !important;
            font-size: 12px !important;
        }

        .form-group label {
            margin-bottom: .25rem !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed" style="font-size:12px !important;">
    <div class="wrapper d-flex justify-content-center pt-3">
        <!-- Main content -->
        <div class="content py-3 mx-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title w-100 font-weight-bold text-center">Detalles del boleto #<?= $DatosBoleto['IdBoleto'] ?></h3>
                        </div>
                        <form action="../forms/boletos/editar.php" method="post" class="card-body" id="frmNuevo">
                            <div class="form-group mx-1 p-2 rounded" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                                <div class="form-group mx-1  ">
                                    <label>Código PNR</label>
                                    <input type="text" class="form-control" placeholder="PNR ..." name="txtPnr" value="<?= $DatosBoleto['Pnr'] ?>" <?= $editar ? '' : 'readonly' ?>>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea" value="<?= $DatosBoleto['Aerolinea'] ?>" <?= $editar ? '' : 'readonly' ?>>
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen" value="<?= $DatosBoleto['Origen'] ?>" <?= $editar ? '' : 'readonly' ?>>
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino" value="<?= $DatosBoleto['Destino'] ?>" <?= $editar ? '' : 'readonly' ?>>
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda" value="<?= $Obj_Ajustes->FechaInvertir($DatosBoleto['FechaIda']) ?>" <?= $editar ? '' : 'disabled' ?>>
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda" value="<?= $Obj_Ajustes->FechaInvertir($DatosBoleto['FechaIda']) ?>" <?= $editar ? '' : 'disabled' ?>>
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso" value="<?= $Obj_Ajustes->FechaInvertir($DatosBoleto['FechaRegreso']) ?>" <?= $editar ? '' : 'disabled' ?>>
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso" value="<?= $Obj_Ajustes->FechaInvertir($DatosBoleto['FechaRegreso']) ?>" <?= $editar ? '' : 'disabled' ?>>
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- IATA -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata" <?= $editar ? '' : 'disabled' ?>>
                                            <?= "<option value=" . $DatosBoleto['IdIata'] . ">" . $DatosBoleto['NombreIata'] . "</option>"; ?>
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo" <?= $editar ? '' : 'disabled' ?>>
                                            <?= "<option value=" . $DatosBoleto['IdTipo'] . ">" . $DatosBoleto['NombreTipo'] . "</option>"; ?>
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="px-2 mb-3 pt-3 rounded fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="1">
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" name="txtBoleto1" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask value="<?= $DatosBoleto['NumeroBoletos'] ?>" <?= $editar ? '' : 'readonly' ?>>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero1" value="<?= $DatosBoleto['NombrePasajero'] ?>" <?= $editar ? '' : 'readonly' ?>>
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob1" value="<?php if ($DatosBoleto['Dob'] !== '0000-00-00') {
                                                                                                                                                                                                                                    echo $Obj_Ajustes->FechaInvertir($DatosBoleto['Dob']);
                                                                                                                                                                                                                                } ?>" <?= $editar ? '' : 'readonly' ?>>
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob1" value="<?php if ($DatosBoleto['Dob'] !== '0000-00-00') {
                                                                                                                                                                                                                                    echo $Obj_Ajustes->FechaInvertir($DatosBoleto['Dob']);
                                                                                                                                                                                                                                } ?>" <?= $editar ? '' : 'readonly' ?>>
                                            <?php } ?>


                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="d-flex  flex-column flex-xl-row">
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago1" <?= $editar ? '' : 'disabled' ?>>
                                            <?= "<option value=" . $DatosBoleto['IdFormaPago'] . ">" . $DatosBoleto['FormaPago'] . "</option>"; ?>
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio1" value="<?= $DatosBoleto['Precio'] ?>" <?= $editar ? '' : 'readonly' ?>>
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase1" value="<?= $DatosBoleto['Base'] ?>" <?= $editar ? '' : 'readonly' ?>>
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax1" value="<?= $DatosBoleto['Tax'] ?>" <?= $editar ? '' : 'readonly' ?>>
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm1" value="<?= $DatosBoleto['Fm'] ?>" <?= $editar ? '' : 'readonly' ?>>
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee1" value="<?= $DatosBoleto['Fee'] !== '' ? $DatosBoleto['Fee'] : '0.00' ?>" <?= $editar ? '' : 'readonly' ?>>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Itinerario</label>
                                    <textarea id="summernote" name="txtItinerario" value="<?= $DatosBoleto['Itinerario'] ?>">

                                </textarea>
                                </div>
                                <input type="hidden" name="nb" id="nb" value="1">
                                <input type="hidden" name="nm" id="nm">
                                <input type="hidden" class="form-control d-none" name="IdCliente" value="<?= $DatosBoleto['IdCliente'] ?>">
                                <input type="hidden" class="form-control d-none" name="IdBoleto" value="<?= $DatosBoleto['IdBoleto'] ?>">
                                <!-- /.form group -->
                                <?= $editar ? '<div class="form-group pr-1 mt-3"><button class="btn btn-primary btn-block btn-lg" type="submit">Guardar cambios</button></div>' : '' ?>

                                <div class="form-group pl-1 pb-3">
                                    <button class="btn btn-block text-center" type="reset" onclick="javascript:closeForm();">Cerrar</button>
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
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- InputMask -->
    <script src="../plugins/moment/moment.min.js"></script>
    <script src="../plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Summernote -->
    <script src="../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- jquery-validation -->
    <script src="../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../plugins/toastr/toastr.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Select2 -->
    <script src="../plugins/select2/js/select2.full.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- Page specific script -->
    <script>
        $(document).ready(function() {
            // Obtener el contenido de PHP en una variable JavaScript
            var newContent = <?= json_encode($DatosBoleto['Itinerario']) ?>;

            // Inicializar Summernote
            $('#summernote').summernote();

            $('#summernote').on('summernote.paste', function(_, e) {
                setTimeout(() => {

                    // Obtener el elemento pre con el id "responseCommand"
                    var preElement = document.getElementById("responseCommand");

                    // Quitar el estilo de fondo
                    preElement.style.backgroundColor = "transparent";

                    // Cambiar el color del texto a #000 (negro)
                    preElement.style.color = "#000";
                    preElement.querySelector('code').style.fontFamily = "Arial";
                }, 200);

            });

            // Establecer el contenido de PHP en Summernote
            $('#summernote').summernote('code', newContent);
        });
    </script>

    <script>
        $(function() {
            // $('.select2').select2()
            //Phone Number
            $('[data-mask]').inputmask()
            // Summernote
            $('#summernote').summernote()
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
            $('#frmNuevo').validate({
                rules: {
                    txtPnr: {
                        required: true
                    },
                    txtBoleto1: {
                        required: true
                    },
                    txtNombrePasajero1: {
                        required: true
                    },
                    txtFechaDob1: {
                        required: true
                    },
                    txtAerolinea: {
                        required: true
                    },
                    txtOrigen: {
                        required: true
                    },
                    txtDestino: {
                        required: true
                    },
                    txtFechaIda: {
                        required: true
                    },
                    txtPrecio1: {
                        required: true
                    },
                    txtBase1: {
                        required: true
                    },
                    txtTax1: {
                        required: true
                    },
                    txtFm1: {
                        required: true
                    }
                },
                messages: {
                    txtPnr: {
                        required: "El PNR es obligatorio",
                    },
                    txtBoleto1: {
                        required: "El # de boleto es obligatorio"
                    },
                    txtNombrePasajero1: {
                        required: "El nombre es obligatorio"
                    },
                    txtFechaDob1: {
                        required: "La fecha es obligatorio"
                    },
                    txtAerolinea: {
                        required: "La aerolínea es obligatorio"
                    },
                    txtOrigen: {
                        required: "El origen es obligatorio"
                    },
                    txtDestino: {
                        required: "El destino es obligatorio"
                    },
                    txtFechaIda: {
                        required: "La fecha de ida es obligatorio"
                    },
                    txtPrecio1: {
                        required: "El precio es obligatorio"
                    },
                    txtBase1: {
                        required: "La base es obligatorio"
                    },
                    txtTax1: {
                        required: "El TAX es obligatorio"
                    },
                    txtFm1: {
                        required: "El FM es obligatorio"
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
        let posicion = 1;
        let formsValidar = [1]
        let inputNb = document.getElementById('nb')

        let posicionMCO = 0;
        let formsValidarMCO = []
        let inputNm = document.getElementById('nm')

        function closeForm() {
            window.close()
        }
    </script>
    <script>
        <?php require_once '../func/Mensajes.php'; ?>
    </script>

</body>

</html>