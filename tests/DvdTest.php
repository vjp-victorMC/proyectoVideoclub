<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Dvd;

class DvdTest extends TestCase
{
    public function testConstructor()
    {
        $dvd = new Dvd('meta', 'Dvd Test', 1, 5.0, 'en,es', '16:9', 120);
        $this->assertInstanceOf(Dvd::class, $dvd);
    }

    public function testMuestraResumen()
    {
        $dvd = new Dvd('http://meta.com', 'Dvd Test', 1, 5.0, 'en,es', '16:9', 120);

        ob_start();
        $result = $dvd->muestraResumen();
        ob_get_clean();

        $this->assertStringContainsString('Idiomas: en,es', $result);
        $this->assertStringContainsString('Pantalla: 16:9', $result);
        $this->assertStringContainsString('http://meta.com', $result);
    }
}
