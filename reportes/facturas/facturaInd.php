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
$Res_Facturas = $Obj_Facturas->buscarPorId($_GET['id']);

$Datosfacturas = $Res_Facturas->fetch_assoc();


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Factura</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
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
                                        <b>Factura #7</b><br>
                                        <b>Factura creada:</b> <?= $Obj_Ajustes->FechaInvertir(substr($DatosCliente['Creado'], 0, -9)) . " " . substr($DatosCliente['Creado'], 10, 20) . " " .  $DatosCliente['CreadoTimestamp'] ?>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row mt-5">
                                    <div class="col-12 table-responsive">
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
                                                    <td><?= $DatosCliente['FormaPagoInicial'] ?></td>
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
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <!-- /.col -->
                                    <div class="col-6 mt-4">
                                        <p class="lead">Resumen</p>

                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th style="width:50%">Total:</th>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosCliente['Valor']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Total recibido:</th>
                                                    <td><?= $Obj_Ajustes->FormatoDinero(doubleval($DatosCliente['Valor']) + doubleval($DatosCliente['Balance'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Balance:</th>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosCliente['Balance']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Agencia:</th>
                                                    <td><?= $DatosCliente['Agencia'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Agente:</th>
                                                    <td><?= $DatosCliente['Agente'] ?></td>
                                                </tr>
                                            </table>
                                        </div>
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