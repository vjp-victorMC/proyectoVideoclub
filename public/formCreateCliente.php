<?php
session_start(); // Iniciamos sesión para poder acceder a los clientes guardados
?>

<h2>Crear nuevo cliente</h2>

<?php
// Mostramos mensaje de error si llega desde createCliente.php
if (isset($_GET['error'])) {
    echo "<p style='color:red'>" . $_GET['error'] . "</p>";
}
?>

<!-- Formulario de creación de cliente -->
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

<!-- Enlace de vuelta al panel admin -->
<a href="mainAdmin.php">Volver</a>
