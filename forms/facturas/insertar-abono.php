<?php
require_once '../../func/validateSession.php';
require_once '../../bd/bd.php';
require_once '../../class/Abonos.php';
require_once '../../class/Facturas.php';
require_once '../../class/Ajustes.php';

$Obj_Abonos = new Abonos();
$Obj_Ajustes = new Ajustes();
$Obj_Facturas = new Facturas();

$Obj_Abonos->IdCliente = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdCliente']);
$Obj_Abonos->IdTipoFactura = '3';
$Obj_Abonos->IdFactura = $_POST['txtIdFactura'];
$Obj_Abonos->CantidadAbono = $Obj_Ajustes->RemoverEtiquetas($_POST['txtValor']);
$Obj_Abonos->Efectivo = $Obj_Ajustes->RemoverEtiquetas($_POST['txtEfectivo']);
$Obj_Abonos->CreditoValor = $Obj_Ajustes->RemoverEtiquetas($_POST['txtCreditoValor']);
$Obj_Abonos->CreditoNumero = $Obj_Ajustes->RemoverEtiquetas($_POST['txtCreditoNumero']);
$Obj_Abonos->Cheque = $Obj_Ajustes->RemoverEtiquetas($_POST['txtCheque']);
$Obj_Abonos->Banco = $Obj_Ajustes->RemoverEtiquetas($_POST['txtBanco']);
$Obj_Abonos->Cupon = $Obj_Ajustes->RemoverEtiquetas($_POST['txtCupon']);
$Obj_Abonos->Comentario = trim($_POST['txtComentario']);



//EL VALOR NO VENGA VACIO
if (trim($_POST['txtValor']) === '') {
    $_SESSION['error-registro'] = 'cantidad-abono';
    echo "<script>history.go(-1)</script>";
    return;
}

//HAYA SELECCIONADO UNA FORMA DE PAGO
if (trim($_POST['txtEfectivo']) === '' && trim($_POST['txtCreditoValor']) === '' && trim($_POST['txtCheque']) === '' && trim($_POST['txtBanco']) === '' && trim($_POST['txtCupon']) === '') {
    $_SESSION['error-registro'] = 'pago';
    echo "<script>history.go(-1)</script>";
    return;
}
//SI LA FORMA DE PAGO SELECCIONADA ES CREDITO AGREGAR LOS 4 NUMEROS DE TARJETA
if (trim($_POST['txtCreditoValor']) !== '' && trim($_POST['txtCreditoNumero']) === '') {
    //VALIDANDO FORMATO DE TELEFONO
    if (trim($_POST['txtCreditoNumero'] === '')) {
        $_SESSION['error-registro'] = 'numeroTarjetaVacio';
        echo "<script>history.go(-1)</script>";
        return;
    };
    return;
}
//SI LA FORMA DE PAGO SELECCIONADA ES CREDITO AGREGAR LOS 4 NUMEROS DE TARJETA
if (trim($_POST['txtCreditoValor']) !== '' && trim($_POST['txtCreditoNumero']) !== '' && strpos($_POST['txtCreditoNumero'], "_")) {
    //VALIDANDO NUMEROS DE TARJETA DE CREDITO
    $_SESSION['error-registro'] = 'numeroTarjetaNoCompleto';
    echo "<script>history.go(-1)</script>";
    return;
}

//NO AGREGAR LOS 4 DIGITOS DE LA TARJETA SI NO HAY CANTIDAD INGRESADA CON ESTA FORMA DE PAGO
if (trim($_POST['txtCreditoValor']) === '' && strpos($_POST['txtCreditoNumero'], "_")) {
    //VALIDANDO NUMEROS DE TARJETA DE CREDITO
    $Obj_Abonos->CreditoNumero = "";
}

// ACTUALIZAMOS EL BALANCE DE LA FACTURA
$Res_Balance = $Obj_Facturas->obtenerBalanceFactura($_POST['txtIdFactura']);
$ValorBalance = $Res_Balance->fetch_assoc()['Balance'];
$Obj_Abonos->BalanceActual = doubleval($ValorBalance) + doubleval($_POST['txtValor']);

$Res_Abonos = $Obj_Abonos->Insertar();

$Res_Factura = $Obj_Facturas->obtenerValoresPagos($_POST['txtIdFactura']);

while ($DatosPagos = $Res_Factura->fetch_assoc()) {
    $Obj_Facturas->Efectivo = $Obj_Ajustes->ConvertirFormatoDolar($DatosPagos['Efectivo']) + $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtEfectivo']);
    $Obj_Facturas->CreditoValor = $Obj_Ajustes->ConvertirFormatoDolar($DatosPagos['CreditoValor']) + $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtCreditoValor']);
    $Obj_Facturas->CreditoNumero = $Obj_Ajustes->RemoverEtiquetas($_POST['txtCreditoNumero']);
    $Obj_Facturas->Cheque = $Obj_Ajustes->ConvertirFormatoDolar($DatosPagos['Cheque']) + $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtCheque']);
    $Obj_Facturas->Banco = $Obj_Ajustes->ConvertirFormatoDolar($DatosPagos['Banco']) + $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtBanco']);
    $Obj_Facturas->Cupon = $Obj_Ajustes->ConvertirFormatoDolar($DatosPagos['Cupon']) + $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtCupon']);
}
$Obj_Facturas->ActualizarValoresPago($_POST['txtIdFactura']);


if ($Res_Abonos) {
    $_SESSION['success-registro'] = 'abono';
    $Obj_Facturas->ActualizarBalanceFactura($_POST['txtIdFactura'], doubleval($ValorBalance) + doubleval($_POST['txtValor']));


    echo "<script>
        window.opener.location.reload();
    window.close();
</script>";
}
