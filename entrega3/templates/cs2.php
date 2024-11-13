<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'head_config.php'; ?>
    <title>Game Tracker - Counter Strike</title>
    <link rel="stylesheet" href="../assets/css/cs2.css">
</head>
<body>

    <!-- Header -->
    <?php include 'header_template.php'; ?>

    <!-- Main-->
    <main class="container mt-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-danger mb-3 text-shadow game-title">COUNTER-STRIKE 2</h1>
            <p class="lead fs-3 text-white bg-dark bg-opacity-75 p-3 rounded shadow-lg border border-danger">RUSH B CON P90!!</p>
        </div>

        <!-- Selector de juego -->
        <section class="text-center mb-5">
            <div class="row justify-content-center mt-4">
                <div class="col-md-3 mb-3">
                    <a href="valo.php">
                        <img src="../assets/imgs/valo-logo.png" class="img-fluid shadow rounded" alt="Valorant Logo" style="max-width: 150px;">
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="cs2.php">
                        <img src="../assets/imgs/cs-logo.png" class="img-fluid shadow rounded" alt="Counter Strike Logo" style="max-width: 150px;">
                    </a>
                </div>
            </div>
        </section>

        <!-- Form agregar stats-->
        <section id="add-stats" class="bg-light p-4 rounded shadow-sm my-5">
            <h2 class="text-center mb-4 text-black">Añadir Nueva Partida</h2>
            <form id="stats-form">
                <input type="hidden" id="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <div class="form-group">
                    <label for="win" class="label-black">¿Ganaste?:</label>
                    <select name="win" id="win" class="form-control" required>
                        <option value="win">Sí</option>
                        <option value="loss">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kills" class="label-black">Asesinatos:</label>
                    <input type="number" id="kills" name="kills" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="deaths" class="label-black">Muertes:</label>
                    <input type="number" id="deaths" name="deaths" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="assists" class="label-black">Asistencias:</label>
                    <input type="number" id="assists" name="assists" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="map" class="label-black">Mapa:</label>
                    <select name="map" id="map" class="form-control" required>
                        <option value="">Selecciona el mapa</option>
                        <!-- Opciones de mapas -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-4">Agregar</button>
            </form>
        </section>
        
        <!-- Tabla con estadisticas -->
        <div id="user-stats">
            <section id="stats" class="bg-dark text-white p-4 rounded shadow-sm">
                <h2 class="text-center mb-4">Estadísticas Generales</h2>
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <h5>Partidas Jugadas</h5>
                            <p class="display-4">{{ totalMatches }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <h5>Victorias</h5>
                            <p class="display-4">{{ totalWins }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <h5>Derrotas</h5>
                            <p class="display-4">{{ totalLosses }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <h5>Winrate</h5>
                            <p class="display-4">{{ winrate }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <h5>Kills</h5>
                            <p class="display-4">{{ totalKills }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <h5>Deaths</h5>
                            <p class="display-4">{{ totalDeaths }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <h5>Assists</h5>
                            <p class="display-4">{{ totalAssists }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <h5>K/D Ratio</h5>
                            <p class="display-4">{{ kdRatio }}</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>    
    </main>

</body>
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p class="mb-0">&copy; 2024 Game Tracker. Todos los derechos reservados.</p>
        <p class="small text-muted">Mantente al tanto de tu rendimiento en Counter Strike</p>
    </footer>

    <!-- jQuery and Bootstrap JavaScript -->
    <?php include 'scripts_config.php'; ?>
</html>