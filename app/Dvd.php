<?php

namespace Dwes\ProyectoVideoclub;

class Dvd extends Soporte
{
    private $idiomas;
    private $formatPantalla;
    private $duracion; // Ejercicio 562: Nueva propiedad

    public function __construct($titulo, $numero, $precio, $idiomas, $pantalla, $duracion)
    {
        parent::__construct($titulo, $numero, $precio);
        $this->idiomas = $idiomas;
        $this->formatPantalla = $pantalla;
        $this->duracion = $duracion; // Ejercicio 562
    }

    public function getPrecioConIva()
    {
        return $this->getPrecio() * 1.21;
    }

    public function muestraResumen()
    {
        // Guardamos el mensaje en una variable para hacer echo y return
        $msg = "Película en DVD: " . $this->titulo . "<br>";
        $msg .= "Idiomas: " . $this->idiomas;
        $msg .= "<br>Pantalla: " . $this->formatPantalla;
        $msg .= "<br>Duración: " . $this->duracion . " min"; // Ejercicio 562
        $msg .= "<br>Precio con IVA: " . $this->getPrecioConIva() . " euros";
        
        echo $msg;
        return $msg; // Ejercicio 551: Ahora devuelve la cadena
    }
}