<?php
require_once '../../func/validateSession.php';

if (!isset($_GET['id'])) {
    echo "<script>window.location.replace('" . $_SESSION['path'] . "buscar-cliente/');</script>";
    return;
}

require_once '../../bd/bd.php';
require_once '../../class/Clientes.php';
require_once '../../class/Ajustes.php';

$Obj_Clientes = new Clientes();
$Obj_Ajustes = new Ajustes();

$Res_Clientes = $Obj_Clientes->buscarPorId($_GET['id']);

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
                                <label>C??digo PNR</label>
                                <input type="text" class="form-control" placeholder="PNR ..." name="txtPnr">
                            </div>
                            <div id="addNewRow">
                                <span class="btn btn-primary mb-1" onclick="mostrarNuevaFila();">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </div>
                            <div class="px-2 mb-3 rounded fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="1">
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="number" class="form-control" placeholder="# Boleto ..." name="txtBoleto1">
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
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob1" value="<?php if ($DatosClientes['FechaNacimiento'] !== '0000-00-00') {
                                                                                                                                                                                                                                echo $Obj_Ajustes->FechaInvertir($DatosClientes['FechaNacimiento']);
                                                                                                                                                                                                                            } ?>">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerol??nea -->
                                    <div class="form-group mx-1">
                                        <label>Aerol??nea</label>
                                        <input type="text" class="form-control" placeholder="Aerol??nea ..." name="txtAerolinea1">
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

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaIda1">
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaRegreso1">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex  flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata1">
                                            <option selected="selected" value="2">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo1">
                                            <option selected="selected"  value="2">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago1">
                                            <option selected="selected" value="2">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
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
                            </div>
                            <div class="px-2 mb-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="2">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-primary fa-lg fa fa-window-close" onclick="javascript:eliminarFila(2)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="number" class="form-control" placeholder="# Boleto ..." name="txtBoleto2">
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
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob2">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerol??nea -->
                                    <div class="form-group mx-1">
                                        <label>Aerol??nea</label>
                                        <input type="text" class="form-control" placeholder="Aerol??nea ..." name="txtAerolinea2">
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

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaIda2">
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaRegreso2">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata2">
                                            <option value="2" selected="selected">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo2">
                                            <option value="2" selected="selected">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago2">
                                            <option value="2" selected="selected">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
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
                            </div>
                            <div class="px-2 mb-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="3">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-primary fa-lg fa fa-window-close" onclick="javascript:eliminarFila(3)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="number" class="form-control" placeholder="# Boleto ..." name="txtBoleto3">
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
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob3">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerol??nea -->
                                    <div class="form-group mx-1">
                                        <label>Aerol??nea</label>
                                        <input type="text" class="form-control" placeholder="Aerol??nea ..." name="txtAerolinea3">
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

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaIda3">
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaRegreso3">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata3">
                                            <option selected="selected" value="2">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo3">
                                            <option selected="selected" value="2">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago3">
                                            <option selected="selected" value="2">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
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
                            </div>
                            <div class="px-2 mb-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="4">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-primary fa-lg fa fa-window-close" onclick="javascript:eliminarFila(4)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="number" class="form-control" placeholder="# Boleto ..." name="txtBoleto4">
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
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob4">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerol??nea -->
                                    <div class="form-group mx-1">
                                        <label>Aerol??nea</label>
                                        <input type="text" class="form-control" placeholder="Aerol??nea ..." name="txtAerolinea4">
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

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaIda4">
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaRegreso4">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option selected="selected" value="2">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option selected="selected" value="2">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option selected="selected" value="2">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
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
                                    <input type="text" class="form-control d-none" name="IdCliente" value="<?= $DatosClientes['IdCliente'] ?>">
                                </div>
                            </div>
                            <div class="px-2 mb-3 rounded d-none fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="5">
                                <div class="d-flex justify-content-end pt-2">
                                    <i class="btn bg-primary fa-lg fa fa-window-close" onclick="javascript:eliminarFila(5)"></i>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1">
                                        <label># Boleto</label>
                                        <input type="number" class="form-control" placeholder="# Boleto ..." name="txtBoleto5">
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
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob5">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- Aerol??nea -->
                                    <div class="form-group mx-1">
                                        <label>Aerol??nea</label>
                                        <input type="text" class="form-control" placeholder="Aerol??nea ..." name="txtAerolinea5">
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

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaIda5">
                                        </div>
                                    </div>
                                    <!-- Fecha regreso dd-mm-yyyy -->
                                    <div class="form-group mx-1">
                                        <label>Fecha regreso:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaRegreso5">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- IATA -->
                                    <div class="form-group mx-1">
                                        <label>IATA</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option value="2" selected="selected">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1">
                                        <label>Tipo</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option value="2" selected="selected">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
                                        </select>
                                    </div>
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option value="2" selected="selected">Opci??n 1</option>
                                            <option value="3">Opci??n 2</option>
                                            <option value="4">Opci??n 3</option>
                                            <option value="5">Opci??n 4</option>
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
                            </div>
                            <div class="form-group">
                                <label>Itinerario</label>
                                <textarea id="summernote" name="txtItinerario">
                                    Escribe <em>el</em> <u>itinerario</u> <strong>aqu??</strong>
                                </textarea>
                            </div>
                            <input type="hidden" name="nb" id="nb" value="1">
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
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            //Phone Number
            $('[data-mask]').inputmask()
            // Summernote
            $('#summernote').summernote()
        })
    </script>
    <script>
        // $(function() {
        //     $('#frmNuevo').validate({
        //         rules: {
        //             txtPnr: {
        //                 required: true
        //             },
        //             txtBoleto1: {
        //                 required: true
        //             },
        //             txtNombrePasajero1: {
        //                 required: true
        //             },
        //             txtFechaDob1: {
        //                 required: true
        //             },
        //             txtAerolinea1: {
        //                 required: true
        //             },
        //             txtOrigen1: {
        //                 required: true
        //             },
        //             txtDestino1: {
        //                 required: true
        //             },
        //             txtFechaIda1: {
        //                 required: true
        //             },
        //             txtFechaRegreso1: {
        //                 required: true
        //             },
        //             txtPrecio1: {
        //                 required: true
        //             },
        //             txtBase1: {
        //                 required: true
        //             },
        //             txtTax1: {
        //                 required: true
        //             },
        //             txtFm1: {
        //                 required: true
        //             }
        //         },
        //         messages: {
        //             txtPnr: {
        //                 required: "El PNR es obligatorio",
        //             },
        //             txtBoleto1: {
        //                 required: "El # de boletos es obligatorio"
        //             },
        //             txtNombrePasajero1: {
        //                 required: "El nombre es obligatorio"
        //             },
        //             txtFechaDob1: {
        //                 required: "La fecha es obligatorio"
        //             },
        //             txtAerolinea1: {
        //                 required: "La Aerol??nea es obligatorio"
        //             },
        //             txtOrigen1: {
        //                 required: "El origen es obligatorio"
        //             },
        //             txtDestino1: {
        //                 required: "El desino es obligatorio"
        //             },
        //             txtFechaIda1: {
        //                 required: "La fecha de ida es obligatorio"
        //             },
        //             txtFechaRegreso1: {
        //                 required: "La fecha de regreso es obligatorio"
        //             },
        //             txtPrecio1: {
        //                 required: "El precio es obligatorio"
        //             },
        //             txtBase1: {
        //                 required: "La base es obligatorio"
        //             },
        //             txtTax1: {
        //                 required: "El TAX es obligatorio"
        //             },
        //             txtFm1: {
        //                 required: "El FM es obligatorio"
        //             }
        //         },
        //         errorElement: 'span',
        //         errorPlacement: function(error, element) {
        //             error.addClass('invalid-feedback');
        //             element.closest('.form-group').append(error);
        //         },
        //         highlight: function(element, errorClass, validClass) {
        //             $(element).addClass('is-invalid');
        //         },
        //         unhighlight: function(element, errorClass, validClass) {
        //             $(element).removeClass('is-invalid');
        //         }
        //     });
        // })
    </script>
    <script>
        let posicion = 1;
        let formsValidar = [1]
        let inputNb = document.getElementById('nb')

        function closeForm() {
            window.close()
        }

        function mostrarNuevaFila() {
            const filas = document.querySelectorAll('.fila.d-none')

            if (posicion === 4) {
                document.getElementById('addNewRow').classList.add('d-none')
            }
            if (posicion <= 5) {
                formsValidar.push(parseInt(filas[0].id))
                filas[0].classList.remove('d-none')
                posicion++
                inputNb.value = formsValidar
                return
            }
        }

        function eliminarFila(id) {
            document.getElementById(id).classList.add('d-none')
            posicion--
            formsValidar = formsValidar.filter(pos => pos !== id)
            inputNb.value = formsValidar

            if (posicion <= 4) {
                document.getElementById('addNewRow').classList.remove('d-none')
            }
        }
    </script>
    <script>
        <?php
        if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'dobVacio') {
            echo "
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'Passenger DOB es obligatorio.'
            })";
            unset($_SESSION['error-registro']);
        }

        if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'boletos') {
            echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'El n??mero de boletos es obligatorio.'
            })";
            unset($_SESSION['error-registro']);
        
        
        
        }
        
        if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'dobFormato') {
            echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'La fecha de Passenger DOB no es v??lida.'
            })";
            unset($_SESSION['error-registro']);
        }

        if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'nombre') {
            echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'El nombre del pasajero es obligatorio.'
            })";
            unset($_SESSION['error-registro']);
        }
        if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'aerolinea') {
            echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'La aerolinea es obligatorio.'
            })";
            unset($_SESSION['error-registro']);
        }
        if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'origen') {
            echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'El origen es obligatorio.'
            })";
            unset($_SESSION['error-registro']);
        }
        if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'destino') {
            echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'El destino es obligatorio.'
            })";
            unset($_SESSION['error-registro']);
        }
        if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'idaVacio') {
            echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'La fecha de ida es obligatoria.'
            })";
            unset($_SESSION['error-registro']);
        }
        if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'idaFormato') {
            echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'La fecha de ida no es v??lida.'
            })";
            unset($_SESSION['error-registro']);
        }
        if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'regresoVacio') {
            echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'La fecha de regreso es obligatoria.'
            })";
            unset($_SESSION['error-registro']);
        }
        if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'regresoFormato') {
            echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'La fecha de regreso no es v??lida.'
            })";
            unset($_SESSION['error-registro']);
        }
        if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'precio') {
            echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'El precio es obligatorio.'
            })";
            unset($_SESSION['error-registro']);
        }
        if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'base') {
            echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'Base es obligatorio.'
            })";
            unset($_SESSION['error-registro']);
        }
        if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'tax') {
            echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'El TAX es obligatorio.'
            })";
            unset($_SESSION['error-registro']);
        }
        
        ?>
    </script>

</body>

</html>