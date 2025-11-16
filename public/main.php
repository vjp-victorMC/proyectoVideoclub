<?php
// Recuperamos la información de la sesión
if (!isset($_SESSION)) {
    session_start();
}

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario'])) {
    die("Error - debe <a href='index.php'>identificarse</a>.<br />");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="wrap">
        <header class="site-header">
            <h1>Bienvenido al Videoclub <?= htmlspecialchars($_SESSION['usuario']) ?></h1>
            <p class="logout"><a class="btn" href="logout.php">Salir</a></p>
        </header>
        <main class="content">
            <!-- contenido -->
        </main>
    </div>
</body>

</html>