<?php
function conectar() {
    $host = "localhost";
    $user = "root";
    $pass = "!!Ypunto33!!";
    $db = "lemmif_ventas";

    $conexion = new mysqli($host, $user, $pass, $db);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    return $conexion;
}

