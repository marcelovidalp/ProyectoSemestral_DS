<?php
session_start();
require 'config.inc';

// Asegurarse de que estamos recibiendo una solicitud JSON
header('Content-Type: application/json');

// Obtener los datos JSON del cuerpo de la solicitud
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$username = $data['username'] ?? null;
$pass = $data['password'] ?? null;

if (!$username || !$pass) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Por favor ingresa usuario y contraseña.'
    ]);
    exit();
}

try {
    $stmt = $conn->prepare("SELECT * FROM dw2_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($pass, $user['passwd'])) {
            $_SESSION['user_id'] = $user['id_users'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['last_activity'] = time();
            
            echo json_encode([
                'status' => 'success',
                'redirect' => './templates/home.php'  // Ruta actualizada
            ]);
            exit();
        }
    }

    echo json_encode([
        'status' => 'error',
        'message' => 'Usuario o contraseña incorrectos.'
    ]);
    
} catch (Exception $e) {
    error_log("Error en login: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Error del sistema.'
    ]);
}

$stmt->close();
$conn->close();
?>
