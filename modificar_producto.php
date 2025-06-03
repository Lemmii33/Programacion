<?php
include 'conexion.php';

$resultado = $conn->query("SELECT * FROM productos");
$productos = $resultado->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Productos</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        td input {
            width: 100%;
            padding: 4px;
            box-sizing: border-box;
        }
        .acciones button {
            margin-right: 5px;
        }
    </style>
</head>
<body>
<div class="container">
<h1>Modificar o Eliminar Productos</h1>

<table>
    <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio (€)</th>
        <th>Vendido</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($productos as $producto): ?>
    <tr data-id="<?= $producto['Id'] ?>">
        <td><input type="text" value="<?= htmlspecialchars($producto['Nombre']) ?>"></td>
        <td><input type="text" value="<?= htmlspecialchars($producto['Descripcion']) ?>"></td>
        <td><input type="number" step="0.01" value="<?= $producto['Precio'] ?>"></td>
        <td>
            <select>
                <option value="0" <?= !$producto['Vendido'] ? 'selected' : '' ?>>No</option>
                <option value="1" <?= $producto['Vendido'] ? 'selected' : '' ?>>Sí</option>
            </select>
        </td>
        <td class="acciones">
            <button onclick="guardar(this)">💾 Guardar</button>
            <button onclick="eliminar(this)">🗑️ Eliminar</button>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<script>
function guardar(btn) {
    const fila = btn.closest("tr");
    const id = fila.dataset.id;
    const datos = {
        id: id,
        nombre: fila.cells[0].querySelector("input").value,
        descripcion: fila.cells[1].querySelector("input").value,
        precio: fila.cells[2].querySelector("input").value,
        vendido: fila.cells[3].querySelector("select").value
    };

    fetch("producto_api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ accion: "actualizar", datos: datos })
    })
    .then(res => res.json())
    .then(res => alert(res.mensaje));
}

function eliminar(btn) {
    const fila = btn.closest("tr");
    const id = fila.dataset.id;

    if (confirm("¿Estás seguro de eliminar este producto?")) {
        fetch("producto_api.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ accion: "eliminar", id: id })
        })
        .then(res => res.json())
        .then(res => {
            alert(res.mensaje);
            if (res.ok) fila.remove();
        });
    }
}
</script>
<div style="text-align: center; margin-top: 30px;">
    <a class="btn" href="index.php">🔙 Volver al inicio</a>
</div>
</div>
</body>
</html>
