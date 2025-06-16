<?php
session_start();
include 'conexion.php';

$conexion = conectar();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['clave']);

    $stmt = $conexion->prepare("SELECT id, clave FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hash);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            $_SESSION["user_id"] = $id;
            header("Location: index.php");
            exit;
        } else {
            $error = "❌ Contraseña incorrecta.";
        }
    } else {
        $error = "❌ Usuario no encontrado.";
    }

    $stmt->close();
    $conexion->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - REY CORPORACIÓN</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="body_rey">
    <div class="container" style="max-width: 400px; margin-top: 100px;">
        <h1 style="text-align:center;">🔐 Iniciar Sesión</h1>

        <?php if ($error): ?>
            <p style="color: red; text-align: center;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" style="display: flex; flex-direction: column; gap: 15px; margin-top: 30px;">
            <input type="text" name="usuario" placeholder="👤 Usuario" required class="btn" style="padding: 10px;">
            <input type="password" name="clave" placeholder="🔑 Contraseña" required class="btn" style="padding: 10px;">
            <button type="submit" class="btn">➡️ Entrar</button>
        </form>

        <div style="margin-top: 40px; text-align:center;">
            <button class="btn" onclick="alternarTema()" id="toggle-tema">🌙 Cambiar tema</button>
        </div>
    </div>

    <script src="js/tema.js"></script>
    <script>
        // Modo oscuro según preferencia guardada
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
