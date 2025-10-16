<?php
class Soporte
{
    public $titulo;
    public $numero;
    public $precio;

    const IVA = 21;

    public function __construct($titulo, $numero, $precio)
    {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }

    public function getPrecio()
    {
        return $this->precio;
    }
    public function getPrecioConIva()
    {
        $precioConIva = $this->precio;
        return $precioConIva += $precioConIva * self::IVA / 100;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function muestraResumen()
    {
        echo "<br>Titulo: " . $this->titulo . "<br>";
        echo "Numero: " . $this->numero . "<br>";
        echo "Precio: " . $this->precio . "(IVA no incluido)<br>";
    }
}
