<?php
session_start(); // Necesario para guardar los clientes en sesión

// Validación de datos obligatorios
if (empty($_POST['nombre']) || empty($_POST['user']) || empty($_POST['password'])) {
    // Si falta algún dato, volvemos al formulario con mensaje de error
    header("Location: formCreateCliente.php?error=Faltan datos obligatorios");
    exit;
}

// Recogemos los datos enviados
$nombre = $_POST['nombre'];
$user = $_POST['user'];
$password = $_POST['password'];
$telefono = $_POST['telefono'] ?? ""; // Puede venir vacío

// Verificamos si ya existe un cliente con ese login
if (isset($_SESSION['videoclub']['socios'][$user])) {
    header("Location: formCreateCliente.php?error=El usuario ya existe");
    exit;
}

// Guardamos el cliente en la sesión en el array 'socios'
//  Cambiado de $_SESSION['clientes'] a $_SESSION['videoclub']['socios']
$_SESSION['videoclub']['socios'][$user] = [
    "nombre" => $nombre,
    "usuario" => $user,
    "password" => $password,
    "telefono" => $telefono,
    "maxAlquileres" => 3, // valor por defecto
];

// Redirigimos al panel admin para ver el nuevo cliente
header("Location: mainAdmin.php");
exit;
