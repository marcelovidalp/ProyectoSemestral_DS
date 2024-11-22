<?php

require 'config.inc';

header('Content-Type: application/json');

// Iniciar la sesión
session_start();

if (!isset($_SESSION['user_id'])) {
    error_log("Usuario no autenticado");
    echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
    exit();
}

// Recibir datos del formulario
$username = $_POST['username'];

// Decodificar el JSON recibido
$data = json_decode(file_get_contents('php://input'), true);

// Depuración: Imprimir los datos recibidos para verificar si están completos
error_log("Datos recibidos: " . print_r($data, true));

// Verificar si los datos necesarios están presentes para ambos juegos
if (!isset($data['wins'], $data['kills'], $data['deaths'], $data['assists'], $data['mapa_id'], $data['juego_id'], $data['user_id'])) {
    error_log("Faltan datos para añadir la partida");
    echo json_encode(["status" => "error", "message" => "Faltan datos para añadir la partida"]);
    exit;
}

// Si es Valorant (juego_id = 1), se requiere el agente_id
if ($data['juego_id'] == 1) {
    if (!isset($data['agente_id'])) {
        error_log("Faltan datos del agente para Valorant");
        echo json_encode(["status" => "error", "message" => "Faltan datos del agente para Valorant"]);
        exit;
    }
    $agente_id = intval($data['agente_id']);
} else {
    // Para CS2 (juego_id = 2), no necesitamos agente_id
    $agente_id = null;
}

// Asignar los datos a variables, asegurando que sean enteros
$ganada = intval($data['wins']);
$kills = intval($data['kills']);
$muertes = intval($data['deaths']);
$asistencias = intval($data['assists']);
$mapa_id = intval($data['mapa_id']);
$juego_id = intval($data['juego_id']);
$user_id = intval($data['user_id']);  // Obtener el id del usuario autenticado desde los datos recibidos

// Verificar la conexión a la base de datos
if (!isset($conn)) {
    error_log("Conexión a la base de datos no establecida");
    echo json_encode(["status" => "error", "message" => "Conexión a la base de datos no establecida"]);
    exit;
}

// Preparar la consulta SQL según si es Valorant o CS2
if ($juego_id == 1) {
    // Si es Valorant, incluir el agente_id
    $sql = "INSERT INTO dw2_partidas (resultado, asesinatos, muertes, asistencias, id_mapa, id_agente, id_user, id_juego) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiiiii", $ganada, $kills, $muertes, $asistencias, $mapa_id, $agente_id, $user_id, $juego_id);
} else {
    // Si es CS2, no se incluye el agente_id
    $sql = "INSERT INTO dw2_partidas (resultado, asesinatos, muertes, asistencias, id_mapa, id_user, id_juego) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiiii", $ganada, $kills, $muertes, $asistencias, $mapa_id, $user_id, $juego_id);
}

// Ejecutar la consulta y verificar si fue exitosa
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Partida añadida exitosamente"]);
} else {
    error_log("Error al añadir la partida: " . $stmt->error);
    echo json_encode(["status" => "error", "message" => "Error al añadir la partida: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
