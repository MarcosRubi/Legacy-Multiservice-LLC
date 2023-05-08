<?php
require_once '../../func/validateSession.php';

require_once '../../bd/bd.php';
require_once '../../class/Empleados.php';
require_once '../../class/Ajustes.php';


$Obj_Empleados = new Empleados();
$Obj_Ajustes = new Ajustes();

if (isset($_POST['user'])) {
    $Res_DatosEmpleado = $Obj_Empleados->buscarPorId($_POST['IdEmpleado']);
    $DatosEmpleado = $Res_DatosEmpleado->fetch_assoc();

    $Obj_Empleados->NombreEmpleado = $_SESSION['NombreEmpleado'];
    $Obj_Empleados->Email =  $_SESSION['Email'];
    $Obj_Empleados->IdRole = $_SESSION['IdRole'];
    $Obj_Empleados->Agencia = $_SESSION['Agencia'];
    $Obj_Empleados->Agente =  $_SESSION['Agente'];

    // VALIDACIONES

    if (trim($_POST['txtPasswordOld']) !== '' && !password_verify($_POST['txtPasswordOld'], $DatosEmpleado['Contrasenna'])) {
        $_SESSION['error-update'] = 'contraNoCoincide';
        echo "<script>history.go(-1)</script>";
        return false;
    };


    if (trim($_POST['txtPasswordOld']) !== '' && trim($_POST['txtPasswordNew']) === '') {
        $_SESSION['error-update'] = 'nuevaContra';
        echo "<script>history.go(-1)</script>";
        return false;
    };
} else {
    $Obj_Empleados->NombreEmpleado = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower(trim($_POST['txtNombreEmpleado']))));
    $Obj_Empleados->Email =  $_POST['txtEmail'];
    $Obj_Empleados->IdRole = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower(trim($_POST['txtIdRole']))));
    $Obj_Empleados->Agencia = $Obj_Ajustes->RemoverEtiquetas(strtoupper(strtolower(trim($_POST['txtAgencia']))));
    $Obj_Empleados->Agente =  $Obj_Ajustes->RemoverEtiquetas(strtoupper(strtolower(trim($_POST['txtAgente']))));

    // VALIDANDO CAMPOS NO VACIOS
    if (trim($_POST['txtNombreEmpleado']) === '') {
        $_SESSION['error-registro'] = 'nombreEmpleado';
        echo "<script>history.go(-1)</script>";
        return false;
    };
    if (trim($_POST['txtEmail']) === '') {
        $_SESSION['error-registro'] = 'email';
        echo "<script>history.go(-1)</script>";
        return false;
    };
    if (trim($_POST['txtAgencia']) === '') {
        $_SESSION['error-registro'] = 'agencia';
        echo "<script>history.go(-1)</script>";
        return false;
    };
    if (trim($_POST['txtAgente']) === '') {
        $_SESSION['error-registro'] = 'agente';
        echo "<script>history.go(-1)</script>";
        return false;
    };
}

$Obj_Empleados->UrlFoto = "dist/img/avatar" . $_POST['rdbImg'] . ".png";
$Obj_Empleados->FormatoFecha =  $Obj_Ajustes->RemoverEtiquetas(strtolower(trim($_POST['rdbFormatoFecha'])));


if (trim($_POST['txtPasswordOld']) !== '' && password_verify($_POST['txtPasswordOld'], $DatosEmpleado['Contrasenna'])) {
    $Obj_Empleados->Contrasenna = $_POST['txtPasswordNew'];
    $Obj_Empleados->ActualizarContrasenna($_POST['IdEmpleado']);
};

$Res_Empleados = $Obj_Empleados->Actualizar($_POST['IdEmpleado']);

if ($Res_Empleados) {

    if (isset($_POST['user'])) {
        $_SESSION['success-update'] = 'empleadoActual';
        $_SESSION['UrlFoto'] = "dist/img/avatar" . $_POST['rdbImg'] . ".png";
        $_SESSION['FormatoFecha'] = $Obj_Ajustes->RemoverEtiquetas(strtolower(trim($_POST['rdbFormatoFecha'])));

        echo "<script>history.go(-1)</script>";
        return;
    }

    echo "<script>
            let URL = window.opener.location.pathname;
            window.opener.location.reload();
            window.close();
          </script>";
    $_SESSION['success-update'] = 'empleado';
}
