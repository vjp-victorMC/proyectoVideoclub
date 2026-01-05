<?php
namespace Dwes\Videoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\Videoclub\Videoclub;
use Dwes\Videoclub\Exception\ClienteNoExisteException;

class VideoclubTest extends TestCase {
    private $vc;

    protected function setUp(): void {
        $this->vc = new Videoclub("Video-App");
    }

    // Ejercicio 561: TDD para ClienteNoExisteException
    public function testAlquilarLanzaExcepcionSiClienteNoExiste() {
        $this->expectException(ClienteNoExisteException::class);
        $this->vc->alquilarSocioProducto(999, 1);
    }

    // Ejercicio 553: Alquiler mediante array
    public function testAlquilarMultiplesProductos() {
        $this->vc->incluirSocio("Lucas"); // ID socio 0
        $this->vc->incluirCintaVideo("Peli 1", 1, 120); // ID prod 0
        $this->vc->incluirCintaVideo("Peli 2", 2, 90);  // ID prod 1
        
        $this->vc->alquilarSocioProductos(0, [0, 1]);
        
        $socios = $this->vc->getSocios();
        $this->assertCount(2, $socios[0]->getAlquileres());
    }
}