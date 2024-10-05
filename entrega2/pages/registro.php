<?php
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

$sql = "INSERT INTO dw2_users (username, passwd, correo) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Vincular parámetros y ejecutar consulta preparada
$stmt->bind_param('sss', $username, $pass, $email);

if ($stmt->execute()) 
    {echo "Nuevo player añadido correctamente: $username $pass <br>";}

// Cerrar la consulta preparada

$stmt->close();
$conn->close();
?>