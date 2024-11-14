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
    // Query para Winrate (tanto para Valorant como CS2)
    $winrateQuery = "
        SELECT 
            u.username,
            COUNT(*) as total_partidas,
            SUM(p.resultado) as victorias,
            ROUND((SUM(p.resultado) * 100.0 / COUNT(*)), 2) as winrate
        FROM dw2_users u
        JOIN dw2_partidas p ON u.id_users = p.id_user
        WHERE p.id_juego = ?
        GROUP BY u.id_users, u.username
        ORDER BY winrate DESC, total_partidas DESC
        LIMIT 10";

    // Query para KDA (tanto para Valorant como CS2)
    $kdaQuery = "
        SELECT 
            u.username,
            SUM(p.asesinatos) as kills,
            SUM(p.muertes) as deaths,
            SUM(p.asistencias) as assists,
            ROUND(
                (SUM(p.asesinatos) + (SUM(p.asistencias) * 0.5)) / 
                CASE 
                    WHEN SUM(p.muertes) = 0 THEN 1 
                    ELSE SUM(p.muertes) 
                END
            , 2) as kda
        FROM dw2_users u
        JOIN dw2_partidas p ON u.id_users = p.id_user
        WHERE p.id_juego = ?
        GROUP BY u.id_users, u.username
        ORDER BY kda DESC, kills DESC
        LIMIT 10";

    // Preparar y ejecutar consultas para Valorant (id_juego = 1)
    $stmtValoWinrate = $conn->prepare($winrateQuery);
    $stmtValoWinrate->bind_param("i", $valorantId);
    $valorantId = 1;
    $stmtValoWinrate->execute();
    $valorantWinrate = $stmtValoWinrate->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmtValoKda = $conn->prepare($kdaQuery);
    $stmtValoKda->bind_param("i", $valorantId);
    $stmtValoKda->execute();
    $valorantKda = $stmtValoKda->get_result()->fetch_all(MYSQLI_ASSOC);

    // Preparar y ejecutar consultas para CS2 (id_juego = 2)
    $stmtCs2Winrate = $conn->prepare($winrateQuery);
    $stmtCs2Winrate->bind_param("i", $cs2Id);
    $cs2Id = 2;
    $stmtCs2Winrate->execute();
    $cs2Winrate = $stmtCs2Winrate->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmtCs2Kda = $conn->prepare($kdaQuery);
    $stmtCs2Kda->bind_param("i", $cs2Id);
    $stmtCs2Kda->execute();
    $cs2Kda = $stmtCs2Kda->get_result()->fetch_all(MYSQLI_ASSOC);

    // Cerrar statements
    $stmtValoWinrate->close();
    $stmtValoKda->close();
    $stmtCs2Winrate->close();
    $stmtCs2Kda->close();

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


