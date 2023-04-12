
<?php
require_once '../../func/validateSession.php';

if ($_SESSION['IdRole'] > 3) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

require_once '../../bd/bd.php';
require_once '../../class/Clientes.php';
require_once '../../class/Eventos.php';


$Obj_Clientes = new Clientes();
$Obj_Eventos = new Eventos();


$Res_DatosCliente = $Obj_Clientes->buscarPorId($_GET['id']);
$Res_Clientes = $Obj_Clientes->Eliminar($_GET['id']);

$DatosCliente = $Res_DatosCliente->fetch_assoc();

$Obj_Eventos->NombreEmpleado = $_SESSION['NombreEmpleado'];
$Obj_Eventos->Mensaje = 'ha eliminado al cliente';
$Obj_Eventos->VentanaEmergente = 'N';
$Obj_Eventos->TipoEvento = $DatosCliente['PrimerNombre'] . " "  . $DatosCliente['SegundoNombre'] . " " . $DatosCliente['Apellido'];
$Obj_Eventos->Icono = 'fas fa-user-minus bg-danger';
$Obj_Eventos->Insertar();

if ($Res_Clientes) {
    $_SESSION['success-delete'] = 'cliente';
    header("Location:" . $_SESSION['path'] . "buscar-cliente/");
}
?>
