<?php

namespace Dwes\ProyectoVideoclub;

class Bluray extends Soporte {
    
    public function __construct(
        $metacritic,
        $titulo, 
        $numero, 
        $precio, 
        public $duracion, 
        public $es4k = false
    ) {
        parent::__construct($metacritic, $titulo, $numero, $precio);
    }

    public function muestraResumen() {
        $calidad = $this->es4k ? "Es 4K" : "No es 4K";
        // Reutilizamos la logica del padre
        $msg = parent::muestraResumen();
        $extra = "<br>Duración: " . $this->duracion . " min";
        $extra .= "<br>Calidad: " . $calidad;
        
        echo $extra;
        return $msg . $extra;
    }
}