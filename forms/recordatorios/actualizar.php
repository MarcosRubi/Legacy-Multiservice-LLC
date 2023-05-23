<?php
require_once '../../func/validateSession.php';
require_once '../../bd/bd.php';
require_once '../../class/Recordatorios.php';
require_once '../../class/Ajustes.php';


$Obj_Recordatorios = new Recordatorios();
$Obj_Ajustes = new Ajustes();


if (isset($_GET['accion']) && $_GET['accion'] === 'completar') {
    $Obj_Recordatorios->Estado = "Realizado";
    $Res_Recordatorios = $Obj_Recordatorios->ActualizarEstado($_GET['id']);
    $_SESSION['success-update'] = 'recordatorioRealizado';
}
if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') {
    $Obj_Recordatorios->Estado = "Cancelado";
    $Obj_Recordatorios->ActualizarEstado($_GET['id']);
    $Res_Recordatorios = $Obj_Recordatorios->Eliminar($_GET['id']);
    $_SESSION['success-update'] = 'recordatorioEliminado';
}
if (isset($_GET['edit'])) {
    if (trim($_POST['txtTitulo']) === '') {
        $_SESSION['error-registro'] = 'titulo';
        echo "<script>history.go(-1)</script>";
        return;
    }

    $Obj_Recordatorios->IdCliente = $Obj_Ajustes->RemoverEtiquetas(strtolower(trim($_POST['txtIdCliente'])));
    $Obj_Recordatorios->Fecha = $Obj_Ajustes->FechaInvertirGuardar(substr($_POST['txtFecha'], 0, -9));
    $Obj_Recordatorios->Hora = strtoupper(substr($_POST['txtFecha'], 10, 20));
    $Obj_Recordatorios->Estado = $Obj_Ajustes->RemoverEtiquetas(ucfirst(strtolower(trim($_POST['txtEstado']))));
    $Obj_Recordatorios->Titulo = $Obj_Ajustes->RemoverEtiquetas(ucfirst(trim($_POST['txtTitulo'])));
    $Obj_Recordatorios->Descripcion = $_POST['txtDescripcion'];
    $Obj_Recordatorios->IdEmpleado = $_SESSION['IdEmpleado'];

    $_SESSION['success-update'] = 'recordatorio';

    $Res_Recordatorios = $Obj_Recordatorios->Actualizar($_POST['IdRecordatorio']);
}

if ($Res_Recordatorios) {
    echo "<script>history.go(-1)</script>";
}
