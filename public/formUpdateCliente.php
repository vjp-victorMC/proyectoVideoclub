<?php
session_start();

// Verificamos que nos envían el usuario y que existe en la sesión
//  Cambiado a $_SESSION['videoclub']['socios']
if (!isset($_GET['user']) || !isset($_SESSION['videoclub']['socios'][$_GET['user']])) {
    echo "Cliente no encontrado";
    exit;
}

// Obtenemos los datos del cliente a editar
$cliente = $_SESSION['videoclub']['socios'][$_GET['user']];
?>

<h2>Editar cliente: <?= htmlspecialchars($cliente['nombre']) ?></h2>

<form action="updateCliente.php" method="POST">
    <!-- Guardamos el login original para poder cambiarlo si se edita -->
    <input type="hidden" name="user_original" value="<?= htmlspecialchars($cliente['usuario']) ?>">

    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?= htmlspecialchars($cliente['nombre']) ?>"><br><br>

    <label>Usuario (login):</label><br>
    <input type="text" name="user" value="<?= htmlspecialchars($cliente['usuario']) ?>"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" value="<?= htmlspecialchars($cliente['password']) ?>"><br><br>

    <label>Teléfono:</label><br>
    <input type="text" name="telefono" value="<?= htmlspecialchars($cliente['telefono']) ?>"><br><br>

    <input type="submit" value="Actualizar cliente">
</form>

<a href="mainAdmin.php">Volver</a>
