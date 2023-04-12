
<?php
require_once '../../func/validateSession.php';

if ($_SESSION['IdRole'] > 3) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

require_once '../../bd/bd.php';
require_once '../../class/Facturas.php';
require_once '../../class/Eventos.php';

$Obj_Facturas = new Facturas();
$Obj_Eventos = new Eventos();


$Res_Facturas = $Obj_Facturas->Eliminar($_GET['id']);


$Obj_Eventos->NombreEmpleado = $_SESSION['NombreEmpleado'];
$Obj_Eventos->Mensaje = 'ha eliminado la';
$Obj_Eventos->VentanaEmergente = 'N';
$Obj_Eventos->TipoEvento = "factura #" . $_GET['id'];
$Obj_Eventos->Icono = 'fas fa-user-minus bg-danger';
$Obj_Eventos->Insertar();

if ($Res_Facturas) {
    $_SESSION['success-delete'] = 'factura';
    header("Location:" . $_SESSION['path'] . "buscar-factura/");
}
?>
