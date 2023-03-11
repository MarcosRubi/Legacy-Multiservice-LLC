<?php
session_start();

require_once '../bd/bd.php';
require_once '../class/Empleados.php';

$Obj_Empleados = new Empleados();

$Obj_Empleados->Email = $_POST['email'];
$Obj_Empleados->Contrasenna = $_POST['password'];

$Res_Empleado = $Obj_Empleados->buscarEmpleado();
$Datos_Empleado = $Res_Empleado->fetch_assoc();

$_SESSION['path'] = "http://127.0.0.1/Proyectos/Legacy-Multiservice-LLC/";

if ($Res_Empleado->num_rows > 0 && password_verify($_POST['password'], $Datos_Empleado['Contrasenna'])) {
    $_SESSION['IdEmpleado'] = $Datos_Empleado['IdEmpleado'];
    $_SESSION['NombreEmpleado'] = $Datos_Empleado['NombreEmpleado'];
    $_SESSION['UrlFoto'] = $Datos_Empleado['UrlFoto'];
    $_SESSION['NombreRol'] = $Datos_Empleado['NombreRol'];
    $_SESSION['Agencia'] = $Datos_Empleado['Agencia'];
    $_SESSION['Agente'] = $Datos_Empleado['Agente'];
    header("Location:" . $_SESSION['path']);
    return;
}
$_SESSION['error-login'] = 'true';
$_SESSION['email'] = $_POST['email'];
header("Location:" . $_SESSION['path'] . "/iniciar-sesion ");

