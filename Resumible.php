<?php

//Creamos la interfaz Resumible y declaramos el metodo muestraResumen, de esta forma cualquier clase que implemente la interfaz(y sus clases hijas) deberan tener este metodo definido.

interface Resumible
{

    public function muestraResumen();
}
