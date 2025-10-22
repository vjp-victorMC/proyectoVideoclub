<?php

use Dwes\ProyectoVideoclub\CintaVideo;
use Dwes\ProyectoVideoclub\DVD;
use Dwes\ProyectoVideoclub\Juego;

require_once __DIR__ . '/../autoload.php';

$miCinta = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);
echo "<strong>" . $miCinta->getTitulo() . "</strong>";
echo "<br>Precio: " . $miCinta->getPrecio() . " euros";
echo "<br>Precio IVA incluido: " . $miCinta->getPrecioConIva() . " euros";
$miCinta->muestraResumen();


// Probando DVD


$miDvd = new Dvd("Origen", 24, 15, "es,en,fr", "16:9");
echo "<strong>" . $miDvd->getTitulo() . "</strong>";
echo "<br>Precio: " . $miDvd->getPrecio() . " euros";
echo "<br>Precio IVA incluido: " . $miDvd->getPrecioConIva() . " euros";
$miDvd->muestraResumen();

// Probando Juego


$miJuego = new Juego("<br>The Last of Us Part II", 26, 49.99, "PS4", 2, 10);
echo "<strong>" . $miJuego->getTitulo() . "</strong>";
echo "<br>Precio: " . $miJuego->getPrecio() . " euros";
echo "<br>Precio IVA incluido: " . $miJuego->getPrecioConIva() . " euros";
$miJuego->muestraResumen();

// parte uno funcional_comprovada