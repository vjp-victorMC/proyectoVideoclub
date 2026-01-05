<?php

namespace Dwes\ProyectoVideoclub;

use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\ClienteNoEncontradoException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

class Videoclub
{
    private $nombre;
    private $productos = []; // array de Soporte
    private $numProductos = 0;
    private $socios = []; // array de Cliente
    private $numSocios = 0;
    private $numProductosAlquilados;
    private $numTotalAlquileres;
    private $logger;

    public function __construct($nombre)
    {
        $this->nombre = $nombre;
        $this->logger = new Logger('VideoclubLogger');
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/videoclub.log', Level::Debug));
    }

    //Getters

    public function getNumProductosAlquilados()
    {
        return $this->numProductosAlquilados;
    }

    public function getNumTotalAlquileres()
    {
        return $this->numTotalAlquileres;
    }

    // Métodos públicos para crear soportes.

    public function incluirCintaVideo($titulo, $precio, $duracion)
    {
        $numero = $this->numProductos + 1;
        $cintaVideo = new CintaVideo($titulo, $numero, $precio, $duracion);
        $this->incluirProducto($cintaVideo);
    }

    public function incluirDvd($titulo, $precio, $idiomas, $pantalla)
    {
        $numero = $this->numProductos + 1;
        $dvd = new Dvd($titulo, $numero, $precio, $idiomas, $pantalla);
        $this->incluirProducto($dvd);
    }

    public function incluirJuego($titulo, $precio, $consola, $minJ, $maxJ)
    {
        $numero = $this->numProductos + 1;
        $juego = new Juego($titulo, $numero, $precio, $consola, $minJ, $maxJ);
        $this->incluirProducto($juego);
    }

    //Metodo que alquila todos los productos que le pasemos en un array, si no existe alguno de ellos, no alquila ninguno
    public function alquilarSocioProductos(int $numSocio, array $numerosProductos)
    {
        // Buscar el cliente
        $cliente = null;
        foreach ($this->socios as $s) {
            if ($s->getNumero() == $numSocio) {
                $cliente = $s;
                break;
            }
        }
        if ($cliente === null) {
            echo "<br>No existe el socio con número $numSocio.";
            return $this;
        }

        // Buscar los soportes y comprobar disponibilidad
        $soportes = [];
        foreach ($numerosProductos as $numSoporte) {
            $soporte = null;
            foreach ($this->productos as $p) {
                if ($p->getNumero() == $numSoporte) {
                    $soporte = $p;
                    break;
                }
            }
            if ($soporte === null) {
                $this->logger->warning("No existe el soporte con número $numSoporte.", ['num_soporte' => $numSoporte]);
                return $this;
            }
            if ($soporte->alquilado) {
                $this->logger->warning("El soporte con número $numSoporte ya está alquilado. No se realiza ningún alquiler.", ['num_soporte' => $numSoporte]);
                // return $this; // Corregido el original? El original hacia return $this. Mantenemos comportamiento.
                return $this;
            }
            $soportes[] = $soporte;
        }

        // Si todos están disponibles, alquilarlos
        foreach ($soportes as $soporte) {
            try {
                $cliente->alquilar($soporte);
                // El log de 'Alquilado soporte' ya está en Cliente::alquilar. 
                // Pero el enunciado dice "Siempre que se llame a un método del log, se le pasará como segundo parámetro la información que dispongamos."
                // Y "Sustituir los echo que haya en el código, que ahora pasarán por el log..."
                // Videoclub tenía: echo "<br>Has alquilado: " . $soporte->getTitulo();
                // Lo reemplazamos aquí también para cumplir con "Videoclub" log.
                $this->logger->info("Has alquilado: " . $soporte->getTitulo(), ['titulo' => $soporte->getTitulo(), 'cliente' => $cliente->getNumero()]);
            } catch (CupoSuperadoException $e) {
                $this->logger->warning("Error: " . $e->getMessage(), ['exception' => $e]);
                break; // Si supera el cupo, no sigue alquilando
            } catch (\Exception $e) {
                $this->logger->warning("Error inesperado: " . $e->getMessage(), ['exception' => $e]);
                break;
            }
        }

        return $this;
    }

    // Añade el soporte al array
    private function incluirProducto(Soporte $producto)
    {
        $this->productos[] = $producto;
        $this->numProductos++;
        $this->logger->info("Producto incluido: " . $producto->getTitulo() . " (Nº " . $producto->getNumero() . ")", ['titulo' => $producto->getTitulo(), 'numero' => $producto->getNumero()]);
    }

    // Socios
    public function incluirSocio($nombre, $maxAlquileresConcurrentes = 3)
    {
        $numero = $this->numSocios + 1;
        $socio = new Cliente($nombre, $numero, $maxAlquileresConcurrentes);
        $this->socios[] = $socio;
        $this->numSocios++;
        $this->logger->info("Socio incluido: " . $nombre . " (Nº " . $numero . ")", ['nombre' => $nombre, 'numero' => $numero]);
    }

    // Listados
    public function listarProductos()
    {
        $this->logger->info("Productos en " . $this->nombre . ":", ['videoclub' => $this->nombre]);
        if ($this->numProductos == 0) {
            $this->logger->info("No hay productos.", ['videoclub' => $this->nombre]);
            return;
        }
        foreach ($this->productos as $p) {
            $p->muestraResumen();
        }
    }

