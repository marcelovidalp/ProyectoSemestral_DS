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

        <section class="mt-5">
            <div class="row justify-content-center g-4">
                <div class="col-md-6 text-center">
                    <a href="partidas.php" class="btn btn-warning btn-lg w-75">
                        <i class="fas fa-history me-2"></i>Ver Historial de Partidas
                    </a>
                </div>
                <div class="col-md-6 text-center">
                    <a href="rankings.php" class="btn btn-warning btn-lg w-75">
                        <i class="fas fa-trophy me-2"></i>Ver Rankings
                    </a>
                </div>
            </div>
        </section>
    </main>

</body>
    <?php include 'footer_template.php'; ?>
    <?php include 'scripts_config.php'; ?>
</html>