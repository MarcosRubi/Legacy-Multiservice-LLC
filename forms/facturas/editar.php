<?php
require_once '../../func/validateSession.php';

if ($_SESSION['IdRole'] > 3) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

require_once '../../bd/bd.php';
require_once '../../class/Facturas.php';
require_once '../../class/Eventos.php';
require_once '../../class/Ajustes.php';
require_once '../../class/Abonos.php';


$Obj_Facturas = new Facturas();
$Obj_Ajustes = new Ajustes();
$Obj_Eventos = new Eventos();
$Obj_Abonos = new Abonos();

$Res_ValoresFactura = $Obj_Facturas->buscarFacturaPorId($_POST['txtIdFactura']);
$DatosFactura = $Res_ValoresFactura->fetch_assoc();


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
if (trim($_POST['txtCreditoValor']) !== '' && trim($_POST['txtCreditoNumero']) === '') {
    if (trim($_POST['txtCreditoNumero'] === '')) {
        $_SESSION['error-registro'] = 'numeroTarjetaVacio';
        echo "<script>history.go(-1)</script>";
        return;
    };
    return;
}


if ($Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Efectivo']) !== $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtEfectivo'])) {
    // ENCUENTRA LA DIFERENCIA VALORNUEVO - VALORVIEJO Y ESTO VE A LA FACTURA A SUMARLO
    $diferencia =  $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtEfectivo']) - $Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Efectivo']);

    $Obj_Facturas->Efectivo = $Obj_Ajustes->ConvertirFormatoDolar($Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Efectivo']) + $Obj_Ajustes->ConvertirFormatoDolar($diferencia));
}
if ($Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['CreditoValor']) !== $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtCreditoValor'])) {
    // ENCUENTRA LA DIFERENCIA VALORNUEVO - VALORVIEJO Y ESTO VE A LA FACTURA A SUMARLO
    $diferencia =  $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtCreditoValor']) - $Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['CreditoValor']);

    $Obj_Facturas->CreditoValor = $Obj_Ajustes->ConvertirFormatoDolar($Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['CreditoValor']) + $Obj_Ajustes->ConvertirFormatoDolar($diferencia));

    if (doubleval($_POST['txtCreditoValor']) === 0 || trim($_POST['txtCreditoValor']) === '') {
        $Obj_Facturas->CreditoNumero = "";
        $Obj_Facturas->CreditoValor = "";
    }
}
if ($Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Cheque']) !== $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtCheque'])) {
    // ENCUENTRA LA DIFERENCIA VALORNUEVO - VALORVIEJO Y ESTO VE A LA FACTURA A SUMARLO
    $diferencia =  $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtCheque']) - $Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Cheque']);

    $Obj_Facturas->Cheque = $Obj_Ajustes->ConvertirFormatoDolar($Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Cheque']) + $Obj_Ajustes->ConvertirFormatoDolar($diferencia));
}
if ($Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Banco']) !== $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtBanco'])) {
    // ENCUENTRA LA DIFERENCIA VALORNUEVO - VALORVIEJO Y ESTO VE A LA FACTURA A SUMARLO
    $diferencia =  $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtBanco']) - $Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Banco']);

    $Obj_Facturas->Banco = $Obj_Ajustes->ConvertirFormatoDolar($Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Banco']) + $Obj_Ajustes->ConvertirFormatoDolar($diferencia));
}
if ($Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Cupon']) !== $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtCupon'])) {
    // ENCUENTRA LA DIFERENCIA VALORNUEVO - VALORVIEJO Y ESTO VE A LA FACTURA A SUMARLO
    $diferencia =  $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtCupon']) - $Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Cupon']);

    $Obj_Facturas->Cupon = $Obj_Ajustes->ConvertirFormatoDolar($Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Cupon']) + $Obj_Ajustes->ConvertirFormatoDolar($diferencia));
}

$Res_Facturas = $Obj_Facturas->Actualizar($_POST['txtIdFactura']);


$Res_Abonos = $Obj_Abonos->obtenerUltimoAbono($_POST['txtIdFactura']);
$DatosAbono = $Res_Abonos->fetch_assoc();

if ($Res_Abonos->num_rows > 0) {
    $Obj_Abonos->BalanceActual = ((doubleval($_POST['txtEfectivo']) + doubleval($_POST['txtCreditoValor']) + doubleval($_POST['txtCheque']) + doubleval($_POST['txtCupon']) + doubleval($_POST['txtBanco'])) - doubleval($_POST['txtValor']));
    $Obj_Abonos->Actualizar($DatosAbono['IdAbono']);
}


if ($Res_Facturas) {

    $Obj_Eventos->NombreEmpleado = $_SESSION['NombreEmpleado'];
    $Obj_Eventos->TipoEvento = 'factura #'  . $_POST['txtIdFactura'];
    $Obj_Eventos->Mensaje = 'ha actualizado la ';
    $Obj_Eventos->Icono = 'fas fa-file-signature bg-orange';
    $Obj_Eventos->UrlEvento = 'facturas/detalles.php?id=' . $_POST['txtIdFactura'] . '&edit=false';
    $Obj_Eventos->Insertar();


    $_SESSION['success-update'] = 'factura';
    echo "<script>
        let URL = window.opener.location.pathname;
            window.opener.location.reload();
        window.close();
    </script>";
}
