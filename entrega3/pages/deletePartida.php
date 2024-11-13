
<?php
require 'config.inc';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$partida_id = $data['partida_id'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$partida_id) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "ID de partida no proporcionado"]);
    exit;
}

try {
    // Verificar que la partida pertenece al usuario
    $stmt = $conn->prepare("DELETE FROM dw2_partidas WHERE id_partidas = ? AND id_user = ?");
    $stmt->bind_param("ii", $partida_id, $user_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "message" => "Partida eliminada correctamente"]);
        } else {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "No se encontró la partida o no tienes permiso para eliminarla"]);
        }
    } else {
        throw new Exception("Error al eliminar la partida");
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Error al eliminar la partida: " . $e->getMessage()]);
}

$stmt->close();
$conn->close();
?>