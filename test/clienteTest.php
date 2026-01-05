<?php
namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Cliente;
use Dwes\ProyectoVideoclub\CintaVideo;

class ClienteTest extends TestCase {
    // Proveedor de datos (Ejercicio 552)
    public static function clientesProvider() {
        return [
            ["Socio A", 1, 3],
            ["Socio B", 2, 5],
            ["Socio C", 3, 0]
        ];
    }

    /** @dataProvider clientesProvider */
    public function testFuncionalidadCliente($nombre, $num, $cupo) {
        $c = new Cliente($nombre, $num, $cupo);
        $this->assertEquals($nombre, $c->nombre);
    }

    public function testAlquilerYaAlquiladoLanzaExcepcion() {
        $c = new Cliente("Juan", 1);
        $s = new CintaVideo("Peli", 1, 2, 90);
        $c->alquilar($s);
        
        $this->expectException(\Exception::class);
        $c->alquilar($s); // Intentar alquilar lo mismo dos veces
    }
}