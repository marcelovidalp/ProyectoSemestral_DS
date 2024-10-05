<?php
session_start(); // Iniciar la sesión
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
        header("Location: /~marcelo.vidal/DesWeb/Proyecto/entrega2/templates/home.html");
        exit();
    } else {
        echo "Contraseña incorrecta.";
        header("Location: /~marcelo.vidal/DesWeb/Proyecto/entrega2/index.html");
        exit();
    }
} else {
    echo "Usuario no encontrado.";
    header("Location: /~marcelo.vidal/DesWeb/Proyecto/entrega2/index.html");
    exit();
}

$stmt->close();
$conn->close();
?>