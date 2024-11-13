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
        <section id="home" class="text-center mb-5 py-4 bg-dark bg-opacity-75 rounded-3 shadow-lg border border-warning">
            <h2 class="bienvenido display-4 text-warning fw-bold mb-3">Bienvenido al Game Tracker <strong>DEFINITIVO</strong></h2>
            <p class="lead text-white">Este sitio te ayuda a llevar un seguimiento de tus <strong class="text-warning">estadísticas</strong> y <strong class="text-warning">partidas</strong> en tus videojuegos favoritos.</p>
            <p class="lead text-white mb-0">Haz <em class="text-warning">click</em> en tu videojuego favorito para comenzar.</p>
        </section>

        <section class="mt-5">
            <div class="row text-center g-4">
                <div class="col-md-6">
                    <a href="valo.php" class="d-block hover-effect">
                        <img src="../assets/imgs/valo-logo.png" class="img-fluid shadow-lg rounded" alt="Valorant Logo" style="max-width: 200px;">
                    </a>
                    <p class="text-white mt-3 bg-dark bg-opacity-75 p-2 rounded-pill d-inline-block px-4">Añade tus estadísticas en Valorant</p>
                </div>
                <div class="col-md-6">
                    <a href="cs2.php" class="d-block hover-effect">
                        <img src="../assets/imgs/cs-logo.png" class="img-fluid shadow-lg rounded" alt="Counter Strike Logo" style="max-width: 200px;">
                    </a>
                    <p class="text-white mt-3 bg-dark bg-opacity-75 p-2 rounded-pill d-inline-block px-4">Añade tus estadísticas en Counter-Strike 2</p>
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