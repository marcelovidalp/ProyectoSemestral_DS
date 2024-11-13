<?php
session_start();
require 'config.inc';

header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No session found'
    ]);
    exit;
}

try {
    // Query para Valorant Winrate
    $valorantWinrateQuery = "
        SELECT u.username, 
               COUNT(*) as total_partidas,
               SUM(p.resultado) as victorias,
               ROUND((SUM(p.resultado) * 100 / COUNT(*)), 2) as winrate
        FROM dw2_users u
        JOIN dw2_partidas p ON u.id_users = p.id_user
        WHERE p.id_juego = 1
        GROUP BY u.id_users, u.username
        ORDER BY winrate DESC
        LIMIT 10";

    // Query para Valorant KDA
    $valorantKdaQuery = "
        SELECT u.username,
               SUM(p.asesinatos) as kills,
               SUM(p.muertes) as deaths,
               SUM(p.asistencias) as assists,
               ROUND((SUM(p.asesinatos) + SUM(p.asistencias)/2) / NULLIF(SUM(p.muertes), 0), 2) as kda
        FROM dw2_users u
        JOIN dw2_partidas p ON u.id_users = p.id_user
        WHERE p.id_juego = 1
        GROUP BY u.id_users, u.username
        ORDER BY kda DESC
        LIMIT 10";

    // Query para CS2 Winrate
    $cs2WinrateQuery = "
        SELECT u.username, 
               COUNT(*) as total_partidas,
               SUM(p.resultado) as victorias,
               ROUND((SUM(p.resultado) * 100 / COUNT(*)), 2) as winrate
        FROM dw2_users u
        JOIN dw2_partidas p ON u.id_users = p.id_user
        WHERE p.id_juego = 2
        GROUP BY u.id_users, u.username
        ORDER BY winrate DESC
        LIMIT 10";

    // Query para CS2 KDA
    $cs2KdaQuery = "
        SELECT u.username,
               SUM(p.asesinatos) as kills,
               SUM(p.muertes) as deaths,
               SUM(p.asistencias) as assists,
               ROUND((SUM(p.asesinatos) + SUM(p.asistencias)/2) / NULLIF(SUM(p.muertes), 0), 2) as kda
        FROM dw2_users u
        JOIN dw2_partidas p ON u.id_users = p.id_user
        WHERE p.id_juego = 2
        GROUP BY u.id_users, u.username
        ORDER BY kda DESC
        LIMIT 10";

    $valorantWinrate = $conn->query($valorantWinrateQuery)->fetch_all(MYSQLI_ASSOC);
    $valorantKda = $conn->query($valorantKdaQuery)->fetch_all(MYSQLI_ASSOC);
    $cs2Winrate = $conn->query($cs2WinrateQuery)->fetch_all(MYSQLI_ASSOC);
    $cs2Kda = $conn->query($cs2KdaQuery)->fetch_all(MYSQLI_ASSOC);

    echo json_encode([
        'status' => 'success',
        'valorantWinrate' => $valorantWinrate,
        'valorantKda' => $valorantKda,
        'cs2Winrate' => $cs2Winrate,
        'cs2Kda' => $cs2Kda
    ]);

} catch(Exception $e) {
    error_log("Error in getRankings.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

$conn->close();
?>


