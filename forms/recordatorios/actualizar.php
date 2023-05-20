<?php
require_once '../../func/validateSession.php';
require_once '../../bd/bd.php';
require_once '../../class/Recordatorios.php';

$Obj_Recordatorios = new Recordatorios();


if ($_GET['accion'] === 'completar') {
    $Obj_Recordatorios->Estado = "Realizado";
    $Res_Recordatorios = $Obj_Recordatorios->ActualizarEstado($_GET['id']);
    $_SESSION['success-update'] = 'recordatorioRealizado';
}
if ($_GET['accion'] === 'eliminar') {
    $Obj_Recordatorios->Estado = "Cancelado";
    $Obj_Recordatorios->ActualizarEstado($_GET['id']);
    $Res_Recordatorios = $Obj_Recordatorios->Eliminar($_GET['id']);
    $_SESSION['success-update'] = 'recordatorioEliminado';
}

if ($Res_Recordatorios) {
    echo "<script>history.go(-1)</script>";
}
