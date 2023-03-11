<?php

session_start();
require_once '../../bd/bd.php';
require_once '../../class/Cotizaciones.php';
require_once '../../class/Ajustes.php';

$Obj_Cotizaciones = new Cotizaciones();
$Obj_Ajustes = new Ajustes();

$Obj_Cotizaciones->IdCliente = $Obj_Ajustes->RemoverEtiquetas($_POST['IdCliente']);
$Obj_Cotizaciones->Pnr = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtPnr']));
$Obj_Cotizaciones->Comentario = $Obj_Ajustes->RemoverEtiquetas(ucfirst(strtolower($_POST['txtComentario'])));
$Obj_Cotizaciones->Accion = $Obj_Ajustes->RemoverEtiquetas(ucfirst(strtolower($_POST['txtAccion'])));
$Obj_Cotizaciones->Fecha = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertir($_POST['txtFecha']));
$Obj_Cotizaciones->Agencia = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtAgencia']));
$Obj_Cotizaciones->Agente = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtAgente']));
$Obj_Cotizaciones->Origen = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtOrigen']));
$Obj_Cotizaciones->Destino = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtDestino']));
$Obj_Cotizaciones->Ida = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertir($_POST['txtIda']));
$Obj_Cotizaciones->Regreso = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertir($_POST['txtRegreso']));
$Obj_Cotizaciones->NumeroBoletos = $Obj_Ajustes->RemoverEtiquetas($_POST['txtNumeroBoletos']);
$Obj_Cotizaciones->Cotizado = $Obj_Ajustes->RemoverEtiquetas($_POST['txtCotizado']);
$Obj_Cotizaciones->Max = $Obj_Ajustes->RemoverEtiquetas($_POST['txtMax']);

$regexFecha = '/^(\d{2})-(\d{2})-(\d{4})$/';


//VALIDANDO FORMATO DE FECHA
if ($_POST['txtFecha'] !== "" && $_POST['txtFecha'] !== "dd-mm-yyyy" && !preg_match($regexFecha, $_POST['txtFecha'])) {
    $_SESSION['error-registro'] = 'fecha';
    echo "<script>history.go(-1)</script>";
    return;
};
//VALIDANDO FORMATO DE FECHA - IDA
if ($_POST['txtIda'] !== "" && $_POST['txtIda'] !== "dd-mm-yyyy" && !preg_match($regexFecha, $_POST['txtIda'])) {
    $_SESSION['error-registro'] = 'ida';
    echo "<script>history.go(-1)</script>";
    return;
};

$Res_Cotizaciones = $Obj_Cotizaciones->Insertar();

if ($Res_Cotizaciones) {
    $_SESSION['registro'] = 's-cotizacion';
    echo "<script>
    let URL = window.opener.location.pathname;
    if (URL.indexOf('buscar-cliente') !== -1) {
        window.opener.location.reload();
    }
    window.close();
</script>";
}
