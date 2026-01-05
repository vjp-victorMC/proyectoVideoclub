<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Videoclub;
use ReflectionClass;

class VideoclubTest extends TestCase
{
    private $vc;

    protected function setUp(): void
    {
        $this->vc = new Videoclub("VideoTest");
    }

    // Helper para acceder a propiedades privadas
    private function getPrivateProperty($object, $propertyName)
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        return $property->getValue($object);
    }

    public function testIncluirProductos()
    {
        $this->vc->incluirCintaVideo("meta", "Cinta 1", 10, 100);
        $this->vc->incluirDvd("meta", "DVD 1", 10, "es", "16:9");
        $this->vc->incluirJuego("meta", "Juego 1", 10, "PS4", 1, 1);

        $productos = $this->getPrivateProperty($this->vc, 'productos');
        $this->assertCount(3, $productos);
        $this->assertEquals("Cinta 1", $productos[0]->getTitulo());
    }

    public function testIncluirSocio()
    {
        $this->vc->incluirSocio("Socio 1");
        $this->vc->incluirSocio("Socio 2");

        $socios = $this->getPrivateProperty($this->vc, 'socios');
        $this->assertCount(2, $socios);
        $this->assertEquals(1, $socios[0]->getNumero());
    }

    public function testAlquilerIndividualExito()
    {
        $this->vc->incluirSocio("Juan");
        $this->vc->incluirJuego("meta", "Game", 10, "PC", 1, 1); // Producto 1

        // Alquilar Juego (1) a Socio (1)
        $this->vc->alquilaSocioProducto(1, 1);

        $socios = $this->getPrivateProperty($this->vc, 'socios');
        $cliente = $socios[0];
        
        $productos = $this->getPrivateProperty($this->vc, 'productos');
        $juego = $productos[0];

        $this->assertTrue($juego->alquilado);
        $this->assertTrue($cliente->tieneAlquilado($juego));
    }

    public function testAlquilerArrayExito()
    {
        $this->vc->incluirSocio("Ana");
        $this->vc->incluirJuego("m", "G1", 1, "P", 1, 1); // 1
        $this->vc->incluirJuego("m", "G2", 1, "P", 1, 1); // 2

        // Alquilar array [1, 2] a Socio 1
        $this->vc->alquilarSocioProductos(1, [1, 2]);

        $socios = $this->getPrivateProperty($this->vc, 'socios');
        $cliente = $socios[0];
        
        $this->assertEquals(2, $cliente->getNumSoportesAlquilados());
    }

    public function testAlquilerArrayFallaSiUnoNoExiste()
    {
        $this->vc->incluirSocio("Ana");
        $this->vc->incluirJuego("m", "G1", 1, "P", 1, 1); // 1

        // Intentar alquilar 1 (existe) y 99 (no existe)
        // La implementacion actual NO alquila ninguno si uno falla (linea 131 de Videoclub.php return $this)
        $this->vc->alquilarSocioProductos(1, [1, 99]);

        $socios = $this->getPrivateProperty($this->vc, 'socios');
        $cliente = $socios[0];

        // No debió alquilarse nada
        $this->assertEquals(0, $cliente->getNumSoportesAlquilados());
    }

    public function testAlquilerArrayFallaSiUnoYaAlquilado()
    {
        $this->vc->incluirSocio("Ana");
        $this->vc->incluirJuego("m", "G1", 1, "P", 1, 1); // 1
        $this->vc->incluirJuego("m", "G2", 1, "P", 1, 1); // 2

        // Alquilamos el 1 primero
        $this->vc->alquilaSocioProducto(1, 1);

        // Intentamos alquilar [1, 2]. El 1 ya está alquilado.
        // La implementación actual aborta si cualquiera está alquilado.
        $this->vc->alquilarSocioProductos(1, [1, 2]);

        $socios = $this->getPrivateProperty($this->vc, 'socios');
        $cliente = $socios[0];

        // Solo debe tener 1 alquilado (el inicial), no el 2.
        $this->assertEquals(1, $cliente->getNumSoportesAlquilados());
        
        $productos = $this->getPrivateProperty($this->vc, 'productos');
        $this->assertTrue($productos[0]->alquilado); // G1
        $this->assertFalse($productos[1]->alquilado); // G2 no se alquiló
    }

    public function testDevolucionIndividual()
    {
        $this->vc->incluirSocio("Pepe");
        $this->vc->incluirDvd("m", "D1", 1, "en", "16:9"); // 1
        
        $this->vc->alquilaSocioProducto(1, 1);
        
        // Verificar alquilado
        $socios = $this->getPrivateProperty($this->vc, 'socios');
        $this->assertTrue($socios[0]->tieneAlquilado($this->getPrivateProperty($this->vc, 'productos')[0]));

        // Devolver
        $this->vc->devolverSocioProducto(1, 1);
        
        // Verificar devuelto
        $this->assertFalse($socios[0]->tieneAlquilado($this->getPrivateProperty($this->vc, 'productos')[0]));
        $this->assertFalse($this->getPrivateProperty($this->vc, 'productos')[0]->alquilado);
    }

    public function testDevolucionArray()
    {
        $this->vc->incluirSocio("Pepe");
        $this->vc->incluirDvd("m", "D1", 1, "en", "16:9"); // 1
        $this->vc->incluirDvd("m", "D2", 1, "en", "16:9"); // 2
        
        $this->vc->alquilarSocioProductos(1, [1, 2]);
        
        $this->vc->devolverSocioProductos(1, [1, 2]);
        
        $socios = $this->getPrivateProperty($this->vc, 'socios');
        $this->assertEquals(0, $socios[0]->getNumSoportesAlquilados());
    }
}
