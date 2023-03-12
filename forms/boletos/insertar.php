<?php

session_start();
require_once '../../bd/bd.php';
require_once '../../class/Boletos.php';
require_once '../../class/Ajustes.php';

$Obj_Boletos = new Boletos();
$Obj_Ajustes = new Ajustes();

$Obj_Boletos->IdCliente = $Obj_Ajustes->RemoverEtiquetas($_POST['IdCliente']);
$Obj_Boletos->NumeroBoletos = $Obj_Ajustes->RemoverEtiquetas($_POST['txtBoleto1']);
$Obj_Boletos->NombrePasajero = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower($_POST['txtNombrePasajero1'])));
$Obj_Boletos->Aerolinea = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower($_POST['txtAerolinea1'])));
$Obj_Boletos->Origen = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtOrigen1']));
$Obj_Boletos->Destino = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtDestino1']));
$Obj_Boletos->FechaIda = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertir($_POST['txtFechaIda1']));
$Obj_Boletos->FechaRegreso = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertir($_POST['txtFechaRegreso1']));
$Obj_Boletos->Dob = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertir($_POST['txtFechaDob1']));
$Obj_Boletos->IdIata = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdIata1']);
$Obj_Boletos->IdTipo = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdTipo1']);
$Obj_Boletos->IdFormaPago = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdPago1']);
$Obj_Boletos->Precio = $Obj_Ajustes->RemoverEtiquetas($_POST['txtPrecio1']);
$Obj_Boletos->Base = $Obj_Ajustes->RemoverEtiquetas($_POST['txtBase1']);
$Obj_Boletos->Tax = $Obj_Ajustes->RemoverEtiquetas($_POST['txtTax1']);
$Obj_Boletos->Fm = $Obj_Ajustes->RemoverEtiquetas($_POST['txtFm1']);
$Obj_Boletos->Fee = $Obj_Ajustes->RemoverEtiquetas($_POST['txtFee1']);
$Obj_Boletos->Itinerario = trim($_POST['txtItinerario']);
$Obj_Boletos->Agencia = $_SESSION['Agencia'];
$Obj_Boletos->Agente = $_SESSION['Agente'];


$regexFecha = '/^(\d{2})-(\d{2})-(\d{4})$/';


//VALIDANDO FORMATO DE FECHA
if (trim($_POST['txtBoleto1']) === '') {
    $_SESSION['error-registro'] = 'boletos';
    echo "<script>history.go(-1)</script>";
    return;
};
//VALIDANDO FORMATO DE FECHA
if (trim($_POST['txtFechaDob1']) === '') {
    $_SESSION['error-registro'] = 'dobVacio';
    echo "<script>history.go(-1)</script>";
    return;
};
if ($_POST['txtFechaDob1'] !== "" && $_POST['txtFechaDob1'] !== "dd-mm-yyyy" && !preg_match($regexFecha, $_POST['txtFechaDob1'])) {
    $_SESSION['error-registro'] = 'dobFormato';
    echo "<script>history.go(-1)</script>";
    return;
};
//VALIDANDO FORMATO DE FECHA
if (trim($_POST['txtNombrePasajero1']) === '') {
    $_SESSION['error-registro'] = 'nombre';
    echo "<script>history.go(-1)</script>";
    return;
};
if (trim($_POST['txtAerolinea1']) === '') {
    $_SESSION['error-registro'] = 'aerolinea';
    echo "<script>history.go(-1)</script>";
    return;
};
if (trim($_POST['txtOrigen1']) === '') {
    $_SESSION['error-registro'] = 'origen';
    echo "<script>history.go(-1)</script>";
    return;
};
if (trim($_POST['txtDestino1']) === '') {
    $_SESSION['error-registro'] = 'destino';
    echo "<script>history.go(-1)</script>";
    return;
};
if (trim($_POST['txtFechaIda1']) === '') {
    $_SESSION['error-registro'] = 'idaVacio';
    echo "<script>history.go(-1)</script>";
    return;
};
if ($_POST['txtFechaIda1'] !== "" && $_POST['txtFechaIda1'] !== "dd-mm-yyyy" && !preg_match($regexFecha, $_POST['txtFechaIda1'])) {
    $_SESSION['error-registro'] = 'idaFormato';
    echo "<script>history.go(-1)</script>";
    return;
};
if ($_POST['txtFechaRegreso1'] === '') {
    $_SESSION['error-registro'] = 'regresoVacio';
    echo "<script>history.go(-1)</script>";
    return;
};
if ($_POST['txtFechaRegreso1'] !== "" && $_POST['txtFechaRegreso1'] !== "dd-mm-yyyy" && !preg_match($regexFecha, $_POST['txtFechaRegreso1'])) {
    $_SESSION['error-registro'] = 'regresoFormato';
    echo "<script>history.go(-1)</script>";
    return;
};
if (trim($_POST['txtPrecio1']) === '') {
    $_SESSION['error-registro'] = 'precio';
    echo "<script>history.go(-1)</script>";
    return;
};
if (trim($_POST['txtBase1']) === '') {
    $_SESSION['error-registro'] = 'base';
    echo "<script>history.go(-1)</script>";
    return;
};
if (trim($_POST['txtTax1']) === '') {
    $_SESSION['error-registro'] = 'tax';
    echo "<script>history.go(-1)</script>";
    return;
};
if ($_POST['txtFm1'] === '') {
    $_SESSION['error-registro'] = 'fm';
    echo "<script>history.go(-1)</script>";
    return;
};



$Res_Boletos = $Obj_Boletos->Insertar();

if ($Res_Boletos) {
    $_SESSION['registro'] = 's-boleto';
    echo "<script>
    let URL = window.opener.location.pathname;
    if (URL.indexOf('buscar-cliente') !== -1) {
        window.opener.location.reload();
    }
    window.close();
</script>";
}
