<?php
include_once "CintaVideo.php";
include_once "Dvd.php";
include_once "Juego.php";
include_once "Cliente.php";

$cliente1 = new Cliente("Bruce Wayne", 23);
$cliente2 = new Cliente("Clark Kent", 33);

echo "<br>El número del cliente 1 es: " . $cliente1->getNumero();
echo "<br>El número del cliente 2 es: " . $cliente2->getNumero();

$soporte1 = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);
$soporte2 = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1);
$soporte3 = new Dvd("Origen", 24, 15, "es,en,fr", "16:9");
$soporte4 = new Dvd("El Imperio Contraataca", 4, 3, "es,en", "16:9");

$cliente1->alquilar($soporte1);
$cliente1->alquilar($soporte2);
$cliente1->alquilar($soporte3);

// Intento alquilar uno repetido
$cliente1->alquilar($soporte1);

// Intento alquilar un cuarto 
$cliente1->alquilar($soporte4);

// Intento devolver uno que no tiene
$cliente1->devolver(4);

// Devuelvo uno que si tiene
$cliente1->devolver(26);

// Alquilo otro
$cliente1->alquilar($soporte4);

// Listo los alquileres
$cliente1->listaAlquileres();

// Cliente 2 intenta devolver algo sin tener alquileres
$cliente2->devolver(2);
?>
