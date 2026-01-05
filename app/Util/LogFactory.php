<?php

namespace Dwes\ProyectoVideoclub\Util;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Psr\Log\LoggerInterface;

class LogFactory
{
    /**
     * Devuelve una instancia de Logger configurada.
     *
     * @param string $canal Nombre del canal del logger.
     * @return LoggerInterface Instancia de un Logger (PSR-3).
     */
    public static function getLogger(string $canal = 'VideoclubLogger'): LoggerInterface
    {
        $log = new Logger($canal);
        // Ajustamos la ruta al archivo de log (subiendo 3 niveles desde Util: Util -> app -> proyecto -> root -> logs)
        // app/Util/LogFactory.php -> __DIR__ is .../app/Util
        // ../../logs : ../ (app) -> ../ (proyecto) -> /logs
        $log->pushHandler(new StreamHandler(__DIR__ . '/../../logs/videoclub.log', Level::Debug));

        return $log;
    }
}
