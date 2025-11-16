<?php
// Recuperamos la información de la sesión
if (!isset($_SESSION)) {
    session_start();
}

// Eliminamos solo la información de autenticación y del cliente actual,
// pero dejamos $_SESSION['videoclub'] para que los datos creados por el admin persistan.
unset($_SESSION['usuario']);
unset($_SESSION['cliente']);

// Si quieres destruir también otros datos concretos, hazlo aquí:
// unset($_SESSION['otra_clave']);

// Redirigimos al formulario de login
header("Location: index.php");
exit;
?>