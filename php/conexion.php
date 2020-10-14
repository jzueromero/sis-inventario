<?php
    include("configuracion.php");

    $conexion = new mysqli($server, $user, $pass, $db);
    if(mysqli_connect_errno())
    {
        echo "No Conectado", mysqli_connect_error();        
        exit();
    }
    
?>