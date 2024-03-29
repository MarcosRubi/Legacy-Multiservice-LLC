<?php
date_default_timezone_set('America/El_Salvador');
require_once '../../func/validateSession.php';

require_once '../../bd/bd.php';
require_once '../../class/Abonos.php';
require_once '../../class/Facturas.php';
require_once '../../class/Ajustes.php';
require_once '../../class/Boletos.php';

$Obj_Abonos = new Abonos();
$Obj_Boletos = new Boletos();
$Obj_Ajustes = new Ajustes();

$Res_Abonos = $Obj_Abonos->listarAbonos($_GET['id']);
$Res_Cliente = $Obj_Abonos->listarDatosCliente($_GET['id']);

$DatosCliente = $Res_Cliente->fetch_assoc();


$Obj_Facturas = new Facturas();
$Res_Facturas = $Obj_Facturas->buscarPorId($_GET['id']);

$Datosfacturas = $Res_Facturas->fetch_assoc();

$Res_PnrFactura = $Obj_Facturas->obtenerIdclienteYPnrFactura($DatosCliente['IdFactura']);


$Res_buscarPagos = $Res_PnrFactura->fetch_assoc();
$Res_PagosBoletos = $Obj_Boletos->buscarPorPnr($Res_buscarPagos['IdCliente'], $Res_buscarPagos['Pnr']);

