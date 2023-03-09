<?php
require_once '../../func/validateSession.php';
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
                                    <h3 class="card-title">Boletos a nombre de <strong>Marcos Daniel Rubí</strong></h3>
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
                                                <th>Aerolínea</th>
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
                                            <tr>
                                                <td>1651651</td>
                                                <td>Marcos Daniel Rubí</td>
                                                <td>07-07-1999</td>
                                                <td>American Multi Services</td>
                                                <td>Marcos Rubí</td>
                                                <td>134</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td style="width:4.1rem;">02-02-2020</td>
                                                <td style="width:4.1rem;">02-07-2020</td>
                                                <td>U</td>
                                                <td>Efectivo</td>
                                                <td>623.00</td>
                                                <td>523.00</td>
                                                <td>100.00</td>
                                                <td>5.00</td>
                                                <td style="width:1rem;">
                                                    <a href="#" title="Editar">
                                                        <i class="fa fa-edit fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>1651651</td>
                                                <td>Marcos Daniel Rubí</td>
                                                <td>07-07-1999</td>
                                                <td>American Multi Services</td>
                                                <td>Marcos Rubí</td>
                                                <td>134</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td style="width:4.1rem;">02-02-2020</td>
                                                <td style="width:4.1rem;">02-07-2020</td>
                                                <td>U</td>
                                                <td>Efectivo</td>
                                                <td>623.00</td>
                                                <td>523.00</td>
                                                <td>100.00</td>
                                                <td>5.00</td>
                                                <td style="width:1rem;">
                                                    <a href="#" title="Editar">
                                                        <i class="fa fa-edit fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>1651651</td>
                                                <td>Marcos Daniel Rubí</td>
                                                <td>07-07-1999</td>
                                                <td>American Multi Services</td>
                                                <td>Marcos Rubí</td>
                                                <td>134</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td style="width:4.1rem;">02-02-2020</td>
                                                <td style="width:4.1rem;">02-07-2020</td>
                                                <td>U</td>
                                                <td>Efectivo</td>
                                                <td>623.00</td>
                                                <td>523.00</td>
                                                <td>100.00</td>
                                                <td>5.00</td>
                                                <td style="width:1rem;">
                                                    <a href="#" title="Editar">
                                                        <i class="fa fa-edit fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>1651651</td>
                                                <td>Marcos Daniel Rubí</td>
                                                <td>07-07-1999</td>
                                                <td>American Multi Services</td>
                                                <td>Marcos Rubí</td>
                                                <td>134</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td style="width:4.1rem;">02-02-2020</td>
                                                <td style="width:4.1rem;">02-07-2020</td>
                                                <td>U</td>
                                                <td>Efectivo</td>
                                                <td>623.00</td>
                                                <td>523.00</td>
                                                <td>100.00</td>
                                                <td>5.00</td>
                                                <td style="width:1rem;">
                                                    <a href="#" title="Editar">
                                                        <i class="fa fa-edit fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>1651651</td>
                                                <td>Marcos Daniel Rubí</td>
                                                <td>07-07-1999</td>
                                                <td>American Multi Services</td>
                                                <td>Marcos Rubí</td>
                                                <td>134</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td style="width:4.1rem;">02-02-2020</td>
                                                <td style="width:4.1rem;">02-07-2020</td>
                                                <td>U</td>
                                                <td>Efectivo</td>
                                                <td>623.00</td>
                                                <td>523.00</td>
                                                <td>100.00</td>
                                                <td>5.00</td>
                                                <td style="width:1rem;">
                                                    <a href="#" title="Editar">
                                                        <i class="fa fa-edit fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>1651651</td>
                                                <td>Marcos Daniel Rubí</td>
                                                <td>07-07-1999</td>
                                                <td>American Multi Services</td>
                                                <td>Marcos Rubí</td>
                                                <td>134</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td style="width:4.1rem;">02-02-2020</td>
                                                <td style="width:4.1rem;">02-07-2020</td>
                                                <td>U</td>
                                                <td>Efectivo</td>
                                                <td>623.00</td>
                                                <td>523.00</td>
                                                <td>100.00</td>
                                                <td>5.00</td>
                                                <td style="width:1rem;">
                                                    <a href="#" title="Editar">
                                                        <i class="fa fa-edit fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>1651651</td>
                                                <td>Marcos Daniel Rubí</td>
                                                <td>07-07-1999</td>
                                                <td>American Multi Services</td>
                                                <td>Marcos Rubí</td>
                                                <td>134</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td style="width:4.1rem;">02-02-2020</td>
                                                <td style="width:4.1rem;">02-07-2020</td>
                                                <td>U</td>
                                                <td>Efectivo</td>
                                                <td>623.00</td>
                                                <td>523.00</td>
                                                <td>100.00</td>
                                                <td>5.00</td>
                                                <td style="width:1rem;">
                                                    <a href="#" title="Editar">
                                                        <i class="fa fa-edit fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>1651651</td>
                                                <td>Marcos Daniel Rubí</td>
                                                <td>07-07-1999</td>
                                                <td>American Multi Services</td>
                                                <td>Marcos Rubí</td>
                                                <td>134</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td style="width:4.1rem;">02-02-2020</td>
                                                <td style="width:4.1rem;">02-07-2020</td>
                                                <td>U</td>
                                                <td>Efectivo</td>
                                                <td>623.00</td>
                                                <td>523.00</td>
                                                <td>100.00</td>
                                                <td>5.00</td>
                                                <td style="width:1rem;">
                                                    <a href="#" title="Editar">
                                                        <i class="fa fa-edit fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>1651651</td>
                                                <td>Marcos Daniel Rubí</td>
                                                <td>07-07-1999</td>
                                                <td>American Multi Services</td>
                                                <td>Marcos Rubí</td>
                                                <td>134</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td style="width:4.1rem;">02-02-2020</td>
                                                <td style="width:4.1rem;">02-07-2020</td>
                                                <td>U</td>
                                                <td>Efectivo</td>
                                                <td>623.00</td>
                                                <td>523.00</td>
                                                <td>100.00</td>
                                                <td>5.00</td>
                                                <td style="width:1rem;">
                                                    <a href="#" title="Editar">
                                                        <i class="fa fa-edit fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>1651651</td>
                                                <td>Marcos Daniel Rubí</td>
                                                <td>07-07-1999</td>
                                                <td>American Multi Services</td>
                                                <td>Marcos Rubí</td>
                                                <td>134</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td style="width:4.1rem;">02-02-2020</td>
                                                <td style="width:4.1rem;">02-07-2020</td>
                                                <td>U</td>
                                                <td>Efectivo</td>
                                                <td>623.00</td>
                                                <td>523.00</td>
                                                <td>100.00</td>
                                                <td>5.00</td>
                                                <td style="width:1rem;">
                                                    <a href="#" title="Editar">
                                                        <i class="fa fa-edit fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>1651651</td>
                                                <td>Marcos Daniel Rubí</td>
                                                <td>07-07-1999</td>
                                                <td>American Multi Services</td>
                                                <td>Marcos Rubí</td>
                                                <td>134</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td style="width:4.1rem;">02-02-2020</td>
                                                <td style="width:4.1rem;">02-07-2020</td>
                                                <td>U</td>
                                                <td>Efectivo</td>
                                                <td>623.00</td>
                                                <td>523.00</td>
                                                <td>100.00</td>
                                                <td>5.00</td>
                                                <td style="width:1rem;">
                                                    <a href="#" title="Editar">
                                                        <i class="fa fa-edit fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>1651651</td>
                                                <td>Marcos Daniel Rubí</td>
                                                <td>07-07-1999</td>
                                                <td>American Multi Services</td>
                                                <td>Marcos Rubí</td>
                                                <td>134</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td style="width:4.1rem;">02-02-2020</td>
                                                <td style="width:4.1rem;">02-07-2020</td>
                                                <td>U</td>
                                                <td>Efectivo</td>
                                                <td>623.00</td>
                                                <td>523.00</td>
                                                <td>100.00</td>
                                                <td>5.00</td>
                                                <td style="width:1rem;">
                                                    <a href="#" title="Editar">
                                                        <i class="fa fa-edit fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>1651651</td>
                                                <td>Marcos Daniel Rubí</td>
                                                <td>07-07-1999</td>
                                                <td>American Multi Services</td>
                                                <td>Marcos Rubí</td>
                                                <td>134</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td style="width:4.1rem;">02-02-2020</td>
                                                <td style="width:4.1rem;">02-07-2020</td>
                                                <td>U</td>
                                                <td>Efectivo</td>
                                                <td>623.00</td>
                                                <td>523.00</td>
                                                <td>100.00</td>
                                                <td>5.00</td>
                                                <td style="width:1rem;">
                                                    <a href="#" title="Editar">
                                                        <i class="fa fa-edit fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th># Boleto</th>
                                                <th>Nombre del pasajero</th>
                                                <th>Passenger DOB</th>
                                                <th>Agencia</th>
                                                <th>Agente</th>
                                                <th>Aerolínea</th>
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
                                        </tfoot>
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