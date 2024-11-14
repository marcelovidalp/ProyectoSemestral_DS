
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'head_config.php'; ?>
    <title>Rankings - Game Tracker</title>
</head>
<body>
    <?php include 'header_template.php'; ?>

    <main class="container my-5">
        <h1 class="text-center mb-5">Rankings Globales</h1>
        
        <section id="rankings">
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

</body>
    <?php include 'scripts_config.php'; ?>
    <?php include 'footer_template.php'; ?>
</html>