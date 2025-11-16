<?php
session_start(); // Abrimos sesión para modificar los datos del cliente

// Recibimos el usuario original
$user_original = $_POST['user_original'];

// Comprobamos que ese cliente existe
if (!isset($_SESSION['clientes'][$user_original])) {
    echo "Cliente no encontrado";
    exit;
}

// Validamos datos mínimos
if (empty($_POST['nombre']) || empty($_POST['user'])) {
    echo "Datos incorrectos";
    exit;
}

// Recogemos los datos modificados
$nombre = $_POST['nombre'];
$user = $_POST['user'];
$password = $_POST['password'];
$telefono = $_POST['telefono'];

// Si cambia el login (el índice del array), hay que mover el cliente
if ($user_original !== $user) {

    // Evitamos que un usuario nuevo ya exista
    if (isset($_SESSION['clientes'][$user])) {
        echo "El usuario ya existe.";
        exit;
    }

    // Copiamos el cliente con nueva clave
    $_SESSION['clientes'][$user] = $_SESSION['clientes'][$user_original];

    // Eliminamos la clave antigua
    unset($_SESSION['clientes'][$user_original]);
}

// Guardamos los nuevos datos del cliente
$_SESSION['clientes'][$user]['nombre'] = $nombre;
$_SESSION['clientes'][$user]['user'] = $user;
$_SESSION['clientes'][$user]['password'] = $password;
$_SESSION['clientes'][$user]['telefono'] = $telefono;

// Volvemos al panel del admin
header("Location: mainAdmin.php");
exit;
