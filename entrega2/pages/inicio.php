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
$username = $_POST['username'];
$pass = $_POST['password'];

// Buscar al usuario en la base de datos usando declaración preparada
$stmt = $conn->prepare("SELECT * FROM dw2_users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verificar la contraseña
    if (password_verify($pass, $row['passwd'])) {
        $_SESSION['username'] = $username; // Guardar el usuario en la sesión
        echo "Inicio de sesión exitoso. Bienvenido, $username.";
        header("Location: ../templates/home.html");
        exit();
    } else {
        echo "Contraseña incorrecta.";
        header("Location: ../index.html");
        exit();
    }
} else {
    echo "Usuario no encontrado.";
    header("Location: ../index.html");
    exit();
}

$stmt->close();
$conn->close();
?>