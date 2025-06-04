<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<div class="container">
    <h1>Panel de Gestión de Productos</h1>

    <div class="resumen">
        <p>Elige una acción para realizar sobre la tabla <strong>productos</strong>:</p>
    </div>

    <div style="text-align:center; margin-top: 30px;">
        <a class="btn" href="productos.php">📄 Ver Productos</a>
        <a class="btn" href="nuevo_producto.php">➕ Añadir Producto</a>
        <a class="btn" href="modificar_producto.php">✏️ Modificar / Eliminar Producto</a>
        <a class="btn" href="total_ventas.php">💰 Total de Ventas</a>
    </div>

    <div style="text-align: center; margin-top: 40px;">
        <button class="btn" onclick="alternarTema()">🌙 Cambiar tema</button>
    </div>
</div>

<script>
    // Alterna entre modo claro/oscuro
    document.addEventListener("DOMContentLoaded", () => {
        const body = document.body;
        const btn = document.getElementById("toggle-tema");
        const temaGuardado = localStorage.getItem("modo");

        if (temaGuardado === "oscuro") {
            body.classList.add("oscuro");
        }

        btn.addEventListener("click", () => {
            body.classList.toggle("oscuro");
            const nuevoModo = body.classList.contains("oscuro") ? "oscuro" : "claro";
            localStorage.setItem("modo", nuevoModo);
        });
    });
</script>
<script src="tema.js"></script>
</body>
</html>
