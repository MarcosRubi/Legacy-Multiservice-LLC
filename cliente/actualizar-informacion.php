<?php
require_once '../func/validateSession.php';
require_once '../bd/bd.php';
require_once '../class/Clientes.php';
require_once '../class/Eventos.php';

$Obj_Clientes = new Clientes();
$Obj_Eventos = new Eventos();

$Obj_Eventos->NombreEmpleado = $_SESSION['NombreEmpleado'];
$Obj_Eventos->TipoEvento = $_POST['NombreCliente'];
$Obj_Eventos->Mensaje = 'ha actualizado la información de';
$Obj_Eventos->Icono = 'fas fa-user-edit bg-orange';
$Obj_Eventos->VentanaEmergente = 'N';
$Obj_Eventos->UrlEvento = 'cliente/?id=' . $_POST['IdCliente'];

$Obj_Clientes->Informacion = $_POST['txtInformacion'];

$Res_Clientes = $Obj_Clientes->ActualizarInformacion($_POST['IdCliente']);

if ($Res_Clientes) {

    $Obj_Eventos->Insertar();

    $_SESSION['success-update'] = 'cliente';
    echo "<script>history.go(-1)</script>";
}
