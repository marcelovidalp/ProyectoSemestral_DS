<?php
require 'config.inc';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $query = "SELECT p.id_partidas, p.resultado, p.asesinatos, p.muertes, p.asistencias,
                     p.id_juego, m.nombre AS nombre_mapa, 
                     j.nombre AS nombre_juego,
                     CASE WHEN j.nombre = 'Valorant' THEN a.nombre ELSE NULL END AS nombre_agente
              FROM dw2_partidas p
              JOIN dw2_mapas m ON p.id_mapa = m.id_mapas
              JOIN dw2_juegos j ON p.id_juego = j.id_juegos
              LEFT JOIN dw2_agentes a ON p.id_agente = a.id_agentes
              WHERE p.id_user = ?
              ORDER BY p.id_partidas DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $partidas = [];
    while ($row = $result->fetch_assoc()) {
        $partidas[] = [
            'id_partidas' => $row['id_partidas'],
            'id_juego' => (int)$row['id_juego'], // Aseguramos que sea entero
            'resultado' => $row['resultado'],
            'asesinatos' => $row['asesinatos'],
            'muertes' => $row['muertes'],
            'asistencias' => $row['asistencias'],
            'nombre_mapa' => $row['nombre_mapa'],
            'nombre_juego' => $row['nombre_juego'],
            'nombre_agente' => $row['nombre_agente']
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($partidas);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Error al obtener las partidas: " . $e->getMessage()
    ]);
}

$stmt->close();
$conn->close();
?>


