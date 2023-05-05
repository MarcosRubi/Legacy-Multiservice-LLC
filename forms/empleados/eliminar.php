
<?php
require_once '../../func/validateSession.php';

if ($_SESSION['IdRole'] > 3) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

if ($_SESSION['IdEmpleado'] === $_GET['id']) {
    $_SESSION['error-delete'] = 'empleadoActual';
    echo "<script>history.go(-1)</script>";
    return false;
}

require_once '../../bd/bd.php';
require_once '../../class/Empleados.php';


$Obj_Empleados = new Empleados();


$Res_Empleados = $Obj_Empleados->Eliminar($_GET['id']);

if ($Res_Empleados) {
    $_SESSION['success-delete'] = 'empleado';
    header("Location:" . $_SESSION['path'] . "empleados/");
}
?>
