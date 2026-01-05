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
     * @param string $metacritic URL de Metacritic.
     * @param string $titulo Título de la cinta.
     * @param int $numero Número de soporte.
     * @param float $precio Precio de alquiler.
     * @param int $duracion Duración en minutos.
     */
    public function __construct($metacritic, $titulo, $numero, $precio, $duracion)
    {
        parent::__construct($metacritic, $titulo, $numero, $precio);
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
        $resumen = parent::muestraResumen();
        $resumen .= "<br>Duración: " . $this->duracion . " minutos";
        $resumen .= "<br>Metacritic: <a href='" . $this->metacritic . "'>" . $this->metacritic . "</a>";
        $resumen .= "<br>Precio con IVA: " . $this->getPrecioConIva() . " euros";
        
        echo $resumen; // Nota: parent::muestraResumen() ya hace echo, por lo que esto duplicaría la salida del padre si no tenemos cuidado.
        // PERO: El enunciado dice "Los métodos muestraResumen, tras hacer echo de los mensajes, deben devolver una cadena con el propio mensaje."
        // Si parent::muestraResumen() hace echo, y nosotros llamamos a parent::muestraResumen(), ya sale por pantalla la primera parte.
        // Si luego hacemos echo $resumen (que contiene TODO), saldrá DOS VECES la parte del padre.
        // SOLUCION: El padre devuelve el string y hace echo. El hijo captura el string.
        // El hijo debe hacer echo SOLO DE LO SUYO? O del total?
        // "Los métodos... tras hacer echo de los mensajes..."
        // Si el padre hace echo, y el hijo llama al padre, el echo del padre sale.
        // Si el hijo concatena y hace echo del TOTAL, se repite lo del padre.
        // Lo ideal sería que el padre NO hiciera echo si se llama desde el hijo, pero no podemos cambiar firma facilmente.
        // O asumimos que se duplicará, o hacemos que el hijo solo haga echo de la diferencia?
        // "devuelven una cadena con el propio mensaje".
        // Vamos a asumir que duplicar el echo no es critico A MENOS que el usuario lo diga, O intentamos limpiar.
        // Mejor: El padre devuelve string. El hijo concatena. El hijo hace echo SOLO DE LO NUEVO?
        // No, el hijo debe comportarse como `muestraResumen`. Si llamo a `$cinta->muestraResumen()`, quiero ver todo.
        // Si llamo a parent::muestraResumen(), ya veo lo del padre.
        // Entonces solo hago echo de la parte nueva.
        // Pero el return debe ser completo.
        
        // CORRECCION:
        // Soporte::muestraResumen hace echo y return.
        // Cinta::muestraResumen llama a parent. Parent imprime y retorna PART1.
        // Cinta concatena PART2.
        // Cinta imprime PART2 (no todo, porque PART1 ya salió).
        // Cinta retorna PART1 . PART2.
        
        // Implementación corregida:
        // $resumenPadre = parent::muestraResumen(); // Imprime Título...
        // $extra = "...";
        // echo $extra;
        // return $resumenPadre . $extra;
        
        // Espera, el usuario dijo: "Los métodos muestraResumen, tras hacer echo de los mensajes, deben devolver una cadena con el propio mensaje."
        // Si modifico como pensaba, cumplo.
        
        $extra = "<br>Duración: " . $this->duracion . " minutos";
        $extra .= "<br>Metacritic: <a href='" . $this->metacritic . "'>" . $this->metacritic . "</a>";
        $extra .= "<br>Precio con IVA: " . $this->getPrecioConIva() . " euros";
        
        echo $extra;
        return $resumen . $extra;
    }
}
