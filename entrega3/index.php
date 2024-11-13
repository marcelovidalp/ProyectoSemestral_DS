<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ./templates/home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Tracker - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-dark text-white">
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="auth-container bg-secondary p-4 rounded-3 shadow-lg">
            <h2 class="text-center mb-4">Iniciar Sesión</h2>
            
            <?php if (isset($_SESSION['register_success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php 
                        echo $_SESSION['register_success'];
                        unset($_SESSION['register_success']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php 
                        echo $_SESSION['login_error'];
                        unset($_SESSION['login_error']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form id="loginForm" @submit="handleSubmit" class="needs-validation" novalidate>
                <div v-if="errors.length" class="alert alert-danger">
                    <ul class="mb-0">
                        <li v-for="error in errors">{{ error }}</li>
                    </ul>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" 
                           class="form-control bg-dark text-white" 
                           id="username" 
                           v-model="formData.username" 
                           required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" 
                           class="form-control bg-dark text-white" 
                           id="password" 
                           v-model="formData.password" 
                           required>
                </div>
                <button type="submit" 
                        class="btn btn-warning w-100 mb-3 btn-lg fw-bold" 
                        :disabled="loading">
                    {{ loading ? 'Procesando...' : 'Iniciar Sesión' }}
                </button>
                
                <div class="text-center">
                    <p class="text-white mb-2">¿Aún no tienes una cuenta?</p>
                    <a href="templates/registrarse.php" class="btn btn-outline-warning fw-bold">Registrarse</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14/dist/vue.js"></script>
    <script src="assets/JS/script.js"></script>
    </body>
</html>