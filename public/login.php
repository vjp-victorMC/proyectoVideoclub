<?php
// Recuperamos/arrancamos sesión para poder comprobar si ya hay datos del videoclub cargados
if (!isset($_SESSION)) {
    session_start();
}

// Comprobamos si ya se ha enviado el formulario
if (isset($_POST['enviar'])) {
    $usuario = $_POST['inputUsuario'];
    $password = $_POST['inputPassword'];

    // validamos que recibimos ambos parámetros
    if (empty($usuario) || empty($password)) {
        $error = "Debes introducir un usuario y contraseña";
        include "index.php";
        exit;
    }

    // Si existen datos del videoclub en sesión (los creó el admin anteriormente),
    if (!empty($_SESSION['videoclub']['socios'])) {
        // DEBUG TEMPORAL: registra los socios cargados
        // error_log('VIDECLUB socios: ' . print_r($_SESSION['videoclub']['socios'], true));

        foreach ($_SESSION['videoclub']['socios'] as $socioData) {
            $sUsuario = trim((string)($socioData['usuario'] ?? ''));
            $sPassword = trim((string)($socioData['password'] ?? ''));

            // sólo intentamos comparar si ambos campos existen en el array de socio
            if ($sUsuario !== '' && $sPassword !== '' &&
                $sUsuario === trim((string)$usuario) && $sPassword === trim((string)$password)) {

                // Cargamos autoload si no está cargado aún
                require_once __DIR__ . '/../autoload.php';

                // Creamos la instancia Cliente
                $cliente = new \Dwes\ProyectoVideoclub\Cliente(
                    $socioData['nombre'] ?? '',
                    $socioData['numero'] ?? 0,
                    $socioData['maxAlquileres'] ?? 3,
                    $sUsuario,
                    $sPassword
                );

                $_SESSION['usuario'] = $sUsuario;
                $_SESSION['cliente'] = $cliente;

                include "mainCliente.php";
                exit;
            }
        }

        // Si llegamos aquí no se encontró coincidencia entre socios
    }

    // Si no coincide con un socio, manejamos usuario/admin fijo
    if ($usuario === "usuario" && $password === "usuario") {
        $_SESSION['usuario'] = $usuario;
        include "main.php";
        exit;
    } elseif ($usuario === "admin" && $password === "admin") {
        $_SESSION['usuario'] = $usuario;

        // Creamos aquí los arrays asociativos con los datos de ejemplo (ahora con usuario/password)
        $productos = [
            ['tipo' => 'Juego', 'titulo' => 'God of War', 'numero' => 1, 'precio' => 19.99, 'consola' => 'PS4', 'min' => 1, 'max' => 1],
            ['tipo' => 'Juego', 'titulo' => 'The Last of Us Part II', 'numero' => 2, 'precio' => 49.99, 'consola' => 'PS4', 'min' => 1, 'max' => 1],
            ['tipo' => 'Dvd', 'titulo' => 'Torrente', 'numero' => 3, 'precio' => 4.5, 'idiomas' => 'es', 'pantalla' => '16:9'],
            ['tipo' => 'Dvd', 'titulo' => 'Origen', 'numero' => 4, 'precio' => 4.5, 'idiomas' => 'es,en,fr', 'pantalla' => '16:9'],
            ['tipo' => 'Dvd', 'titulo' => 'El Imperio Contraataca', 'numero' => 5, 'precio' => 3.0, 'idiomas' => 'es,en', 'pantalla' => '16:9'],
            ['tipo' => 'CintaVideo', 'titulo' => 'Los cazafantasmas', 'numero' => 6, 'precio' => 3.5, 'duracion' => 107],
            ['tipo' => 'CintaVideo', 'titulo' => 'El nombre de la Rosa', 'numero' => 7, 'precio' => 1.5, 'duracion' => 140],
        ];

        // Añadimos ahora credenciales a los socios de ejemplo
        $socios = [
            ['nombre' => 'Amancio Ortega', 'numero' => 1, 'maxAlquileres' => 2, 'usuario' => 'amancio', 'password' => 'amancio123'],
            ['nombre' => 'Pablo Picasso', 'numero' => 2, 'maxAlquileres' => 3, 'usuario' => 'pablo', 'password' => 'pablo123'],
        ];

        // Guardamos en la sesión bajo una clave del videoclub 
        $_SESSION['videoclub'] = [
            'nombre' => 'Severo 8A',
            'productos' => $productos,
            'socios' => $socios,
            'numProductos' => count($productos),
            'numSocios' => count($socios)
        ];

        include "mainAdmin.php";
        exit;
    } else {
        // Si las credenciales no son válidas, se vuelven a pedir
        $error = "Usuario o contraseña no válidos!";
        include "index.php";
        exit;
    }
}
