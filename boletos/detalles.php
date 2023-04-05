<?php
require_once '../func/validateSession.php';
if (!isset($_GET['id'])) {
    echo "<script>window.location.replace('" . $_SESSION['path'] . "');</script>";
    return;
}

require_once '../bd/bd.php';
require_once '../class/Boletos.php';
require_once '../class/Ajustes.php';

$Obj_Boletos = new Boletos();
$Obj_Ajustes = new Ajustes();

$Res_Boletos = $Obj_Boletos->buscarPorId($_GET['id']);
$DatosBoleto = $Res_Boletos->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalles Boleto</title>

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
                            <h3 class="card-title w-100 font-weight-bold text-center">Detalles de boleto #<?=$DatosBoleto['IdBoleto'] ?></h3>
                        </div>
                        <form action="#" method="post" class="card-body" id="frmNuevo" onsubmit="return false;">
                            <div class="form-group mx-1 p-2 rounded" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                                <div class="form-group mx-1  ">
                                    <label>Código PNR</label>
                                    <input type="text" class="form-control" placeholder="PNR ..." name="txtPnr" value="<?=$DatosBoleto['Pnr'] ?>" readonly>
                                </div>
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- Aerolínea -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Aerolínea</label>
                                        <input type="text" class="form-control" placeholder="Aerolínea ..." name="txtAerolinea" value="<?=$DatosBoleto['Aerolinea'] ?>" readonly>
                                    </div>
                                    <!-- Origen -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Origen</label>
                                        <input type="text" class="form-control" placeholder="Origen ..." name="txtOrigen" value="<?=$DatosBoleto['Origen'] ?>" readonly>
                                    </div>
                                    <!-- Destino -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Destino</label>
                                        <input type="text" class="form-control" placeholder="Destino ..." name="txtDestino" value="<?=$DatosBoleto['Destino'] ?>" readonly>
                                    </div>
                                    <!-- Fecha Ida dd-mm-yyyy -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Fecha ida:</label>
                                        <div class="input-group date" id="dateto" data-target-input="nearest">
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaIda" value="<?=$Obj_Ajustes->FechaInvertir($DatosBoleto['FechaIda']) ?>" disabled>
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateto" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaIda" value="<?=$Obj_Ajustes->FechaInvertir($DatosBoleto['FechaIda']) ?>" disabled>
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
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaRegreso" value="<?=$Obj_Ajustes->FechaInvertir($DatosBoleto['FechaRegreso']) ?>" disabled>
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#datefrom" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaRegreso" value="<?=$Obj_Ajustes->FechaInvertir($DatosBoleto['FechaRegreso']) ?>" disabled>
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
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdIata" disabled>
                                            <option value="<?=$DatosBoleto['IdIata'] ?>"><?=$DatosBoleto['NombreIata'] ?></option>
                                        </select>
                                    </div>
                                    <!-- Tipo -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Tipo</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdTipo" disabled>
                                            <option value="<?=$DatosBoleto['IdTipo'] ?>"><?=$DatosBoleto['NombreTipo'] ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="px-2 mb-3 pt-3 rounded fila" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" id="1">
                                <div class="d-flex flex-column flex-xl-row">
                                    <!-- # Boleto -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label># Boleto</label>
                                        <input type="text" class="form-control" name="txtBoleto1" data-inputmask='"mask": "999-9999999999"' placeholder="XXX-XXXXXXXXXX" data-mask value="<?=$DatosBoleto['NumeroBoletos'] ?>" readonly>
                                    </div>
                                    <!-- Nombre del pasajero -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Nombre del pasajero</label>
                                        <input type="text" class="form-control" placeholder="Nombre del pasajero ..." name="txtNombrePasajero1" value="<?=$DatosBoleto['NombrePasajero'] ?>" readonly>
                                    </div>
                                    <!-- Passenger DOB dd-mm-yyyy -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Passenger DOB:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask placeholder="dd-mm-yyyy" name="txtFechaDob1" value="<?=$Obj_Ajustes->FechaInvertir($DatosBoleto['Dob']) ?>" readonly>
                                            <?php } ?>
                                            <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" data-mask placeholder="mm-dd-yyyy" name="txtFechaDob1" value="<?=$Obj_Ajustes->FechaInvertir($DatosBoleto['Dob']) ?>" readonly>
                                            <?php } ?>


                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    

                                </div>
                                <div class="d-flex  flex-column flex-xl-row">
                                    <!-- Forma de pago -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Forma de pago</label>
                                        <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="txtIdPago1" disabled>
                                            <option value="<?=$DatosBoleto['IdFormaPago'] ?>"><?=$DatosBoleto['FormaPago'] ?></option>
                                        </select>
                                    </div>
                                    <!-- Precio -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio ..." name="txtPrecio1" value="<?=$DatosBoleto['Precio']?>" readonly>
                                    </div>
                                    <!--Base -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Base</label>
                                        <input type="number" class="form-control" placeholder="Base ..." name="txtBase1" value="<?=$DatosBoleto['Base']?>" readonly>
                                    </div>
                                    <!-- TAX -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Tax</label>
                                        <input type="number" class="form-control" placeholder="Tax ..." name="txtTax1" value="<?=$DatosBoleto['Tax']?>" readonly>
                                    </div>
                                    <!-- Fm -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Fm</label>
                                        <input type="number" class="form-control" placeholder="Fm ..." name="txtFm1" value="<?=$DatosBoleto['Fm']?>" readonly>
                                    </div>
                                    <!-- Fee -->
                                    <div class="form-group mx-1 flex-fill">
                                        <label>Fee</label>
                                        <input type="number" class="form-control" placeholder="Fee ..." name="txtFee1" value="<?=$DatosBoleto['Fee']?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Itinerario</label>
                                <textarea id="summernote" name="txtItinerario">
                                <?=$DatosBoleto['Itinerario']?>
                                </textarea>
                            </div>
                            <input type="hidden" name="nb" id="nb" value="1">
                            <input type="hidden" name="nm" id="nm">
                            <input type="hidden" class="form-control d-none" name="IdCliente" value="<?=$DatosBoleto['IdCliente']?>">
                            <!-- /.form group -->
                            <?php
                                if($_SESSION['IdRole'] === 2){
                            ?>
                            <div class="form-group pr-1 mt-3">
                                <button class="btn btn-primary btn-block btn-lg" type="submit">Editar Boleto</button>
                            </div>
                            <div class="form-group pl-1">
                                <button class="btn btn-block text-center" type="reset" onclick="javascript:closeForm();">Cerrar</button>
                            </div>
                            <?php } ?>
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
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
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
        function closeForm(){
            window.close();
        }
    </script>


</body>

</html>