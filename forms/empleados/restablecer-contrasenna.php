<?php
require_once '../../func/validateSession.php';

require_once '../../bd/bd.php';
require_once '../../class/Empleados.php';
require_once '../../class/Ajustes.php';


$Obj_Empleados = new Empleados();
$Obj_Ajustes = new Ajustes();

$Res_Empleados = $Obj_Empleados->buscarPorId($_SESSION['IdEmpleado']);
$DatosEmpleado = $Res_Empleados->fetch_assoc();

if (trim($_POST['passwordAdmin']) === '') {
    $_SESSION['error-update'] = 'passwordAdminVacio';
    echo "<script>history.go(-1)</script>";
    return false;
};
if (trim($_POST['passwordEmpleado']) === '') {
    $_SESSION['error-update'] = 'nuevaContra';
    echo "<script>history.go(-1)</script>";
    return false;
};
if (trim($_POST['IdEmpleado']) === '') {
    $_SESSION['error-update'] = 'IdEmpleadoVacio';
    echo "<script>history.go(-1)</script>";
    return false;
};
if (!password_verify($_POST['passwordAdmin'], $DatosEmpleado['Contrasenna'])) {
    $_SESSION['error-update'] = 'contraAdminNoCoincide';
    echo "<script>history.go(-1)</script>";
    return false;
};




if (trim($_POST['passwordAdmin']) !== '' && password_verify($_POST['passwordAdmin'], $DatosEmpleado['Contrasenna'])) {
    $Obj_Empleados->Contrasenna = $_POST['passwordEmpleado'];
    $Res_Empleados = $Obj_Empleados->ActualizarContrasenna($_POST['IdEmpleado']);

    if ($Res_Empleados) {
        echo "<script>
                let URL = window.opener.location.pathname;
                window.opener.location.reload();
                window.close();
              </script>";
        $_SESSION['success-update'] = 'empleado';
    };
}
