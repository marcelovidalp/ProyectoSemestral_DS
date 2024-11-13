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
    <title>Game Tracker</title>
</head>
<body>

    <?php include 'header_template.php'; ?>

    <main class="container my-5">
        <section id="home" class="text-center mb-5">
            <h2 class="bienvenido display-5">Bienvenido al Game Tracker</h2>
            <p class="text-muted">Este sitio te ayuda a llevar un <strong>seguimiento</strong> de tu progreso en tus videojuegos favoritos. Haz un <em>click</em> en cada sección para ver más detalles.</p>
            <hr class="my-4">
        </section>
    
        <section>
            <div class="row text-center">
                <div class="col-md-6 mb-4">
                    <a href="valo.php" class="d-block">
                        <img src="../assets/imgs/valo-logo.png" class="img-fluid shadow rounded" alt="Valorant Logo" style="max-width: 200px;">
                    </a>
                    <p class="text-muted mt-2">Explora tus estadísticas en Valorant</p>
                </div>
                <div class="col-md-6 mb-4">
                    <a href="cs2.php" class="d-block">
                        <img src="../assets/imgs/cs-logo.png" class="img-fluid shadow rounded" alt="Counter Strike Logo" style="max-width: 200px;">
                    </a>
                    <p class="text-muted mt-2">Explora tus estadísticas en Counter Strike</p>
                </div>
            </div>
        </section>
        
        <section id="rankings" class="my-5">
            <h2 class="text-center mb-4">Rankings por Juego</h2>
            <div class="row mb-4">
                <!-- Valorant Rankings -->
                <div class="col-md-6 mb-4">
                    <h3 class="text-center">Valorant</h3>
                    <div class="card bg-dark text-white mb-3">
                        <div class="card-header">
                            <h4 class="text-center">Top Winrate Valorant</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Usuario</th>
                                            <th>Partidas</th>
                                            <th>Victorias</th>
                                            <th>Winrate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(player, index) in valorantWinrateRankings" :key="player.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ player.username }}</td>
                                            <td>{{ player.total_partidas }}</td>
                                            <td>{{ player.victorias }}</td>
                                            <td>{{ player.winrate }}%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-dark text-white">
                        <div class="card-header">
                            <h4 class="text-center">Top KDA Valorant</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Usuario</th>
                                            <th>Kills</th>
                                            <th>Deaths</th>
                                            <th>Assists</th>
                                            <th>KDA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(player, index) in valorantKdaRankings" :key="player.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ player.username }}</td>
                                            <td>{{ player.kills }}</td>
                                            <td>{{ player.deaths }}</td>
                                            <td>{{ player.assists }}</td>
                                            <td>{{ player.kda }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CS2 Rankings -->
                <div class="col-md-6 mb-4">
                    <h3 class="text-center">Counter-Strike 2</h3>
                    <div class="card bg-dark text-white mb-3">
                        <div class="card-header">
                            <h4 class="text-center">Top Winrate CS2</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Usuario</th>
                                            <th>Partidas</th>
                                            <th>Victorias</th>
                                            <th>Winrate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(player, index) in cs2WinrateRankings" :key="player.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ player.username }}</td>
                                            <td>{{ player.total_partidas }}</td>
                                            <td>{{ player.victorias }}</td>
                                            <td>{{ player.winrate }}%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-dark text-white">
                        <div class="card-header">
                            <h4 class="text-center">Top KDA CS2</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Usuario</th>
                                            <th>Kills</th>
                                            <th>Deaths</th>
                                            <th>Assists</th>
                                            <th>KDA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(player, index) in cs2KdaRankings" :key="player.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ player.username }}</td>
                                            <td>{{ player.kills }}</td>
                                            <td>{{ player.deaths }}</td>
                                            <td>{{ player.assists }}</td>
                                            <td>{{ player.kda }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p class="mb-0">&copy; 2024 Game Tracker. Todos los derechos reservados.</p>
        <p class="small text-muted">Diseñado para jugadores apasionados</p>
    </footer>

    <?php include 'scripts_config.php'; ?>

</body>
</html>