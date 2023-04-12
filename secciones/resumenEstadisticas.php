<?php
$URL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$META = 100;

if (!isset($_POST['report']) && strpos($URL, "reportes") === false) {
    require_once 'func/validateSession.php';
    require_once 'bd/bd.php';
    require_once 'class/Boletos.php';
    require_once 'class/Clientes.php';
    require_once 'class/Cotizaciones.php';
} else if (strpos($URL, "reportes") !== false) {
    require_once '../../func/validateSession.php';
    require_once '../../bd/bd.php';
    require_once '../../class/Boletos.php';
    require_once '../../class/Clientes.php';
    require_once '../../class/Cotizaciones.php';
} else {
    require_once '../func/validateSession.php';
    require_once '../bd/bd.php';
    require_once '../class/Boletos.php';
    require_once '../class/Clientes.php';
    require_once '../class/Cotizaciones.php';
}



$Obj_Boletos = new Boletos();
$Obj_Clientes = new Clientes();
$Obj_Cotizaciones = new Cotizaciones();

$Res_Boletos = $Obj_Boletos->cantidadBoletosPorDiaActual();
$Res_Clientes = $Obj_Clientes->cantidadClientesPorDiaActual();
$Res_Cotizaciones = $Obj_Cotizaciones->cantidadCotizacionesPorDiaActual();


if (isset($_POST['report']) && isset($_POST['filter']) && $_POST['filter'] === 'week') {
    $Res_Boletos = $Obj_Boletos->cantidadBoletosPorSemanaActual();
    $Res_Clientes = $Obj_Clientes->cantidadClientesPorSemanaActual();
    $Res_Cotizaciones = $Obj_Cotizaciones->cantidadCotizacionesPorSemanaActual();
}
if (isset($_POST['report']) && isset($_POST['filter']) && $_POST['filter'] === 'month') {
    $Res_Boletos = $Obj_Boletos->cantidadBoletosPorMesActual();
    $Res_Clientes = $Obj_Clientes->cantidadClientesPorMesActual();
    $Res_Cotizaciones = $Obj_Cotizaciones->cantidadCotizacionesPorMesActual();
}
if (isset($_POST['report']) && isset($_POST['filter']) && $_POST['filter'] === 'year') {
    $Res_Boletos = $Obj_Boletos->cantidadBoletosPorAnioActual();
    $Res_Clientes = $Obj_Clientes->cantidadClientesPorAnioActual();
    $Res_Cotizaciones = $Obj_Cotizaciones->cantidadCotizacionesPorAnioActual();
}

if (!isset($_POST['filter'])) {
    $Res_Boletos = $Obj_Boletos->cantidadBoletosPorMesActual();
    $Res_Clientes = $Obj_Clientes->cantidadClientesPorMesActual();
    $Res_Cotizaciones = $Obj_Cotizaciones->cantidadCotizacionesPorMesActual();
}

$TotalBoletos = $Res_Boletos->fetch_assoc()['total_boletos'];
$TotalClientes = $Res_Clientes->fetch_assoc()['total_clientes'];
$TotalCotizaciones = $Res_Cotizaciones->fetch_assoc()['total_cotizaciones'];

$PORCENTAJE_META = $META * (intval($TotalBoletos) / 100);


?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $TotalBoletos ?></h3>

                        <p>Boletos vendidos</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="<?= $_SESSION['IdRole'] === 2 ? $_SESSION['path'] . 'reportes/boletos/' : '#' ?>" class="small-box-footer">Más información<i class="fas fa-arrow-circle-right ml-1"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $TotalClientes ?></h3>

                        <p>Clientes creados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="<?= $_SESSION['path'] . 'buscar-cliente/' ?>" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $TotalCotizaciones ?></h3>

                        <p>Cotizaciones realizadas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" onclick="javascript:obtenerCotizaciones();" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $PORCENTAJE_META ?><sup style="font-size: 20px">%</sup></h3>

                        <p>Meta alcanzada</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="<?= $_SESSION['IdRole'] === 2 ? $_SESSION['path'] . 'reportes/volumen/' : '#'  ?>" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<script>
    function obtenerCotizaciones() {
        window.open('<?= $_SESSION['path'] ?>forms/cotizaciones/frmResultados.php', 'Cotizaciones', 'width=1400,height=600')
    }
</script>