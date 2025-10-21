<?php
spl_autoload_register(function ($class) {
    // Elimina el namespace base
    $prefix = 'Dwes\\ProyectoVideoclub\\';
    $base_dir = __DIR__ . '/app/';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        // No es de nuestro namespace
        return;
    }
    // Obtén el nombre relativo de la clase
    $relative_class = substr($class, strlen($prefix));
    // Reemplaza los separadores de namespace por /
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
