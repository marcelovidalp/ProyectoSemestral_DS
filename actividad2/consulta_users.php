<?php
header('Content-Type: application/json');

// Conectar a la base de datos
$host = "mysql.inf.uct.cl";  
$user = "marcelo_vidal";    
$password = "2x5EXaUNG0-ZcB360";      
$dbname = "A2023_marcelo_vidal"; 

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conn->connect_error]));
}

// Consulta SQL a la tabla dw2_users
$sql = "SELECT id_users, username, correo FROM dw2_users";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    $usuarios = array();

    // Guardar cada fila de resultado en el array
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }

    // Devolver los datos en formato JSON
    echo json_encode($usuarios);
} else {
    echo json_encode([]);
}

// Cerrar conexión
$conn->close();
?>
