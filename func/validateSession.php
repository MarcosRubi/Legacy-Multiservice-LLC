<?php
session_start();

if (!isset($_SESSION['NombreEmpleado'])) {
    header("Location: http://127.0.0.1/Proyectos/Legacy-Multiservice-LLC/iniciar-sesion/");
    die();
}
