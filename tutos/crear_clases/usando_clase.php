<?php

    include("crear_clase.php");

    $mazda = new Coche();

    $mazda->set_ruedas_color(8, "Amarillo");

    echo "Tienen numero de ruedas: ".$mazda->ruedas;
?>