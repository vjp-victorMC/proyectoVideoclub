<?php
// ejercicio 323 del projecto
include_once "Soporte.php";

class CintaVideo extends Soporte
{
    private $duracion;

    public function __construct($titulo, $numero, $precio, $duracion)
    {
        parent::__construct($titulo, $numero, $precio);
        $this->duracion = $duracion;
    }

    public function getPrecioConIva()
    {
        // Usamos el getter del padre para acceder al precio
        return $this->getPrecio() * 1.21;
    }

    public function muestraResumen()
    {
        echo "<br>Título: " . $this->getTitulo();
        echo "<br>Número: " . $this->getNumero();
        echo "<br>Duración: " . $this->duracion . " minutos";
        echo "<br>Precio: " . $this->getPrecio() . " euros (IVA no incluido)";
        echo "<br>Precio con IVA: " . $this->getPrecioConIva() . " euros";
    }
}
// ejercicio terminado sigue 324

?>
