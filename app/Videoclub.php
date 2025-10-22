<?php

namespace Dwes\ProyectoVideoclub;

use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\ClienteNoEncontradoException;

class Videoclub
{
    private $nombre;
    private $productos = []; // array de Soporte
    private $numProductos = 0;
    private $socios = []; // array de Cliente
    private $numSocios = 0;
    private $numProductosAlquilados;
    private $numTotalAlquileres;

    public function __construct($nombre)
    {
        $this->nombre = $nombre;
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

    //Metodo que alquila todos los productos que le pasemos en un array, si no existe alguno de ellos, no alquila ninguno.
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
                echo "<br>No existe el soporte con número $numSoporte.";
                return $this;
            }
            if ($soporte->alquilado) {
                echo "<br>El soporte con número $numSoporte ya está alquilado. No se realiza ningún alquiler.";
                return $this;
            }
            $soportes[] = $soporte;
        }

        // Si todos están disponibles, alquilarlos
        foreach ($soportes as $soporte) {
            try {
                $cliente->alquilar($soporte);
                echo "<br>Has alquilado: " . $soporte->getTitulo();
            } catch (CupoSuperadoException $e) {
                echo "<br>Error: " . $e->getMessage();
                break; // Si supera el cupo, no sigue alquilando
            } catch (\Exception $e) {
                echo "<br>Error inesperado: " . $e->getMessage();
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
        echo "<br>Producto incluido: " . $producto->getTitulo() . " (Nº " . $producto->getNumero() . ")";
    }

    // Socios
    public function incluirSocio($nombre, $maxAlquileresConcurrentes = 3)
    {
        $numero = $this->numSocios + 1;
        $socio = new Cliente($nombre, $numero, $maxAlquileresConcurrentes);
        $this->socios[] = $socio;
        $this->numSocios++;
        echo "<br>Socio incluido: " . $nombre . " (Nº " . $numero . ")";
    }

    // Listados
    public function listarProductos()
    {
        echo "<br><br>Productos en " . $this->nombre . ":<br>";
        if ($this->numProductos == 0) {
            echo "No hay productos.<br>";
            return;
        }
        foreach ($this->productos as $p) {
            $p->muestraResumen();
        }
    }

    public function listarSocios()
    {
        echo "<br><br>Socios en " . $this->nombre . ":<br>";
        if ($this->numSocios == 0) {
            echo "No hay socios.<br>";
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
            echo "<br>No existe el socio con número $numeroCliente.";
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
            echo "<br>No existe el soporte con número $numeroSoporte.";
            return $this;
        }

        try {
            $cliente->alquilar($soporte);
            echo "<br>Has alquilado: " . $soporte->getTitulo();
        } catch (SoporteYaAlquiladoException $e) {
            echo "<br>Error: " . $e->getMessage();
        } catch (CupoSuperadoException $e) {
            echo "<br>Error: " . $e->getMessage();
        } catch (SoporteNoEncontradoException $e) {
            echo "<br>Error: " . $e->getMessage();
        } catch (\Exception $e) {
            // Captura cualquier otra excepción inesperada
            echo "<br>Error inesperado: " . $e->getMessage();
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
            echo "<br>No existe el socio con número $numSocio.";
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
            echo "<br>No existe el soporte con número $numeroProducto.";
            return $this;
        }

        try {
            $cliente->devolver($soporte->getNumero());
            echo "<br>Has devuelto: " . $soporte->getTitulo();
        } catch (SoporteNoEncontradoException $e) {
            echo "<br>Error: " . $e->getMessage();
        } catch (\Exception $e) {
            // Captura cualquier otra excepción inesperada
            echo "<br>Error inesperado: " . $e->getMessage();
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
                echo "<br>No existe el soporte con número $numSoporte.";
                return $this;
            }
            if (!$soporte->alquilado) {
                echo "<br>El soporte con número $numSoporte ya está devuelto. No se realiza ninguna devolución.";
                return $this;
            }
            $soportes[] = $soporte;
        }

        // Si todos están disponibles, devolverlos
        foreach ($soportes as $soporte) {
            try {
                $cliente->devolver($soporte->getNumero());
                echo "<br>Has devuelto: " . $soporte->getTitulo();
            } catch (\Exception $e) {
                echo "<br>Error inesperado: " . $e->getMessage();
                break;
            }
        }

        return $this;
    }
}
