<?php

namespace Dwes\ProyectoVideoclub;

/**
 * Class CintaVideo
 * 
 * Representa una cinta de video.
 * 
 * @package Dwes\ProyectoVideoclub
 */
class CintaVideo extends Soporte
{
    private $duracion;

    /**
     * Constructor de CintaVideo.
     * 
     * @param string $titulo Título de la cinta.
     * @param int $numero Número de soporte.
     * @param float $precio Precio de alquiler.
     * @param int $duracion Duración en minutos.
     */
    public function __construct($titulo, $numero, $precio, $duracion)
    {
        parent::__construct($titulo, $numero, $precio);
        $this->duracion = $duracion;
    }

    public function getPrecioConIva()
    {
        // Usamos el getter del padre para acceder al precio
        return $this->getPrecio() * 1.21;
    }

    /**
     * Muestra el resumen de la cinta de video.
     */
    public function muestraResumen()
    {
        parent::muestraResumen();
        echo "<br>Duración: " . $this->duracion . " minutos";
        echo "<br>Precio con IVA: " . $this->getPrecioConIva() . " euros";
    }
}
