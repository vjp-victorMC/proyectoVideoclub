<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Juego;

class JuegoTest extends TestCase
{
    public function testConstructorAndResumen()
    {
        $juego = new Juego('meta', 'Game', 1, 20.0, 'PS4', 1, 1);
        
        ob_start();
        $result = $juego->muestraResumen();
        ob_get_clean();

        $this->assertStringContainsString('PS4', $result);
        $this->assertStringContainsString('Para un jugador', $result);
    }

    public function testJugadoresPosibles()
    {
        // 1-1
        $j1 = new Juego('m', 'G1', 1, 1, 'C', 1, 1);
        $this->assertEquals('Para un jugador', $j1->muestraJugadoresPosibles());

        // 2-2
        $j2 = new Juego('m', 'G2', 1, 1, 'C', 2, 2);
        $this->assertEquals('Para 2 jugadores', $j2->muestraJugadoresPosibles());

        // 1-4
        $j3 = new Juego('m', 'G3', 1, 1, 'C', 1, 4);
        $this->assertEquals('De 1 a 4 jugadores', $j3->muestraJugadoresPosibles());
    }
}
