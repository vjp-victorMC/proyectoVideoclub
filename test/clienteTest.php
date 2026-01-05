<?php
// Ejercicio 552: Pruebas para la clase Cliente con proveedores de datos
namespace Dwes\Videoclub\Tests;

use PHPUnit\Framework\TestCase;
use Dwes\Videoclub\Cliente;
use Dwes\Videoclub\CintaVideo;
use Dwes\Videoclub\Util\SoporteYaAlquiladoException; // Asumiendo este nombre

class ClienteTest extends TestCase {

    public function clienteProvider() {
        return [
            "Cliente Platino" => ["Pepe", 1, 5],
            "Cliente Estándar" => ["Ana", 2, 3],
            "Cliente Nuevo" => ["Luis", 3, 1]
        ];
    }

    /** @dataProvider clienteProvider */
    public function testCuposDiferentes($nombre, $id, $cupo) {
        $c = new Cliente($nombre, $id, $cupo);
        $this->assertEquals($cupo, $c->getLimiteAlquileres());
    }

    public function testNoSePuedeAlquilarSoporteYaAlquilado() {
        $c = new Cliente("Test", 1);
        $s = new CintaVideo("Peli", 1, 2, 90);
        
        $c->alquilar($s); // Primer alquiler OK
        
        $this->expectException(\Exception::class); // O SoporteYaAlquiladoException
        $c->alquilar($s); // Debería fallar
    }
}