<?php
require_once '../../func/validateSession.php';
require_once '../../bd/bd.php';
require_once '../../class/Recordatorios.php';
require_once '../../class/Ajustes.php';

$Obj_Recordatorios = new Recordatorios();
$Obj_Ajustes = new Ajustes();

$Obj_Recordatorios->IdCliente = $Obj_Ajustes->RemoverEtiquetas(strtolower(trim($_POST['txtIdCliente'])));
$Obj_Recordatorios->Fecha = $Obj_Ajustes->FechaInvertirGuardar(substr($_POST['txtFecha'], 0, -9));
$Obj_Recordatorios->Hora = strtoupper(substr($_POST['txtFecha'], 10, 20));
$Obj_Recordatorios->Estado = $Obj_Ajustes->RemoverEtiquetas(ucfirst(strtolower(trim($_POST['txtEstado']))));
$Obj_Recordatorios->Titulo = $Obj_Ajustes->RemoverEtiquetas(ucfirst(trim($_POST['txtTitulo'])));
$Obj_Recordatorios->Descripcion = $_POST['txtDescripcion'];
$Obj_Recordatorios->IdEmpleado = $_SESSION['IdEmpleado'];

if (trim($_POST['txtTitulo']) === '') {
    $_SESSION['error-registro'] = 'titulo';
    echo "<script>history.go(-1)</script>";
    return;
}

$Res_Recordatorios = $Obj_Recordatorios->Insertar();

if ($Res_Recordatorios) {

    $_SESSION['success-registro'] = 'recordatorio';
    echo "<script>history.go(-1)</script>";
}
