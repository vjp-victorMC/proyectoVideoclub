<?php

namespace Dwes\ProyectoVideoclub;

use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\LogFactory;
use Monolog\Logger;

/**
 * Class Cliente
 * 
 * Gestiona la información y los alquileres de un cliente del videoclub.
 * 
 * @package Dwes\ProyectoVideoclub
 */
class Cliente
{
    // Atributos del cliente
    private $nombre;
    private $numero;
    private $maxAlquilerConcurrente;
    private $numSoportesAlquilados = 0;
    private $soportesAlquilados = []; //  soportes que se  alquila

    // Nuevo: credenciales del cliente
    private $usuario;
    private $password;
    private $logger;

    /**
     * Constructor de Cliente.
     * 
     * @param string $nombre Nombre del cliente.
     * @param int $numero Número identificativo del cliente.
     * @param int $maxAlquilerConcurrente Máximo alquileres simultáneos (default 3).
     * @param string|null $usuario Nombre de usuario (opcional).
     * @param string|null $password Contraseña del usuario (opcional).
     */
    public function __construct($nombre, $numero, $maxAlquilerConcurrente = 3, $usuario = null, $password = null)
    {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
        $this->usuario = $usuario;
        $this->password = $password; // en producción deberías almacenar solo hash
        
        $this->logger = LogFactory::getLogger();
    }
    
    // geters y setters de numeros de clientes
    public function getNumero()
    {
        return $this->numero;
    }

    // Nuevo: getter para el usuario
    public function getUsuario()
    {
        return $this->usuario;
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

    /**
     * Muestra el resumen del cliente y sus alquileres actuales.
     */
    public function muestraResumen()
    {
        echo "<br>Nombre: " . $this->nombre;
        echo "<br>Soportes alquilados ahora: " . count($this->soportesAlquilados);
    }

    /**
     * Comprueba si el cliente tiene un soporte alquilado.
     * 
     * @param Soporte $s Soporte a comprobar.
     * @return bool True si lo tiene alquilado, false en caso contrario.
     */
    public function tieneAlquilado(Soporte $s): bool
    {
        foreach ($this->soportesAlquilados as $soporte) {
            if ($soporte->getNumero() == $s->getNumero()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Alquila un soporte para el cliente.
     * 
     * @param Soporte $s Soporte a alquilar.
     * @return Cliente Instancia actual para encadenamiento.
     * @throws SoporteYaAlquiladoException Si el soporte ya lo tiene alquilado.
     * @throws CupoSuperadoException Si ha alcanzado el límite de alquileres.
     */
    public function alquilar(Soporte $s) //creamos  un objeto soporte por parametro
    {
        if ($this->tieneAlquilado($s)) {
            $this->logger->warning("El soporte ya está alquilado: " . $s->getTitulo());
            throw new SoporteYaAlquiladoException("Ya tienes alquilado: " . $s->getTitulo());
        }

        if (count($this->soportesAlquilados) >= $this->maxAlquilerConcurrente) {
            $this->logger->warning("Cupo de alquileres superado. No puedes alquilar más de " . $this->maxAlquilerConcurrente . " soportes.");
            throw new CupoSuperadoException("No puedes alquilar más de " . $this->maxAlquilerConcurrente . " soportes.");
        }

        $this->soportesAlquilados[] = $s;
        $this->numSoportesAlquilados++;
        $s->alquilado = true;
        $this->logger->info("Alquilado soporte: " . $s->getTitulo());

        return $this; // Encadenamiento
    }

    /**
     * Devuelve un soporte alquilado.
     * 
     * @param int $numSoporte Número del soporte a devolver.
     * @return Cliente Instancia actual.
     * @throws SoporteNoEncontradoException Si el soporte no está en su lista de alquileres.
     */
    public function devolver(int $numSoporte)
    {
        foreach ($this->soportesAlquilados as $key => $soporte) {
            if ($soporte->getNumero() === $numSoporte) {
                $soporte->alquilado = false; // Marcar como no alquilado
                unset($this->soportesAlquilados[$key]);
                $this->numSoportesAlquilados--;
                $this->soportesAlquilados = array_values($this->soportesAlquilados);
                $this->logger->info("Devuelto soporte: " . $soporte->getTitulo());
                return $this;
            }
        }
        $this->logger->warning("No tienes alquilado el soporte número: $numSoporte");
        throw new SoporteNoEncontradoException("No tienes alquilado el soporte número: $numSoporte");
    }

    /**
     * Lista los alquileres actuales del cliente (log).
     */
    public function listaAlquileres()
    {
        $cantidad = count($this->soportesAlquilados);
        $this->logger->info("$this->nombre tiene $cantidad soporte(s) alquilado(s):");

        if ($cantidad == 0) {
            $this->logger->info("No tiene ningún soporte alquilado.");
        } else {
            foreach ($this->soportesAlquilados as $soporte) {
                $this->logger->info("- " . $soporte->getTitulo() . " (Nº " . $soporte->getNumero() . ")");
            }
        }
    }

    // devolver array de alquileres (objetos Soporte)
    public function getAlquileres(): array
    {
        return $this->soportesAlquilados;
    }
}
