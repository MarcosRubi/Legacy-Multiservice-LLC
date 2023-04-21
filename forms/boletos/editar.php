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


$boletoActualizar = [];

$Obj_Boletos->IdCliente = $Obj_Ajustes->RemoverEtiquetas($_POST['IdCliente']);

$Obj_Boletos->Itinerario = trim($_POST['txtItinerario']);

$Obj_Boletos->Aerolinea = trim($_POST['txtAerolinea']);
$Obj_Boletos->Origen = trim($_POST['txtOrigen']);
$Obj_Boletos->Destino = trim($_POST['txtDestino']);

$Obj_Boletos->Agencia = $_SESSION['Agencia'];
$Obj_Boletos->Agente = $_SESSION['Agente'];
$Obj_Boletos->Pnr = $Obj_Ajustes->RemoverEtiquetas(trim(strtoupper($_POST['txtPnr'])));
$Obj_Boletos->Aerolinea = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower($_POST['txtAerolinea'])));
$Obj_Boletos->Origen = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtOrigen']));
$Obj_Boletos->Destino = $Obj_Ajustes->RemoverEtiquetas(strtoupper($_POST['txtDestino']));
$Obj_Boletos->FechaIda = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaIda']));
$Obj_Boletos->FechaRegreso = $_POST['txtFechaRegreso'] === '--' ? '0000-00-00' : $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaRegreso']));
$Obj_Boletos->IdIata = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdIata']);
$Obj_Boletos->IdTipo = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdTipo']);

$Obj_Eventos = new Eventos();
$Obj_Eventos->NombreEmpleado = $_SESSION['NombreEmpleado'];
$Obj_Eventos->TipoEvento = 'boleto #' . $_POST['IdBoleto'];
$Obj_Eventos->Mensaje = 'ha editado el';
$Obj_Eventos->Icono = 'fas fa-ticket-alt bg-blue';


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
    foreach ($arr as $key => $i) {
        $Obj_Boletos->NumeroBoletos = $Obj_Ajustes->RemoverEtiquetas($_POST['txtBoleto' . $i]);
        $Obj_Boletos->NombrePasajero = $Obj_Ajustes->RemoverEtiquetas(ucwords(strtolower($_POST['txtNombrePasajero' . $i])));
        $Obj_Boletos->Dob = $Obj_Ajustes->RemoverEtiquetas($Obj_Ajustes->FechaInvertirGuardar($_POST['txtFechaDob' . $i]));
        $Obj_Boletos->IdFormaPago = $Obj_Ajustes->RemoverEtiquetas($_POST['txtIdPago' . $i]);
        $Obj_Boletos->Precio =  $Obj_Ajustes->ConvertirFormatoDolar($Obj_Ajustes->RemoverEtiquetas($_POST['txtPrecio' . $i]));
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

        $Res_BoletoActualizar = $Obj_Boletos->buscarPorId($_POST['IdBoleto']);
        $DatosBoleto = $Res_BoletoActualizar->fetch_assoc();

        $Res_Facturas = $Obj_Facturas->buscarFacturaPorIdClienteYPnr($DatosBoleto['IdCliente'], $DatosBoleto['Pnr']);
        $DatosFactura = $Res_Facturas->fetch_assoc();

        $Obj_Facturas->CreditoValor =  $Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['CreditoValor']);
        $Obj_Facturas->Efectivo =  $Obj_Ajustes->ConvertirFormatoDolar($DatosFactura['Efectivo']);
        $Obj_Facturas->Cheque = $DatosFactura['Cheque'];
        $Obj_Facturas->Banco = $DatosFactura['Banco'];
        $Obj_Facturas->Cupon = $DatosFactura['Cupon'];
        $Obj_Facturas->CreditoNumero = $DatosFactura['CreditoNumero'];

        $Obj_Eventos->NombreEmpleado = $_SESSION['NombreEmpleado'];
        $Obj_Eventos->TipoEvento = 'factura #'  . $DatosFactura['IdFactura'];
        $Obj_Eventos->Mensaje = 'ha actualizado la ';
        $Obj_Eventos->Icono = 'fas fa-file-signature bg-orange';
        $Obj_Eventos->UrlEvento = 'facturas/detalles.php?id=' . $DatosFactura['IdFactura'];

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
        }

        // SI CAMBIA LA FORMA DE PAGO RESTAR EL VALOR DEL BOLETO EN LA FACTURA SECCION CREDITO O EFECTIVO Y SUMARLO AL OTRO

        // VALIDAR SI LO HA CAMBIADO
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
        }


        // SI ALGUNO DE LOS CAMPOS GENERALES ES MODIFICADO IR A TODOS LOS BOLETOS A ACTUALIZARLO
        // VERIFICAR SI HAN SIDO MODIFICADOS
        // VER SI HAY MAS DE UN BOLETO
        // RECORRER LOS BOLETOS Y ACTUALIZAR LOS VALORES
        // AL FINAL DEB BUCLE LLAMAR LA FUNCION ACTUALIZAR

        $boletoActualizar[] = $Obj_Boletos->ActualizarPreparar($_POST['IdBoleto']);
    }
}



foreach ($boletoActualizar as $key => $boleto) {
    $Res_BoletosActualizar = $Obj_Boletos->ActualizarQueryPreparada($boleto);

    $Obj_Eventos->UrlEvento = 'boletos/detalles.php?id=' . $_POST['IdBoleto'];
    $Obj_Eventos->Insertar();

    if ($Res_BoletosActualizar) {
        $_SESSION['success-update'] = 'boleto';
        echo "<script>history.go(-1)</script>";
    }
}
