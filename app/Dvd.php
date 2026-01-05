<?php
namespace Dwes\ProyectoVideoclub;

class Dvd extends Soporte {
    private $idiomas;
    private $formatPantalla;
    private $duracion; // Ejercicio 562

    public function __construct($titulo, $numero, $precio, $idiomas, $pantalla, $duracion) {
        parent::__construct($titulo, $numero, $precio);
        $this->idiomas = $idiomas;
        $this->formatPantalla = $pantalla;
        $this->duracion = $duracion;
    }

    public function muestraResumen() {
        $msg = parent::muestraResumen(); // Asumiendo que Soporte ya devuelve algo
        $msg .= "<br>Idiomas: " . $this->idiomas;
        $msg .= "<br>Pantalla: " . $this->formatPantalla;
        $msg .= "<br>Duración: " . $this->duracion . " min";
        echo $msg;
        return $msg; // Ejercicio 551
    }
}