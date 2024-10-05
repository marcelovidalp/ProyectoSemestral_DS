<?php
session_start(); // Iniciar la sesión

// Conexión a la base de datos
$host = "mysql.inf.uct.cl";  
$user = "marcelo_vidal";    
$password = "2x5EXaUNG0-ZcB360";      
$dbname = "A2023_marcelo_vidal"; 

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$username = $_POST['username'];
$pass = $_POST['password'];

// Buscar al usuario en la base de datos
$sql = "SELECT * FROM dw2_users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verificar la contraseña
    if (password_verify($pass, $row['password'])) {
        $_SESSION['username'] = $user; // Guardar el usuario en la sesión
        echo "Inicio de sesión exitoso. Bienvenido, $username.";
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}

$conn->close();
?>