<?php
session_start(); // Necesario para borrar del array de clientes

// Comprobamos que nos envían un usuario válido
if (!isset($_GET['user'])) {
    echo "Cliente no especificado";
    exit;
}

$user = $_GET['user'];

// Si existe ese cliente, lo eliminamos
if (isset($_SESSION['clientes'][$user])) {
    unset($_SESSION['clientes'][$user]);
}

// Volvemos al panel del administrador
header("Location: mainAdmin.php");
exit;
