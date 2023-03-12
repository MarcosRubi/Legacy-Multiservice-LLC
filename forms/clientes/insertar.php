<?php
session_start();
require_once '../../bd/bd.php';
require_once '../../class/Clientes.php';
require_once '../../class/Ajustes.php';

$Obj_Clientes = new Clientes();
$Obj_Ajustes = new Ajustes();

$Obj_Clientes->PrimerNombre = $Obj_Ajustes->RemoverEtiquetas(ucfirst(strtolower($_POST['txtPrimerNombre'])));
$Obj_Clientes->SegundoNombre = $Obj_Ajustes->RemoverEtiquetas(ucfirst(strtolower($_POST['txtSegundoNombre'])));
$Obj_Clientes->Apellido = $Obj_Ajustes->RemoverEtiquetas(ucfirst(strtolower($_POST['txtApellido'])));
$Obj_Clientes->Telefono = $Obj_Ajustes->RemoverEtiquetas($_POST['txtTelefono']);
$Obj_Clientes->Direccion = $Obj_Ajustes->RemoverEtiquetas(ucfirst(strtolower($_POST['txtDireccion'])));
$Obj_Clientes->FechaNacimiento =  $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertir($_POST['txtFechaNacimiento']));

$regexFecha = '/^(\d{2})-(\d{2})-(\d{4})$/';

//VALIDANDO FORMATO DE FECHA
if($_POST['txtFechaNacimiento'] !== "" && $_POST['txtFechaNacimiento'] !== "dd-mm-yyyy" && !preg_match($regexFecha, $_POST['txtFechaNacimiento'])){
    $_SESSION['error-registro'] = 'fecha';
    echo "<script>history.go(-1)</script>";
    return;
};

//VALIDANDO FORMATO DE TELEFONO
if(strpos($_POST['txtTelefono'], "_")){
    $_SESSION['error-registro'] = 'tel';
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