    public function listarSocios()
    {
        $this->logger->info("Socios en " . $this->nombre . ":", ['videoclub' => $this->nombre]);
        if ($this->numSocios == 0) {
            $this->logger->info("No hay socios.", ['videoclub' => $this->nombre]);
            return;
        }
        foreach ($this->socios as $socio) {
            $socio->muestraResumen();
            $socio->listaAlquileres();
        }
    }

    // Alquilar: busca cliente y soporte por número y delega en Cliente->alquilar()
    public function alquilaSocioProducto(int $numeroCliente, int $numeroSoporte)
    {
        $cliente = null;
        foreach ($this->socios as $s) {
            if ($s->getNumero() == $numeroCliente) {
                $cliente = $s;
                break;
            }
        }
        if ($cliente === null) {
            $this->logger->warning("No existe el socio con número $numeroCliente.", ['num_socio' => $numeroCliente]);
            return $this;
        }

        $soporte = null;
        foreach ($this->productos as $p) {
            if ($p->getNumero() == $numeroSoporte) {
                $soporte = $p;
                break;
            }
        }
        if ($soporte === null) {
            $this->logger->warning("No existe el soporte con número $numeroSoporte.", ['num_soporte' => $numeroSoporte]);
            return $this;
        }

        try {
            $cliente->alquilar($soporte);
            $this->logger->info("Has alquilado: " . $soporte->getTitulo(), ['titulo' => $soporte->getTitulo(), 'cliente' => $cliente->getNumero()]);
        } catch (SoporteYaAlquiladoException $e) {
            $this->logger->warning("Error: " . $e->getMessage(), ['exception' => $e]);
        } catch (CupoSuperadoException $e) {
            $this->logger->warning("Error: " . $e->getMessage(), ['exception' => $e]);
        } catch (SoporteNoEncontradoException $e) {
            $this->logger->warning("Error: " . $e->getMessage(), ['exception' => $e]);
        } catch (\Exception $e) {
            // Captura cualquier otra excepción inesperada
            $this->logger->warning("Error inesperado: " . $e->getMessage(), ['exception' => $e]);
        }

        return $this; // Encadenamiento
    }

    //Meotodo para devolver un producto

    public function devolverSocioProducto(int $numSocio, int $numeroProducto)
    {
        $cliente = null;
        foreach ($this->socios as $s) {
            if ($s->getNumero() == $numSocio) {
                $cliente = $s;
                break;
            }
        }
        if ($cliente === null) {
            $this->logger->warning("No existe el socio con número $numSocio.", ['num_socio' => $numSocio]);
            return $this;
        }

        $soporte = null;
        foreach ($this->productos as $p) {
            if ($p->getNumero() == $numeroProducto) {
                $soporte = $p;
                break;
            }
        }
        if ($soporte === null) {
            $this->logger->warning("No existe el soporte con número $numeroProducto.", ['num_soporte' => $numeroProducto]);
            return $this;
        }

        try {
            $cliente->devolver($soporte->getNumero());
            $this->logger->info("Has devuelto: " . $soporte->getTitulo(), ['titulo' => $soporte->getTitulo(), 'cliente' => $cliente->getNumero()]);
        } catch (SoporteNoEncontradoException $e) {
            $this->logger->warning("Error: " . $e->getMessage(), ['exception' => $e]);
        } catch (\Exception $e) {
            // Captura cualquier otra excepción inesperada
            $this->logger->warning("Error inesperado: " . $e->getMessage(), ['exception' => $e]);
        }
        return $this;
    }

    //Metodo para devolver varios productos

    public function devolverSocioProductos(int $numSocio, array $numerosProductos)
    {
        // Buscar el cliente
        $cliente = null;
        foreach ($this->socios as $s) {
            if ($s->getNumero() == $numSocio) {
                $cliente = $s;
                break;
            }
        }
        if ($cliente === null) {
            $this->logger->warning("No existe el socio con número $numSocio.", ['num_socio' => $numSocio]);
            return $this;
        }

        // Buscar los soportes y comprobar disponibilidad
        $soportes = [];
        foreach ($numerosProductos as $numSoporte) {
            $soporte = null;
            foreach ($this->productos as $p) {
                if ($p->getNumero() == $numSoporte) {
                    $soporte = $p;
                    break;
                }
            }
            if ($soporte === null) {
                $this->logger->warning("No existe el soporte con número $numSoporte.", ['num_soporte' => $numSoporte]);
                return $this;
            }
            if (!$soporte->alquilado) {
                $this->logger->warning("El soporte con número $numSoporte ya está devuelto. No se realiza ninguna devolución.", ['num_soporte' => $numSoporte]);
                return $this;
            }
            $soportes[] = $soporte;
        }

        // Si todos están disponibles, devolverlos
        foreach ($soportes as $soporte) {
            try {
                $cliente->devolver($soporte->getNumero());
                $this->logger->info("Has devuelto: " . $soporte->getTitulo(), ['titulo' => $soporte->getTitulo(), 'cliente' => $cliente->getNumero()]);
            } catch (\Exception $e) {
                $this->logger->warning("Error inesperado: " . $e->getMessage(), ['exception' => $e]);
                break;
            }
        }

        return $this;
    }
}
