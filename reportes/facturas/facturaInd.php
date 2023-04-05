<?php
date_default_timezone_set('America/El_Salvador');
require_once '../../func/validateSession.php';

require_once '../../bd/bd.php';
require_once '../../class/Abonos.php';
require_once '../../class/Facturas.php';
require_once '../../class/Ajustes.php';

$Obj_Abonos = new Abonos();
$Obj_Ajustes = new Ajustes();

$Res_Abonos = $Obj_Abonos->listarAbonos($_GET['id']);
$Res_Cliente = $Obj_Abonos->listarDatosCliente($_GET['id']);

$DatosCliente = $Res_Cliente->fetch_assoc();


$Obj_Facturas = new Facturas();
$Res_Facturas = $Obj_Facturas->buscarFacturaPorId($_GET['id']);

$Datosfacturas = $Res_Facturas->fetch_assoc();

$efectivo = 0;
$banco = 0;
$credito = 0;
$cheque = 0;
$cupon = 0;

if ($Res_Facturas->num_rows === 1) {
    foreach ($Datosfacturas as $key => $value) {
        if ($key === 'Efectivo') {
            $efectivo = $efectivo + doubleval($Datosfacturas['Efectivo']);
        }
        if ($key === 'CreditoValor') {
            $credito = $credito + doubleval($Datosfacturas['CreditoValor']);
        }
        if ($key === 'Banco') {
            $banco = $banco + doubleval($Datosfacturas['Banco']);
        }
        if ($key === 'Cheque') {
            $cheque = $cheque + doubleval($Datosfacturas['Cheque']);
        }
        if ($key === 'Cupon') {
            $cupon = $cupon + doubleval($Datosfacturas['Cupon']);
        }
    }
}


$arrPagos = [$efectivo, $banco, $credito, $cheque, $cupon];
$formasPagos = 0;

for ($i = 0; $i < 5; $i++) {
    if ($arrPagos[$i] > 0) {
        $formasPagos++;
    }
}


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
                                        <!-- <b>Factura creada:</b>  -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->

                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="text-center py-2">FACTURA DE SERVICIOS</h5>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Servicio</th>
                                                    <th>Fecha</th>
                                                    <th>Valor total</th>
                                                    <?php if ($formasPagos <= 1) { ?>
                                                        <th>Total recibido</th>
                                                        <?php if ((doubleval($DatosCliente['Valor']) + doubleval($DatosCliente['BalanceInicial'])) > 0) { ?>
                                                            <th>Forma de pago</th>
                                                        <?php } ?>
                                                        <th>Balance</th>
                                                    <?php } ?>
                                                    <th>Agencia</th>
                                                    <th>Agente</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?= $DatosCliente['Tipo'] ?></td>
                                                    <td><?= $Obj_Ajustes->FechaInvertir(substr($DatosCliente['Creado'], 0, -9)) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosCliente['Valor']) ?></td>
                                                    <?php if ($formasPagos <= 1) { ?>
                                                        <td><?= $Obj_Ajustes->FormatoDinero(doubleval($DatosCliente['Valor']) + doubleval($DatosCliente['BalanceInicial'])) ?></td>
                                                        <?php if ((doubleval($DatosCliente['Valor']) + doubleval($DatosCliente['BalanceInicial'])) > 0) { ?>

                                                            <td><?php
                                                                if ($efectivo > 0) {
                                                                    echo "Efectivo";
                                                                }
                                                                if ($credito > 0) {
                                                                    echo "Crédito";
                                                                }
                                                                if ($cupon > 0) {
                                                                    echo "Cupon";
                                                                }
                                                                if ($cheque > 0) {
                                                                    echo "Cheque";
                                                                }
                                                                if ($banco > 0) {
                                                                    echo "Banco";
                                                                }
                                                                ?></td>
                                                        <?php } ?>

                                                        <td><?= $Obj_Ajustes->FormatoDinero($DatosCliente['BalanceInicial']) ?></td>
                                                    <?php } ?>
                                                    <td><?= $DatosCliente['Agencia'] ?></td>
                                                    <td><?= $DatosCliente['Agente'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <?php
                                        if ($formasPagos > 1) { ?>
                                            <div class="row">
                                                <!-- /.col -->
                                                <div class="col-4">
                                                    <p class="lead">Información de pago</p>

                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <?php if ($efectivo > 0) { ?>
                                                                <tr>
                                                                    <td>Pago recibido: <b><?= $Obj_Ajustes->FormatoDinero($efectivo) ?></b></td>
                                                                    <td>Forma de pago: <b>Efectivo</b></td>
                                                                </tr>
                                                            <?php } ?>
                                                            <?php if ($credito > 0) { ?>
                                                                <tr>
                                                                    <td>Pago recibido: <b><?= $Obj_Ajustes->FormatoDinero($credito) ?></b></td>
                                                                    <td>Forma de pago: <b>Crédito</b></td>
                                                                </tr>
                                                            <?php } ?>
                                                            <?php if ($banco > 0) { ?>
                                                                <tr>
                                                                    <td>Pago recibido: <b><?= $Obj_Ajustes->FormatoDinero($banco) ?></b></td>
                                                                    <td>Forma de pago: <b>Banco</b></td>
                                                                </tr>
                                                            <?php } ?>
                                                            <?php if ($cheque > 0) { ?>
                                                                <tr>
                                                                    <td>Pago recibido: <b><?= $Obj_Ajustes->FormatoDinero($cheque) ?></b></td>
                                                                    <td>Forma de pago: <b>Cheque</b></td>
                                                                </tr>
                                                            <?php } ?>
                                                            <?php if ($cupon > 0) { ?>
                                                                <tr>
                                                                    <td>Pago recibido: <b><?= $Obj_Ajustes->FormatoDinero($cupon) ?></b></td>
                                                                    <td>Forma de pago: <b>Cupón</b></td>
                                                                </tr>
                                                            <?php } ?>
                                                            <tr>
                                                                <td colspan="2">TOTAL RECIBIDO: <b><?= $Obj_Ajustes->FormatoDinero(doubleval($DatosCliente['Valor']) + doubleval($DatosCliente['Balance'])) ?></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">BALANCE DE LA FACTURA: <b> <?= $Obj_Ajustes->FormatoDinero($DatosCliente['Balance']) ?></b></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        <?php } ?>

                                        <?php
                                        if ($Res_Abonos->num_rows >= 1) { ?>
                                            <div class="row">
                                                <!-- /.col -->
                                                <div class="col-4">
                                                    <p class="lead">Información de abonos</p>

                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <th>Servicio</th>
                                                                <th>Fecha del abono</th>
                                                                <th>Cantidad</th>
                                                                <th>Forma de pago</th>
                                                                <th>Balance</th>
                                                            </thead>
                                                            <?php while ($DatosAbonos = $Res_Abonos->fetch_assoc()) { ?>
                                                                <tr>
                                                                    <td><?= $DatosAbonos['Tipo'] ?></td>
                                                                    <td><?= $Obj_Ajustes->FechaInvertir(substr($DatosAbonos['Creado'], 0, -9)) ?></td>
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
                                                            <?php
                                                            } ?>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->


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
        window.addEventListener("load", window.print());
    </script>
</body>

</html>