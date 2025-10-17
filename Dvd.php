<?php
include_once "Soporte.php";

class Dvd extends Soporte
{
    private $idiomas;
    private $formatPantalla;

    public function __construct($titulo, $numero, $precio, $idiomas, $pantalla)
    {
        parent::__construct($titulo, $numero, $precio);
        $this->idiomas = $idiomas;
        $this->formatPantalla = $pantalla;
    }

    public function getPrecioConIva()
    {
        return $this->getPrecio() * 1.21; 
    }

    public function muestraResumen()
    {
        echo "<br>Título: " . $this->getTitulo();
        echo "<br>Número: " . $this->getNumero();
        echo "<br>Idiomas: " . $this->idiomas;
        echo "<br>Pantalla: " . $this->formatPantalla;
        echo "<br>Precio: " . $this->getPrecio() . " euros (IVA no incluido)";
        echo "<br>Precio con IVA: " . $this->getPrecioConIva() . " euros";
    }
}
?>
