<?php

require_once '../../func/validateSession.php';

if ($_SESSION['IdRole'] > 3) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

require_once '../../bd/bd.php';
require_once '../../class/Boletos.php';
require_once '../../class/Facturas.php';
require_once '../../class/Eventos.php';
require_once '../../class/Ajustes.php';

$Obj_Boletos = new Boletos();
$Obj_Ajustes = new Ajustes();
$Obj_Facturas = new Facturas();


$regexFecha = '/^(\d{2})-(\d{2})-(\d{4})$/';
$arr = explode(',', $_POST['nb']);

$Res_BoletoActualizar = $Obj_Boletos->buscarPorId($_POST['IdBoleto']);
$DatosBoleto = $Res_BoletoActualizar->fetch_assoc();

$boletoActualizar = [];
$Obj_Boletos->IdCliente = $Obj_Ajustes->RemoverEtiquetas($_POST['IdCliente']);
$Obj_Boletos->Aerolinea = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower($_POST['txtAerolinea'])));
$Obj_Boletos->Origen = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtOrigen']));
$Obj_Boletos->Destino = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtDestino']));
$Obj_Boletos->FechaIda = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaIda']));
$Obj_Boletos->FechaRegreso = $_POST['txtFechaRegreso'] === '--' ? '0000-00-00' : $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaRegreso']));
$Obj_Boletos->IdIata = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdIata']);
$Obj_Boletos->IdTipo = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdTipo']);
$Obj_Boletos->Itinerario = $_POST['txtItinerario'];
$Obj_Boletos->Pnr = $Obj_Ajustes->RemoverEtiquetas(trim(strtoupper($_POST['txtPnr'])));

$Obj_Boletos->NumeroBoletos = $Obj_Ajustes->RemoverEtiquetas($_POST['txtBoleto1']);
$Obj_Boletos->NombrePasajero = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower($_POST['txtNombrePasajero1'])));
$Obj_Boletos->Dob = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaDob1']));
$Obj_Boletos->IdFormaPago = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdPago1']);
$Obj_Boletos->Precio = $Obj_Ajustes->RemoverEtiquetas($_POST['txtPrecio1']);
$Obj_Boletos->Base = $Obj_Ajustes->RemoverEtiquetas($_POST['txtBase1']);
$Obj_Boletos->Tax = $Obj_Ajustes->RemoverEtiquetas($_POST['txtTax1']);
$Obj_Boletos->Fm = $Obj_Ajustes->RemoverEtiquetas($_POST['txtFm1']);
$Obj_Boletos->Fee = $Obj_Ajustes->RemoverEtiquetas($_POST['txtFee1']);
$Obj_Boletos->Agencia = $DatosBoleto['Agencia'];
$Obj_Boletos->Agente = $DatosBoleto['Agente'];


$boletoActualizar[] = $Obj_Boletos->ActualizarPreparar($_POST['IdBoleto']);
$facturaEditada = false;

$Obj_Eventos = new Eventos();
$Obj_Eventos->NombreEmpleado = $_SESSION['NombreEmpleado'];


if (trim($_POST['txtPnr']) === '') {
    $_SESSION['error-registro'] = 'pnr';
    echo "<script>history.go(-1)</script>";
    return;
};
if (trim($_POST['txtAerolinea']) === '') {
    $_SESSION['error-registro'] = 'aerolinea';
    echo "<script>history.go(-1)</script>";
    return;
};
if (trim($_POST['txtOrigen']) === '') {
    $_SESSION['error-registro'] = 'origen';
    echo "<script>history.go(-1)</script>";
    return;
};
if (trim($_POST['txtDestino']) === '') {
    $_SESSION['error-registro'] = 'destino';
    echo "<script>history.go(-1)</script>";
    return;
};
if (trim($_POST['txtFechaIda']) === '') {
    $_SESSION['error-registro'] = 'idaVacio';
    echo "<script>history.go(-1)</script>";
    return;
};
if ($_POST['txtFechaIda'] !== "" && $_POST['txtFechaIda'] !== "dd-mm-yyyy" && $_POST['txtFechaIda'] !== "mm-dd-yyyy" && !preg_match($regexFecha, $_POST['txtFechaIda'])) {
    $_SESSION['error-registro'] = 'idaFormato';
    echo "<script>history.go(-1)</script>";
    return;
};
if ($_POST['txtFechaRegreso'] !== "" && $_POST['txtFechaRegreso'] !== "dd-mm-yyyy" && $_POST['txtFechaRegreso'] !== "mm-dd-yyyy" && !preg_match($regexFecha, $_POST['txtFechaRegreso'])) {
    $_SESSION['error-registro'] = 'regresoFormato';
    echo "<script>history.go(-1)</script>";
    return;
};


