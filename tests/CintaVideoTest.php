<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\CintaVideo;

class CintaVideoTest extends TestCase
{
    public function testConstructor()
    {
        $cinta = new CintaVideo('meta_url', 'Cinta Test', 1, 3.0, 120);
        $this->assertInstanceOf(CintaVideo::class, $cinta);
    }

    public function testMuestraResumen()
    {
        $cinta = new CintaVideo('http://meta.com', 'Cinta 1', 2, 4.0, 90);

        ob_start();
        $result = $cinta->muestraResumen();
        ob_get_clean();

        $this->assertStringContainsString('Cinta 1', $result);
        $this->assertStringContainsString('90 minutos', $result);
        $this->assertStringContainsString('http://meta.com', $result);
        $this->assertStringContainsString('Precio con IVA', $result);
    }
}
