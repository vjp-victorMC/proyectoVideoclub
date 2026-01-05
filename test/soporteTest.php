<?php
// Ejercicio 551: Pruebas para las clases de Soporte
namespace Dwes\Videoclub\Tests;

use PHPUnit\Framework\TestCase;
use Dwes\Videoclub\CintaVideo;
use Dwes\Videoclub\Dvd;
use Dwes\Videoclub\Juego;

class SoporteTest extends TestCase {
    
    public function testMuestraResumenCintaVideo() {
        $cinta = new CintaVideo("Los Cazafantasmas", 1, 3.5, 120);
        $resumen = $cinta->muestraResumen();
        // Comprobamos que el método devuelve el string además de hacer echo
        $this->assertStringContainsString("Los Cazafantasmas", $resumen);
        $this->assertStringContainsString("120", $resumen);
    }

    public function testMuestraResumenDvd() {
        // En 551 el DVD aún no tiene duración (se añade en 562)
        $dvd = new Dvd("Origen", 2, 4.5, "es,en", "16:9");
        $resumen = $dvd->muestraResumen();
        $this->assertStringContainsString("Origen", $resumen);
    }

    public function testMuestraResumenJuego() {
        $juego = new Juego("Zelda", 3, 5, "Switch", 1, 1);
        $resumen = $juego->muestraResumen();
        $this->assertStringContainsString("Zelda", $resumen);
        $this->assertStringContainsString("Switch", $resumen);
    }
}