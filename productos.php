<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'conexion.php';
$conexion= conectar();
$sql = "SELECT Id, Nombre, Descripcion, Precio, Vendido FROM productos";
$resultado = $conexion->query($sql);

$sumaVendidos = 0;
$sumaTotal = 0;
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
    <h1>Lista de Productos</h1>

    <?php
    if ($resultado->num_rows > 0) {
        echo "<table id='tabla-productos' data-orden='asc' data-columna='-1'>";
        echo "<thead><tr>";
        echo "<th onclick='ordenarTabla(0, this)'>ID</th>";
        echo "<th onclick='ordenarTabla(1, this)'>Nombre</th>";
        echo "<th onclick='ordenarTabla(2, this)'>Descripción</th>";
        echo "<th onclick='ordenarTabla(3, this)'>Precio</th>";
        echo "<th onclick='ordenarTabla(4, this)'>Vendido</th>";
        echo "</tr></thead><tbody>";

        while ($fila = $resultado->fetch_assoc()) {
            $totalProductos++;
            $sumaTotal += $fila['Precio'];

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

        echo "</tbody></table>";

        $porcentaje = $totalProductos > 0 ? ($contadorVendidos / $totalProductos) * 100 : 0;

        if ($porcentaje >= 80) {
            $barraClase = "progress-bar high";
        } elseif ($porcentaje >= 50) {
            $barraClase = "progress-bar medium";
        } else {
            $barraClase = "progress-bar low";
        }

        echo "<div class='resumen'>";
        echo "<p><strong>Artículos vendidos:</strong> $contadorVendidos de $totalProductos</p>";
        echo "<p><strong>Total vendido:</strong> " . number_format($sumaVendidos, 2) . " €</p>";
        echo "<p><strong>Total potencial:</strong> " . number_format($sumaTotal, 2) . " €</p>";
        echo "<p><strong>Porcentaje de ventas:</strong> " . number_format($porcentaje, 2) . " %</p>";
        echo "<div class='progress-container'>";
        echo "<div class='$barraClase' style='width: " . max($porcentaje, 5) . "%;'>" . number_format($porcentaje, 0) . "%</div>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "<div class='resumen'>No hay productos en la base de datos.</div>";
    }

    $conexion->close();
    ?>

    <div style="text-align: center; margin-top: 30px;">
        <a class="btn" href="index.php">🔙 Volver al inicio</a>
        <button class="btn" onclick="alternarTema()">🌙 Cambiar tema</button>
    </div>
</div>

<script src="js/tema.js"></script>
<script>
function ordenarTabla(columna, th) {
    const tabla = document.getElementById("tabla-productos");
    const cuerpo = tabla.tBodies[0];
    const filas = Array.from(cuerpo.rows);
    const esNumero = columna === 0 || columna === 3;
    let orden = tabla.getAttribute("data-orden") || "asc";
    let ultimaCol = parseInt(tabla.getAttribute("data-columna") || "-1");

    if (ultimaCol === columna) {
        orden = orden === "asc" ? "desc" : "asc";
    } else {
        orden = "asc";
    }

    tabla.setAttribute("data-orden", orden);
    tabla.setAttribute("data-columna", columna);

    document.querySelectorAll("th").forEach(th => th.textContent = th.textContent.replace(/\s*[▲▼]$/, ""));

    filas.sort((a, b) => {
        let valA = a.cells[columna].textContent.trim();
        let valB = b.cells[columna].textContent.trim();

        if (esNumero) {
            valA = parseFloat(valA.replace("€", "").replace(",", ".")) || 0;
            valB = parseFloat(valB.replace("€", "").replace(",", ".")) || 0;
        }

        return orden === "asc"
            ? (valA > valB ? 1 : valA < valB ? -1 : 0)
            : (valA < valB ? 1 : valA > valB ? -1 : 0);
    });

    filas.forEach(fila => cuerpo.appendChild(fila));

    th.textContent += orden === "asc" ? " ▲" : " ▼";
}
</script>

</body>
</html>
