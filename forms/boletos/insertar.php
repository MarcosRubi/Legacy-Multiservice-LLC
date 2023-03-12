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


$regexFecha = '/^(\d{2})-(\d{2})-(\d{4})$/';

if (isset($_POST['nb'])) {
    for ($i = 1; $i <= intval($_POST['nb']); $i++) {
        $Obj_Boletos->NumeroBoletos = $Obj_Ajustes->RemoverEtiquetas($_POST['txtBoleto' . $_POST['nb'] . '']);
        echo $_POST['txtBoleto' . $_POST['nb'] . ''];
        $Obj_Boletos->NombrePasajero = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower($_POST['txtNombrePasajero' . $_POST['nb'] . ''])));
        $Obj_Boletos->Aerolinea = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower($_POST['txtAerolinea' . $_POST['nb'] . ''])));
        $Obj_Boletos->Origen = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtOrigen' . $_POST['nb'] . '']));
        $Obj_Boletos->Destino = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtDestino' . $_POST['nb'] . '']));
        $Obj_Boletos->FechaIda = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertir($_POST['txtFechaIda' . $_POST['nb'] . '']));
        $Obj_Boletos->FechaRegreso = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertir($_POST['txtFechaRegreso' . $_POST['nb'] . '']));
        $Obj_Boletos->Dob = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertir($_POST['txtFechaDob' . $_POST['nb'] . '']));
        $Obj_Boletos->IdIata = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdIata' . $_POST['nb'] . '']);
        $Obj_Boletos->IdTipo = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdTipo' . $_POST['nb'] . '']);
        $Obj_Boletos->IdFormaPago = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdPago' . $_POST['nb'] . '']);
        $Obj_Boletos->Precio = $Obj_Ajustes->RemoverEtiquetas($_POST['txtPrecio' . $_POST['nb'] . '']);
        $Obj_Boletos->Base = $Obj_Ajustes->RemoverEtiquetas($_POST['txtBase' . $_POST['nb'] . '']);
        $Obj_Boletos->Tax = $Obj_Ajustes->RemoverEtiquetas($_POST['txtTax' . $_POST['nb'] . '']);
        $Obj_Boletos->Fm = $Obj_Ajustes->RemoverEtiquetas($_POST['txtFm' . $_POST['nb'] . '']);
        $Obj_Boletos->Fee = $Obj_Ajustes->RemoverEtiquetas($_POST['txtFee' . $_POST['nb'] . '']);

        if (trim($_POST['txtBoleto' . $_POST['nb'] . '']) === '') {
            $_SESSION['error-registro'] = 'boletos';
            echo "<script>history.go(-1)</script>";
            return;
        };
        //VALIDANDO FORMATO DE FECHA DE NACIMIENTO
        if (trim($_POST['txtFechaDob' . $_POST['nb'] . '']) === '') {
            $_SESSION['error-registro'] = 'dobVacio';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if ($_POST['txtFechaDob' . $_POST['nb'] . ''] !== "" && $_POST['txtFechaDob' . $_POST['nb'] . ''] !== "dd-mm-yyyy" && !preg_match($regexFecha, $_POST['txtFechaDob' . $_POST['nb'] . ''])) {
            $_SESSION['error-registro'] = 'dobFormato';
            echo "<script>history.go(-1)</script>";
            return;
        };
        //VALIDANDO FORMATO DE FECHA
        if (trim($_POST['txtNombrePasajero' . $_POST['nb'] . '']) === '') {
            $_SESSION['error-registro'] = 'nombre';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if (trim($_POST['txtAerolinea' . $_POST['nb'] . '']) === '') {
            $_SESSION['error-registro'] = 'aerolinea';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if (trim($_POST['txtOrigen' . $_POST['nb'] . '']) === '') {
            $_SESSION['error-registro'] = 'origen';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if (trim($_POST['txtDestino' . $_POST['nb'] . '']) === '') {
            $_SESSION['error-registro'] = 'destino';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if (trim($_POST['txtFechaIda' . $_POST['nb'] . '']) === '') {
            $_SESSION['error-registro'] = 'idaVacio';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if ($_POST['txtFechaIda' . $_POST['nb'] . ''] !== "" && $_POST['txtFechaIda' . $_POST['nb'] . ''] !== "dd-mm-yyyy" && !preg_match($regexFecha, $_POST['txtFechaIda' . $_POST['nb'] . ''])) {
            $_SESSION['error-registro'] = 'idaFormato';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if ($_POST['txtFechaRegreso' . $_POST['nb'] . ''] === '') {
            $_SESSION['error-registro'] = 'regresoVacio';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if ($_POST['txtFechaRegreso' . $_POST['nb'] . ''] !== "" && $_POST['txtFechaRegreso' . $_POST['nb'] . ''] !== "dd-mm-yyyy" && !preg_match($regexFecha, $_POST['txtFechaRegreso' . $_POST['nb'] . ''])) {
            $_SESSION['error-registro'] = 'regresoFormato';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if (trim($_POST['txtPrecio' . $_POST['nb'] . '']) === '') {
            $_SESSION['error-registro'] = 'precio';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if (trim($_POST['txtBase' . $_POST['nb'] . '']) === '') {
            $_SESSION['error-registro'] = 'base';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if (trim($_POST['txtTax' . $_POST['nb'] . '']) === '') {
            $_SESSION['error-registro'] = 'tax';
            echo "<script>history.go(-1)</script>";
            return;
        };
        if ($_POST['txtFm' . $_POST['nb'] . ''] === '') {
            $_SESSION['error-registro'] = 'fm';
            echo "<script>history.go(-1)</script>";
            return;
        };



        $Res_Boletos = $Obj_Boletos->Insertar();
        var_dump($Res_Boletos);
    }
}

// if ($Res_Boletos) {
//     $_SESSION['registro'] = 's-boleto';
//     echo "<script>
//     let URL = window.opener.location.pathname;
//     if (URL.indexOf('buscar-cliente') !== -1) {
//         window.opener.location.reload();
//     }
//     window.close();
// </script>";
// }
