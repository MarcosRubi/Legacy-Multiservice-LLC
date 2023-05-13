<?php
require_once '../../func/validateSession.php';

if ($_SESSION['IdRole'] !== 2) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporte de ventas</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
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

<body class="hold-transition sidebar-mini">
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
                        <!-- LINE CHART -->
                        <div class="col-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title" id="title">Ingresos mensuales</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body" id="result">

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="d-flex justify-content-center col-12 mt-3 flex-column flex-md-row">
                            <!-- DONUT CHART -->
                            <div class="card card-danger col mx-2 p-0">
                                <div class="card-header">
                                    <h3 class="card-title" id="title-quotes">Cotizaciones realizadas</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="resultCotizaciones"></div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <!-- PIE CHART -->
                            <div class="card card-info col mx-2 p-0">
                                <div class="card-header">
                                    <h3 class="card-title" id="title-tickets">Boletos creados</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="resultsBoletos"></div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <!-- /.card -->
                        <div class="d-flex justify-content-center col-12 mt-3 flex-column flex-md-row">

                            <!-- PIE CHART -->
                            <div class="card card-warning col mx-2 p-0">
                                <div class="card-header">
                                    <h3 class="card-title" id="title-clients">Clientes creados</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="resultsClientes"></div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <!-- PIE CHART -->
                            <div class="card card-success col mx-2 p-0">
                                <div class="card-header">
                                    <h3 class="card-title" id="title-invoices">Facturas creadas</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="resultsFacturas"></div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.col (RIGHT) -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->

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
    <div class="position-fixed bg-info" style=" z-index: 5000; bottom: 1rem; right: 1rem;  border-radius: 50%;box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
        <div class="btn-group">
            <button type="button" class="btn btn-tool dropdown-toggle text-white" data-toggle="dropdown" aria-expanded="false" style="padding: 2.5rem 1.5rem;">
                <i class="fas fa-lg fa-wrench"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right bg-dark" role="menu">
                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal-xl-date" onclick="javascript:updateActiveItem(event)">Personalizada</a>
                <a href="#" class="dropdown-item" onclick="javascript:changeTime(event,'year')">Este año</a>
                <a href="#" class="dropdown-item" onclick="javascript:changeTime(event,'month')">Este mes</a>
                <a href="#" class="dropdown-item" onclick="javascript:changeTime(event,'week')">Esta semana</a>
                <a href="#" class="dropdown-item active" onclick="javascript:changeTime(event,'now')">Hoy</a>
            </div>
        </div>
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

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="../../plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- InputMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- jquery-validation -->
    <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
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

        changeTime(null, 'now');


        function changeTime(e, filter) {
            const formData = obtenerDatosFormulario(); // Obtener los datos del formulario del modal
            updateIncomeGraph(e, filter, formData);
            updateCharCotizaciones(e, filter, formData);
            updateCharBoletos(e, filter, formData);
            updateCharClientes(e, filter, formData);
            updateCharFacturas(e, filter, formData);
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


        function updateIncomeGraph(e, filter, formData) {
            $.ajax({
                url: '../../secciones/tablaIngresos.php',
                method: 'POST',
                data: {
                    filter,
                    formData
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
        }

        function updateCharCotizaciones(e, filter, formData) {
            $.ajax({
                url: '../../secciones/graficaCotizaciones.php',
                method: 'POST',
                data: {
                    filter,
                    formData
                },
                success: function(response) {
                    $('#resultCotizaciones').html(response);
                }
            });
            changeTitleChar('title-quotes', 'Cotizaciones creadas')
        }

        function updateCharBoletos(e, filter, formData) {
            $.ajax({
                url: '../../secciones/graficaBoletos.php',
                method: 'POST',
                data: {
                    filter,
                    formData
                },
                success: function(response) {
                    $('#resultsBoletos').html(response);
                }
            });

            changeTitleChar('title-tickets', 'Boletos creados')

        }

        function updateCharClientes(e, filter, formData) {
            $.ajax({
                url: '../../secciones/graficaClientes.php',
                method: 'POST',
                data: {
                    filter,
                    formData
                },
                success: function(response) {
                    $('#resultsClientes').html(response);
                }
            });

            changeTitleChar('title-clients', 'Clientes creados')


        }

        function updateCharFacturas(e, filter, formData) {
            $.ajax({
                url: '../../secciones/graficaFacturas.php',
                method: 'POST',
                data: {
                    filter,
                    formData
                },
                success: function(response) {
                    $('#resultsFacturas').html(response);
                }
            });

            changeTitleChar('title-invoices', 'Facturas creadas')
        }

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

        function changeTitleChar(titleId, charName) {
            let title = document.getElementById(titleId)
            if (document.getElementById('txtFechaInicio').value !== '' && document.getElementById('txtFechaFin').value) {
                title.innerHTML = `${charName} entre: <strong>${document.getElementById('txtFechaInicio').value}</strong> al <strong>${document.getElementById('txtFechaFin').value} </strong>`
            } else {
                title.innerHTML = `${charName}`
            }
        }
    </script>
    <!-- Page specific script -->

    <script>
        <?php require_once '../../func/Mensajes.php'; ?>
    </script>
</body>

</html>