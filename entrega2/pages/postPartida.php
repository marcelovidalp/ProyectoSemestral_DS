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

if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit();
}
// Recibir datos del formulario
$ganada = isset($_POST['win']) && $_POST['win'] == '1' ? 1 : 0;
$kills = intval($_POST['kills']);
$muertes = intval($_POST['muertes']);
$asistencias = intval($_POST['asistencias']);
$mapa_id = intval($_POST['mapa_id']);
$agente_id = intval($_POST['agente_id']);
$juego_id = intval($_POST['juego_id']);
$user_id = intval($_POST['user_id']); // Si tienes sesión activa, obtén el user_id de la sesión

// Inserción de datos en la tabla Partidas
$sql = "INSERT INTO Partidas (ganada, kills, muertes, asistencias, mapa_id, agente_id, juego_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiiiiii", $ganada, $kills, $muertes, $asistencias, $mapa_id, $agente_id, $juego_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Partida añadida exitosamente"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error al añadir la partida: " . $stmt->error]);
}
?>
