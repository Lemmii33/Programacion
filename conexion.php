<?php
function conectar() {
    $host = "localhost";
    $user = "producto";
    $pass = "W4ll4p0p@";
    $db = "Ventas";

    $conexion = new mysqli($host, $user, $pass, $db);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    return $conexion;
}