$Res_Itinerario = $Obj_Boletos->buscarPorPnr($Res_buscarPagos['IdCliente'], $Res_buscarPagos['Pnr']);


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Factura #<?= $DatosCliente['IdFactura'] . " - " . $DatosCliente['PrimerNombre'] . " " . $DatosCliente['SegundoNombre'] . " " . $DatosCliente['Apellido'] ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <style>
        .table-striped th {
            min-width: 25rem !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini" style="font-size:12px !important;">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-left:0px;">
            <section class="content mt-2 pt-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <h4 class="d-flex justify-content-between align-middle">
                                            <img src="../../dist/img/logo.png" alt="Logo" style="max-width:10rem;">
                                            <small style="display:flex;align-items:center;"><?= date("d") . "-" . date("m") . "-" . date('Y') . " " . date("h:i:s A") ?></small>
                                        </h4>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        Empresa
                                        <address>
                                            <strong>Legacy Multiservice LLC.</strong><br>
                                            119 Jackson St.<br>
                                            Hempstead, NY 11550<br>
                                            Teléfono #1: (516) 883-2030<br>
                                            Teléfono #2: (516) 782-5503<br>
                                            Correo: legacymultiservice07@gmail.com
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        Cliente
                                        <address>
                                            <strong><?= $DatosCliente['PrimerNombre'] . " " . $DatosCliente['SegundoNombre'] . " " . $DatosCliente['Apellido'] ?></strong><br>
                                            ID: #<?= $DatosCliente['IdCliente'] ?><br>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        <b>Factura #<?= $DatosCliente['IdFactura'] ?></b><br>
                                        <b>Factura creada:</b> <?= $Obj_Ajustes->FechaInvertir(substr($DatosCliente['Creado'], 0, -9)) . " " . substr($DatosCliente['Creado'], 10, 20) . " " .  $DatosCliente['CreadoTimestamp'] ?>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Servicio</th>
                                                    <th>Total</th>
                                                    <th>Fecha</th>
                                                    <th>Recibido</th>
                                                    <th>Forma de pago</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?= $DatosCliente['Tipo'] ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosCliente['Valor']) ?></td>
                                                    <td><?= $Obj_Ajustes->FechaInvertir(substr($DatosCliente['Creado'], 0, -9)) . " " . substr($DatosCliente['Creado'], 10, 20) . " " .  $DatosCliente['CreadoTimestamp'] ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero(doubleval($DatosCliente['Valor']) + doubleval($DatosCliente['BalanceInicial'])) ?></td>
                                                    <td><?= $Res_PagosBoletos->num_rows > 0 ? '' : $DatosCliente['FormaPagoInicial'] ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosCliente['BalanceInicial']) ?></td>
                                                </tr>
                                                <?php while ($DatosAbonos = $Res_Abonos->fetch_assoc()) { ?>
                                                    <tr>
                                                        <td><?= $DatosAbonos['Tipo'] ?></td>
                                                        <td></td>
                                                        <td><?= $Obj_Ajustes->FechaInvertir(substr($DatosAbonos['Creado'], 0, -9)) . " " . substr($DatosAbonos['Creado'], 10, 20) . " " .  $DatosAbonos['CreadoTimestamp'] ?></td>
                                                        <td><?= $Obj_Ajustes->FormatoDinero($DatosAbonos['CantidadAbono']) ?></td>
                                                        <td>
                                                            <?php
                                                            if ($DatosAbonos['Efectivo'] !== '') {
                                                                echo "Efectivo";
                                                            }
                                                            if ($DatosAbonos['CreditoValor'] !== '') {
                                                                echo "Crédito";
                                                            }
                                                            if ($DatosAbonos['Banco'] !== '') {
                                                                echo "Banco";
                                                            }
                                                            if ($DatosAbonos['Cupon'] !== '') {
                                                                echo "Cupon";
                                                            }
                                                            if ($DatosAbonos['Cheque'] !== '') {
                                                                echo "Cheque";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?= $Obj_Ajustes->FormatoDinero($DatosAbonos['BalanceActual']) ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php if ($Res_Itinerario->num_rows > 0) { ?>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre del pasajero</th>
                                                        <th># Boletos</th>
                                                        <th>Aerolínea</th>
                                                        <th>Precio</th>
                                                        <th>Forma de pago</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($DatosPagosBoletos = $Res_PagosBoletos->fetch_assoc()) { ?>
                                                        <tr>
                                                            <td><?= $DatosPagosBoletos['NombrePasajero'] ?></td>
                                                            <td><?= $DatosPagosBoletos['NumeroBoletos'] ?></td>
                                                            <td><?= $DatosPagosBoletos['Aerolinea'] ?></td>
                                                            <td><?= $Obj_Ajustes->FormatoDinero($DatosPagosBoletos['Precio']) ?></td>
                                                            <td><?= $DatosPagosBoletos['FormaPago'] ?></td>
                                                            <td>
                                                            <td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        <?php } ?>

                                        <?php if ($Res_Itinerario->num_rows > 0) { ?>
                                            <div class="row my-4">
                                                <div class="col-12">
                                                    <p class="lead">Itinerario</p>
                                                    <div class="col-12">
                                                        <?= $Res_Itinerario->fetch_assoc()['Itinerario'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <!-- /.col -->
                                    <div class="col-6">
                                        <p class="lead">Resumen</p>

                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <th>Total:</th>
                                                    <th>Total recibido:</th>
                                                    <th>Balance:</th>
                                                    <th>Agencia:</th>
                                                    <th>Agente:</th>
                                                </thead>
                                                <tbody>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosCliente['Valor']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero(doubleval($DatosCliente['Valor']) + doubleval($DatosCliente['Balance'])) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosCliente['Balance']) ?></td>
                                                    <td><?= $DatosCliente['Agencia'] ?></td>
                                                    <td><?= $DatosCliente['Agente'] ?></td>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <?php if ($Res_Itinerario->num_rows > 0) { ?>
                                    <div class="row text-sm mt-3">
                                        <div class="col-12">
                                            <div>
                                                X <span style="min-width: 10rem;border-bottom:1px solid black; display:inline-block;"></span>
                                            </div>
                                            <p class="pl-5">Firma cliente</p>
                                            <p>Es importante revisar cuidadosamente su itinerario al recibirlo para verificar su nombre, fecha de viaje, ruta de vuelo y otra información relevante. Si tiene preguntas, es mejor hacerlas antes de salir de la oficina. No nos haremos responsables si no se revisa. Verifique que sus documentos de viaje estén vigentes por al menos seis meses después de llegar a su destino. Al aceptar los términos y condiciones, autoriza recibir información sobre productos y servicios por correo electrónico, llamadas telefónicas y mensajes de texto.</p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- /.invoice -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <script>
        // window.addEventListener("load", window.print());
    </script>
</body>

</html>