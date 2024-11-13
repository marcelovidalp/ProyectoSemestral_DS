<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'head_config.php'; ?>
    <title>Game Tracker</title>
</head>
<body class="bg-dark text-white">
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="auth-container bg-secondary p-4 rounded-3 shadow-lg">
            <h2 class="text-center mb-4">Registro</h2>
            
            <?php if (isset($_SESSION['register_error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php 
                        echo $_SESSION['register_error'];
                        unset($_SESSION['register_error']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form id="registerForm" action="../pages/register.php" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" class="form-control bg-dark text-white" id="username" name="username" required>
                    <div class="invalid-feedback">Elige un nombre de usuario.</div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control bg-dark text-white" id="email" name="email" required>
                    <div class="invalid-feedback">Ingresa un correo válido.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control bg-dark text-white" id="password" name="password" required>
                    <div class="invalid-feedback">La contraseña debe tener al menos 8 caracteres.</div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">Registrarse</button>
                <div class="text-center">
                    <a href="../index.php" class="text-white text-decoration-none">¿Ya tienes cuenta? Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>
<?php include 'scripts_config.php'; ?>
</body>
</html>