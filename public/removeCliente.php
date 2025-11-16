<?php
session_start();

// Verificamos que nos envían el usuario
if (!isset($_GET['user'])) {
    echo "Cliente no especificado";
    exit;
}

$user = $_GET['user'];

// Eliminamos cliente si existe
if (isset($_SESSION['videoclub']['socios'][$user])) {
    unset($_SESSION['videoclub']['socios'][$user]);
}

// Redirigimos al panel admin
header("Location: mainAdmin.php");
exit;
