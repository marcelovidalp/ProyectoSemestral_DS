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

$sql = "SELECT id, nombre FROM Mapas";
$result = $conn->query($sql);

$mapas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mapas[] = $row;
    }
}

echo json_encode($mapas);
?>
