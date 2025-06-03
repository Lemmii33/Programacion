<?php
include 'conexion.php';

$sql = "SELECT Id, Nombre, Descripcion, Precio, Vendido FROM productos";
$resultado = $conn->query($sql);

$sumaVendidos = 0;
$contadorVendidos = 0;
$totalProductos = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="container">
    <h1>Lista de Productos Marcos carahuevo</h1>

    <?php
    if ($resultado->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Vendido</th></tr>";

        while ($fila = $resultado->fetch_assoc()) {
            $totalProductos++;

            echo "<tr>";
            echo "<td>" . $fila['Id'] . "</td>";
            echo "<td>" . $fila['Nombre'] . "</td>";
            echo "<td>" . $fila['Descripcion'] . "</td>";
            echo "<td>" . number_format($fila['Precio'], 2) . " €</td>";
            echo "<td class='" . ($fila['Vendido'] ? "vendido-si" : "vendido-no") . "'>" . ($fila['Vendido'] ? "Sí" : "No") . "</td>";
            echo "</tr>";

            if ($fila['Vendido']) {
                $sumaVendidos += $fila['Precio'];
                $contadorVendidos++;
            }
        }

        $porcentaje = $totalProductos > 0 ? ($contadorVendidos / $totalProductos) * 100 : 0;

        echo "</table>";
        echo "<div class='resumen'>";
        echo "<p><strong>Artículos vendidos:</strong> $contadorVendidos de $totalProductos</p>";
        echo "<p><strong>Total vendido:</strong> " . number_format($sumaVendidos, 2) . " €</p>";
        echo "<p><strong>Porcentaje de ventas:</strong> " . number_format($porcentaje, 2) . " %</p>";
        echo "</div>";
    } else {
        echo "<div class='resumen'>No hay productos en la base de datos.</div>";
    }

    $conn->close();
    ?>

    <div style="text-align: center; margin-top: 30px;">
        <a class="btn" href="index.php">🔙 Volver al inicio</a>
    </div>
</div>

</body>
</html>
