<?php
session_start();

require_once '../bd/bd.php';
require_once '../class/Empleados.php';
require_once '../class/Recordatorios.php';

$Obj_Empleados = new Empleados();
$Obj_Recordatorios = new Recordatorios();

$Obj_Empleados->Email = $_POST['email'];
$Obj_Empleados->Contrasenna = $_POST['password'];

$Res_Empleado = $Obj_Empleados->buscarEmpleado();
$Datos_Empleado = $Res_Empleado->fetch_assoc();

$Res_RecordatoriosPendientes = $Obj_Recordatorios->recordatoriosRestantes($Datos_Empleado['IdEmpleado']);

$_SESSION['Recordatorios'] =  intval($Res_RecordatoriosPendientes->fetch_assoc()['total_recordatorios']);

$_SESSION['path'] = "http://127.0.0.1/Proyectos/Legacy-Multiservice-LLC/";

if ($Res_Empleado->num_rows > 0 && password_verify($_POST['password'], $Datos_Empleado['Contrasenna'])) {
    $_SESSION['IdEmpleado'] = $Datos_Empleado['IdEmpleado'];
    $_SESSION['NombreEmpleado'] = $Datos_Empleado['NombreEmpleado'];
    $_SESSION['UrlFoto'] = $Datos_Empleado['UrlFoto'];
    $_SESSION['IdRole'] = intval($Datos_Empleado['IdRole']);
    $_SESSION['Agencia'] = $Datos_Empleado['Agencia'];
    $_SESSION['Agente'] = $Datos_Empleado['Agente'];
    $_SESSION['FormatoFecha'] = $Datos_Empleado['FormatoFecha'];
    $_SESSION['Email'] = strtolower($_POST['email']);
    header("Location:" . $_SESSION['path']);
    return;
}
$_SESSION['error-login'] = 'true';
$_SESSION['Email'] = $_POST['email'];
header("Location:" . $_SESSION['path'] . "/iniciar-sesion ");
