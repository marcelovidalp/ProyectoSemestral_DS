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