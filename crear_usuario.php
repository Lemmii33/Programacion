<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ==== CONFIGURA TUS DATOS DE CONEXIÓN ====
$host = "localhost";           // o 127.0.0.1 si es local
$db = "Ventas";      // CAMBIA esto por el nombre real
$user = "producto";                // o tu usuario
$pass = "W4ll4p0p@";                    // contraseña de MySQL

// Conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// ==== DATOS DEL NUEVO USUARIO ====
$usuario = "admin";
$password_plano = "12345";

// Hashear la contraseña
$hash = password_hash($password_plano, PASSWORD_DEFAULT);

// Insertar en la tabla
$stmt = $conn->prepare("INSERT INTO usuarios (usuario, clave) VALUES (?, ?)");
if (!$stmt) {
    die("Error al preparar consulta: " . $conn->error);
}

$stmt->bind_param("ss", $usuario, $hash);
$stmt->execute();

// Verificar resultado
if ($stmt->affected_rows === 1) {
    echo "<p style='color:green;'>✅ Usuario '$usuario' creado correctamente.</p>";
} else {
    echo "<p style='color:red;'>❌ Error al crear usuario: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();
?>
