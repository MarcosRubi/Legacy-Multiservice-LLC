<?php
require_once '../../func/validateSession.php';
require_once '../../bd/bd.php';
require_once '../../class/Ajustes.php';
require_once '../../class/Boletos.php';

if ($_SESSION['IdRole'] >= 3) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

$Obj_Ajustes = new Ajustes();
$Obj_Boletos = new Boletos();

$Res_BoletosListado = $Obj_Boletos->listarTodo();

if (isset($_GET['s'])) {
    $Res_BoletosListado = $Obj_Boletos->buscarBoleto($_GET['s']);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporte de boletos | Legacy Multiservice LLC</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <style>
        .dropdown-item:hover {
            background-color: #555;
        }

        .dropdown-item.active:hover {
            background-color: #007bff;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include_once '../../secciones/navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include_once '../../secciones/mainSidebarContainer.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper pt-3">
            <div id="resultsResumenEstadisticas"></div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- /.col (LEFT) -->
                        <div class="col">
                            <!-- LINE CHART -->
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title" id="title">Ingresos mensuales</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-wrench"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right bg-dark" role="menu">
                                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal-xl-date" onclick="javascript:updateActiveItem(event)">Personalizada</a>
                                                <a href="#" class="dropdown-item active" onclick="javascript:changeTime(event,'year')">Este año</a>
                                                <a href="#" class="dropdown-item" onclick="javascript:changeTime(event,'month')">Este mes</a>
                                                <a href="#" class="dropdown-item" onclick="javascript:changeTime(event,'week')">Esta semana</a>
                                                <a href="#" class="dropdown-item" onclick="javascript:changeTime(event,'now')">Hoy</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" id="result">

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                        </div>
                        <!-- /.col (RIGHT) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <!-- <h2 class="text-center display-4">Buscar Boleto</h2>
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form method="get">
                                <div class="input-group">
                                    <input type="search" class="form-control form-control-lg" placeholder="Buscar..." autofocus name="s">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-lg btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <span class="text-gray">Puedes buscar por cualquier parámetro de la tabla</span>
                        </div>
                    </div> -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <?php
                                    if (isset($_GET['s']) && $_GET['s'] !== "") { ?>
                                        <div class="d-flex justify-content-between mb-2 mt-3">
                                            <h3 class='card-title'>Boletos encontrados para: <strong><?= $_GET['s'] ?></strong></h3>
                                            <a href="./" class="btn btn-primary">Listar todo</a>
                                        </div>
                                    <?php } else {
                                        echo "<h3 class='card-title'>Últimos boletos creados</h3>";
                                    }
                                    ?>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="boletos-logs" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th># Boleto</th>
                                                <th>Nombre del pasajero</th>
                                                <th>Aerolínea</th>
                                                <th>Origen</th>
                                                <th>Destino</th>
                                                <th>Fecha Ida</th>
                                                <th>Fecha Regreso</th>
                                                <th>Forma de pago</th>
                                                <th>Precio</th>
                                                <th>Base</th>
                                                <th>Tax</th>
                                                <th>FM</th>
                                                <th>IATA</th>
                                                <?php if ($_SESSION['IdRole'] <= 3) { ?>
                                                    <th>&nbsp;</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($Res_BoletosListado as $key => $DatosBoleto) {
                                            ?>
                                                <tr>
                                                    <td><?= $DatosBoleto['NumeroBoletos'] ?></td>
                                                    <td><?= $DatosBoleto['NombrePasajero'] ?></td>
                                                    <td><?= $DatosBoleto['Aerolinea'] ?></td>
                                                    <td><?= $DatosBoleto['Origen'] ?></td>
                                                    <td><?= $DatosBoleto['Destino'] ?></td>
                                                    <td><?= $DatosBoleto['FechaIda'] === '0000-00-00' ? '' : $Obj_Ajustes->FechaInvertir($DatosBoleto['FechaIda']) ?></td>
                                                    <td><?= $DatosBoleto['FechaRegreso'] === '0000-00-00' ? '' : $Obj_Ajustes->FechaInvertir($DatosBoleto['FechaRegreso']) ?></td>
                                                    <td><?= $DatosBoleto['FormaPago'] ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosBoleto['Precio']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosBoleto['Base']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosBoleto['Tax']) ?></td>
                                                    <td><?= $Obj_Ajustes->FormatoDinero($DatosBoleto['Fm']) ?></td>
                                                    <td><?= $DatosBoleto['NombreIata'] ?></td>
                                                    <?php if ($_SESSION['IdRole'] <= 3) { ?>
                                                        <td class="d-flex">
                                                            <a class="btn btn-md mx-1 btn-primary" title="Editar" onclick="javascript:editarBoleto(<?= $DatosBoleto['IdBoleto'] ?>);">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a class="btn btn-md mx-1 bg-danger" title="Eliminar" onclick="javascript:eliminarBoleto(<?= $DatosBoleto['IdBoleto'] ?>);">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    <?php  } ?>
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
            </div>
            <!-- /.content -->
            <!-- /.card -->

        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <?php include_once '../../secciones/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <div class="modal fade" id="modal-xl-date">
        <div class="modal-dialog modal-xl-date">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Selecciona el rango de fechas</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" class="card card-info" id="frmDate">
                    <div class="modal-body">
                        <div class="card-body ">
                            <div class="d-flex flex-column">
                                <div class="form-group container-fluid mr-5">
                                    <div class="d-flex align-center">
                                        <div class="form-group mr-3">
                                            <label>Desde:</label>
                                            <div class="input-group date" id="datefrom" data-target-input="nearest">
                                                <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#datefrom" data-inputmask-alias="datetime" placeholder="dd-mm-yyyy" name="txtFechaInicio" id="txtFechaInicio">
                                                <?php } ?>
                                                <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#datefrom" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaInicio" id="txtFechaInicio">
                                                <?php } ?>
                                                <div class="input-group-append" data-target="#datefrom" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Hasta:</label>
                                            <div class="input-group date" id="dateto" data-target-input="nearest">
                                                <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#dateto" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="txtFechaFin" id="txtFechaFin">
                                                <?php } ?>
                                                <?php if ($_SESSION['FormatoFecha'] === 'mdy') { ?>
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#dateto" data-inputmask-alias="datetime" data-inputmask-inputformat="mm-dd-yyyy" placeholder="mm-dd-yyyy" name="txtFechaFin" id="txtFechaFin">
                                                <?php } ?>
                                                <div class="input-group-append" data-target="#dateto" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="reset" class="btn d-none reset">Resetear</button>
                        <button type="submit" class="btn btn-primary">Mostrar reporte</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    </div>

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
    <!-- SweetAlert2 -->
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- ChartJS -->
    <script src="../../plugins/chart.js/Chart.min.js"></script>
    <!-- InputMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- jquery-validation -->
    <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            //Phone Number
            $('[data-mask]').inputmask()
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
        let formDate = document.getElementById('frmDate')

        formDate.addEventListener('submit', (e) => {
            e.preventDefault();

            $('#frmDate').validate({
                rules: {
                    txtFechaInicio: {
                        required: true
                    },
                    txtFechaFin: {
                        required: true
                    }
                },
                messages: {
                    txtFechaInicio: {
                        required: "Este campo es obligatorio",
                    },
                    txtFechaFin: {
                        required: "Este campo es obligatorio",
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            if ($('#frmDate').valid()) {
                changeTime(null, 'personal')
                $('button.btn-default').click();
                $('button.reset').click();
            }
        })
    </script>
    <script>
        const MONTHS = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre']

        const numeroDeSemana = fecha => {
            const DIA_EN_MILISEGUNDOS = 1000 * 60 * 60 * 24,
                DIAS_QUE_TIENE_UNA_SEMANA = 7,
                JUEVES = 4;
            fecha = new Date(Date.UTC(fecha.getFullYear(), fecha.getMonth(), fecha.getDate()));
            let diaDeLaSemana = fecha.getUTCDay(); // Domingo es 0, sábado es 6
            if (diaDeLaSemana === 0) {
                diaDeLaSemana = 7;
            }
            fecha.setUTCDate(fecha.getUTCDate() - diaDeLaSemana + JUEVES);
            const inicioDelAño = new Date(Date.UTC(fecha.getUTCFullYear(), 0, 1));
            const diferenciaDeFechasEnMilisegundos = fecha - inicioDelAño;
            return Math.ceil(((diferenciaDeFechasEnMilisegundos / DIA_EN_MILISEGUNDOS) + 1) / DIAS_QUE_TIENE_UNA_SEMANA);
        };

        $(function() {
            $('#boletos-logs').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

        changeTime(null, 'year');

        function eliminarBoleto(id) {
            let confirmacion = confirm("¿Está seguro que desea eliminar el boleto? Esto puede eliminar o modificar los datos de la factura.");

            if (confirmacion) {
                window.location.href = '<?= $_SESSION['path'] ?>forms/boletos/eliminar.php?id=' + id
            }
        }

        function editarBoleto(id) {
            let confirmacion = confirm("¿Está seguro que desea editar el boleto? Esto puede modificar la factura o demás boletos.");

            if (confirmacion) {
                window.open('<?= $_SESSION['path'] ?>boletos/detalles.php?id=' + id, "Editar boleto", "width=2000,height=2000")
            }
        }


        function changeTime(e, filter) {
            const formData = obtenerDatosFormulario(); // Obtener los datos del formulario del modal
            updateIncomeGraph(e, filter, formData, true);
            updateSalesSummaryCharts(e, filter, formData);
            e?.target.classList.add('active');
        }

        function obtenerDatosFormulario() {
            // Obtener el formulario dentro del modal
            const formulario = document.getElementById('frmDate');

            // Crear un objeto FormData para obtener los datos del formulario
            const formData = new FormData(formulario);

            // Convertir el objeto FormData a un objeto JavaScript
            const datosFormulario = Object.fromEntries(formData.entries());

            return datosFormulario;
        }


        function updateIncomeGraph(e, filter, formData, mco) {
            $.ajax({
                url: '../../secciones/tablaIngresos.php',
                method: 'POST',
                data: {
                    filter,
                    formData,
                    mco
                },
                success: function(response) {
                    $('#result').html(response);
                }
            });

            let title = document.getElementById('title')
            let date = new Date();

            title.innerHTML = 'Ingresos mensuales' + ' del ' + date.getFullYear()

            e ? document.querySelector('.dropdown-item.active').classList.remove('active') : ''
            if (filter) {
                filter === 'year' ? title.innerHTML = 'Ingresos mensuales' + ' del ' + date.getFullYear() : ''
                filter === 'month' ? title.innerHTML = 'Ingresos para el mes de ' + MONTHS[date.getMonth()] + ' del ' + date.getFullYear() : ''
                filter === 'week' ? title.innerHTML = 'Ingresos para la semana #' + numeroDeSemana(new Date()) + ' del ' + date.getFullYear() : ''
                filter === 'now' ? title.innerHTML = 'Ingresos del día ' + date.getDate() + ' de ' + MONTHS[date.getMonth()] + ' del ' + date.getFullYear() : ''
                filter === 'personal' ? title.innerHTML = 'Ingresos del día ' + document.getElementById('txtFechaInicio').value + ' al ' + document.getElementById('txtFechaFin').value : ''
            }
        };

        function updateSalesSummaryCharts(e, filter, formData) {
            $.ajax({
                url: '../../secciones/resumenEstadisticas.php',
                method: 'POST',
                data: {
                    filter,
                    report: true,
                    formData
                },
                success: function(response) {
                    $('#resultsResumenEstadisticas').html(response);
                }
            });
        }

        function updateActiveItem(e) {
            document.querySelector('.dropdown-item.active')?.classList.remove('active');
            e?.target.classList.add('active');
        }
    </script>
    <!-- Page specific script -->

    <script>
        <?php require_once '../../func/Mensajes.php'; ?>
    </script>
</body>

</html>