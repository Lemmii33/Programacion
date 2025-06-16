<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
include 'conexion.php';
$conexion= conectar();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = floatval($_POST['precio']);
    $vendido = isset($_POST['vendido']) ? 1 : 0;

    $stmt = $conexion->prepare("INSERT INTO productos (Nombre, Descripcion, Precio, Vendido) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $vendido);

    if ($stmt->execute()) {
        echo "<p class='resumen'>✅ Producto añadido correctamente.</p>";
    } else {
        echo "<p class='resumen'>❌ Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Producto</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<h1>Añadir Nuevo Producto</h1>

<form method="POST" style="max-width: 500px; margin: auto;">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Descripción:</label><br>
    <input type="text" name="descripcion" required><br><br>

    <label>Precio (€):</label><br>
    <input type="number" step="0.01" name="precio" required><br><br>

    <label><input type="checkbox" name="vendido"> Vendido</label><br><br>

    <button type="submit">Guardar Producto</button>
</form>
<div style="text-align: center; margin-top: 30px;">
    <a class="btn" href="index.php">🔙 Volver al inicio</a>
</div>
</body>
</html>
