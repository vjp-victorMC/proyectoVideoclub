<?php
require_once __DIR__ . '/../autoload.php';

use Dwes\ProyectoVideoclub\Videoclub;


$vc = new Videoclub("Severo 8A");


//voy a incluir unos cuantos soportes de prueba 
$vc->incluirJuego("God of War", 19.99, "PS4", 1, 1);
$vc->incluirJuego("The Last of Us Part II", 49.99, "PS4", 1, 1);
$vc->incluirDvd("Torrente", 4.5, "es", "16:9");
$vc->incluirDvd("Origen", 4.5, "es,en,fr", "16:9");
$vc->incluirDvd("El Imperio Contraataca", 3, "es,en", "16:9");
$vc->incluirCintaVideo("Los cazafantasmas", 3.5, 107);
$vc->incluirCintaVideo("El nombre de la Rosa", 1.5, 140);

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