<?php
require_once '../../func/validateSession.php';
if (!isset($_GET['id'])) {
    echo "<script>window.location.replace('" . $_SESSION['path'] . "buscar-cliente/');</script>";
    return;
}

require_once '../../bd/bd.php';
require_once '../../class/Clientes.php';
require_once '../../class/Ajustes.php';
require_once '../../class/OpcionesTablas.php';

$Obj_Clientes = new Clientes();
$Obj_Ajustes = new Ajustes();
$Obj_OpcionesTablas = new OpcionesTablas();

$Res_Clientes = $Obj_Clientes->buscarPorId($_GET['id']);
$Res_OpcionesIatas = $Obj_OpcionesTablas->listarIatas();
$Res_OpcionesTipos = $Obj_OpcionesTablas->listarTipos();
$Res_OpcionesFormasPago = $Obj_OpcionesTablas->listarFormasPagos();

$opcionesIatas = "";
while ($DatoTipoIata = $Res_OpcionesIatas->fetch_assoc()) {
    $opcionesIatas .= "<option value=" . $DatoTipoIata['IdIata'] . ">" . $DatoTipoIata['NombreIata'] . "</option>";
}

$opcionesTipo = '';
while ($DatoTipos = $Res_OpcionesTipos->fetch_assoc()) {
    $opcionesTipo .= "<option value=" . $DatoTipos['IdTipo'] . ">" . $DatoTipos['NombreTipo'] . "</option>";
}

$opcionesFormaPago = '';
while ($DatoFormaPago = $Res_OpcionesFormasPago->fetch_assoc()) {
    $opcionesFormaPago .= "<option value=" . $DatoFormaPago['IdFormaPago'] . ">" . $DatoFormaPago['FormaPago'] . "</option>";
}

