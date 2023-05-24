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
$Obj_Clientes->Direccion = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower(trim($_POST['txtDireccion']))));
$Obj_Clientes->FechaNacimiento =  $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaNacimiento']));
$Obj_Clientes->Informacion =  '<p><br>
</p><div style="text-align: center;"><h4 class="p-2" style="font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;"><span style="font-size: 1.5rem; font-weight: bolder;">NÚMEROS DE TELÉFONOS</span><br></h4></div><table class="table table-bordered"><tbody><tr class="bg-lightblue"><td><b>NOMBRE DEL PROPIETARIO</b></td><td><b>PARENTESCO CON EL CLIENTE</b></td><td><b>NÚMERO DE TELÉFONO</b></td></tr><tr><td><br></td><td><br></td><td><br></td></tr></tbody></table><div style="text-align: center;"><br></div><div style="text-align: center;"><br></div>

<div style="text-align: center;"><h4 class="p-2" style="font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;"><span style="font-weight: bolder;">CORREOS ELECTRÓNICOS</span></h4></div><table class="table table-bordered"><tbody><tr class="bg-lightblue"><td><b>NOMBRE DEL PROPIETARIO</b></td><td><b>PARENTESCO CON EL CLIENTE</b></td><td><b>DIRECCIÓN DE EMAIL</b></td></tr><tr><td><br></td><td><br></td><td><br></td></tr></tbody></table><div style="text-align: center;"><br></div><div style="text-align: center;"><br></div>

<div style="text-align: center;"><h4 class="p-2" style="font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;"><span style="font-weight: bolder;">PERSONAS QUE VIAJAN FRECUENTEMENTE CON EL CLIENTE</span></h4></div>

<p></p><ul><li><b>Nombre del pasajero:</b></li><li><b>Fecha de vencimiento:</b></li><li><b># Pasaporte:</b></li><li><b># Visa:</b></li><li><b>Residencia:</b></li><li><b>Dirección:</b></li><li><b>Parentesco con el cliente:</b></li></ul><p><br></p>';

$regexFecha = '/^(\d{2})-(\d{2})-(\d{4})$/';

// //VALIDANDO FORMATO DE FECHA
if ($_SESSION['FormatoFecha'] === 'dmy') {
    if ($_POST['txtFechaNacimiento'] !== "" && $_POST['txtFechaNacimiento'] !== "dd-mm-yyyy" && !preg_match($regexFecha, $_POST['txtFechaNacimiento'])) {
        $_SESSION['error-registro'] = 'fecha';
        echo "<script>history.go(-1)</script>";
        return;
    };
}
if ($_SESSION['FormatoFecha'] === 'mdy') {
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
