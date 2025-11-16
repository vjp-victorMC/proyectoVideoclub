<?php
// Recuperamos la información de la sesión
if (!isset($_SESSION)) {
    session_start();
}

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario'])) {
    die("Error - debe <a href='index.php'>identificarse</a>.<br />");
}

// Obtenemos los datos del videoclub desde la sesión (si existen)
$vc = $_SESSION['videoclub'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Admin</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="wrap">
        <header class="site-header">
            <h1>Bienvenido al Videoclub <?= htmlspecialchars($_SESSION['usuario']) ?></h1>
            <p class="logout"><a class="btn" href="logout.php">Salir</a></p>
        </header>

        <main class="content">
            <section>
                <h2>Listado de clientes</h2>
                <?php if ($vc && !empty($vc['socios'])): ?>
                <ul class="list clientes">
                    <?php foreach ($vc['socios'] as $s): ?>
                    <?php
                        $num = htmlspecialchars($s['numero'] ?? '');
                        $nombre = htmlspecialchars($s['nombre'] ?? '');
                        $max = htmlspecialchars($s['maxAlquileres'] ?? '');
                        $usuario = isset($s['usuario']) ? ' - usuario: ' . htmlspecialchars($s['usuario']) : '';
                    ?>
                    <li><?= "{$num} - {$nombre} (max {$max})" . $usuario ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p class="muted">No hay socios cargados.</p>
                <?php endif; ?>
            </section>

            <section>
                <h2>Listado de soportes</h2>
                <?php if ($vc && !empty($vc['productos'])): ?>
                <ul class="list soportes">
                    <?php foreach ($vc['productos'] as $p): ?>
                    <li>
                        <?= htmlspecialchars($p['numero'] . ' - ' . $p['titulo'] . ' [' . $p['tipo'] . '] - ' . $p['precio'] . '€') ?>
                        <?php
                            if ($p['tipo'] === 'Juego') {
                                echo ' - Consola: ' . htmlspecialchars($p['consola']) . ' - Jugadores: ' . htmlspecialchars($p['min']) . ($p['min'] !== $p['max'] ? ' a ' . htmlspecialchars($p['max']) : '');
                            } elseif ($p['tipo'] === 'Dvd') {
                                echo ' - Idiomas: ' . htmlspecialchars($p['idiomas']) . ' - Pantalla: ' . htmlspecialchars($p['pantalla']);
                            } elseif ($p['tipo'] === 'CintaVideo') {
                                echo ' - Duración: ' . htmlspecialchars($p['duracion']) . ' min';
                            }
                        ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p class="muted">No hay soportes cargados.</p>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>

</html>