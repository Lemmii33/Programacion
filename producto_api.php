<?php
include 'conexion.php';

$input = json_decode(file_get_contents("php://input"), true);
$response = ["ok" => false, "mensaje" => "Acción no válida."];

if ($input['accion'] === "actualizar" && isset($input['datos'])) {
    $d = $input['datos'];
    $stmt = $conn->prepare("UPDATE productos SET Nombre=?, Descripcion=?, Precio=?, Vendido=? WHERE Id=?");
    $stmt->bind_param("ssdii", $d['nombre'], $d['descripcion'], $d['precio'], $d['vendido'], $d['id']);
    if ($stmt->execute()) {
        $response = ["ok" => true, "mensaje" => "✅ Producto actualizado correctamente."];
    } else {
        $response['mensaje'] = "❌ Error al actualizar: " . $stmt->error;
    }
    $stmt->close();
}
elseif ($input['accion'] === "eliminar" && isset($input['id'])) {
    $stmt = $conn->prepare("DELETE FROM productos WHERE Id = ?");
    $stmt->bind_param("i", $input['id']);
    if ($stmt->execute()) {
        $response = ["ok" => true, "mensaje" => "🗑️ Producto eliminado correctamente."];
    } else {
        $response['mensaje'] = "❌ Error al eliminar: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
header("Content-Type: application/json");
echo json_encode($response);
