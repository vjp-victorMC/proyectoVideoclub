<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Soporte;

class SoporteTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        // Mock abstract class
        $soporte = $this->getMockForAbstractClass(
            Soporte::class, 
            ['meta_url', 'Titulo Test', 1, 10.0]
        );

        $this->assertEquals('Titulo Test', $soporte->getTitulo());
        $this->assertEquals(1, $soporte->getNumero());
        $this->assertEquals(10.0, $soporte->getPrecio());
    }

    public function testPrecioConIva()
    {
        $soporte = $this->getMockForAbstractClass(
            Soporte::class, 
            ['meta_url', 'Test', 1, 10.0]
        );

        // 10 + 21% = 12.1
        $this->assertEquals(12.1, $soporte->getPrecioConIva());
    }

    public function testMuestraResumenReturnsString()
    {
        $soporte = $this->getMockForAbstractClass(
            Soporte::class, 
            ['meta_url', 'Movie', 1, 5.0]
        );

        ob_start(); // Capture echo output
        $result = $soporte->muestraResumen();
        $output = ob_get_clean();

        // Check return value
        $this->assertStringContainsString('Título: Movie', $result);
        $this->assertStringContainsString('Número: 1', $result);
        $this->assertStringContainsString('Precio: 5', $result);

        // Check hashed output is same as return
        $this->assertEquals($result, $output);
    }
}
