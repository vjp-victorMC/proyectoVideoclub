<?php

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Dvd;

class SoporteTest extends TestCase 
{
    public function testMuestraResumenDvdDevuelveCadena() 
    {
        // Probamos con la nueva duración del ejercicio 562
        $dvd = new Dvd("Origen", 1, 15, "Español", "16:9", 148);
        $resultado = $dvd->muestraResumen();
        
        // Comprobamos que el return no es nulo y contiene datos
        $this->assertIsString($resultado);
        $this->assertStringContainsString("148 min", $resultado);
    }
}