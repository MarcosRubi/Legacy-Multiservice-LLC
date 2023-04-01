<?php
require_once './func/validateSession.php';

require_once './bd/bd.php';
require_once './class/Ajustes.php';
require_once './class/Eventos.php';

$Obj_Eventos = new Eventos();
$Obj_Ajustes = new Ajustes();
$Res_Eventos = $Obj_Eventos->listarEventos();

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio | Legacy Multiservice LLC</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="./plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="./plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include_once './secciones/navbar.php'; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include_once './secciones/mainSidebarContainer.php'; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper pt-3">
    <?php include_once './secciones/resumenEstadisticas.php'; ?>

      <!-- Main content -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Registro de eventos recientes</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <!-- Timelime example  -->
          <div class="row">
            <div class="col-md-12">
              <!-- The time line -->
              <div class="timeline">
                <!-- timeline time label -->
                <div class="time-label">
                  <span class="bg-red px-3">Hoy</span>
                </div>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <?php
                $mensajeAnteriormente = false;
                while ($DatosEventos = $Res_Eventos->fetch_assoc()) { ?>
                  <?php
                  if ((substr($DatosEventos['Creado'], 0, -9) !== date("Y-m-d")) && !$mensajeAnteriormente) {
                    echo "<!-- timeline time label -->
                <div class=\"time-label\">
                  <span class=\"bg-green\">Anteriormente</span>
                </div>";
                    $mensajeAnteriormente = true;
                  }
                  ?>
                  <div>
                    <i class="<?= $DatosEventos['Icono']; ?>"></i>
                    <div class="timeline-item">
                      <span class="time">
                        <i class="fas fa-clock"></i>
                        <?php
                        if (substr($DatosEventos['Creado'], 0, -9) === date("Y-m-d")) {
                          echo substr($DatosEventos['Creado'], 10, 20) . " " .  $DatosEventos['CreadoTimestamp'];
                        } else {
                          echo $Obj_Ajustes->FechaInvertir(substr($DatosEventos['Creado'], 0, -9)) . " " . substr($DatosEventos['Creado'], 10, 20) . " " .  $DatosEventos['CreadoTimestamp'];
                        }
                        ?>
                      </span>
                      <?php
                      if ($DatosEventos['VentanaEmergente'] === 'N') {
                        $url = $DatosEventos['UrlEvento'] !== '' ? $DatosEventos['UrlEvento'] : '#';
                        echo "<h3 class=\"timeline-header\">
                            <strong>" . $DatosEventos['NombreEmpleado'] . " </strong>"
                          . $DatosEventos['Mensaje'] .
                          "<a href=\"" . $url  . "\"> " . $DatosEventos['TipoEvento'] . "</a></h3>";
                      } else {
                        echo "<h3 class=\"timeline-header\"><strong>" . $DatosEventos['NombreEmpleado'] . " </strong>" . $DatosEventos['Mensaje'] . " <a href=\"#\" onclick=\"javascript:abrirFormDetalles('" . $DatosEventos['UrlEvento'] . "')\">" . $DatosEventos['TipoEvento'] . "</a></h3>";
                      }
                      ?>
                      </h3>
                    </div>
                  </div>

                <?php } ?>
                <!-- END timeline item -->
                <div>
                  <i class="fas fa-clock bg-gray"></i>
                </div>
              </div>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.timeline -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include_once './secciones/footer.php'; ?>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="./plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="./plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="./plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="./plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="./plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="./plugins/toastr/toastr.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="./dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
    $(function() {
      $('#logs').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
  <script>
    <?php require_once './func/Mensajes.php'; ?>
  </script>
  <script>
    function abrirFormDetalles(url) {
      window.open('<?= $_SESSION['path'] ?>' + url, 'Detalles', 'width=1000,height=1000')
    }
  </script>
</body>

</html>