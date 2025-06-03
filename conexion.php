<?php
$host = "localhost";
$usuario = "producto";
$contrasena = "W4ll4p0p@";
$base_datos = "Ventas";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
