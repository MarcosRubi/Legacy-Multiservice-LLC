<?php
session_start();
require_once '../../bd/bd.php';
require_once '../../class/Clientes.php';

$Obj_Clientes = new Clientes();

$Obj_Clientes->PrimerNombre = ucfirst(strtolower($_POST['txtPrimerNombre']));
$Obj_Clientes->SegundoNombre = ucfirst(strtolower($_POST['txtSegundoNombre']));
$Obj_Clientes->Apellido = ucfirst(strtolower($_POST['txtApellido']));
$Obj_Clientes->Telefono = $_POST['txtTelefono'];
$Obj_Clientes->Direccion = ucfirst(strtolower($_POST['txtDireccion']));
$Obj_Clientes->FechaNacimiento = $_POST['txtFechaNacimiento'];

$regexFecha = '/^(19|20)(((([02468][048])|([13579][26]))-02-29)|(\d{2})-((02-((0[1-9])|1\d|2[0-8]))|((((0[13456789])|1[012]))-((0[1-9])|((1|2)\d)|30))|(((0[13578])|(1[02]))-31)))$/';

if(!preg_match($regexFecha, $_POST['txtFechaNacimiento'])){
    $_SESSION['error-registro'] = 'true';
    echo "<script>history.go(-1)</script>";
    return;
};

$Res_Clientes = $Obj_Clientes->Insertar();

if ($Res_Clientes) {
    echo "<script>
    let URL = window.opener.location.pathname;
    if (URL.indexOf('buscar-cliente') !== -1) {
        window.opener.location.reload();
    }
    window.close();
</script>";
}
