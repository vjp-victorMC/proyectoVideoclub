<?php
include_once "Soporte.php";
include_once "Cliente.php";
include_once "Dvd.php";
include_once "CintaVideo.php";
include_once "Juego.php";


class Videoclub
{
    private $nombre;
    private $productos = []; // array de Soporte
    private $numProductos = 0;
    private $socios = []; // array de Cliente
    private $numSocios = 0;

    public function __construct($nombre)
    {
        $this->nombre = $nombre;
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
            return false;
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
            return false;
        }

        // Utilizamos el metodo alquilar de la clase cliente para hacer el alquiler pasandole el soporte recibido por parametros.
        return $cliente->alquilar($soporte);
    }
}
