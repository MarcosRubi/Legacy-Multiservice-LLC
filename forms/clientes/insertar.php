<?php
require_once '../../func/validateSession.php';
require_once '../../bd/bd.php';
require_once '../../class/Clientes.php';
require_once '../../class/Ajustes.php';
require_once '../../class/Eventos.php';

$Obj_Clientes = new Clientes();
$Obj_Ajustes = new Ajustes();
$Obj_Eventos = new Eventos();

$Obj_Eventos->NombreEmpleado = $_SESSION['NombreEmpleado'];
$Obj_Eventos->TipoEvento = 'cliente';
$Obj_Eventos->Mensaje = 'ha agregado un nuevo';
$Obj_Eventos->Icono = 'fas fa-user-plus bg-info';
$Obj_Eventos->VentanaEmergente = 'N';

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

if ($Res_Clientes) {
    $Res_Cliente = $Obj_Clientes->obtenerClienteCreado();
    $DatosCliente = $Res_Cliente->fetch_assoc();

    $Obj_Eventos->UrlEvento = 'cliente/?id=' . $DatosCliente['IdCliente'];
    $Obj_Eventos->Insertar();

    $_SESSION['success-registro'] = 'cliente';
    echo "<script>
    let URL = window.opener.location.pathname;
        window.opener.location.reload();
    window.close();
</script>";
}
