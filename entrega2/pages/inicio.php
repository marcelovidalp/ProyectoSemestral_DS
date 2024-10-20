<?php
require 'config.inc';

// Configuración de cookies de sesión
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict',
]);

session_start();

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
        // Guardar el ID del usuario en la sesión (usando id_users)
        $_SESSION['user_id'] = $row['id_users'];  
        $_SESSION['username'] = $username;
        
        // Redireccionar al home o a la página deseada
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
