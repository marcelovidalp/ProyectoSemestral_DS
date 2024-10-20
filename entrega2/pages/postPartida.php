<?php

require 'config.inc';

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict',
]);

session_start();

$data = json_decode(file_get_contents('php://input'), true);

// Asignar los datos a las variables
$ganada = isset($data['wins']) && $data['wins'] == 1 ? 1 : 0;
$kills = intval($data['kills']);
$muertes = intval($data['deaths']);
$asistencias = intval($data['assists']);
$mapa_id = intval($data['mapa_id']);
$agente_id = intval($data['agente_id']);
$juego_id = intval($data['juego_id']);
$user_id = intval($data['user_id']);

// Inserción de datos en la tabla Partidas
$sql = "INSERT INTO dw2_partidas (resultado, asesinatos, muertes, asistencias, id_mapa, id_agente, id_user, id_juego) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiiiiii", $ganada, $kills, $muertes, $asistencias, $mapa_id, $agente_id, $user_id, %juego_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Partida añadida exitosamente"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error al añadir la partida: " . $stmt->error]);
}
?>
