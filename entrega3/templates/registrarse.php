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
            
            <form id="registerForm" @submit.prevent="handleSubmit" class="needs-validation" novalidate>
                <div v-if="errors.length" class="alert alert-danger">
                    <ul class="mb-0">
                        <li v-for="error in errors">{{ error }}</li>
                    </ul>
                </div>
                
                <div v-if="successMessage" class="alert alert-success alert-dismissible fade show">
                    {{ successMessage }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" 
                           class="form-control bg-dark text-white" 
                           id="username" 
                           v-model="formData.username"
                           :class="{'is-invalid': errors.includes('El nombre de usuario es requerido')}"
                           required>
                    <div class="invalid-feedback">Elige un nombre de usuario.</div>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" 
                           class="form-control bg-dark text-white" 
                           id="email" 
                           v-model="formData.email"
                           :class="{'is-invalid': errors.includes('El correo electrónico es requerido') || errors.includes('El formato del correo no es válido')}"
                           required>
                    <div class="invalid-feedback">Ingresa un correo válido.</div>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" 
                           class="form-control bg-dark text-white" 
                           id="password" 
                           v-model="formData.password"
                           :class="{'is-invalid': errors.includes('La contraseña debe tener al menos 8 caracteres')}"
                           required>
                    <div class="invalid-feedback">La contraseña debe tener al menos 8 caracteres.</div>
                </div>
                
                <button type="submit" 
                        class="btn btn-warning w-100 mb-3 btn-lg fw-bold"
                        :disabled="loading">
                    {{ loading ? 'Procesando...' : 'Registrarse' }}
                </button>
                
                <div class="text-center">
                    <p class="text-white mb-2">¿Ya tienes una cuenta?</p>
                    <a href="../index.php" class="btn btn-outline-warning fw-bold">Iniciar Sesión</a>
                </div>
            </form>
        </div>
    </div>
    <?php include 'scripts_config.php'; ?>
</body>
</html>