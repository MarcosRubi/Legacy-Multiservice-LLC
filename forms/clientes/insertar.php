<?php
session_start();
require_once '../../bd/bd.php';
require_once '../../class/Clientes.php';
require_once '../../class/Ajustes.php';

$Obj_Clientes = new Clientes();
$Obj_Ajustes = new Ajustes();

$Obj_Clientes->PrimerNombre = $Obj_Ajustes->RemoverEtiquetas(ucfirst(strtolower(trim($_POST['txtPrimerNombre']))));
$Obj_Clientes->SegundoNombre = $Obj_Ajustes->RemoverEtiquetas(ucfirst(strtolower(trim($_POST['txtSegundoNombre']))));
$Obj_Clientes->Apellido = $Obj_Ajustes->RemoverEtiquetas(ucfirst(strtolower(trim($_POST['txtApellido']))));
$Obj_Clientes->Telefono = $Obj_Ajustes->RemoverEtiquetas(trim(str_replace("_", "", $_POST['txtTelefono'])));
$Obj_Clientes->Cp = $Obj_Ajustes->RemoverEtiquetas(strtoupper(strtolower(trim($_POST['txtCp']))));
$Obj_Clientes->Ciudad = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower(trim($_POST['txtCiudad']))));
$Obj_Clientes->Provincia = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower(trim($_POST['txtProvincia']))));
$Obj_Clientes->FechaNacimiento =  $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaNacimiento']));

$regexFecha = '/^(\d{2})-(\d{2})-(\d{4})$/';

// //VALIDANDO FORMATO DE FECHA
if($_SESSION['FormatoFecha'] === 'dmy'){
    if ($_POST['txtFechaNacimiento'] !== "" && $_POST['txtFechaNacimiento'] !== "dd-mm-yyyy" && !preg_match($regexFecha, $_POST['txtFechaNacimiento'])) {
        $_SESSION['error-registro'] = 'fecha';
        echo "<script>history.go(-1)</script>";
        return;
    };
}
if($_SESSION['FormatoFecha'] === 'mdy'){
    if ($_POST['txtFechaNacimiento'] !== "" && $_POST['txtFechaNacimiento'] !== "mm-dd-yyyy" && !preg_match($regexFecha, $_POST['txtFechaNacimiento'])) {
        $_SESSION['error-registro'] = 'fecha';
        echo "<script>history.go(-1)</script>";
        return;
    };
}

// //VALIDANDO FORMATO DE TELEFONO
// if (strpos($_POST['txtTelefono'], "_")) {
//     // $_SESSION['error-registro'] = 'tel';
//     // echo "<script>history.go(-1)</script>";

//     return str_replace("_", "", $_POST['txtTelefono']);
// };

$Res_Clientes = $Obj_Clientes->Insertar();

var_dump($Res_Clientes);

// if ($Res_Clientes) {
//     $_SESSION['success-registro'] = 'cliente';
//     echo "<script>
//     let URL = window.opener.location.pathname;
//         window.opener.location.reload();
//     window.close();
// </script>";
// }
