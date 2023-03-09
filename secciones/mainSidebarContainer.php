<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= $_SESSION['path'] ?>" class="brand-link d-flex">
        <img src="<?= $_SESSION['path'] . '/dist/img/AdminLTELogo.png' ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light text-md">Legacy Multiservice LLC</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $_SESSION['path'] . $_SESSION['UrlFoto'] ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a class="d-block"><?= $_SESSION['NombreEmpleado']; ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?= $_SESSION['path'] ?>" class="nav-link active">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Inicio
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Clientes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= $_SESSION['path'] ?>buscar-cliente/" class="nav-link">
                                <i class="fa fa-search nav-icon"></i>
                                <p>Buscar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="javascript:nuevoCliente();">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Nuevo Cliente</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?= $_SESSION['path'] ?>recordatorios/" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>
                            Recordatorios
                        </p>
                        <span class="badge badge-info right">0</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="javascript:buscarCotizacion();">
                        <i class="nav-icon fa fa-dollar-sign"></i>
                        <p>
                            Cotizaciones
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>
                            Contabilidad
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-search nav-icon"></i>
                                <p>Buscar Factura</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-list-alt nav-icon"></i>
                                <p>Reporte Diario</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-list-alt nav-icon"></i>
                                <p>Reporte De Boletos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-list-alt nav-icon"></i>
                                <p>Reporte Volumen</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-list-alt nav-icon"></i>
                                <p>Reporte De Llamadas</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php if($_SESSION['NombreRol'] === 'Administrador'){ ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-user-cog"></i>
                        <p>
                            Mantenimiento
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-list nav-icon"></i>
                                <p>Listar Empleados</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Nuevo Empleado</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="javascript:CerrarSesion();">
                        <i class="nav-icon fa fa-door-open"></i>
                        <p>
                            Cerrar Sesión
                        </p>
                    </a>
                </li>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<script>
    function nuevoCliente() {
        window.open('<?= $_SESSION['path'] ?>forms/clientes/frmNuevo.php', 'Nuevo Cliente', 'width=400,height=1000')
    }

    function buscarCotizacion() {
        window.open('<?= $_SESSION['path'] ?>forms/cotizaciones/frmBuscar.php', 'Buscar Cotización', 'width=400,height=450')
    }

    function CerrarSesion() {
        location.replace('<?= $_SESSION['path'] ?>func/CerrarSesion.php');
    }
</script>