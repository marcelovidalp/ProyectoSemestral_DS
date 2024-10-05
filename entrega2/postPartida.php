<?php
$host = "mysql.inf.uct.cl";  
$user = "marcelo_vidal";    
$password = "2x5EXaUNG0-ZcB360";      
$dbname = "A2023_marcelo_vidal"; 

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $agente = $_POST['select_agente'];
    $assists = $_POST['assists'];
    $deaths = $_POST['deaths'];
    $juego_id = $_POST['juego_id'];
    $kills = $_POST['kills'];
    $mapa = $_POST['mapa'];
    $rondasTotales = $_POST['rondas_totales'];

    $win_losse = $_POST['win_losse'];
    // Preparar consulta SQL
    $sql = "INSERT INTO dw2_partida (agente_id, assists, deaths, juego_id, kills, map_id, rondas_totales, win_losse)
            VALUES ('$agente','$assists', '$deaths', $juego_id, '$kills', $mapa, '$rondasTotales', '$win_losse')";

    if ($conn->query($sql) === TRUE) {
        echo "Partida añadida exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
