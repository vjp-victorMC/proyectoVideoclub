<?php
// Recuperamos la información de la sesión
if (!isset($_SESSION)) {
    session_start();
}

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario'])) {
    die("Error - debe <a href='index.php'>identificarse</a>.<br />");
}

// Obtenemos el objeto Cliente desde la sesión
$cliente = $_SESSION['cliente'] ?? null;

// Si no hay objeto Cliente, indicamos que no hay datos
if (!$cliente || !($cliente instanceof \Dwes\ProyectoVideoclub\Cliente)) {
    die("Cliente no encontrado en la sesión. <a href='index.php'>Volver</a>");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Cliente</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="wrap">
        <header class="site-header">
            <h1>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?></h1>
            <p class="logout"><a class="btn" href="logout.php">Salir</a></p>
        </header>

        <main class="content">
            <h2>Tus alquileres actuales</h2>
            <?php
            $alquileres = $cliente->getAlquileres();
            if (empty($alquileres)) {
                echo "<p class='muted'>No tienes alquileres en este momento.</p>";
            } else {
                echo "<ul class='list alquileres'>";
                foreach ($alquileres as $a) {
                    echo "<li>" . htmlspecialchars($a->getNumero() . " - " . $a->getTitulo()) . "</li>";
                }
                echo "</ul>";
            }
            ?>
        </main>
    </div>
</body>
</html>