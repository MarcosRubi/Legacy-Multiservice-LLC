<?php
require_once '../../func/validateSession.php';
if (!isset($_GET['id'])) {
    echo "<script>window.close(); window.location.replace('" . $_SESSION['path'] . "buscar-cliente/');</script>";
    return;
}

require_once '../../bd/bd.php';
require_once '../../class/Boletos.php';
require_once '../../class/Ajustes.php';

$Obj_Ajustes = new Ajustes();

$Obj_Boletos = new Boletos();
$Res_Boletos = $Obj_Boletos->buscarPorClienteId($_GET['id']);

$DatosBoletos = $Res_Boletos->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boletos</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
                                    <?php if ($Res_Boletos->num_rows === 0) {
                                        echo "<h3 class='card-title'>No se encontraron boletos</h3>";
                                    } ?>
                                    <?php if ($Res_Boletos->num_rows !== 0) {
                                        echo "<h3 class='card-title'>Boletos realizados a <strong>" . $DatosBoletos['PrimerNombre'] . " " . $DatosBoletos['SegundoNombre'] . " " . $DatosBoletos['Apellido'] . "</strong></h3>";
                                    } ?>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="list-results" class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th># Boleto</th>
                                                <th>Nombre del pasajero</th>
                                                <th>Passenger DOB</th>
                                                <th>Agencia</th>
                                                <th>Agente</th>
                                                <th>Aerol??nea</th>
                                                <th>Origen</th>
                                                <th>Destino</th>
                                                <th>Fecha Ida</th>
                                                <th>Fecha Regreso</th>
                                                <th>IATA</th>
                                                <th>Forma de pago</th>
                                                <th>Precio</th>
                                                <th>Base</th>
                                                <th>Tax</th>
                                                <th>FM</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($Res_Boletos as $key => $DatosBoleto) { ?>
                                                <tr>
                                                    <td><?= $DatosBoleto['IdBoleto'] ?></td>
                                                    <td><?= $DatosBoleto['NombrePasajero'] ?></td>
                                                    <td><?= $Obj_Ajustes->FechaInvertir($DatosBoleto['Dob']) ?></td>
                                                    <td><?= $DatosBoleto['Agencia'] ?></td>
                                                    <td><?= $DatosBoleto['Agente'] ?></td>
                                                    <td><?= $DatosBoleto['Aerolinea'] ?></td>
                                                    <td><?= $DatosBoleto['Origen'] ?></td>
                                                    <td><?= $DatosBoleto['Destino'] ?></td>
                                                    <td><?= $Obj_Ajustes->FechaInvertir($DatosBoleto['FechaIda']) ?></td>
                                                    <td><?= $Obj_Ajustes->FechaInvertir($DatosBoleto['FechaRegreso']) ?></td>
                                                    <td><?= $DatosBoleto['IdIata'] ?></td>
                                                    <td><?= $DatosBoleto['IdTipo'] ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosBoleto['Precio']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosBoleto['Base']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosBoleto['Tax']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosBoleto['Fm']) ?></td>
                                                    <td>
                                                        <a class="btn btn-sm mx-1 btn-primary" title="Editar" onclick="javascript:editarBoleto(<?= $DatosCliente['IdBoleto'] ?>);">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
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
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $('#list-results').DataTable({
                "paging": true,
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