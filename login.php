<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include 'conexion.php';
$conexion= conectar();

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
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - REY CORPORACIÓN</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body class="body_rey">
    <div id="firma">
        <div class="titulo_logo">
            <img src="logo.png" alt="Logo">
            <span>Acceso</span>
        </div>
        <?php if ($error): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post">
            <p><input type="text" name="usuario" placeholder="Usuario" required></p>
            <p><input type="password" name="clave" placeholder="Contraseña" required></p>
            <p><input type="submit" value="Entrar"></p>
        </form>
    </div>
</body>
</html>
