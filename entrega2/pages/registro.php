<?php
include 'entrega2/includes/config.php';

// Recibir datos del formulario
$username = $_POST['username'];
$pass = $_POST['password'];
$email = $_POST['email'];

// Validar entradas
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Formato de correo no válido.");
}
if (strlen($pass) < 8) {
    die("La contraseña debe tener al menos 8 caracteres.");
}

// Encriptar la contraseña
$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

// Insertar el nuevo usuario en la base de datos usando declaración preparada
$stmt = $conn->prepare("INSERT INTO dw2_users (user, passwd, correo) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $hashed_pass, $email);

if ($stmt->execute()) {
    echo "Usuario registrado exitosamente.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>