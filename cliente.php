<?php
include_once "Soporte.php";

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
    public function tieneAlquilado(Soporte $s)
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
        //  Si ya lo tiene alquilado
        if ($this->tieneAlquilado($s)) {
            echo "<br>Ya tienes alquilado: " . $s->getTitulo();
            return false;
        }

        //  Si ya llego al maximo
        if (count($this->soportesAlquilados) >= $this->maxAlquilerConcurrente) {
            echo "<br>No puedes alquilar más de " . $this->maxAlquilerConcurrente . " soportes.";
            return false;
        }

        // Alquilamos el soporte
        $this->soportesAlquilados[] = $s;
        $this->numSoportesAlquilados++;
        echo "<br>Has alquilado: " . $s->getTitulo();
        return true;
    }

    // Devolvemos un soporte
    public function devolver($numSoporte)
    {
        foreach ($this->soportesAlquilados as $i => $soporte) {
            if ($soporte->getNumero() == $numSoporte) {
                echo "<br>Has devuelto: " . $soporte->getTitulo();
                unset($this->soportesAlquilados[$i]); // se quita del array
                $this->soportesAlquilados = array_values($this->soportesAlquilados); // reordenamos el array
                return true;
            }
        }

        echo "<br>No tienes alquilado el soporte con número $numSoporte.";
        return false;
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
?>
