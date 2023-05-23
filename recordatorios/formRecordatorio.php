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

if (isset($_POST['id']) && $_POST['id'] !== '') {
    $Res_DatosRecordatorio = $Obj_recordatorios->buscarPorId($_POST['id']);
    $DatosRecordatorio = $Res_DatosRecordatorio->fetch_assoc();
}
?>

<form action="<?= isset($DatosRecordatorio) ? '../forms/recordatorios/actualizar.php?edit=true'  : '../forms/recordatorios/insertar.php' ?>" method="post" id="frmRecordatorios">
    <div class="row">
        <!-- Título -->
        <div class="col-sm-12">
            <div class="form-group">
                <label>Título</label>
                <input type="text" class="form-control" placeholder="Título ..." name="txtTitulo" value="<?= isset($DatosRecordatorio) ? $DatosRecordatorio['Titulo'] : '' ?>">
            </div>
        </div>
        <!-- Cliente -->
        <div class="col-sm-4">
            <div class="form-group">
                <label>Cliente</label>
                <select class="form-control select2" style="width: 100%;" name="txtIdCliente">
                    <option value="1" <?= isset($DatosRecordatorio) && $DatosRecordatorio['IdCliente'] === '1' ? 'selected' : '' ?>>Sin asignar cliente</option>
                    <?php
                    while ($DatosClientes = $Res_Clientes->fetch_assoc()) {
                    ?>
                        <option value="<?= $DatosClientes['IdCliente'] ?>" <?= isset($DatosRecordatorio) && intval($DatosRecordatorio['IdCliente']) === intval($DatosClientes['IdCliente']) ? 'selected' : '' ?>>
                            <?= $DatosClientes['PrimerNombre'] . " " . $DatosClientes['SegundoNombre']  . " " .  $DatosClientes['Apellido'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <!-- Fecha -->
        <div class="col-sm-4">

            <div class="form-group">
                <label>Fecha y Hora:</label>
                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime" name="txtFecha" value="<?= isset($DatosRecordatorio) ? $Obj_ajustes->FechaInvertir($DatosRecordatorio['Fecha']) . " " . $DatosRecordatorio['Hora'] : '' ?>">
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
                <select class="form-control select2 " name="txtEstado">
                    <option selected>Pendiente</option>
                    <option <?= isset($DatosRecordatorio) && $DatosRecordatorio['Estado'] === 'En Proceso' ? 'selected' : '' ?>>En Proceso</option>
                    <option <?= isset($DatosRecordatorio) && $DatosRecordatorio['Estado'] === 'Realizado' ? 'selected' : '' ?>>Realizado</option>
                    <option <?= isset($DatosRecordatorio) && $DatosRecordatorio['Estado'] === 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                </select>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label>Descripción</label>
                <textarea id="summernote" name="txtDescripcion"><?= isset($DatosRecordatorio) ? $DatosRecordatorio['Descripcion'] : '' ?></textarea>
            </div>
        </div>
    </div>
    <input type="hidden" class="form-control" name="IdRecordatorio" value="<?= isset($DatosRecordatorio) ? $DatosRecordatorio['IdRecordatorio'] : '' ?>">
    <?php
    if (isset($_POST['id']) && $_POST['id'] !== '') { ?>
        <button class="btn btn-primary btn-lg font-weight-bold btn-block ">Actualizar recordatorio</button>
        <button type="reset" class="btn btn-lg font-weight-bold btn-block " onclick="javascript:obtenerFrmRecordarorios()">Cancelar</button>
    <?php } else { ?>
        <button class="btn btn-primary btn-lg font-weight-bold btn-block ">Agregar nuevo recordatorio</button>
    <?php } ?>
</form>