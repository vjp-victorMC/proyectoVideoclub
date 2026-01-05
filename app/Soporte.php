<?php

//Hacemos la clase abstracta como dice en el ej 328, con esto conseguimos que no se pueda instanciar un objeto de la clase Soporte directamente, si no que lo debes hacer utilizando las subclases de esta.

//Implementamos la interfaz como pide el ej 329, y comprobamos que no hace falta que la implementen tambien en su declaracion las clases hijas, ya lo hacen automaticamente al heredar de esta.

namespace Dwes\ProyectoVideoclub;


/**
 * Class Soporte
 * 
 * Clase abstracta que define los soportes del videoclub.
 * Implementa la interfaz Resumible.
 * 
 * @package Dwes\ProyectoVideoclub
 */
abstract class Soporte implements Resumible
{
    private $titulo;
    private $numero;
    private $precio;
    public $alquilado = false;
    public $metacritic;

    const IVA = 21;

    /**
     * Constructor de la clase Soporte.
     * 
     * @param string $metacritic URL de Metacritic.
     * @param string $titulo Título del soporte.
     * @param int $numero Número identificativo del soporte.
     * @param float $precio Precio de alquiler del soporte.
     */
    public function __construct($metacritic, $titulo, $numero, $precio)
    {
        $this->metacritic = $metacritic;
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }

    /**
     * Obtiene el título del soporte.
     * 
     * @return string Título del soporte.
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Obtiene el número identificativo.
     * 
     * @return int Número del soporte.
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Obtiene el precio sin IVA.
     * 
     * @return float Precio.
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Calcula y devuelve el precio con IVA incluido.
     * 
     * @return float Precio con IVA.
     */
    public function getPrecioConIva()
    {
        return $this->precio * (1 + self::IVA / 100);
    }

    /**
     * Muestra un resumen de los datos del soporte (HTML).
     */
    public function muestraResumen()
    {
        echo "<br>Título: " . $this->titulo . "<br>";
        echo "Número: " . $this->numero . "<br>";
        echo "Precio: " . $this->precio . " (IVA no incluido)<br>";
    }

    /**
     * Obtiene la puntuación de Metacritic mediante scraping.
     * 
     * @return string Puntuación o mensaje de error.
     */
    public function getPuntuacion()
    {
        if (empty($this->metacritic)) {
            return "Sin URL";
        }

        try {
            // Contexto para simular un navegador y evitar errores SSL
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n" .
                                "Accept-Language: en-US,en;q=0.9\r\n",
                    'ignore_errors' => true
                ],
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ],
            ]);

            // Obtenemos el HTML
            $html = @file_get_contents($this->metacritic, false, $context);

            if ($html === false) {
                return "Error conexión";
            }

            // Buscamos la puntuación con Regex (intentamos varios patrones comunes de Metacritic)
            // Patrón nuevo: <div  title="Metascore 94 out of 100" ...
            // Patrón para el numero en el circulo: class="c-productScoreInfo_scoreNumber ... "><span>94</span>
            
            $score = "Desconocida";

            // Intento 1: Patrón de clases modernas
            if (preg_match('/c-productScoreInfo_scoreNumber[^>]*>.*?<span>(\d+)<\/span>/s', $html, $matches)) {
                $score = $matches[1];
            }
            // Intento 2: Buscar en JSON-LD (ratingValue) - Más robusto. Permisivo con caracteres intermedios (comillas, dos puntos, espacios).
            elseif (preg_match('/ratingValue.*?(\d{2})/', $html, $matches)) {
                $score = $matches[1];
            }
            // Intento 3: Buscar por title="Metascore XX out of 100"
            elseif (preg_match('/title="Metascore (\d+) out of 100"/', $html, $matches)) {
                $score = $matches[1];
            }
            // Intento 3: Legacy metascore_w
            elseif (preg_match('/metascore_w[^>]*>(\d+)<\/span>/', $html, $matches)) {
                $score = $matches[1];
            }

            return $score;

        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