if (isset($_POST['nb'])) {

    if (trim($_POST['txtBoleto1']) === '') {
        $_SESSION['error-registro'] = 'boletos';
        echo "<script>history.go(-1)</script>";
        return;
    };
    //VALIDANDO FORMATO DE FECHA DE NACIMIENTO
    if (trim($_POST['txtFechaDob1']) === '') {
        $_SESSION['error-registro'] = 'dobVacio';
        echo "<script>history.go(-1)</script>";
        return;
    };
    if ($_POST['txtFechaDob1'] !== "" && $_POST['txtFechaDob1'] !== "dd-mm-yyyy" && $_POST['txtFechaDob1'] !== "mm-dd-yyyy" && !preg_match($regexFecha, $_POST['txtFechaDob1'])) {
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
}

$Res_Facturas = $Obj_Facturas->buscarFacturaPorIdClienteYPnr($DatosBoleto['IdCliente'], $DatosBoleto['Pnr']);
$DatosFactura = $Res_Facturas->fetch_assoc();


$Obj_Facturas->CreditoValor =  $Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['CreditoValor']);
$Obj_Facturas->Efectivo =  $Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Efectivo']);
$Obj_Facturas->Cheque = $DatosFactura['Cheque'];
$Obj_Facturas->Banco = $DatosFactura['Banco'];
$Obj_Facturas->Cupon = $DatosFactura['Cupon'];
$Obj_Facturas->CreditoNumero = $DatosFactura['CreditoNumero'];

// SI ESTA ACTUALIZANDO EL PRECIO DETERMINA LA DIFERENCIA Y SE LA MODIFICA EN LA FACTURA ACORDE AL METODO DE PAGO Y EN EL BOLETO
if ($Obj_Ajustes->ConvertirFormatoDolar($DatosBoleto['Precio']) !== $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtPrecio1'])) {

    // ENCUENTRA LA DIFERENCIA VALORNUEVO - VALORVIEJO Y ESTO VE A LA FACTURA A SUMARLO
    $diferencia =  $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtPrecio1']) - $Obj_Ajustes->ConvertirFormatoDolar($DatosBoleto['Precio']);


    if ($DatosBoleto['FormaPago'] === 'Efectivo') {
        $Obj_Facturas->Efectivo = $Obj_Ajustes->ConvertirFormatoDolar($Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Efectivo']) + $Obj_Ajustes->ConvertirFormatoDolar($diferencia));
    }
    if ($DatosBoleto['FormaPago'] === 'Crédito') {
        $Obj_Facturas->CreditoValor = $Obj_Ajustes->ConvertirFormatoDolar($Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['CreditoValor']) + $Obj_Ajustes->ConvertirFormatoDolar($diferencia));
    }

    $Obj_Facturas->ActualizarValoresPago($DatosFactura['IdFactura']);
    $facturaEditada = true;
}

// SI CAMBIA LA FORMA DE PAGO RESTAR EL VALOR DEL BOLETO EN LA FACTURA SECCION CREDITO O EFECTIVO Y SUMARLO AL OTRO
if (intval($_POST['txtIdPago1']) !== intval($DatosBoleto['IdFormaPago'])) {
    if (intval($DatosBoleto['IdFormaPago']) === 2) {
        $Obj_Facturas->CreditoValor = $Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['CreditoValor']) + $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtPrecio1']);
        $Obj_Facturas->Efectivo = $Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Efectivo']) - $Obj_Ajustes->ConvertirFormatoDolar($DatosBoleto['Precio']);

        $Obj_Facturas->ActualizarValoresPago($DatosFactura['IdFactura']);
    }
    if (intval($DatosBoleto['IdFormaPago']) === 3) {
        $Obj_Facturas->CreditoValor = $Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['CreditoValor']) - $Obj_Ajustes->ConvertirFormatoDolar($DatosBoleto['Precio']);
        $Obj_Facturas->Efectivo = $Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Efectivo']) + $Obj_Ajustes->ConvertirFormatoDolar($_POST['txtPrecio1']);
    }
    $Obj_Facturas->ActualizarValoresPago($DatosFactura['IdFactura']);
    $facturaEditada = true;
}


