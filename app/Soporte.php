<?php

//Hacemos la clase abstracta como dice en el ej 328, con esto conseguimos que no se pueda instanciar un objeto de la clase Soporte directamente, si no que lo debes hacer utilizando las subclases de esta.

//Implementamos la interfaz como pide el ej 329, y comprobamos que no hace falta que la implementen tambien en su declaracion las clases hijas, ya lo hacen automaticamente al heredar de esta.

namespace Dwes\ProyectoVideoclub;


abstract class Soporte implements Resumible
{
    private $titulo;
    private $numero;
    private $precio;
    public $alquilado = false;

    const IVA = 21;

    public function __construct($titulo, $numero, $precio)
    {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getPrecioConIva()
    {
        return $this->precio * (1 + self::IVA / 100);
    }

    public function muestraResumen()
    {
        echo "<br>Título: " . $this->titulo . "<br>";
        echo "Número: " . $this->numero . "<br>";
        echo "Precio: " . $this->precio . " (IVA no incluido)<br>";
    }
}
