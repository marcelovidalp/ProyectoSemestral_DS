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
$email = $_post['email'];

// Insertar el nuevo usuario en la base de datos
$sql = "INSERT INTO dw2_users (user, passwd, correo) VALUES ('$username', '$pass', '$email)";

if ($conn->query($sql) === TRUE) {
    echo "Usuario registrado exitosamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>