<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dwes\ProyectoVideoclub\Videoclub;


$vc = new Videoclub("Severo 8A");


//voy a incluir unos cuantos soportes de prueba 
//voy a incluir unos cuantos soportes de prueba 
$vc->incluirJuego("https://www.metacritic.com/game/playstation-4/god-of-war", "God of War", 19.99, "PS4", 1, 1);
$vc->incluirJuego("https://www.metacritic.com/game/playstation-4/the-last-of-us-part-ii", "The Last of Us Part II", 49.99, "PS4", 1, 1);
$vc->incluirDvd("https://www.metacritic.com/movie/torrente-el-brazo-tonto-de-la-ley", "Torrente", 4.5, "es", "16:9");
$vc->incluirDvd("https://www.metacritic.com/movie/inception", "Origen", 4.5, "es,en,fr", "16:9");
$vc->incluirDvd("https://www.metacritic.com/movie/star-wars-episode-v---the-empire-strikes-back", "El Imperio Contraataca", 3, "es,en", "16:9");
$vc->incluirCintaVideo("https://www.metacritic.com/movie/ghostbusters", "Los cazafantasmas", 3.5, 107);
$vc->incluirCintaVideo("https://www.metacritic.com/movie/the-name-of-the-rose", "El nombre de la Rosa", 1.5, 140);

//listo los productos 
$vc->listarProductos();

//voy a crear algunos socios 
$vc->incluirSocio("Amancio Ortega", 2);
$vc->incluirSocio("Pablo Picasso", 3);

$vc->alquilaSocioProducto(1, 2)
    ->alquilaSocioProducto(2, 3)
    ->alquilaSocioProducto(2, 3)
    //debe dejarme porque ya lo tiene alquilado 
    ->alquilaSocioProducto(1, 3) // no 
    ->alquilaSocioProducto(1, 6); // no se puede porque el socio 1 tiene 2 alquileres como máximo



echo "Mostrando Socios: <br>";
//listo los socios 

$vc->listarSocios();

$vc->devolverSocioProducto(1, 2);

$vc->devolverSocioProductos(1, [2, 3]);

echo "<br>Mostrando Socios después de devolver";

$vc->listarSocios();

// parte tres completamente funcional_comprovada

echo "<br><br>--- Puntuaciones de alquileres del Socio 1 ---<br>";
$reflection = new ReflectionClass($vc);
$propiedadSocios = $reflection->getProperty('socios');
$propiedadSocios->setAccessible(true);
$socios = $propiedadSocios->getValue($vc);
$cliente1 = null;
foreach($socios as $s) {
    if ($s->getNumero() == 1) {
        $cliente1 = $s;
        break;
    }
}

if ($cliente1) {
    $alquileres = $cliente1->getAlquileres();
    foreach ($alquileres as $soporte) {
        $puntuacion = $soporte->getPuntuacion();
        echo "<b>" . $soporte->getTitulo() . "</b> - Metacritic Score: " . $puntuacion . "<br>";
    }
} else {
    echo "No se encontró el cliente 1.";
}
