<?php
// v0.331

namespace Dwes\ProyectoVideoclub;

use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;

class Cliente
{
    // Atributos del cliente
    private $nombre;
    private $numero;
    private $maxAlquilerConcurrente;
    private $numSoportesAlquilados = 0;
    private $soportesAlquilados = []; //  soportes que se  alquila

    // Constructor
    public function __construct($nombre, $numero, $maxAlquilerConcurrente = 3)
    {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
    }

    // geters y setters de numeros de clientes
    public function getNumero()
    {
        return $this->numero;
    }


    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    //  total de alquileres hechos
    public function getNumSoportesAlquilados()
    {
        return $this->numSoportesAlquilados;
    }

    //  resumen del cliente
    public function muestraResumen()
    {
        echo "<br>Nombre: " . $this->nombre;
        echo "<br>Soportes alquilados ahora: " . count($this->soportesAlquilados);
    }

    // Comprobamos si un soporte ya esta alquilado por el cliente
    public function tieneAlquilado(Soporte $s): bool
    {
        foreach ($this->soportesAlquilados as $soporte) {
            if ($soporte->getNumero() == $s->getNumero()) {
                return true;
            }
        }
        return false;
    }

    // Alquilamos un soporte
    public function alquilar(Soporte $s) //creamos  un objeto soporte por parametro
    {
        if ($this->tieneAlquilado($s)) {
            throw new SoporteYaAlquiladoException("Ya tienes alquilado: " . $s->getTitulo());
        }

        if (count($this->soportesAlquilados) >= $this->maxAlquilerConcurrente) {
            throw new CupoSuperadoException("No puedes alquilar más de " . $this->maxAlquilerConcurrente . " soportes.");
        }

        $this->soportesAlquilados[] = $s;
        $this->numSoportesAlquilados++;
        // Puedes dejar el echo si quieres mensajes, pero no es obligatorio
        return $this; // Encadenamiento
    }

    // Devolvemos un soporte
    public function devolver(int $numSoporte)
    {
        foreach ($this->soportesAlquilados as $key => $soporte) {
            if ($soporte->getNumero() === $numSoporte) {
                unset($this->soportesAlquilados[$key]);
                $this->numSoportesAlquilados--;
                // Reindexar el array si lo necesitas:
                $this->soportesAlquilados = array_values($this->soportesAlquilados);
                return $this; // Encadenamiento
            }
        }
        throw new SoporteNoEncontradoException("No tienes alquilado el soporte número: $numSoporte");
    }

    // Mostramos todos los soportes alquilados
    public function listaAlquileres()
    {
        $cantidad = count($this->soportesAlquilados);
        echo "<br><br> $this->nombre tiene $cantidad soporte(s) alquilado(s):<br>";

        if ($cantidad == 0) {
            echo "No tiene ningún soporte alquilado.<br>";
        } else {
            foreach ($this->soportesAlquilados as $soporte) {
                echo "- " . $soporte->getTitulo() . " (Nº " . $soporte->getNumero() . ")<br>";
            }
        }
    }
}
