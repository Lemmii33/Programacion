<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Esto usa la ruta absoluta desde el mismo directorio
require_once __DIR__ . '/conexion.php';

$conexion = conectar();
echo "Conexión exitosa.";
$conexion->close();
?>
