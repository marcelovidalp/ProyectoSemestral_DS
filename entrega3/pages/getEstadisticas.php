<?php
require 'config.inc'; // conexion a la bd

session_start();//mantenemos sesion iniciada

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
    exit();
}

$user_id = $_SESSION['user_id'];  // Obtener el id del usuario autenticado desde la sesión

$juego_id = $_GET['juego_id'] ?? null;
if (!$juego_id) {
    echo json_encode(["status" => "error", "message" => "Juego no especificado"]);
    exit();
}

// query get total matches, wins, losses, kills, deaths, assists dependiendo el juego
$sql = "SELECT 
            COUNT(*) AS total_partidas, 
            SUM(CASE WHEN resultado = 1 THEN 1 ELSE 0 END) AS total_victorias,
            SUM(CASE WHEN resultado = 0 THEN 1 ELSE 0 END) AS total_derrotas,
            SUM(asesinatos) AS total_kills,
            SUM(muertes) AS total_deaths,
            SUM(asistencias) AS total_assists
        FROM dw2_partidas 
        WHERE id_user = ? AND id_juego = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $juego_id);
$stmt->execute();
$result = $stmt->get_result();
$stats = $result->fetch_assoc();

if ($stats) {
    // calculamos winrate
    $winrate = $stats['total_victorias'] > 0 ? ($stats['total_victorias'] * 100) / $stats['total_partidas'] : 0;
    echo json_encode([
        "status" => "success",
        "total_partidas" => $stats['total_partidas'],
        "total_victorias" => $stats['total_victorias'],
        "total_derrotas" => $stats['total_derrotas'],
        "total_kills" => $stats['total_kills'],
        "total_deaths" => $stats['total_deaths'],
        "total_assists" => $stats['total_assists'],
        "winrate" => $winrate
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "No se encontraron estadísticas"]);
}
?>
