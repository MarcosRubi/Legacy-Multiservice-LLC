<?php

session_start();
require_once '../../bd/bd.php';
require_once '../../class/Boletos.php';
require_once '../../class/Ajustes.php';

$Obj_Boletos = new Boletos();
$Obj_Ajustes = new Ajustes();

$Obj_Boletos->IdCliente = $Obj_Ajustes->RemoverEtiquetas($_POST['IdCliente']);
$Obj_Boletos->Itinerario = trim($_POST['txtItinerario']);
$Obj_Boletos->Agencia = $_SESSION['Agencia'];
$Obj_Boletos->Agente = $_SESSION['Agente'];
$Obj_Boletos->Pnr = $Obj_Ajustes->RemoverEtiquetas(trim(strtoupper($_POST['txtPnr'])));

if (trim($_POST['txtPnr']) === '') {
    $_SESSION['error-registro'] = 'pnr';
    echo "<script>history.go(-1)</script>";
    return;
};

$regexFecha = '/^(\d{2})-(\d{2})-(\d{4})$/';
$arr = explode(',', $_POST['nb']);
$arrMCO = explode(',', $_POST['nm']);


$arrBoletosInsertar = [];
$arrMcosInsertar = [];



if (isset($_POST['nb'])) {
    foreach ($arr as $key => $i) {
        $Obj_Boletos->NumeroBoletos = $Obj_Ajustes->RemoverEtiquetas($_POST['txtBoleto' . $i]);
        $Obj_Boletos->NombrePasajero = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower($_POST['txtNombrePasajero' . $i])));
        $Obj_Boletos->Aerolinea = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower($_POST['txtAerolinea' . $i])));
        $Obj_Boletos->Origen = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtOrigen' . $i]));
        $Obj_Boletos->Destino = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtDestino' . $i]));
        $Obj_Boletos->FechaIda = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaIda' . $i]));
        $Obj_Boletos->FechaRegreso = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaRegreso' . $i]));
        $Obj_Boletos->Dob = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaDob' . $i]));
        $Obj_Boletos->IdIata = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdIata' . $i]);
        $Obj_Boletos->IdTipo = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdTipo' . $i]);
        $Obj_Boletos->IdFormaPago = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdPago' . $i]);
        $Obj_Boletos->Precio = $Obj_Ajustes->RemoverEtiquetas($_POST['txtPrecio' . $i]);
        $Obj_Boletos->Base = $Obj_Ajustes->RemoverEtiquetas($_POST['txtBase' . $i]);
        $Obj_Boletos->Tax = $Obj_Ajustes->RemoverEtiquetas($_POST['txtTax' . $i]);
        $Obj_Boletos->Fm = $Obj_Ajustes->RemoverEtiquetas($_POST['txtFm' . $i]);
        $Obj_Boletos->Fee = $Obj_Ajustes->RemoverEtiquetas($_POST['txtFee' . $i]);

        if (trim($_POST['txtBoleto' . $i]) === '') {
            $_SESSION['error-registro'] = 'boletos';
            echo "<script>history.go(-1)</script>";
            return;
        };
        //VALIDANDO FORMATO DE FECHA DE NACIMIENTO
        if (trim($_POST['txtFechaDob' . $i]) === '') {
            $_SESSION['error-registro'] = 'dobVacio';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if ($_POST['txtFechaDob' . $i] !== "" && $_POST['txtFechaDob' . $i] !== "dd-mm-yyyy" && $_POST['txtFechaDob' . $i] !== "mm-dd-yyyy" && !preg_match($regexFecha, $_POST['txtFechaDob' . $i])) {
            $_SESSION['error-registro'] = 'dobFormato';
            echo "<script>history.go(-1)</script>";
            return;
        };
        //VALIDANDO FORMATO DE FECHA
        if (trim($_POST['txtNombrePasajero' . $i]) === '') {
            $_SESSION['error-registro'] = 'nombre';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if (trim($_POST['txtAerolinea' . $i]) === '') {
            $_SESSION['error-registro'] = 'aerolinea';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if (trim($_POST['txtOrigen' . $i]) === '') {
            $_SESSION['error-registro'] = 'origen';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if (trim($_POST['txtDestino' . $i]) === '') {
            $_SESSION['error-registro'] = 'destino';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if (trim($_POST['txtFechaIda' . $i]) === '') {
            $_SESSION['error-registro'] = 'idaVacio';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if ($_POST['txtFechaIda' . $i] !== "" && $_POST['txtFechaIda' . $i] !== "dd-mm-yyyy" && $_POST['txtFechaIda' . $i] !== "mm-dd-yyyy" && !preg_match($regexFecha, $_POST['txtFechaIda' . $i])) {
            $_SESSION['error-registro'] = 'idaFormato';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if ($_POST['txtFechaRegreso' . $i] !== "" && $_POST['txtFechaRegreso' . $i] !== "dd-mm-yyyy" && $_POST['txtFechaRegreso' . $i] !== "mm-dd-yyyy" && !preg_match($regexFecha, $_POST['txtFechaRegreso' . $i])) {
            $_SESSION['error-registro'] = 'regresoFormato';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if (trim($_POST['txtPrecio' . $i]) === '') {
            $_SESSION['error-registro'] = 'precio';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if (trim($_POST['txtBase' . $i]) === '') {
            $_SESSION['error-registro'] = 'base';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if (trim($_POST['txtTax' . $i]) === '') {
            $_SESSION['error-registro'] = 'tax';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if ($_POST['txtFm' . $i] === '') {
            $_SESSION['error-registro'] = 'fm';
            echo "<script>history.go(-1)</script>";
            return;
        };

        $arrBoletosInsertar[] = $Obj_Boletos->InsertarPreparar();
    }
}


if (isset($_POST['nm']) && count($arrMCO) >= 1 & $arrMCO[0] !== '') {
    require_once '../../class/Mcos.php';

    $Obj_Mcos = new Mcos();

    $Obj_Mcos->Pnr = $Obj_Ajustes->RemoverEtiquetas(trim(strtoupper($_POST['txtPnr'])));
    $Obj_Mcos->IdCliente = $Obj_Ajustes->RemoverEtiquetas($_POST['IdCliente']);

    foreach ($arrMCO as $key => $i) {
        $Obj_Mcos->NumeroMco = $_POST['txtMCO' . $i];
        $Obj_Mcos->Dob = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaDobMCO' . $i]));
        $Obj_Mcos->Valor = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtValorMCO' . $i]));
        $Obj_Mcos->IdIata = $_POST['txtIdIataMCO' . $i];
        $Obj_Mcos->IdFormaPago = $_POST['txtIdPagoMCO' . $i];
        $Obj_Mcos->Fm = 'test';
        $Obj_Mcos->Fee = 'testFee';

        if (trim($_POST['txtMCO' . $i]) === '') {
            $_SESSION['error-registro'] = 'mco';
            echo "<script>history.go(-1)</script>";
            return;
        };
        //VALIDANDO FORMATO DE FECHA DE NACIMIENTO
        if (trim($_POST['txtFechaDobMCO' . $i]) === '') {
            $_SESSION['error-registro'] = 'dobVacio';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if ($_POST['txtFechaDobMCO' . $i] !== "" && $_POST['txtFechaDobMCO' . $i] !== "dd-mm-yyyy" && $_POST['txtFechaDobMCO' . $i] !== "mm-dd-yyyy" && !preg_match($regexFecha, $_POST['txtFechaDob' . $i])) {
            $_SESSION['error-registro'] = 'dobFormato';
            echo "<script>history.go(-1)</script>";
            return;
        };
        //VALIDANDO FORMATO DE FECHA
        if (trim($_POST['txtValorMCO' . $i]) === '') {
            $_SESSION['error-registro'] = 'valorMCO';
            echo "<script>history.go(-1)</script>";
            return;
        };

        $arrMcosInsertar[] = $Obj_Mcos->InsertarPreparar();
    }
}

foreach ($arrBoletosInsertar as $key => $boleto) {
    $Obj_Boletos->InsertarQueryPreparada($boleto);
}
foreach ($arrMcosInsertar as $key => $mco) {
    $Obj_Mcos->InsertarQueryPreparada($mco);
}

$Res_Boletos = $Obj_Boletos->obtenerBoletoCreado($_POST['IdCliente']);
$DatosBoleto = $Res_Boletos->fetch_assoc();


if (count($arr) > 1) {
    $_SESSION['success-registro'] = 'boletos';
} else {
    $_SESSION['success-registro'] = 'boleto';
}
if (count($arrMCO) > 1 & $arrMCO[0] !== '') {
    $_SESSION['success-registro'] = 'mcos';
} else {
    $_SESSION['success-registro'] = 'mco';
}


header("Location:" . $_SESSION['path'] . "forms/facturas/frmNuevo.php?cliente=" . $DatosBoleto['IdCliente'] . "&pnr=" . $DatosBoleto['Pnr'] . "");
