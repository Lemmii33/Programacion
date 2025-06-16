<?php
include 'conexion.php';

// Datos del nuevo usuario
$usuario = 'lemmi';
$password_plano = '12345';

// Hashear la contraseña
$password_hash = password_hash($password_plano, PASSWORD_DEFAULT);

// Insertar en la base de datos
$stmt = $conexion->prepare("INSERT INTO usuarios (usuario, clave) VALUES (?, ?)");
$stmt->bind_param("ss", $usuario, $password_hash);
$stmt->execute();

if ($stmt->affected_rows === 1) {
    echo "Usuario creado con éxito.";
} else {
    echo "Error al crear usuario.";
}

$stmt->close();
$conexion->close();
?>
