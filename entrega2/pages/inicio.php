<?php
$config = '/entrega2/pages/config.php';

include $config;

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
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