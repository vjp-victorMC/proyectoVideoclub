<?php
session_start();

$user_original = $_POST['user_original'];

// Verificamos que el cliente original existe
if (!isset($_SESSION['videoclub']['socios'][$user_original])) {
    echo "Cliente no encontrado";
    exit;
}

// Validamos que se envíen datos mínimos
if (empty($_POST['nombre']) || empty($_POST['user'])) {
    echo "Datos incorrectos";
    exit;
}

// Recogemos los datos del formulario
$nombre = $_POST['nombre'];
$user = $_POST['user'];
$password = $_POST['password'];
$telefono = $_POST['telefono'] ?? "";

// Si se cambia el login del cliente
if ($user_original !== $user) {
    // Evitamos duplicados
    if (isset($_SESSION['videoclub']['socios'][$user])) {
        echo "El usuario ya existe.";
        exit;
    }

    // Creamos nueva entrada con la clave nueva
    $_SESSION['videoclub']['socios'][$user] = $_SESSION['videoclub']['socios'][$user_original];

    // Eliminamos la antigua
    unset($_SESSION['videoclub']['socios'][$user_original]);
}

// Guardamos los cambios
$_SESSION['videoclub']['socios'][$user]['nombre'] = $nombre;
$_SESSION['videoclub']['socios'][$user]['usuario'] = $user;
$_SESSION['videoclub']['socios'][$user]['password'] = $password;
$_SESSION['videoclub']['socios'][$user]['telefono'] = $telefono;

// Redirigimos al panel admin
header("Location: mainAdmin.php");
exit;
