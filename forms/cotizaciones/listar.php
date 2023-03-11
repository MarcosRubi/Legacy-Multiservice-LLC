<?php
require_once '../../func/validateSession.php';
if (!isset($_GET['id'])) {
    echo "<script>window.close(); window.location.replace('" . $_SESSION['path'] . "buscar-cliente/');</script>";
    return;
}

require_once '../../bd/bd.php';
require_once '../../class/Cotizaciones.php';
require_once '../../class/Ajustes.php';

$Obj_Ajustes = new Ajustes();

$Obj_Cotizaciones = new Cotizaciones();
$Res_Cotizaciones = $Obj_Cotizaciones->buscarPorClienteId($_GET['id']);

$DatosCotizacion = $Res_Cotizaciones->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cotizaciones</title>

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
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <?php if ($Res_Cotizaciones->num_rows === 0) {
                                        echo "<h3 class='card-title'>No se encontraron cotizaciones</h3>";
                                    } ?>
                                    <?php if ($Res_Cotizaciones->num_rows !== 0) {
                                        echo "<h3 class='card-title'>Cotizaciones realizadas a <strong>" . $DatosCotizacion['PrimerNombre'] . " " . $DatosCotizacion['SegundoNombre'] . " " . $DatosCotizacion['Apellido'] . "</strong></h3>";
                                    } ?>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                        <table id="list-results" class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>PNR</th>
                                                    <th>Ingresada</th>
                                                    <th>Agencia</th>
                                                    <th>Agente</th>
                                                    <th>Origen</th>
                                                    <th>Destino</th>
                                                    <th>Fecha Ida</th>
                                                    <th>Fecha Regreso</th>
                                                    <th># Boletos</th>
                                                    <th>Acción</th>
                                                    <th>Fecha</th>
                                                    <th>Comentario</th>
                                                    <th>Cotizado</th>
                                                    <th>Max</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($Res_Cotizaciones as $key => $DatosCotizacion) {?>
                                                <tr>
                                                    <td style="width:1rem;">
                                                        <a href="#" title="Ver detalles" onclick="javascript:detallesCotizacion(<?=$DatosCotizacion['IdCotizacion'] ?>)"><?=$DatosCotizacion['IdCotizacion']?></a>
                                                    </td>
                                                    <td><?=$DatosCotizacion['Pnr']?></td>
                                                    <td><?=$DatosCotizacion['FechaCreado'] ." ". $DatosCotizacion['HoraCreado'] . " ". $DatosCotizacion['CreadoTimestamp'] ?></td>
                                                    <td><?=$DatosCotizacion['Agencia']?></td>
                                                    <td><?=$DatosCotizacion['Agente']?></td>
                                                    <td><?=$DatosCotizacion['Origen']?></td>
                                                    <td><?=$DatosCotizacion['Destino']?></td>
                                                    <td><?=$Obj_Ajustes->FechaInvertir($DatosCotizacion['Ida'])?></td>
                                                    <td><?=$Obj_Ajustes->FechaInvertir($DatosCotizacion['Regreso'])?></td>
                                                    <td><?=$DatosCotizacion['NumeroBoletos']?></td>
                                                    <td><?=$DatosCotizacion['Accion']?></td>
                                                    <td><?=$DatosCotizacion['Fecha'] === '0000-00-00' ? '' : $Obj_Ajustes->FechaInvertir($DatosCotizacion['Fecha']) ?></td>
                                                    <td><?=$DatosCotizacion['Comentario']?></td>
                                                    <td><?=$Obj_Ajustes->FormatoDinero($DatosCotizacion['Cotizado'])?></td>
                                                    <td><?=$Obj_Ajustes->FormatoDinero($DatosCotizacion['Max'])?></td>
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
    <script>
        function detallesCotizacion(id) {
            window.open('<?= $_SESSION['path'] ?>cotizaciones/detalles.php?id='+id ,'Nueva Cotización', 'width=800,height=1000')
        }
    </script>
</body>

</html>