<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
} // cloudfare.com para el tarrito de basura
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Game Tracker</title>
    <?php include 'head_config.php'; ?>
    <link rel="stylesheet" href="../assets/css/partidas.css">
</head>

<body>
    <?php include 'header_template.php'; ?>
    <input type="hidden" id="user_id" value="<?php echo $_SESSION['user_id']; ?>">
    <div id="partidas-list" class="container my-5">
        <h2 class="text-center mb-4">Historial de Partidas</h2>
        <!-- Indicador de carga -->
        <div v-if="cargando" class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
        <!-- Lista de partidas -->
        <div v-else>
            <div v-if="partidas.length > 0" class="row">
                <div v-for="partida in partidas" :key="partida.id_partidas" class="col-md-6 mb-4">
                    <div class="card h-100" :class="{'border-success': partida.resultado == 1, 'border-danger': partida.resultado == 0}">
                        <div class="card-header" :class="{'bg-success text-white': partida.resultado == 1, 'bg-danger text-white': partida.resultado == 0}">
                            {{ partida.nombre_juego }} - {{ partida.resultado == 1 ? 'Victoria' : 'Derrota' }}
                        </div>
                        <div class="card-body text-dark">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-subtitle mb-3">Estadísticas</h5>
                                    <p class="mb-2"><strong>K/D/A:</strong> {{ partida.asesinatos }}/{{ partida.muertes }}/{{ partida.asistencias }}</p>
                                    <p class="mb-2"><strong>Mapa:</strong> {{ partida.nombre_mapa }}</p>
                                    <p v-if="partida.nombre_agente" class="mb-2"><strong>Agente:</strong> {{ partida.nombre_agente }}</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="btn-group">
                                        <button @click="editarPartida(partida)" 
                                                class="btn btn-primary btn-sm">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button @click="eliminarPartida(partida.id_partidas)" 
                                                class="btn btn-danger btn-sm ms-2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <div v-else class="text-center">
                <p class="lead">No hay partidas registradas</p>
            </div>
        </div>
        
        <!-- Modal para editar partida -->
        <div class="modal fade" id="editarPartidaModal" tabindex="-1" aria-labelledby="editarPartidaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarPartidaModalLabel">
                            <i class="fas fa-edit me-2"></i>Editar Partida
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" v-if="partidaEditando">
                        <form @submit.prevent="actualizarPartida" class="edit-form">
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-trophy me-2"></i>Resultado</label>
                                <select v-model="partidaEditando.resultado" class="form-select">
                                    <option value="1">Victoria</option>
                                    <option value="0">Derrota</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-crosshairs"></i> Asesinatos</label>
                                <input type="number" v-model="partidaEditando.asesinatos" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-skull"></i> Muertes</label>
                                <input type="number" v-model="partidaEditando.muertes" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-hands-helping"></i> Asistencias</label>
                                <input type="number" v-model="partidaEditando.asistencias" class="form-control">
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Guardar cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p class="mb-0">&copy; 2024 Game Tracker. Todos los derechos reservados.</p>
        <p class="small text-muted">Mantente al tanto de tu rendimiento en Counter Strike</p>
    </footer>

    <!-- Scripts -->
    <?php include 'scripts_config.php'; ?>
</html>
