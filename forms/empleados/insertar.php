<?php
require_once '../../func/validateSession.php';
require_once '../../bd/bd.php';
require_once '../../class/Empleados.php';
require_once '../../class/Ajustes.php';


$Obj_Empleados = new Empleados();
$Obj_Ajustes = new Ajustes();


$Obj_Empleados->NombreEmpleado = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower(trim($_POST['txtNombreEmpleado']))));
$Obj_Empleados->Contrasenna = $_POST['txtContrasenna'];
$Obj_Empleados->Email =  $_POST['txtEmail'];
$Obj_Empleados->UrlFoto = "dist/img/avatar" . $_POST['rdbImg'] . ".png";
$Obj_Empleados->IdRole = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower(trim($_POST['txtIdRole']))));
$Obj_Empleados->Agencia = $Obj_Ajustes->RemoverEtiquetas(strtoupper(strtolower(trim($_POST['txtAgencia']))));
$Obj_Empleados->Agente =  $Obj_Ajustes->RemoverEtiquetas(strtoupper(strtolower(trim($_POST['txtAgente']))));
$Obj_Empleados->FormatoFecha =  $Obj_Ajustes->RemoverEtiquetas(strtolower(trim($_POST['rdbFormatoFecha'])));

//VALIDANDO CAMPOS NO VACIOS
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

$Res_Empleados = $Obj_Empleados->Insertar();

if ($Res_Empleados) {

    $_SESSION['success-registro'] = 'empleado';
    echo "<script>
    let URL = window.opener.location.pathname;
        window.opener.location.reload();
    window.close();
</script>";
}
