<?php
require_once '../func/validateSession.php';
require_once '../bd/bd.php';
require_once '../class/Clientes.php';
require_once '../class/Recordatorios.php';
require_once '../class/Ajustes.php';

$Obj_clientes = new Clientes();
$Obj_recordatorios = new Recordatorios();
$Obj_ajustes = new Ajustes();

$Res_Clientes = $Obj_clientes->listarTodo();
$Res_recordatorios = $Obj_recordatorios->listarRecordatorios($_SESSION['IdEmpleado']);

?>

<form action="../forms/recordatorios/insertar.php" method="post" id="frmRecordatorios">
    <div class="row">
        <!-- Título -->
        <div class="col-sm-12">
            <div class="form-group">
                <label>Título</label>
                <input type="text" class="form-control" placeholder="Título ..." name="txtTitulo">
            </div>
        </div>
        <!-- Cliente -->
        <div class="col-sm-4">
            <div class="form-group">
                <label>Cliente</label>
                <select class="form-control select2" style="width: 100%;" name="txtIdCliente">
                    <option value="1" selected>Sin asignar cliente</option>
                    <?php while ($DatosClientes = $Res_Clientes->fetch_assoc()) { ?>
                        <option value="<?= $DatosClientes['IdCliente'] ?>"><?= $DatosClientes['PrimerNombre'] . " " . $DatosClientes['SegundoNombre']  . " " .  $DatosClientes['Apellido'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <!-- Fecha -->
        <div class="col-sm-4">

            <div class="form-group">
                <label>Fecha y Hora:</label>
                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime" name="txtFecha">
                    <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Estado -->
        <div class="col-sm-4">
            <div class="form-group">
                <label>Estado</label>
                <select class="form-control select2" style="width: 100%;" name="txtEstado">
                    <option selected="selected">Pendiente</option>
                    <option>En Proceso</option>
                    <option>Realizado</option>
                    <option>Cancelado</option>
                </select>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label>Descripción</label>
                <textarea id="summernote" name="txtDescripcion">

                                                </textarea>
            </div>
        </div>
    </div>
    <button class="btn btn-primary font-weight-bold btn-block">Agregar nuevo
        recordatorio</button>
</form>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        // Summernote
        $('#summernote').summernote()

        //Date and time picker
        <?php if ($_SESSION['FormatoFecha'] === 'dmy') { ?>
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                },
                format: 'DD-MM-YYYY hh:mm A'

            });
        <?php } else { ?>
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                },
                format: 'MM-DD-YYYY hh:mm A'

            });
        <?php  } ?>
    })

    $(function() {
        $('#frmRecordatorios').validate({
            rules: {
                txtTitulo: {
                    required: true
                },
                txtFecha: {
                    required: true
                }
            },
            messages: {
                txtTitulo: {
                    required: "El título es obligatorio",
                },
                txtFecha: {
                    required: "La fecha y hora son obligatorios"
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
        document.querySelectorAll('.card-body')[1].childNodes[0].remove()

    })
</script>