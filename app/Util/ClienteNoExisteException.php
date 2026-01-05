<?php
// Ejercicio 561
namespace Dwes\Videoclub\Exception;

use Dwes\ProyectoVideoclub\Util\VideoclubException;

// Hereda de tu excepción base para mantener la jerarquía
class ClienteNoExisteException extends VideoclubException 
{
}