<?php 
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

include 'conexion.php';
$conexion = conectar();

// Obtener nombre de usuario
$nombre_usuario = "";
$stmt = $conexion->prepare("SELECT usuario FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$stmt->bind_result($nombre_usuario);
$stmt->fetch();
$stmt->close();
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .usuario-logueado {
            font-size: 1em;
            color: gray;
            margin-bottom: 20px;
        }

        .resumen {
            margin-bottom: 30px;
        }

        .btn {
            padding: 12px 20px;
            font-size: 16px;
            margin: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #ddd;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #bbb;
        }

        .acciones {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .footer-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 40px;
        }

        form {
            margin: 0;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 1.5em;
            }

            .btn {
                font-size: 15px;
                padding: 10px 15px;
            }

            .usuario-logueado {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Panel de Gestión de Productos</h1>
        <div class="usuario-logueado">👤 Usuario: <strong><?= htmlspecialchars($nombre_usuario) ?></strong></div>

        <div class="resumen">
            <p>Elige una acción para realizar sobre la tabla <strong>productos</strong>:</p>
        </div>

        <div class="acciones">
            <a class="btn" href="productos.php">📄 Ver Productos</a>
            <a class="btn" href="nuevo_producto.php">➕ Añadir Producto</a>
            <a class="btn" href="modificar_producto.php">✏️ Modificar / Eliminar Producto</a>
            <a class="btn" href="total_ventas.php">💰 Total de Ventas</a>
        </div>

        <div class="footer-buttons">
            <button class="btn" id="toggle-tema">🌙 Cambiar tema</button>
            <form action="logout.php" method="post">
                <button type="submit" class="btn">🚪 Cerrar sesión</button>
            </form>
        </div>
    </div>

    <script src="js/tema.js"></script>
    <script>
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
</body>
</html>
