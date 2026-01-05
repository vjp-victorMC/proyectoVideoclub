<?php
namespace Dwes\ProyectoVideoclub;

class Bluray extends Soporte {
    public function __construct(
        $titulo, 
        $numero, 
        $precio, 
        public $duracion, 
        public $es4k = false
    ) {
        parent::__construct($titulo, $numero, $precio);
    }

    public function muestraResumen() {
        $calidad = $this->es4k ? "Es 4K" : "No es 4K";
        $msg = "Película en Bluray: " . $this->titulo . "<br>";
        $msg .= "Duración: " . $this->duracion . " min<br>";
        $msg .= $calidad;
        echo $msg;
        return $msg;
    }
}