// SI ALGUNO DE LOS CAMPOS GENERALES ES MODIFICADO IR A TODOS LOS BOLETOS A ACTUALIZARLO

if (
    trim($_POST['txtPnr']) !== $DatosBoleto['Pnr'] ||
    $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower($_POST['txtAerolinea']))) !== $DatosBoleto['Aerolinea'] ||
    $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtOrigen'])) !== $DatosBoleto['Origen'] ||
    $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtDestino'])) !== $DatosBoleto['Destino'] ||
    $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaIda'])) !== $DatosBoleto['FechaIda'] ||
    $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaRegreso'])) !== $DatosBoleto['FechaRegreso'] ||
    $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdIata']) !== $DatosBoleto['IdIata'] ||
    $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdTipo']) !== $DatosBoleto['IdTipo']
) {

    $boletos = $Obj_Boletos->buscarPorPnr($DatosBoleto['IdCliente'], $DatosBoleto['Pnr']);

    foreach ($boletos as $key => $boleto) {
        $Obj_Boletos->IdCliente = $boleto['IdCliente'];
        $Obj_Boletos->NumeroBoletos = $boleto['NumeroBoletos'];
        $Obj_Boletos->NombrePasajero = $boleto['NombrePasajero'];
        $Obj_Boletos->Dob = $boleto['Dob'];
        $Obj_Boletos->IdFormaPago = $boleto['IdFormaPago'];
        $Obj_Boletos->Precio =  $boleto['Precio'];
        $Obj_Boletos->Base = $boleto['Base'];
        $Obj_Boletos->Tax = $boleto['Tax'];
        $Obj_Boletos->Fm = $boleto['Fm'];
        $Obj_Boletos->Fee = $boleto['Fee'];
        $Obj_Boletos->Agente = $boleto['Agente'];
        $Obj_Boletos->Agencia = $boleto['Agencia'];

        $Obj_Boletos->Actualizar($boleto['IdBoleto']);
    }
}


if (trim($_POST['txtPnr']) !== $DatosBoleto['Pnr']) { //SOLO ACTUALIZA SI CAMBIA EL PNR EN LA FACTURA
    $Obj_Facturas->ActualizarPnr($DatosFactura['IdFactura'],  $Obj_Ajustes->RemoverEtiquetas(trim(strtoupper($_POST['txtPnr']))));
    $facturaEditada = true;
}

if ($facturaEditada) {
    $Obj_Eventos->TipoEvento = 'factura #'  . $DatosFactura['IdFactura'];
    $Obj_Eventos->Mensaje = 'ha actualizado la ';
    $Obj_Eventos->Icono = 'fas fa-file-signature bg-orange';
    $Obj_Eventos->UrlEvento = 'facturas/detalles.php?id=' . $DatosFactura['IdFactura'] . '&edit=false';
    $Obj_Eventos->VentanaEmergente = "S";
    $Obj_Eventos->Insertar();
}

foreach ($boletoActualizar as $key => $boleto) {
    $Res_BoletosActualizar = $Obj_Boletos->ActualizarQueryPreparada($boleto);

    $Obj_Eventos->TipoEvento = 'boleto #' . $_POST['IdBoleto'] . '&edit=false';
    $Obj_Eventos->Mensaje = 'ha editado el';
    $Obj_Eventos->Icono = 'fas fa-ticket-alt bg-blue';
    $Obj_Eventos->UrlEvento = 'boletos/detalles.php?id=' . $_POST['IdBoleto'];
    $Obj_Eventos->VentanaEmergente = "S";

    $Obj_Eventos->Insertar();

    if ($Res_BoletosActualizar) {
        $_SESSION['success-update'] = 'boleto';
        echo "<script>history.go(-1)</script>";
    }
}
