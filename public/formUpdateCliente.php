<?php
session_start(); // Necesario para acceder a los datos del cliente

// Comprobamos que nos envían el usuario correcto
if (!isset($_GET['user']) || !isset($_SESSION['clientes'][$_GET['user']])) {
    echo "Cliente no encontrado";
    exit;
}

// Cargamos los datos del cliente seleccionado
$cliente = $_SESSION['clientes'][$_GET['user']];
?>

<h2>Editar cliente: <?= $cliente['nombre'] ?></h2>

<!-- Formulario de edición. Enviamos el usuario original en un campo oculto -->
<form action="updateCliente.php" method="POST">

    <!-- Usuario original (por si se cambia el login) -->
    <input type="hidden" name="user_original" value="<?= $cliente['user'] ?>">

    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?= $cliente['nombre'] ?>"><br><br>

    <label>Usuario (login):</label><br>
    <input type="text" name="user" value="<?= $cliente['user'] ?>"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" value="<?= $cliente['password'] ?>"><br><br>

    <label>Teléfono:</label><br>
    <input type="text" name="telefono" value="<?= $cliente['telefono'] ?>"><br><br>

    <input type="submit" value="Actualizar cliente">
</form>

<!-- Enlace para volver al panel del administrador -->
<a href="mainAdmin.php">Volver</a>
