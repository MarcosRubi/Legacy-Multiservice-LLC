
<?php
require_once '../../func/validateSession.php';

if ($_SESSION['IdRole'] > 3) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

require_once '../../bd/bd.php';
require_once '../../class/Boletos.php';
require_once '../../class/Eventos.php';
require_once '../../class/Facturas.php';

$Obj_Boletos = new Boletos();
$Obj_Eventos = new Eventos();
$Obj_Facturas = new Facturas();

$Res_Boletos = $Obj_Boletos->buscarPorId($_GET['id']);
$DatosBoleto = $Res_Boletos->fetch_assoc();

$Res_BoletosFactura = $Obj_Boletos->buscarPorPnr($DatosBoleto['IdCliente'], $DatosBoleto['Pnr']);
$cantidadBoletosFactura = $Res_BoletosFactura->num_rows;


$Res_Facturas = $Obj_Facturas->buscarFacturaPorIdClienteYPnr($DatosBoleto['IdCliente'], $DatosBoleto['Pnr']);
$DatosFactura = $Res_Facturas->fetch_assoc();

$Obj_Eventos->NombreEmpleado = $_SESSION['NombreEmpleado'];
$Obj_Eventos->Mensaje = 'ha eliminado el';
$Obj_Eventos->VentanaEmergente = 'N';
$Obj_Eventos->TipoEvento = "boleto #" . $_GET['id'];
$Obj_Eventos->Icono = 'fas fa-minus bg-danger';
$Obj_Eventos->Insertar();

if ($cantidadBoletosFactura <= 1) {
    $Res_Boletos = $Obj_Boletos->Eliminar($_GET['id']);
    $Obj_Facturas->Eliminar($DatosFactura['IdFactura']);

    if ($Res_Boletos) {
        echo "<script>history.go(-1)</script>";
        $_SESSION['success-delete'] = 'boleto&factura';
    }
    return;
}

$valorFacturaActualizado = $DatosFactura['Valor'] - $DatosBoleto['Precio'];
$valorEnEfectivoActualizado = $DatosFactura['Efectivo'];
$valorEnCreditoActualizado = $DatosFactura['CreditoValor'];

if ($DatosBoleto['IdFormaPago'] === '2') {
    $valorEnEfectivoActualizado = $DatosFactura['Efectivo'] - $DatosBoleto['Precio'];
}
if ($DatosBoleto['IdFormaPago'] === '3') {
    $valorEnCreditoActualizado = $DatosFactura['CreditoValor'] - $DatosBoleto['Precio'];
}


$Obj_Facturas->IdCliente = $DatosFactura['IdCliente'];
$Obj_Facturas->IdTipoFactura = $DatosFactura['IdTipoFactura'];
$Obj_Facturas->Valor = $valorFacturaActualizado;
$Obj_Facturas->Descripcion = $DatosFactura['Descripcion'];
$Obj_Facturas->Efectivo = $valorEnEfectivoActualizado;
$Obj_Facturas->CreditoValor = $valorEnCreditoActualizado;
$Obj_Facturas->CreditoNumero = $DatosFactura['CreditoNumero'];
$Obj_Facturas->Cheque = $DatosFactura['Cheque'];
$Obj_Facturas->Banco = $DatosFactura['Banco'];
$Obj_Facturas->Cupon = $DatosFactura['Cupon'];
$Obj_Facturas->Comentario = $DatosFactura['Comentario'];
$Obj_Facturas->Agencia = $DatosFactura['Agencia'];
$Obj_Facturas->Agente = $DatosFactura['Agente'];
$Obj_Facturas->Pnr = $DatosFactura['Pnr'];

$Res_Boletos = $Obj_Boletos->Eliminar($_GET['id']);
$Obj_Facturas->ActualizarTodaLaFactura($DatosFactura['IdFactura']);


if ($Res_Facturas && $Res_Boletos) {
    echo "<script>history.go(-1)</script>";
    $_SESSION['success-delete'] = 'boleto&editFactura';
}


?>
