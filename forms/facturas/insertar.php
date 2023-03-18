<?php
session_start();
require_once '../../bd/bd.php';
require_once '../../class/Facturas.php';
require_once '../../class/Ajustes.php';

$Obj_Facturas = new Facturas();
$Obj_Ajustes = new Ajustes();

$Obj_Facturas->IdCliente = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdCliente']);
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
$Obj_Facturas->Agencia = $_SESSION['Agencia'];
$Obj_Facturas->Agente = $_SESSION['Agente'];
$Obj_Facturas->Pnr = $_POST['txtPnr'];

if ($_POST['txtEfectivo'] !== '') {
    $Obj_Facturas->FormaPagoInicial = 'Efectivo';
}
if ($_POST['txtCreditoValor'] !== '') {
    $Obj_Facturas->FormaPagoInicial = 'Crédito';
}
if ($_POST['txtCheque'] !== '') {
    $Obj_Facturas->FormaPagoInicial = 'Cheque';
}
if ($_POST['txtBanco'] !== '') {
    $Obj_Facturas->FormaPagoInicial = 'Banco';
}
if ($_POST['txtCupon'] !== '') {
    $Obj_Facturas->FormaPagoInicial = 'Cupon';
}

//EL VALOR NO VENGA VACIO
if (trim($_POST['txtValor']) === '') {
    $_SESSION['error-registro'] = 'valor';
    echo "<script>history.go(-1)</script>";
    return;
}

//HAYA SELECCIONADO UNA FORMA DE PAGO
// if (trim($_POST['txtEfectivo']) === '' && trim($_POST['txtCreditoValor']) === '' && trim($_POST['txtCheque']) === '' && trim($_POST['txtBanco']) === '') {
//     $_SESSION['error-registro'] = 'pago';
//     echo "<script>history.go(-1)</script>";
//     return;
// }
//SI LA FORMA DE PAGO SELECCIONADA ES CREDITO AGREGAR LOS 4 NUMEROS DE TARJETA
if (trim($_POST['txtCreditoValor']) !== '' && trim($_POST['txtCreditoNumero']) === '') {
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
if (trim($_POST['txtCreditoValor']) === '' && trim($_POST['txtCreditoNumero']) !== '' && strpos($_POST['txtCreditoNumero'], "_")) {
    //VALIDANDO NUMEROS DE TARJETA DE CREDITO
    $Obj_Facturas->CreditoNumero = "";
}

$Res_Facturas = $Obj_Facturas->Insertar();


if ($Res_Facturas) {
    $_SESSION['success-registro'] = 'factura';
    echo "<script>
    let URL = window.opener.location.pathname;
    if (URL.indexOf('buscar-cliente') !== -1) {
        window.opener.location.reload();
    }
    window.close();
</script>";
}
