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

$sql = "SELECT id, nombre, rol FROM Agentes";
$result = $conn->query($sql);

$agentes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $agentes[] = $row;
    }
}

echo json_encode($agentes);
?>