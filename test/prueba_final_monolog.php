<?php
// test/prueba_final_monolog.php
require_once __DIR__ . '/../vendor/autoload.php';

use Dwes\ProyectoVideoclub\Videoclub;

// 1. Limpiamos el log anterior para ver solo lo nuevo
$logFile = __DIR__ . '/../logs/videoclub.log';
if (file_exists($logFile)) {
    unlink($logFile);
    echo "Log anterior borrado.\n";
}

echo "Iniciando prueba de Videoclub con LogFactory...\n";

// 2. Creamos videoclub y añadimos datos
$vc = new Videoclub("VideoClub Malla");
$vc->incluirSocio("Cliente Vip", 1);
$vc->incluirJuego("Final Fantasy VII", 49.99, "PS1", 1, 1); // Producto 1

// 3. Operaciones que generan logs
echo "Realizando alquiler (debería generar INFO en el log)...\n";
$vc->alquilaSocioProducto(1, 1);

echo "Intentando alquilar lo mismo (debería generar WARNING en el log)...\n";
$vc->alquilaSocioProducto(1, 1);

echo "Devolviendo producto (debería generar INFO en el log)...\n";
$vc->devolverSocioProducto(1, 1);

// 4. Mostramos el contenido del log
echo "\n--- CONTENIDO DE LOGS/VIDEOCLUB.LOG ---\n";
if (file_exists($logFile)) {
    echo file_get_contents($logFile);
} else {
    echo "ERROR: El archivo de log no se ha creado.";
}
echo "--- FIN DEL LOG ---\n";
