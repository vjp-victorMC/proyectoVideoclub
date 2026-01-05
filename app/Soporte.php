<?php

//Hacemos la clase abstracta como dice en el ej 328, con esto conseguimos que no se pueda instanciar un objeto de la clase Soporte directamente, si no que lo debes hacer utilizando las subclases de esta.

//Implementamos la interfaz como pide el ej 329, y comprobamos que no hace falta que la implementen tambien en su declaracion las clases hijas, ya lo hacen automaticamente al heredar de esta.

namespace Dwes\ProyectoVideoclub;


/**
 * Class Soporte
 * 
 * Clase abstracta que define los soportes del videoclub.
 * Implementa la interfaz Resumible.
 * 
 * @package Dwes\ProyectoVideoclub
 */
abstract class Soporte implements Resumible
{
    private $titulo;
    private $numero;
    private $precio;
    public $alquilado = false;

    const IVA = 21;

    /**
     * Constructor de la clase Soporte.
     * 
     * @param string $titulo Título del soporte.
     * @param int $numero Número identificativo del soporte.
     * @param float $precio Precio de alquiler del soporte.
     */
    public function __construct($titulo, $numero, $precio)
    {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }

    /**
     * Obtiene el título del soporte.
     * 
     * @return string Título del soporte.
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Obtiene el número identificativo.
     * 
     * @return int Número del soporte.
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Obtiene el precio sin IVA.
     * 
     * @return float Precio.
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Calcula y devuelve el precio con IVA incluido.
     * 
     * @return float Precio con IVA.
     */
    public function getPrecioConIva()
    {
        return $this->precio * (1 + self::IVA / 100);
    }

    /**
     * Muestra un resumen de los datos del soporte (HTML).
     */
    public function muestraResumen()
    {
        echo "<br>Título: " . $this->titulo . "<br>";
        echo "Número: " . $this->numero . "<br>";
        echo "Precio: " . $this->precio . " (IVA no incluido)<br>";
    }
}
