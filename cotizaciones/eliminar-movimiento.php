<?php

session_start();
require_once '../bd/bd.php';
require_once '../class/Movimientos.php';

$Obj_Movimientos = new Movimientos();

$Res_Movimientos = $Obj_Movimientos->Eliminar($_GET['id']);


if ($Res_Movimientos) {
    $_SESSION['success-registro'] = 'eliminar-movimiento';
    echo "<script>history.go(-1);setTimeout(() => {
        window.location.reload()
    }, 1000); </script>";
}
?>
