<?php
session_start(); // Abrimos sesión para modificar la lista de clientes

// Validamos los datos obligatorios
if (
    empty($_POST['nombre']) ||
    empty($_POST['user']) ||
    empty($_POST['password'])
) {
    // Si falta algún dato, volvemos al formulario con un mensaje de error
    header("Location: formCreateCliente.php?error=Faltan datos obligatorios");
    exit;
}

// Recogemos los datos del formulario
$nombre = $_POST['nombre'];
$user = $_POST['user'];
$password = $_POST['password'];
$telefono = $_POST['telefono'] ?? ""; // Puede venir vacío

// Comprobamos si ya existe un cliente con ese usuario
if (isset($_SESSION['clientes'][$user])) {
    header("Location: formCreateCliente.php?error=El usuario ya existe");
    exit;
}

// Creamos el cliente y lo guardamos en la sesión
// (Si estás usando clases, aquí iría new Cliente(...))
$_SESSION['clientes'][$user] = [
    "nombre" => $nombre,
    "user" => $user,
    "password" => $password,
    "telefono" => $telefono,
    "alquileres" => [] // Se crea vacío
];

// Volvemos al panel del administrador
header("Location: mainAdmin.php");
exit;
