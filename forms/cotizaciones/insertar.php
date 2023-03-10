<?php

session_start();
require_once '../../bd/bd.php';
require_once '../../class/Cotizaciones.php';

$Obj_Cotizaciones = new Cotizaciones();

$Obj_Cotizaciones->IdCliente = $_POST['IdCliente'];
$Obj_Cotizaciones->Pnr = strtoupper($_POST['txtPnr']);
$Obj_Cotizaciones->Comentario = ucfirst(strtolower($_POST['txtComentario']));
$Obj_Cotizaciones->Accion = ucfirst(strtolower($_POST['txtAccion']));
$Obj_Cotizaciones->Fecha = $_POST['txtFecha'];
$Obj_Cotizaciones->Agencia = strtoupper($_POST['txtAgencia']);
$Obj_Cotizaciones->Agente = strtoupper($_POST['txtAgente']);
$Obj_Cotizaciones->Origen = strtoupper($_POST['txtOrigen']);
$Obj_Cotizaciones->Destino = strtoupper($_POST['txtDestino']);
$Obj_Cotizaciones->Ida = $_POST['txtIda'];
$Obj_Cotizaciones->Regreso = $_POST['txtRegreso'];
$Obj_Cotizaciones->NumeroBoletos = $_POST['txtNumeroBoletos'];
$Obj_Cotizaciones->Cotizado = $_POST['txtCotizado'];
$Obj_Cotizaciones->Max = $_POST['txtMax'];

$regexFecha = '/^(19|20)(((([02468][048])|([13579][26]))-02-29)|(\d{2})-((02-((0[1-9])|1\d|2[0-8]))|((((0[13456789])|1[012]))-((0[1-9])|((1|2)\d)|30))|(((0[13578])|(1[02]))-31)))$/';


//VALIDANDO FORMATO DE FECHA
if($_POST['txtFecha'] !== "" && $_POST['txtFecha'] !== "yyyy-mm-dd" && !preg_match($regexFecha, $_POST['txtFecha'])){
    $_SESSION['error-registro'] = 'fecha';
    echo "<script>history.go(-1)</script>";
    return;
};
//VALIDANDO FORMATO DE FECHA - IDA
if($_POST['txtIda'] !== "" && $_POST['txtIda'] !== "yyyy-mm-dd" && !preg_match($regexFecha, $_POST['txtIda'])){
    $_SESSION['error-registro'] = 'ida';
    echo "<script>history.go(-1)</script>";
    return;
};
//VALIDANDO FORMATO DE FECHA - REGRESO
if($_POST['txtRegreso'] !== "" && $_POST['txtRegreso'] !== "yyyy-mm-dd" && !preg_match($regexFecha, $_POST['txtRegreso'])){
    $_SESSION['error-registro'] = 'regreso';
    echo "<script>history.go(-1)</script>";
    return;
};

$Res_Cotizaciones = $Obj_Cotizaciones->Insertar();

if ($Res_Cotizaciones) {
    echo "<script>
    let URL = window.opener.location.pathname;
    if (URL.indexOf('buscar-cliente') !== -1) {
        window.opener.location.reload();
    }
    window.close();
</script>";
}
