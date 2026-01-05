<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Cliente;
use Dwes\ProyectoVideoclub\Soporte;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;

class ClienteTest extends TestCase
{
    public function testConstructor()
    {
        $cliente = new Cliente('Juan', 1, 5, 'juan.user', 'pass123');
        $this->assertEquals(1, $cliente->getNumero());
        $this->assertEquals('juan.user', $cliente->getUsuario());
        $this->assertEquals(0, $cliente->getNumSoportesAlquilados());
    }

    /**
     * @dataProvider supportsProvider
     */
    public function testAlquilarExito($supports)
    {
        // Cliente con cupo suficiente
        $cliente = new Cliente('Test', 1, 10);
        
        foreach ($supports as $data) {
            // Pasamos los datos reales al constructor del mock
            $soporte = $this->getMockForAbstractClass(
                Soporte::class, 
                ['meta', $data['titulo'], $data['numero'], 10]
            );
            
            // No necesitamos stubear getNumero ni getTitulo si el constructor real funciona
            // $soporte->method('getNumero')->willReturn($data['numero']); 
            
            $cliente->alquilar($soporte);
            
            // Verificar estado del soporte y del cliente
            $this->assertTrue($soporte->alquilado);
            $this->assertTrue($cliente->tieneAlquilado($soporte));
        }

        $this->assertEquals(count($supports), $cliente->getNumSoportesAlquilados());
    }

    public static function supportsProvider()
    {
        return [
            'un soporte' => [[
                ['titulo' => 'Soporte 1', 'numero' => 101]
            ]],
            'tres soportes' => [[
                ['titulo' => 'Soporte 1', 'numero' => 101],
                ['titulo' => 'Soporte 2', 'numero' => 102],
                ['titulo' => 'Soporte 3', 'numero' => 103]
            ]]
        ];
    }

    public function testSoporteYaAlquiladoLanzaExcepcion()
    {
        $cliente = new Cliente('Test', 1);
        // Creamos un soporte real (mock abstracto) con número 1
        $soporte = $this->getMockForAbstractClass(Soporte::class, ['m', 'Repetido', 1, 1]);
        
        $cliente->alquilar($soporte);

        $this->expectException(SoporteYaAlquiladoException::class);
        $cliente->alquilar($soporte);
    }

    /**
     * @dataProvider cupoProvider
     */
    public function testCupoSuperadoLanzaExcepcion($maxAlquileres, $soportesParaAlquilar)
    {
        $cliente = new Cliente('Test', 1, $maxAlquileres);
        
        // Alquilar hasta el límite
        foreach ($soportesParaAlquilar as $index => $data) {
            $soporte = $this->getMockForAbstractClass(
                Soporte::class, 
                ['m', $data['titulo'], $data['numero'], 1]
            );

            if ($index < $maxAlquileres) {
                $cliente->alquilar($soporte);
            } else {
                // El siguiente debe fallar
                $this->expectException(CupoSuperadoException::class);
                $cliente->alquilar($soporte);
            }
        }
    }

    public static function cupoProvider()
    {
        return [
            'cupo 1, intento 2' => [
                1, 
                [
                    ['titulo' => 'A', 'numero' => 1],
                    ['titulo' => 'B', 'numero' => 2]
                ]
            ],
            'cupo 2, intento 3' => [
                2, 
                [
                    ['titulo' => 'A', 'numero' => 1],
                    ['titulo' => 'B', 'numero' => 2],
                    ['titulo' => 'C', 'numero' => 3]
                ]
            ]
        ];
    }

    public function testDevolver()
    {
        $cliente = new Cliente('Test', 1);
        $soporte = $this->getMockForAbstractClass(Soporte::class, ['m', 'T', 55, 1]);

        $cliente->alquilar($soporte);
        $this->assertEquals(1, $cliente->getNumSoportesAlquilados());
        $this->assertTrue($soporte->alquilado);

        $cliente->devolver(55);
        $this->assertEquals(0, $cliente->getNumSoportesAlquilados());
        $this->assertFalse($soporte->alquilado);
    }

    public function testDevolverNoEncontradoExcepcion()
    {
        $cliente = new Cliente('Test', 1);
        $this->expectException(SoporteNoEncontradoException::class);
        $cliente->devolver(999);
    }
}
