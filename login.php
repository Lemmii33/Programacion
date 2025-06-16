<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #firma {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            text-align: center;
        }

        .titulo_logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .titulo_logo img {
            width: 60px;
        }

        form input[type="text"],
        form input[type="password"],
        form input[type="submit"],
        .btn {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            font-size: 16px;
        }

        @media (max-width: 480px) {
            #firma {
                margin: 40px 20px;
                padding: 20px;
            }

            .titulo_logo img {
                width: 50px;
            }
        }

        .error-msg {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="body_rey">
    <div id="firma">
        <div class="titulo_logo">
            <img src="logo.png" alt="Logo">
            <span>Acceso</span>
        </div>

        <?php if ($error): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="usuario" placeholder="👤 Usuario" required>
            <input type="password" name="clave" placeholder="🔑 Contraseña" required>
            <input type="submit" value="➡️ Entrar" class="btn">
        </form>

        <button class="btn" onclick="alternarTema()" id="toggle-tema">🌙 Cambiar tema</button>
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