if ($Res_Clientes->num_rows === 0) {
    $_SESSION['error'] = 'ClienteNotFound';
    echo "<script>window.location.replace('" . $_SESSION['path'] . "buscar-cliente/');</script>";
}
$DatosClientes = $Res_Clientes->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo Boleto</title>

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
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
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
                            <h3 class="card-title w-100 font-weight-bold text-center">Agregar nuevo boleto</h3>
                        </div>
                        <form action="./insertar.php" method="post" class="card-body" id="frmNuevo">
                            <div class="form-group mx-1 p-2 rounded" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                                <label>Código PNR</label>
                                <input type="text" class="form-control" placeholder="PNR ..." name="txtPnr">
                            </div>
                            <div id="addNewRow">
                                <span class="btn btn-primary mb-1" onclick="mostrarNuevaFila();">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="1">
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" name="txtBoleto1" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero1" value="<?= $DatosClientes['PrimerNombre'] . " " . $DatosClientes['SegundoNombre'] . " " .  $DatosClientes['Apellido'] ?>">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob1" value="<?php if ($DatosClientes['FechaNacimiento'] !== '0000-00-00') {
                                                                                                                                                                                                                                    echo $Obj_Ajustes->FechaInvertir($DatosClientes['FechaNacimiento']);
                                                                                                                                                                                                                                } ?>">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob1" value="<?php if ($DatosClientes['FechaNacimiento'] !== '0000-00-00') {
                                                                                                                                                                                                                                    echo $Obj_Ajustes->FechaInvertir($DatosClientes['FechaNacimiento']);
                                                                                                                                                                                                                                } ?>">
                                            <?php } ?>


                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea1">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen1">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino1">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto1" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto1" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda1">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto1" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda1">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto1" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom1" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom1" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso1">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom1" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso1">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom1" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex  flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata1">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo1">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago1">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio1">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase1">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax1">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm1">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee1">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(1);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="2">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFila(2)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtBoleto2" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero2">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob2">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob2">
                                            <?php } ?>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea2">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen2">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino2">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto2" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto2" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda2">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto2" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda2">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto2" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom2" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom2" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso2">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom2" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso2">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom2" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata2">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo2">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago2">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio2">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase2">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax2">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm2">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee2">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(1);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="3">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFila(3)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtBoleto3" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero3">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob3">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob3">
                                            <?php } ?>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea3">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen3">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino3">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto3" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto3" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda3">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto3" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda3">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto3" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom3" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom3" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso3">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom3" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso3">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom3" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata3">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo3">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago3">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio3">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase3">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax3">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm3">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee3">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(3);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="4">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFila(4)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtBoleto4" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero4">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob4">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob4">
                                            <?php } ?>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea4">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen4">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino4">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto4" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto4" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda4">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto4" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda4">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto4" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom4" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom4" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso4">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom4" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso4">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom4" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata4">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo4">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago4">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio4">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase4">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax4">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm4">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee4">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(4);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="5">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFila(5)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtBoleto5" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero5">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob5">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob5">
                                            <?php } ?>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea5">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen5">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino5">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto5" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto5" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda5">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto5" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda5">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto5" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom5" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom5" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso5">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom5" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso5">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom5" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata5">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo5">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago5">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio5">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase5">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax5">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm5">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee5">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(5);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="6">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFila(6)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtBoleto6" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero6">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob6">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob6">
                                            <?php } ?>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea6">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen6">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino6">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto6" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto6" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda6">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto6" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda6">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto6" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom6" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom6" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso6">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom6" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso6">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom6" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata6">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo6">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago6">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio6">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase6">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax6">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm6">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee6">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(6);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="7">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFila(7)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtBoleto7" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero7">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob7">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob7">
                                            <?php } ?>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea7">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen7">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino7">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto7" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto7" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda7">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto7" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda7">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto7" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom7" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom7" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso7">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom7" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso7">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom7" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata7">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo7">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago7">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio7">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase7">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax7">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm7">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee7">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(7);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="8">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFila(8)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtBoleto8" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero8">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob8">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob8">
                                            <?php } ?>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea8">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen8">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino8">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto8" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto8" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda8">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto8" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda8">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto8" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom8" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom8" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso8">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom8" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso8">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom8" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata8">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo8">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago8">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio8">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase8">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax8">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm8">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee8">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(8);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="9">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFila(9)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtBoleto9" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero9">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob9">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob9">
                                            <?php } ?>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea9">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen9">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino9">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto9" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto9" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda9">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto9" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda9">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto9" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom9" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom9" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso9">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom9" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso9">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom9" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata9">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo9">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago9">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio9">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase9">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax9">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm9">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee9">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(9);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="10">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFila(10)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtBoleto10" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero10">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob10">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob10">
                                            <?php } ?>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea10">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen10">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino10">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto10" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto10" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda10">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto10" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda10">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto10" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom10" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom10" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso10">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom10" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso10">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom10" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata10">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo10">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago10">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio10">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase10">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax10">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm10">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee10">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(10);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="11">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFila(11)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtBoleto11" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero11">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob11">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob11">
                                            <?php } ?>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea11">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen11">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino11">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto11" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto11" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda11">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto11" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda11">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto11" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom11" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom11" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso11">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom11" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso11">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom11" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata11">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo11">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago11">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio11">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase11">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax11">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm11">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee11">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(11);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="12">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFila(12)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtBoleto12" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero12">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob12">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob12">
                                            <?php } ?>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea12">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen12">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino12">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto12" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto12" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda12">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto12" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda12">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto12" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom12" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom12" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso12">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom12" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso12">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom12" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata12">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo12">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago12">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio12">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase12">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax12">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm12">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee12">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(12);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="13">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFila(13)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtBoleto13" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero13">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob13">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob13">
                                            <?php } ?>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea13">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen13">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino13">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto13" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto13" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda13">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto13" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda13">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto13" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom13" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom13" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso13">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom13" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso13">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom13" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata13">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo13">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago13">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio13">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase13">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax13">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm13">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee13">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(13);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="14">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFila(14)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtBoleto14" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero14">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob14">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob14">
                                            <?php } ?>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea14">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen14">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino14">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto14" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto14" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda14">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto14" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda14">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto14" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom14" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom14" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso14">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom14" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso14">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom14" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata14">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo14">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago14">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio14">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase14">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax14">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm14">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee14">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(14);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 pt-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="15">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFila(15)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtBoleto15" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero15">
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob15">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob15">
                                            <?php } ?>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea15">
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen15">
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino15">
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto15" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto15" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda15">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto15" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda15">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#dateto15" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>
                                        <div class="input-group date" id="datefrom15" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom15" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso15">
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom15" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso15">
                                            <?php } ?>
                                            <div class="input-group-append" data-target="#datefrom15" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata15">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo15">
                                            <?= $opcionesTipo ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago15">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio15">
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase15">
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax15">
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm15">
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee15">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pb-2">
                                    <div id="addMCO">
                                        <span class="btn btn-primary mb-1" onclick="agregarMCO(15);">
                                            AGREGAR MCO <i class="fa fa-plus pl-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>


                            <h3 class="font-weight-bold text-center mt-5 d-none" id="title-mco">LISTA DE MCO AGREGADOS</h3>
                            <div class="px-2 mb-3 rounded mco d-none" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="MCO-1">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFilaMCO('MCO-1')"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <div class="form-group mx-1">
                                        <label># MCO</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtMCO1" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Valor</label>
                                        <input type="number" class="form-control" placeholder="Valor ..." name="txtValorMCO1">
                                    </div>
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIataMCO1">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPagoMCO1">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 rounded mco d-none" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="MCO-2">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFilaMCO('MCO-2')"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <div class="form-group mx-1">
                                        <label># MCO</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtMCO2" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Valor</label>
                                        <input type="number" class="form-control" placeholder="Valor ..." name="txtValorMCO2">
                                    </div>
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIataMCO2">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPagoMCO2">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 rounded mco d-none" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="MCO-3">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFilaMCO('MCO-3')"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <div class="form-group mx-1">
                                        <label># MCO</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtMCO3" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Valor</label>
                                        <input type="number" class="form-control" placeholder="Valor ..." name="txtValorMCO3">
                                    </div>
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIataMCO3">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPagoMCO3">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 rounded mco d-none" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="MCO-4">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFilaMCO('MCO-4')"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <div class="form-group mx-1">
                                        <label># MCO</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtMCO4" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Valor</label>
                                        <input type="number" class="form-control" placeholder="Valor ..." name="txtValorMCO4">
                                    </div>
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIataMCO4">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPagoMCO4">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 rounded mco d-none" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="MCO-5">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFilaMCO('MCO-5')"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <div class="form-group mx-1">
                                        <label># MCO</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtMCO5" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Valor</label>
                                        <input type="number" class="form-control" placeholder="Valor ..." name="txtValorMCO5">
                                    </div>
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIataMCO5">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPagoMCO5">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 rounded mco d-none" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="MCO-6">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFilaMCO('MCO-6')"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <div class="form-group mx-1">
                                        <label># MCO</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtMCO6" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Valor</label>
                                        <input type="number" class="form-control" placeholder="Valor ..." name="txtValorMCO6">
                                    </div>
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIataMCO6">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPagoMCO6">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 rounded mco d-none" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="MCO-7">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFilaMCO('MCO-7')"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <div class="form-group mx-1">
                                        <label># MCO</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtMCO7" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Valor</label>
                                        <input type="number" class="form-control" placeholder="Valor ..." name="txtValorMCO7">
                                    </div>
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIataMCO7">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPagoMCO7">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 rounded mco d-none" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="MCO-8">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFilaMCO('MCO-8')"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <div class="form-group mx-1">
                                        <label># MCO</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtMCO8" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Valor</label>
                                        <input type="number" class="form-control" placeholder="Valor ..." name="txtValorMCO8">
                                    </div>
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIataMCO8">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPagoMCO8">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 mb-3 rounded mco d-none" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="MCO-9">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-danger fa-lg fa fa-window-close" onclick="javascript:eliminarFilaMCO('MCO-9')"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <div class="form-group mx-1">
                                        <label># MCO</label>
                                        <input type="text" class="form-control" placeholder="XXX-XXXXXXXXXX" name="txtMCO9" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1">
                                        <label>Valor</label>
                                        <input type="number" class="form-control" placeholder="Valor ..." name="txtValorMCO9">
                                    </div>
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIataMCO9">
                                            <?= $opcionesIatas ?>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPagoMCO9">
                                            <?= $opcionesFormaPago ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Itinerario</label>
                                <textarea id="summernote" name="txtItinerario">
                                    Escribe <em>el</em> <u>itinerario</u> <strong>aquí</strong>
                                </textarea>
                            </div>
                            <input type="hidden" name="nb" id="nb" value="1">
                            <input type="hidden" name="nm" id="nm" >
                            <input type="hidden" class="form-control d-none" name="IdCliente" value="<?= $DatosClientes['IdCliente'] ?>">
                            <!-- /.form group -->
                            <div class="form-group pr-1 mt-3">
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
    <!-- Summernote -->
    <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
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
            // $('.select2').select2()
            //Phone Number
            $('[data-mask]').inputmask()
            // Summernote
            $('#summernote').summernote()
            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                //Date picker
                $('#datefrom1').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto1').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#datefrom2').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto2').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#datefrom3').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto3').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#datefrom4').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto4').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#datefrom5').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto5').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#datefrom6').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto6').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#datefrom7').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto7').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#datefrom8').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto8').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#datefrom9').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto9').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#datefrom10').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto10').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#datefrom11').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto11').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#datefrom12').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto12').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#datefrom13').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto13').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#datefrom14').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto14').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#datefrom15').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#dateto15').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
            <?php } ?>
            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                //Date picker
                $('#datefrom1').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto1').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#datefrom2').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto2').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#datefrom3').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto3').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#datefrom4').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto4').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#datefrom5').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto5').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#datefrom6').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto6').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#datefrom7').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto7').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#datefrom8').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto8').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#datefrom9').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto9').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#datefrom10').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto10').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#datefrom11').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto11').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#datefrom12').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto12').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#datefrom13').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto13').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#datefrom14').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto14').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#datefrom15').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
                $('#dateto15').datetimepicker({
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
                    txtAerolinea1: {
                        required: true
                    },
                    txtOrigen1: {
                        required: true
                    },
                    txtDestino1: {
                        required: true
                    },
                    txtFechaIda1: {
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
                    txtAerolinea1: {
                        required: "La Aerolínea es obligatorio"
                    },
                    txtOrigen1: {
                        required: "El origen es obligatorio"
                    },
                    txtDestino1: {
                        required: "El desino es obligatorio"
                    },
                    txtFechaIda1: {
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

        function mostrarNuevaFila() {
            const filas = document.querySelectorAll('.fila.d-none')

            if (posicion === 14) {
                document.getElementById('addNewRow').classList.add('d-none')
            }
            if (posicion <= 15) {
                formsValidar.push(parseInt(filas[0].id))
                filas[0].classList.remove('d-none')
                posicion++
                inputNb.value = formsValidar
                return
            }
        }

        function agregarMCO() {
            const filas = document.querySelectorAll('.mco.d-none')

            let id = filas[0].id
            formsValidarMCO.push(parseInt(id.charAt(id.length - 1)))

            filas[0].classList.remove('d-none')
            posicionMCO++
            
            if(posicionMCO <= 9){
                inputNm.value = formsValidarMCO
            }
            
            if(posicionMCO >= 1){
                document.getElementById('title-mco').classList.remove('d-none')
            }
        }

        function eliminarFila(id) {
            document.getElementById(id).classList.add('d-none')
            posicion--
            formsValidar = formsValidar.filter(pos => pos !== id)
            inputNb.value = formsValidar

            if (posicion <= 14) {
                document.getElementById('addNewRow').classList.remove('d-none')
            }
        }

        function eliminarFilaMCO(id) {
            document.getElementById(id).classList.add('d-none')
            posicionMCO--
            if(posicionMCO <= 0){
                document.getElementById('title-mco').classList.add('d-none')
            }
            formsValidarMCO = formsValidarMCO.filter(pos => pos !== parseInt(id.charAt(id.length - 1)))
            inputNm.value = formsValidarMCO
        }
    </script>
    <script>
        <?php require_once '../../func/Mensajes.php'; ?>
    </script>

</body>

</html>