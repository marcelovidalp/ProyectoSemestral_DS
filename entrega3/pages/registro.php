<?php
require 'config.inc';

header('Content-Type: application/json');

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict',
]);

session_start();

// Recibir datos JSON
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'] ?? '';
$pass = $data['password'] ?? '';
$email = $data['email'] ?? '';

// Validaciones
$errors = [];

if (empty($username)) {
    $errors[] = "El nombre de usuario es requerido";
}

if (empty($email)) {
    $errors[] = "El correo electrónico es requerido";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "El formato del correo no es válido";
}

if (empty($pass)) {
    $errors[] = "La contraseña es requerida";
} elseif (strlen($pass) < 8) {
    $errors[] = "La contraseña debe tener al menos 8 caracteres";
}

// Verificar si el usuario ya existe
$stmt = $conn->prepare("SELECT id_users FROM dw2_users WHERE username = ? OR correo = ?");
$stmt->bind_param('ss', $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $errors[] = "El usuario o correo ya está registrado";
}

if (!empty($errors)) {
    echo json_encode([
        'status' => 'error',
        'errors' => $errors
    ]);
    exit();
}

// Encriptar la contraseña
$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

// Insertar nuevo usuario
$stmt = $conn->prepare("INSERT INTO dw2_users (username, passwd, correo) VALUES (?, ?, ?)");
$stmt->bind_param('sss', $username, $hashed_pass, $email);

if ($stmt->execute()) {
    $_SESSION['register_success'] = '¡Registro exitoso! Ya puedes iniciar sesión.';
    echo json_encode([
        'status' => 'success',
        'message' => 'Registro exitoso',
        'redirect' => '../index.php'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'errors' => ['Error al crear la cuenta. Por favor, intenta nuevamente.']
    ]);
}

$stmt->close();
$conn->close();
?>