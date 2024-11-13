<?php
require 'config.inc';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
    exit();
}

$sql = "SELECT id_agentes, nombre, rol FROM dw2_agentes";
$result = $conn->query($sql);

$agentes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $agentes[] = $row;
    }
}

echo json_encode($agentes);
?>