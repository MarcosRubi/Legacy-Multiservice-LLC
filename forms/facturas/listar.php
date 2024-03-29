<?php
require_once '../../func/validateSession.php';
if (!isset($_GET['id'])) {
    echo "<script>window.close(); window.location.replace('" . $_SESSION['path'] . "buscar-cliente/');</script>";
    return;
}

require_once '../../bd/bd.php';
require_once '../../class/Facturas.php';
require_once '../../class/Ajustes.php';

$Obj_Ajustes = new Ajustes();

$Obj_Facturas = new Facturas();
$Res_Facturas = $Obj_Facturas->buscarPorId($_GET['id']);
$Res_ValorTotal = $Obj_Facturas->ValorTotalPorCliente($_GET['id']);
$Res_BalanceTotal = $Obj_Facturas->BalanceTotalPorCliente($_GET['id']);

$Datosfacturas = $Res_Facturas->fetch_assoc();
$valorTotal = $Res_ValorTotal->fetch_assoc()['ValorTotal'];
$BalanceTotal = $Res_BalanceTotal->fetch_assoc()['BalanceTotal'];

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Facturas</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini" style="font-size:12px !important;">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-left:0px;">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <?php if ($Res_Facturas->num_rows === 0) { ?>
                                        <h3 class="card-title">No hay facturas creadas para este cliente</h3>
                                    <?php } ?>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="data-personal" class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Total de las facturas</th>
                                                <th>Pagos totales</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <?php if ($Res_Facturas->num_rows === 0) { ?>
                                                    <td></td>
                                                <?php } else { ?>
                                                    <td><?= $Datosfacturas['PrimerNombre'] . " " . $Datosfacturas['Apellido'] ?></td>
                                                <?php } ?>
                                                <td><?= $Obj_Ajustes->FormatoDinero($valorTotal) ?></td>
                                                <td><?= $Obj_Ajustes->FormatoDinero(doubleval($valorTotal) + doubleval($BalanceTotal)) ?></td>
                                                <td class="<?= doubleval($BalanceTotal) < 0 ? 'text-danger font-weight-bold' : '' ?>"><?= $Obj_Ajustes->FormatoDinero($BalanceTotal) ?></td>
                                    </table>
                                </div>
                                <div class="card-body">
                                    <table id="list-results-1" class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th># Factura</th>
                                                <th>Factura ingresada</th>
                                                <th>Cliente</th>
                                                <th>Agente</th>
                                                <th>Agencia</th>
                                                <th>Tipo</th>
                                                <th>Descripción</th>
                                                <th>Valor</th>
                                                <th>Balance</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($Res_Facturas as $key => $Datosfactura) { ?>
                                                <tr>
                                                    <td><?= $Datosfactura['IdFactura'] ?></td>
                                                    <td><?= $Obj_Ajustes->FechaInvertir(substr($Datosfacturas['Creado'], 0, -9)) ?></td>
                                                    <td><?= $Datosfactura['PrimerNombre'] . " " . $Datosfactura['Apellido'] ?></td>
                                                    <td><?= $Datosfactura['Agente'] ?></td>
                                                    <td><?= $Datosfactura['Agencia'] ?></td>
                                                    <td><?= $Datosfactura['Tipo'] ?></td>
                                                    <td><?= $Datosfactura['Descripcion'] ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($Datosfactura['Valor']) ?></td>
                                                    <td class="<?= doubleval($Datosfactura['Balance']) < 0 ? 'text-danger font-weight-bold' : '' ?>"><?= $Obj_Ajustes->FormatoDinero($Datosfactura['Balance']) ?></td>
                                                    <td>
                                                        <div class="d-flex justify-content-around">
                                                            <?php if ($Datosfactura['IdTipoFactura'] === '2') { ?>
                                                                <a href="<?= $_SESSION['path'] . "reportes/facturas/facturaBoleto.php?id=" . $Datosfactura['IdFactura'] ?>&boleto" class="btn btn-sm mx-1 btn-primary" title="Imprimir">
                                                                    <i class="fa fa-print fa-lg"></i>
                                                                </a>
                                                            <?php } ?>
                                                            <?php if ($Datosfactura['IdTipoFactura'] !== '2') { ?>
                                                                <a href="<?= $_SESSION['path'] . "reportes/facturas/facturaInd.php?id=" . $Datosfactura['IdFactura'] ?>" class="btn btn-sm mx-1 btn-primary" title="Imprimir">
                                                                    <i class="fa fa-print fa-lg"></i>
                                                                </a>
                                                            <?php } ?>
                                                            <a href="<?= "./frmAbono.php?factura=" . $Datosfactura['IdFactura'] . "&nombre=" . $Datosfactura['PrimerNombre'] . " " . $Datosfactura['Apellido'] . "&cliente=" . $Datosfactura['IdCliente'] ?>" class="btn btn-sm mx-1 btn-primary" title="Abonar">
                                                                <i class="fa fa-dollar-sign px-1 fa-lg"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-body">
                                    <table id="list-results-2" class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th># Factura</th>
                                                <th>Agencia</th>
                                                <th>Agente</th>
                                                <th>Factura ingresada</th>
                                                <th>Efectivo</th>
                                                <th>Crédito</th>
                                                <th>Cheque</th>
                                                <th>Banco</th>
                                                <th>Cupón</th>
                                                <th>Total</th>
                                                <th>Comentario</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($Res_Facturas as $key => $Datosfactura) { ?>
                                                <tr>
                                                    <td><?= $Datosfactura['IdFactura'] ?></td>
                                                    <td><?= $Datosfactura['Agencia'] ?></td>
                                                    <td><?= $Datosfactura['Agente'] ?></td>
                                                    <td><?= $Obj_Ajustes->FechaInvertir(substr($Datosfacturas['Creado'], 0, -9)) . " " . substr($Datosfacturas['Creado'], 10, 20) . " " .  $Datosfacturas['CreadoTimestamp'] ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($Datosfactura['Efectivo']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($Datosfactura['CreditoValor']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($Datosfactura['Cheque']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($Datosfactura['Banco']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($Datosfactura['Cupon']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($Datosfactura['Valor']) ?></td>
                                                    <td><?= $Datosfactura['Comentario'] ?></td>
                                                    <td></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../plugins/jszip/jszip.min.js"></script>
    <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $('#list-results-1').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
        $(function() {
            $('#list-results-2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
        $(function() {
            $('#data-personal').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>