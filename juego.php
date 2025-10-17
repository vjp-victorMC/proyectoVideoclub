<?php
include_once "Soporte.php";
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

    // Método que muestra el rango de jugadores posibles
    public function muestraJugadoresPosibles()
    {
        if ($this->minNumJugadores == 1 && $this->maxNumJugadores == 1) {
            echo "Para un jugador";
        } elseif ($this->minNumJugadores == $this->maxNumJugadores) {
            echo "Para " . $this->minNumJugadores . " jugadores";
        } else {
            echo "De " . $this->minNumJugadores . " a " . $this->maxNumJugadores . " jugadores";
        }
    }

    // Sobrescribimos el metodo muestraResumen
    public function muestraResumen()
    {
        echo "<br>Título: " . $this->getTitulo();
        echo "<br>Número: " . $this->getNumero();
        echo "<br>Consola: " . $this->consola;
        echo "<br>Jugadores: ";
        $this->muestraJugadoresPosibles();
        echo "<br>Precio: " . $this->getPrecio() . " euros (IVA no incluido)";
        echo "<br>Precio con IVA: " . $this->getPrecioConIva() . " euros";
    }
}
?>
