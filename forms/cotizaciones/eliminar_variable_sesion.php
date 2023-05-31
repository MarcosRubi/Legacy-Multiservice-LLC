<?php
// Iniciar la sesión
session_start();

echo "<script>alert('Elemento eliminado');</script>";
// Eliminar la variable de sesión
$_SESSION['CotizacionesDisabled'] = false;

?>