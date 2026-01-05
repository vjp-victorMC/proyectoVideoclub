<?php
namespace Dwes\ProyectoVideoclub;

/**
 * Class Dvd
 * 
 * Representa un DVD.
 * 
 * @package Dwes\ProyectoVideoclub
 */
class Dvd extends Soporte {
    private $idiomas;
    private $formatPantalla;
    private $duracion; // Ejercicio 562

    /**
     * Constructor de Dvd.
     * 
     * @param string $titulo Título.
     * @param int $numero Número.
     * @param float $precio Precio.
     * @param string $idiomas Idiomas disponibles.
     * @param string $pantalla Formato de pantalla.
     * @param int $duracion Duración en minutos.
     */
    public function __construct($titulo, $numero, $precio, $idiomas, $pantalla, $duracion) {
        parent::__construct($titulo, $numero, $precio);
        $this->idiomas = $idiomas;
        $this->formatPantalla = $pantalla;
        $this->duracion = $duracion;
    }

    /**
     * Muestra el resumen del DVD.
     */
    public function muestraResumen() {
        $msg = parent::muestraResumen(); // Asumiendo que Soporte ya devuelve algo
        $msg .= "<br>Idiomas: " . $this->idiomas;
        $msg .= "<br>Pantalla: " . $this->formatPantalla;
        $msg .= "<br>Duración: " . $this->duracion . " min";
        echo $msg;
        return $msg; // Ejercicio 551
    }
}