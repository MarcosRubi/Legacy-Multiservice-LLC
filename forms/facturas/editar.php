<?php
require_once '../../func/validateSession.php';
require_once '../../bd/bd.php';
require_once '../../class/Facturas.php';
require_once '../../class/Eventos.php';
require_once '../../class/Ajustes.php';
require_once '../../class/Abonos.php';

$Obj_Facturas = new Facturas();
$Obj_Ajustes = new Ajustes();
$Obj_Eventos = new Eventos();
$Obj_Abonos = new Abonos();

$Obj_Facturas->IdTipoFactura = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdTipo']);
$Obj_Facturas->Valor = $Obj_Ajustes->RemoverEtiquetas($_POST['txtValor']);
$Obj_Facturas->Descripcion = $_POST['txtDescripcion'];
$Obj_Facturas->Efectivo = $Obj_Ajustes->RemoverEtiquetas($_POST['txtEfectivo']);
$Obj_Facturas->CreditoValor = $Obj_Ajustes->RemoverEtiquetas($_POST['txtCreditoValor']);
$Obj_Facturas->CreditoNumero = $Obj_Ajustes->RemoverEtiquetas($_POST['txtCreditoNumero']);
$Obj_Facturas->Cheque = $Obj_Ajustes->RemoverEtiquetas($_POST['txtCheque']);
$Obj_Facturas->Banco = $Obj_Ajustes->RemoverEtiquetas($_POST['txtBanco']);
$Obj_Facturas->Cupon = $Obj_Ajustes->RemoverEtiquetas($_POST['txtCupon']);
$Obj_Facturas->Comentario = $_POST['txtComentario'];



//EL VALOR NO VENGA VACIO
if (trim($_POST['txtValor']) === '') {
    $_SESSION['error-registro'] = 'valor';
    echo "<script>history.go(-1)</script>";
    return;
}
$Res_Facturas = $Obj_Facturas->Actualizar($_POST['txtIdFactura']);


$Res_Abonos = $Obj_Abonos->obtenerUltimoAbono($_POST['txtIdFactura']);
$DatosAbono = $Res_Abonos->fetch_assoc();

var_dump($DatosAbono);

if($Res_Abonos){
    $Obj_Abonos->BalanceActual = ((doubleval($_POST['txtEfectivo']) + doubleval($_POST['txtCreditoValor']) + doubleval($_POST['txtCheque']) + doubleval($_POST['txtCupon']) + doubleval($_POST['txtBanco'])) - doubleval($_POST['txtValor']));
    $Obj_Abonos->Actualizar($DatosAbono['IdAbono']);
}


if ($Res_Facturas) {

    $Obj_Eventos->NombreEmpleado = $_SESSION['NombreEmpleado'];
    $Obj_Eventos->TipoEvento = 'factura';
    $Obj_Eventos->Mensaje = 'ha actualizado una ';
    $Obj_Eventos->Icono = 'fas fa-user-edit bg-orange';
    $Obj_Eventos->UrlEvento = 'facturas/detalles.php?id=' . $_POST['txtIdFactura'];
    $Obj_Eventos->Insertar();


    $_SESSION['success-update'] = 'factura';
    echo "<script>
    let URL = window.opener.location.pathname;
        window.opener.location.reload();
    window.close();
</script>";
}
