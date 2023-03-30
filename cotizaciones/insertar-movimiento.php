<?php

require_once '../func/validateSession.php';
require_once '../bd/bd.php';
require_once '../class/Movimientos.php';
require_once '../class/Ajustes.php';

$Obj_Movimientos = new Movimientos();
$Obj_Ajustes = new Ajustes();

$Obj_Movimientos->IdCotizacion = $Obj_Ajustes->RemoverEtiquetas($_POST['IdCotizacion']);
$Obj_Movimientos->Agente = $_SESSION['Agente'];
$Obj_Movimientos->Agencia = $_SESSION['Agencia'];
$Obj_Movimientos->Comentario = trim($_POST['txtComentario']);
$Obj_Movimientos->Accion = trim($_POST['txtAccion']);

$Res_Movimientos = $Obj_Movimientos->Insertar();


if ($Res_Movimientos) {
    $_SESSION['success-registro'] = 'movimiento';
    echo "<script>history.go(-1);setTimeout(() => {
        window.location.reload()
    }, 1000); </script>";
}
?>
