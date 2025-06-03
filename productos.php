<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<h1>Lista de Productos: pruebaaa</h1>

<?php
include 'conexion.php';

$sql = "SELECT Id, Nombre, Descripcion, Precio, Vendido FROM productos";
$resultado = $conn->query($sql);

$sumaVendidos = 0;

if ($resultado->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Vendido</th></tr>";

    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $fila['Id'] . "</td>";
        echo "<td>" . $fila['Nombre'] . "</td>";
        echo "<td>" . $fila['Descripcion'] . "</td>";
        echo "<td>" . number_format($fila['Precio'], 2) . " €</td>";
        echo "<td class='" . ($fila['Vendido'] ? "vendido-si" : "vendido-no") . "'>" . ($fila['Vendido'] ? "Sí" : "No") . "</td>";
        echo "</tr>";

        if ($fila['Vendido']) {
            $sumaVendidos += $fila['Precio'];
        }
    }

    echo "</table>";
    echo "<div class='resumen'>Total vendido: " . number_format($sumaVendidos, 2) . " €</div>";
} else {
    echo "<div class='resumen'>No hay productos en la base de datos.</div>";
}

$conn->close();
?>
<div style="text-align: center; margin-top: 30px;">
    <a class="btn" href="index.php">🔙 Volver al inicio</a>
</div>
</body>
</html>
