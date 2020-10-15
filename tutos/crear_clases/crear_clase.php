<?php
ini_set('display_errors', 'On');
 
// Valor por defecto en PHP
// Muestra todos los errores menos las notificaciones
error_reporting(E_ALL ^ E_NOTICE);

// Muestro todos los errores
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
error_reporting(E_ALL);
error_reporting(-1);

// Muestro todos los errores, incluso los estrictos
error_reporting(E_ALL | E_STRICT);

// No muestra ningún error
error_reporting(0);

// También se puede usar la función ini_set
ini_set('error_reporting', E_ALL);

class Coche
{

    public $ruedas;
    public $color;

    function __construct()
    {
        $this->ruedas = 4;
        $this->color = "Sin pintar";
    }

    public function arrancar()
    {
        echo "funcion arrancar";
    }
    public function frenar()
    {
        echo "funcion girar";
    }

    public function set_ruedas_color($numero_rudas, $nombre_color)
    {
        $this->ruedas = $numero_rudas;
        $this->color = $nombre_color;
    }
}

?>