<?php
function conectar() {
    $host = "localhost";
    $user = "producto";
    $pass = "W4ll4p0p@";
    $db = "ventas";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}

