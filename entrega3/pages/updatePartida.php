
<?php
require 'config.inc';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $_SESSION['user_id'];

if (!isset($data['id_partidas'], $data['resultado'], $data['asesinatos'], $data['muertes'], $data['asistencias'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
    exit;
}

try {
    $query = "UPDATE dw2_partidas 
              SET resultado = ?, asesinatos = ?, muertes = ?, asistencias = ?
              WHERE id_partidas = ? AND id_user = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiiii", 
        $data['resultado'],
        $data['asesinatos'],
        $data['muertes'],
        $data['asistencias'],
        $data['id_partidas'],
        $user_id
    );
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "message" => "Partida actualizada correctamente"]);
        } else {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "No se encontró la partida o no tienes permiso para editarla"]);
        }
    } else {
        throw new Exception("Error al actualizar la partida");
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Error al actualizar la partida: " . $e->getMessage()]);
}

$stmt->close();
$conn->close();
?>