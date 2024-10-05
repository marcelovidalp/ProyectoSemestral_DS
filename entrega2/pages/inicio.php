<?php
session_start(); // Iniciar la sesión

include '.../pages/config.php';

// Recibir datos del formulario
$username = $_POST['username'];
$pass = $_POST['password'];

// Validar entradas
if (empty($username) || empty($pass)) {
    die("Por favor, complete todos los campos.");
}

// Buscar al usuario en la base de datos usando declaración preparada
$stmt = $conn->prepare("SELECT * FROM dw2_users WHERE user=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verificar la contraseña
    if (password_verify($pass, $row['passwd'])) {
        $_SESSION['username'] = $username; // Guardar el usuario en la sesión
        echo "Inicio de sesión exitoso. Bienvenido, $username.";
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}

$stmt->close();
$conn->close();
?>