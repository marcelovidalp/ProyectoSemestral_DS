<?php
// Incluir la configuración de conexión
require 'config.inc';
session_start();//mantenemos sesion iniciada

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
    exit();
}

// Obtener el ID del juego desde el GET o POST
$juego_id = isset($_GET['juego_id']) ? intval($_GET['juego_id']) : 0;

if ($juego_id === 0) {
    echo json_encode(['status' => 'error', 'message' => 'ID de juego inválido']);
    exit();
}

// Realiza la consulta para obtener los mapas del juego específico
$query = "SELECT id_mapas, nombre FROM dw2_mapas WHERE id_juego = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $juego_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    echo json_encode(['status' => 'error', 'message' => 'Error en la consulta a la base de datos']);
    exit();
}

// Convierte el resultado a JSON
$mapas = [];
while ($row = mysqli_fetch_assoc($result)) {
    $mapas[] = $row;
}

// Enviar el JSON como respuesta
echo json_encode($mapas);
?>
