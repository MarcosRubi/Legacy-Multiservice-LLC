<style>
    .img-user {
        border-radius: 50%;
        max-width: 5rem;
        cursor: pointer;
        margin: .5rem;
    }

    .img-user-container {
        display: flex;
    }

    .img-user {
        opacity: .5;
    }

    .img-user-selected img {
        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, #0d47a1 0px 0px 0px 3px;
        opacity: 1;
    }

    .hide {
        display: none !important;
    }
</style>

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
            <button type="button" class="btn  w-100 d-flex" data-toggle="modal" data-target="#modal-xl">
                <div class="image">
                    <img src="<?= $_SESSION['path'] . $_SESSION['UrlFoto'] ?>" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a class="d-block"><?= $_SESSION['NombreEmpleado']; ?></a>
                </div>
            </button>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
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
                        <span class="badge badge-info right"><?= $_SESSION['Recordatorios']; ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="javascript:buscarCotizacion();" 
                    <?php if(isset($_SESSION['CotizacionesDisabled']) && $_SESSION['CotizacionesDisabled'] === true) { echo 'style="pointer-events:none;"';} ?>>
                        <i class="nav-icon fa fa-dollar-sign"></i>
                        <p>
                            Cotizaciones
                        </p>
                    </a>
                </li>
                <?php if ($_SESSION['IdRole'] === 2) { ?>
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
                                <a href="<?= $_SESSION['path'] ?>buscar-factura/" class="nav-link">
                                    <i class="fa fa-search nav-icon"></i>
                                    <p>Buscar Factura</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= $_SESSION['path'] ?>reportes/ventas/" class="nav-link">
                                    <i class="fa fa-list-alt nav-icon"></i>
                                    <p>Reporte de ventas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= $_SESSION['path'] ?>reportes/boletos/" class="nav-link">
                                    <i class="fa fa-list-alt nav-icon"></i>
                                    <p>Reporte De Boletos</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= $_SESSION['path'] ?>reportes/volumen/" class="nav-link">
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
                                <a href="<?= $_SESSION['path'] ?>empleados/" class="nav-link">
                                    <i class="fa fa-list nav-icon"></i>
                                    <p>Listar Empleados</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" onclick="javascript:nuevoEmpleado();">
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
<div class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Actualiza tus datos <strong> <?= $_SESSION['NombreEmpleado']; ?></strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= $_SESSION['path'] ?>forms/empleados/editar.php" method="POST" class="card card-info" id="frmNuevo" onsubmit="return validarFormulario();">
                <div class="modal-body">
                    <div class="card-body ">
                        <div class="d-flex flex-column">
                            <div class="form-group ">
                                <label>Seleccione un avatar</label>
                                <div class="img-user-container">
                                    <label class="<?= strpos($_SESSION['UrlFoto'], 'avatar1.png') !== false ? 'img-user-selected' : '' ?>">
                                        <input type="radio" name="rdbImg" value="1" <?= strpos($_SESSION['UrlFoto'], 'avatar1.png') !== false ? 'checked=""' : '' ?> class="d-none">
                                        <img src="<?= $_SESSION['path'] ?>dist/img/avatar1.png" alt="..." class="img-user">
                                    </label>
                                    <label class="<?= strpos($_SESSION['UrlFoto'], 'avatar2.png') !== false ? 'img-user-selected' : '' ?>">
                                        <input type="radio" name="rdbImg" value="2" <?= strpos($_SESSION['UrlFoto'], 'avatar2.png') !== false ? 'checked=""' : '' ?> class="d-none">
                                        <img src="<?= $_SESSION['path'] ?>dist/img/avatar2.png" alt="..." class="img-user">
                                    </label>
                                    <label class="<?= strpos($_SESSION['UrlFoto'], 'avatar3.png') !== false ? 'img-user-selected' : '' ?>">
                                        <input type="radio" name="rdbImg" value="3" <?= strpos($_SESSION['UrlFoto'], 'avatar3.png') !== false ? 'checked=""' : '' ?> class="d-none">
                                        <img src="<?= $_SESSION['path'] ?>dist/img/avatar3.png" alt="..." class="img-user">
                                    </label>
                                    <label class="<?= strpos($_SESSION['UrlFoto'], 'avatar4.png') !== false ? 'img-user-selected' : '' ?>">
                                        <input type="radio" name="rdbImg" value="4" <?= strpos($_SESSION['UrlFoto'], 'avatar4.png') !== false ? 'checked=""' : '' ?> class="d-none">
                                        <img src="<?= $_SESSION['path'] ?>dist/img/avatar4.png" alt="..." class="img-user">
                                    </label>
                                    <label class="<?= strpos($_SESSION['UrlFoto'], 'avatar5.png') !== false ? 'img-user-selected' : '' ?>">
                                        <input type="radio" name="rdbImg" value="5" <?= strpos($_SESSION['UrlFoto'], 'avatar5.png') !== false ? 'checked=""' : '' ?> class="d-none">
                                        <img src="<?= $_SESSION['path'] ?>dist/img/avatar5.png" alt="..." class="img-user">
                                    </label>
                                    <label class="<?= strpos($_SESSION['UrlFoto'], 'avatar6.png') !== false ? 'img-user-selected' : '' ?>">
                                        <input type="radio" name="rdbImg" value="6" <?= strpos($_SESSION['UrlFoto'], 'avatar6.png') !== false ? 'checked=""' : '' ?> class="d-none">
                                        <img src="<?= $_SESSION['path'] ?>dist/img/avatar6.png" alt="..." class="img-user">
                                    </label>
                                </div>
                            </div>
                            <div class="form-group container-fluid">
                                <label>Formato de fecha</label>
                                <div class="d-flex align-center">
                                    <div class="form-group clearfix mr-5">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="dmy" name="rdbFormatoFecha" <?= $_SESSION['FormatoFecha'] === 'dmy' ? 'checked' : '' ?> value="dmy">
                                            <label for="dmy">DD-MM-YYYY</label>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="mdy" name="rdbFormatoFecha" <?= $_SESSION['FormatoFecha'] === 'mdy' ? 'checked' : '' ?> value="mdy">
                                            <label for="mdy">MM-DD-YYYY</label>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" onclick="javascript:TogglePasswordView();">Cambiar contraseña</a>
                                <div class=" hide mt-3" id="password-content">
                                    <div class="d-flex">
                                        <div class="form-group clearfix">
                                            <label for="passwordOld">Contraseña actual</label>
                                            <input type="password" id="passwordOld" name="txtPasswordOld" class="form-control">
                                        </div>
                                        <div class="form-group clearfix ml-5">
                                            <label for="passwordNew">Nueva contraseña</label>
                                            <input type="password" id="passwordNew" name="txtPasswordNew" class="form-control">
                                        </div>
                                    </div>
                                    <label class="text-danger text-sm">Si olvidas la contraseña, deberás contactar con un administrador para restablecerla.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="user">
                    <input type="hidden" name="IdEmpleado" value="<?= $_SESSION['IdEmpleado'] ?>">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar datos</button>
            </form>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    function nuevoCliente() {
        window.open('<?= $_SESSION['path'] ?>forms/clientes/frmNuevo.php', 'Nuevo Cliente', 'width=400,height=1000')
    }

    function nuevoEmpleado() {
        window.open('<?= $_SESSION['path'] ?>forms/empleados/frmNuevo.php', 'Nuevo Empleado', 'width=700,height=1000')
    }

    function buscarCotizacion() {
        window.open('<?= $_SESSION['path'] ?>forms/cotizaciones/frmBuscar.php', 'Buscar Cotización', 'width=450,height=600')
    }

    function CerrarSesion() {
        location.replace('<?= $_SESSION['path'] ?>func/CerrarSesion.php');
    }

    document.addEventListener("DOMContentLoaded", function() {
        var radios = document.querySelectorAll('input[type="radio"][name="rdbImg"]');

        radios.forEach(function(radio) {
            radio.addEventListener("click", function() {
                var labels = document.querySelectorAll('label');
                labels.forEach(function(label) {
                    label.classList.remove('img-user-selected');
                });
                this.closest('label').classList.add('img-user-selected');
            });
        });
    });

    function validarFormulario() {
        var radios = document.getElementsByName('rdbImg');
        var imgSeleccionada = false;
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                imgSeleccionada = true;
                break;
            }
        }
        if (!imgSeleccionada) {
            alert('Seleccione un avatar');
            return false;
        }
        return true;
    }

    function TogglePasswordView() {
        let passwordContent = document.getElementById('password-content');

        passwordContent.classList.toggle('hide')
    }
</script>