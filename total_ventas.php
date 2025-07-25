<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'conexion.php';
$conexion= conectar();
$sql = "SELECT SUM(Precio) AS TotalVentas FROM productos WHERE Vendido = 1";
$resultado = $conexion->query($sql);
$fila = $resultado->fetch_assoc();
$total = $fila['TotalVentas'] ?? 0;

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Total de Ventas</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<h1>Total de Ventas</h1>

<div class="resumen">
    <p>La suma total de productos vendidos es:</p>
    <p style="font-size: 2rem; color: green;"><strong><?= number_format($total, 2) ?> €</strong></p>
</div>

<div style="text-align: center; margin-top: 20px;">
    <a class="btn" href="index.php">🔙 Volver al inicio</a>
</div>

</body>

</html>
