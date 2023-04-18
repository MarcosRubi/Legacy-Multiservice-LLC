
<?php
require_once '../../func/validateSession.php';

if ($_SESSION['IdRole'] > 3) {
    header("Location:" . $_SESSION['path']);
    $_SESSION['error-permissions'] = 'true';
    return;
}

require_once '../../bd/bd.php';
require_once '../../class/Facturas.php';
require_once '../../class/Eventos.php';

$Obj_Facturas = new Facturas();
$Obj_Eventos = new Eventos();

$Res_DatosFactura = $Obj_Facturas->buscarFacturaPorId($_GET['id']);
$DatosFactura = $Res_DatosFactura->fetch_assoc();


$Res_Facturas = $Obj_Facturas->Eliminar($_GET['id']);


$Obj_Eventos->NombreEmpleado = $_SESSION['NombreEmpleado'];
$Obj_Eventos->Mensaje = 'ha eliminado la';
$Obj_Eventos->VentanaEmergente = 'N';
$Obj_Eventos->TipoEvento = "factura #" . $_GET['id'];
$Obj_Eventos->Icono = 'fas fa-minus bg-danger';
$Obj_Eventos->Insertar();

if ($Res_Facturas) {
    $_SESSION['success-delete'] = 'factura';
}

require_once '../../class/Boletos.php';

$Obj_Boletos = new Boletos();
$Res_Boletos = $Obj_Boletos->buscarPorPnr($DatosFactura['IdCliente'], $DatosFactura['Pnr']);
$DatosBoleto = $Res_Boletos->fetch_assoc();
$Res_NumBoletos = $Res_Boletos->num_rows;

if ($Res_NumBoletos > 1) {
    foreach ($Res_Boletos as $key => $boleto) {
        $Res_Boleto = $Obj_Boletos->Eliminar($boleto['IdBoleto']);

        if ($Res_Boleto) {

            $Obj_Eventos->Mensaje = 'ha eliminado el';
            $Obj_Eventos->VentanaEmergente = 'N';
            $Obj_Eventos->TipoEvento = "boleto #" . $boleto['IdBoleto'];
            $Obj_Eventos->Icono = 'fas fa-minus bg-danger';
            $Obj_Eventos->Insertar();

            if ($DatosFactura['IdTipoFactura'] === '2') {
                $_SESSION['success-delete'] = 'boletos&factura';
            }

            header("Location:" . $_SESSION['path'] . "buscar-factura/");
        }
    }
}

if ($Res_NumBoletos === 0 && $DatosFactura['IdTipoFactura'] === 2) {
    $Res_Boleto = $Obj_Boletos->Eliminar($DatosBoleto['IdBoleto']);

    if ($Res_Boleto) {
        $Obj_Eventos->Mensaje = 'ha eliminado el';
        $Obj_Eventos->VentanaEmergente = 'N';
        $Obj_Eventos->TipoEvento = "boleto #" . $DatosBoleto['IdBoleto'];
        $Obj_Eventos->Icono = 'fas fa-minus bg-danger';
        $Obj_Eventos->Insertar();
        if ($DatosFactura['IdTipoFactura'] === '2') {
            $_SESSION['success-delete'] = 'boleto&factura';
        }

        header("Location:" . $_SESSION['path'] . "buscar-factura/");
    }
}
header("Location:" . $_SESSION['path'] . "buscar-factura/");

?>
