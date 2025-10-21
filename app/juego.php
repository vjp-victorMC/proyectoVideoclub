<?php

namespace Dwes\ProyectoVideoclub;
// clase juego que extiende de soporte
class Juego extends Soporte
{
    private $consola;
    private $minNumJugadores;
    private $maxNumJugadores;

    // sobrescrivimos el constructor
    public function __construct($titulo, $numero, $precio, $consola, $minNumJugadores, $maxNumJugadores)
    {
        parent::__construct($titulo, $numero, $precio);
        $this->consola = $consola;
        $this->minNumJugadores = $minNumJugadores;
        $this->maxNumJugadores = $maxNumJugadores;
    }

    public function muestraJugadoresPosibles()
    {
        $min = $this->minNumJugadores;
        $max = $this->maxNumJugadores;

        // Caso 1: solo en caso de jugador
        if ($min == 1 && $max == 1) {
            echo "Para un jugador";
        }
        // para el mismo numero de jugadores minimo dos maximo dos o tres y tres etc.. 
        elseif ($min == $max) {
            echo "Para $min jugadores";
        }
        // Caso 3: hay un rango ejemplo de 2 a 4 jugadores
        else {
            echo "De $min a $max jugadores";
        }
    }

    // Sobrescribimos el metodo muestraResumen
    public function muestraResumen()
    {
        parent::muestraResumen();
        echo "<br>Consola: " . $this->consola;
        echo "<br>Jugadores: ";
        $this->muestraJugadoresPosibles();
        echo "<br>Precio con IVA: " . $this->getPrecioConIva() . " euros";
    }
}
