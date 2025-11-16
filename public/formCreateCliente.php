<?php
session_start(); // Iniciamos la sesión para poder acceder al array de clientes
?>

<h2>Crear nuevo cliente</h2>

<?php
// Si llega un mensaje de error desde createCliente.php lo mostramos
if (isset($_GET['error'])) {
    echo "<p style='color:red'>" . $_GET['error'] . "</p>";
}
?>

<!-- Formulario para crear un cliente. Se enviará a createCliente.php -->
<form action="createCliente.php" method="POST">

    <label>Nombre:</label><br>
    <input type="text" name="nombre"><br><br>

    <label>Usuario (login):</label><br>
    <input type="text" name="user"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <label>Teléfono:</label><br>
    <input type="text" name="telefono"><br><br>

    <input type="submit" value="Crear cliente">
</form>

<!-- Enlace para volver al panel del administrador -->
<a href="mainAdmin.php">Volver</a>
