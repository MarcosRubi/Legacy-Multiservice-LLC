<?php
require_once '../../func/validateSession.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resultados de cotizaciones</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-left:0px;">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="pt-3">Cotizaciones encontradas de: <strong>12/02/2023</strong> a
                                    <strong>22/02/2023</strong></p>
                                <div>
                                    <button class="btn btn-primary btn-lg"
                                        onclick="javascript:cerrarVentana();">Cerrar</button>
                                </div>
                            </div>
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="logs" class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="text-center">
                                                <th>ID</th>
                                                <th>Cliente</th>
                                                <th>PNR(s)</th>
                                                <th>Comentario</th>
                                                <th>Acci??n</th>
                                                <th>Fecha</th>
                                                <th>Ingresada</th>
                                                <th>Agencia</th>
                                                <th>Agente</th>
                                                <th>Origen</th>
                                                <th>Destino</th>
                                                <th>Ida</th>
                                                <th>Regreso</th>
                                                <th># de Boletos</th>
                                                <th>MAX</th>
                                                <th>$ Cotizado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href="/cotizazion?id=123456">123456</a></td>
                                                <td><a href="/cliente?id=123456">123456</a></td>
                                                <td>3QRBMG</td>
                                                <td>Dice que no tiene dinero</td>
                                                <td></td>
                                                <td></td>
                                                <td>03/03/2023</td>
                                                <td>SLU</td>
                                                <td>MR</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td>12/02/2023</td>
                                                <td>22/02/2023</td>
                                                <td>1</td>
                                                <td>$500</td>
                                                <td>$300</td>
                                            </tr>
                                            <tr>
                                                <td><a href="/cotizazion?id=123456">123456</a></td>
                                                <td><a href="/cliente?id=123456">123456</a></td>
                                                <td>3QRBMG</td>
                                                <td>Dice que no tiene dinero</td>
                                                <td></td>
                                                <td></td>
                                                <td>03/03/2023</td>
                                                <td>SLU</td>
                                                <td>MR</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td>12/02/2023</td>
                                                <td>22/02/2023</td>
                                                <td>1</td>
                                                <td>$300</td>
                                                <td>$500</td>
                                            </tr>
                                            <tr>
                                                <td><a href="/cotizazion?id=123456">123456</a></td>
                                                <td><a href="/cliente?id=123456">123456</a></td>
                                                <td>3QRBMG</td>
                                                <td>Dice que no tiene dinero</td>
                                                <td></td>
                                                <td></td>
                                                <td>03/03/2023</td>
                                                <td>SLU</td>
                                                <td>MR</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td>12/02/2023</td>
                                                <td>22/02/2023</td>
                                                <td>1</td>
                                                <td>$300</td>
                                                <td>$500</td>
                                            </tr>
                                            <tr>
                                                <td><a href="/cotizazion?id=123456">123456</a></td>
                                                <td><a href="/cliente?id=123456">123456</a></td>
                                                <td>3QRBMG</td>
                                                <td>Dice que no tiene dinero</td>
                                                <td></td>
                                                <td></td>
                                                <td>03/03/2023</td>
                                                <td>SLU</td>
                                                <td>MR</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td>12/02/2023</td>
                                                <td>22/02/2023</td>
                                                <td>1</td>
                                                <td>$300</td>
                                                <td>$500</td>
                                            </tr>
                                            <tr>
                                                <td><a href="/cotizazion?id=123456">123456</a></td>
                                                <td><a href="/cliente?id=123456">123456</a></td>
                                                <td>3QRBMG</td>
                                                <td>Dice que no tiene dinero</td>
                                                <td></td>
                                                <td></td>
                                                <td>03/03/2023</td>
                                                <td>SLU</td>
                                                <td>MR</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td>12/02/2023</td>
                                                <td>22/02/2023</td>
                                                <td>1</td>
                                                <td>$300</td>
                                                <td>$500</td>
                                            </tr>
                                            <tr>
                                                <td><a href="/cotizazion?id=123456">123456</a></td>
                                                <td><a href="/cliente?id=123456">123456</a></td>
                                                <td>3QRBMG</td>
                                                <td>Dice que no tiene dinero</td>
                                                <td></td>
                                                <td></td>
                                                <td>03/03/2023</td>
                                                <td>SLU</td>
                                                <td>MR</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td>12/02/2023</td>
                                                <td>22/02/2023</td>
                                                <td>1</td>
                                                <td>$300</td>
                                                <td>$500</td>
                                            </tr>
                                            <tr>
                                                <td><a href="/cotizazion?id=123456">123456</a></td>
                                                <td><a href="/cliente?id=123456">123456</a></td>
                                                <td>3QRBMG</td>
                                                <td>Dice que no tiene dinero</td>
                                                <td></td>
                                                <td></td>
                                                <td>03/03/2023</td>
                                                <td>SLU</td>
                                                <td>MR</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td>12/02/2023</td>
                                                <td>22/02/2023</td>
                                                <td>1</td>
                                                <td>$300</td>
                                                <td>$500</td>
                                            </tr>
                                            <tr>
                                                <td><a href="/cotizazion?id=123456">123456</a></td>
                                                <td><a href="/cliente?id=123456">123456</a></td>
                                                <td>3QRBMG</td>
                                                <td>Dice que no tiene dinero</td>
                                                <td></td>
                                                <td></td>
                                                <td>03/03/2023</td>
                                                <td>SLU</td>
                                                <td>MR</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td>12/02/2023</td>
                                                <td>22/02/2023</td>
                                                <td>1</td>
                                                <td>$300</td>
                                                <td>$500</td>
                                            </tr>
                                            <tr>
                                                <td><a href="/cotizazion?id=123456">123456</a></td>
                                                <td><a href="/cliente?id=123456">123456</a></td>
                                                <td>3QRBMG</td>
                                                <td>Dice que no tiene dinero</td>
                                                <td></td>
                                                <td></td>
                                                <td>03/03/2023</td>
                                                <td>SLU</td>
                                                <td>MR</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td>12/02/2023</td>
                                                <td>22/02/2023</td>
                                                <td>1</td>
                                                <td>$300</td>
                                                <td>$500</td>
                                            </tr>
                                            <tr>
                                                <td><a href="/cotizazion?id=123456">123456</a></td>
                                                <td><a href="/cliente?id=123456">123456</a></td>
                                                <td>3QRBMG</td>
                                                <td>Dice que no tiene dinero</td>
                                                <td></td>
                                                <td></td>
                                                <td>03/03/2023</td>
                                                <td>SLU</td>
                                                <td>MR</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td>12/02/2023</td>
                                                <td>22/02/2023</td>
                                                <td>1</td>
                                                <td>$300</td>
                                                <td>$500</td>
                                            </tr>
                                            <tr>
                                                <td><a href="/cotizazion?id=123456">123456</a></td>
                                                <td><a href="/cliente?id=123456">123456</a></td>
                                                <td>3QRBMG</td>
                                                <td>Dice que no tiene dinero</td>
                                                <td></td>
                                                <td></td>
                                                <td>03/03/2023</td>
                                                <td>SLU</td>
                                                <td>MR</td>
                                                <td>JFK</td>
                                                <td>SAL</td>
                                                <td>12/02/2023</td>
                                                <td>22/02/2023</td>
                                                <td>1</td>
                                                <td>$300</td>
                                                <td>$500</td>
                                            </tr>
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
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

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
        $(function () {
            $('#logs').DataTable({
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
        function nuevoCliente() {
            window.open('../forms/nuevo-cliente/', 'Nuevo Cliente', 'width=400,height=1000')
        }
        function nuevoClientev2() {
            window.open('../forms/cliente/frmNuevo.php', 'Nuevo Cliente', 'width=2000,height=400')
        }

        function cerrarVentana() {
            window.close();
        }

    </script>
</body>

</html>