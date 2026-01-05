<?php

namespace Dwes\ProyectoVideoclub;

class Bluray extends Soporte 
{
    private $duracion;
    private $es4k;

    public function __construct($titulo, $numero, $precio, $duracion, $es4k = false)
    {
        parent::__construct($titulo, $numero, $precio);
        $this->duracion = $duracion;
        $this->es4k = $es4k;
    }

    public function muestraResumen()
    {
        $calidad = $this->es4k ? "Es 4K" : "No es 4K";
        $msg = "Película en Bluray: " . $this->titulo . "<br>";
        $msg .= "Duración: " . $this->duracion . " min";
        $msg .= "<br>Calidad: " . $calidad;
        
        echo $msg;
        return $msg;
    }
}