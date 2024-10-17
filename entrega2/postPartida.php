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
    $rondasTotales = $_POST['rondas_totales'];
    $kills = $_POST['kills'];
    $deaths = $_POST['deaths'];
    $assists = $_POST['assists'];
    $win_losse = $_POST['win_losse'];
    $game = $_POST['game'];
    $agente = $_POST['select_agente'];
    $mapa = $_POST['map'];

    // Preparar consulta SQL
    $sql = "INSERT INTO dw2_partidas (agente_id, map_id, rondas_totales, kills, deaths, assists, juego, win_losse)
            VALUES ('$agente','$mapa', '$rondasTotales', '$kills', '$deaths', '$assists', '$win_losse', '$game', '$agente', '$mapa', $win_losse)";

    if ($conn->query($sql) === TRUE) {
        echo "Partida añadida exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
