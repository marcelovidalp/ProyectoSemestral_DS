<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Incluir la configuración de conexión
include 'config.inc';

// Verificar si la conexión es exitosa
if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Error en la conexión a la base de datos']);
    exit();
}

// Obtener el ID del juego desde el GET o POST
$juego_id = isset($_GET['juego_id']) ? intval($_GET['juego_id']) : 0;

if ($juego_id === 0) {
    echo json_encode(['status' => 'error', 'message' => 'ID de juego inválido']);
    exit();
}

// Realiza la consulta para obtener los mapas del juego específico
$query = "SELECT id_mapas, nombre FROM mapas WHERE id_juego = ?";
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
