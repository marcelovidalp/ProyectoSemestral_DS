/**
 * Game Tracker - Sistema de Gestión de Estadísticas para Juegos
 * Aplicación principal que maneja las estadísticas de juegos y rankings
 * Implementado con Vue.js para gestión de estado y actualizaciones reactivas
 * 
 * Características principales:
 * - Gestión de estadísticas por juego (Valorant y CS2)
 * - Sistema de rankings por Winrate y KDA
 * - CRUD completo de partidas
 * - Manejo de sesiones de usuario
 * - Interfaz responsiva con Bootstrap
 */

document.addEventListener("DOMContentLoaded", function() {
    if (document.getElementById('user-stats')) {
        if (!document.getElementById('user-stats').__vue__) { // Verificar si Vue.js ya está inicializado
            const vueInstance = new Vue({
                el: "#user-stats", // Elemento HTML donde se montará Vue
                data: {
                    totalMatches: 0,
                    totalWins: 0,
                    totalLosses: 0,
                    winrate: '0%',
                    totalKills: 0,
                    totalDeaths: 0,
                    totalAssists: 0,
                    kdRatio: '0',
                    mapas: [],
                    agentes: []
                },
                methods: {
                    /**
                     * Detecta el juego actual basado en la URL
                     * @returns {number|null} 1 para Valorant, 2 para CS2, null si no se detecta
                     * @description Analiza la URL actual para determinar el contexto del juego
                     */
                    detectarJuego() {
                        const currentPage = window.location.pathname.split("/").pop();  // detecta html
                        console.log("Archivo detectado:", currentPage);  // log para verificar
                        //valida
                        if (currentPage === "valo.php") {
                            return 1;  // valo tiene id 1 en BD
                        } else if (currentPage === "cs2.php") {
                            return 2;  // cs tiene id 2 en BD
                        } else {
                            console.log("no se detecto el juego(php)");  // log para verificar
                            return null;  // no detecta juego
                        }
                    },
                    /**
                     * Carga las estadísticas del usuario desde el servidor
                     * @async
                     * @description Realiza una petición FETCH para obtener estadísticas del usuario actual
                     * Actualiza el estado de Vue con los datos recibidos
                     * Calcula métricas derivadas como winrate y KDA
                     */
                    cargarEstadisticas() {
                        const juego_id = this.detectarJuego();
                        const user_id = document.getElementById('user_id').value;
                        console.log("Cargando estadísticas para juego_id:", juego_id, "user_id:", user_id); 
                        if (!juego_id) {
                            console.error("No se pudo detectar el juego");
                            return;
                        }
                        fetch(`../pages/getEstadisticas.php?juego_id=${juego_id}&user_id=${user_id}`)
                            .then(response => response.json())
                            .then(data => {
                                console.log("Datos recibidos para cargar estadísticas:", data); // Añadir console.log para depurar la data
                                if (data.status === 'success') {
                                    this.totalMatches = parseInt(data.total_partidas) || 0;
                                    this.totalWins = parseInt(data.total_victorias) || 0;
                                    this.totalLosses = parseInt(data.total_derrotas) || 0; // parseInt para convertir a entero y evitar NaN en tabla dinamica
                                    this.totalKills = parseInt(data.total_kills) || 0;
                                    this.totalDeaths = parseInt(data.total_deaths) || 0;
                                    this.totalAssists = parseInt(data.total_assists) || 0;
                                    this.winrate = this.calcularWinrate(this.totalWins, this.totalMatches);
                                    this.kdRatio = this.calcularKdRatio(
                                        this.totalKills, 
                                        this.totalDeaths,
                                        this.totalAssists
                                    );
                                    console.log("Estadísticas cargadas:", {
                                        totalMatches: this.totalMatches,
                                        totalWins: this.totalWins,
                                        totalLosses: this.totalLosses,
                                        totalKills: this.totalKills,
                                        totalDeaths: this.totalDeaths,
                                        totalAssists: this.totalAssists,
                                        winrate: this.winrate,
                                        kdRatio: this.kdRatio
                                    });
                                } else {
                                    alert("Error al cargar las estadísticas: " + data.message);
                                }
                            })
                            .catch(error => {
                                console.error("Error al cargar las estadísticas:", error);
                            });
                    },
                    // Actualiza las estadísticas locales después de una nueva partida
                    //  data - Datos de la nueva partida                 objeto de vue 
                    actualizarEstadisticas(data) {
                        console.log("Datos para actualizar estadísticas:", data); // Añadir console.log para depurar la data
                        this.totalMatches = parseInt(data.total_partidas) || 0;
                        this.totalWins = parseInt(data.total_victorias) || 0;
                        this.totalLosses = parseInt(data.total_derrotas) || 0;
                        this.totalKills = parseInt(data.total_kills) || 0;
                        this.totalDeaths = parseInt(data.total_deaths) || 0;
                        this.totalAssists = parseInt(data.total_assists) || 0;
                        this.winrate = this.calcularWinrate(this.totalWins, this.totalMatches);
                        this.kdRatio = this.calcularKdRatio(this.totalKills, this.totalDeaths, this.totalAssists);
                        console.log("Estadísticas actualizadas después de añadir partida:", {
                            totalMatches: this.totalMatches,
                            totalWins: this.totalWins,
                            totalLosses: this.totalLosses,
                            totalKills: this.totalKills,
                            totalDeaths: this.totalDeaths,
                            totalAssists: this.totalAssists,
                            winrate: this.winrate,
                            kdRatio: this.kdRatio
                        });
                    },
                    // Envía los datos de una nueva partida al servidor
                    //  event - Evento del formulario
                    enviarEstadisticas(event) {
                        event.preventDefault();

                        const juego_id = this.detectarJuego();  // Detectar el juego
                        if (!juego_id) {
                            alert("No se pudo detectar el juego. Por favor, verifica la página actual.");
                            return;
                        }

                        const wins = document.getElementById('win').value === "win" ? 1 : 0;
                        const kills = parseInt(document.getElementById('kills').value);
                        const deaths = parseInt(document.getElementById('deaths').value);
                        const assists = parseInt(document.getElementById('assists').value);
                        const mapa_id = parseInt(document.getElementById('map').value);
                        const user_id = parseInt(document.getElementById('user_id').value);
                        console.log("Datos recogidos para enviar estadísticas:", {
                            juego_id, wins, kills, deaths, assists, mapa_id, user_id
                        });
                        // validamos entrys con int
                        if (isNaN(kills) || isNaN(deaths) || isNaN(assists) || isNaN(mapa_id) || mapa_id === 0) {
                            alert("Por favor, selecciona valores válidos y numéricos.");
                            return;
                        }

                        let agente_id;
                        const currentPage = window.location.pathname.split("/").pop();  // Detectar el archivo HTML
                        //  ---en valo.php se ingresa agente !!!---
                        if (currentPage === "valo.php") {
                            agente_id = parseInt(document.getElementById('agente_id').value);  // convertir a entero
                            if (isNaN(agente_id) || agente_id === 0) {
                                alert("Por favor, selecciona un agente válido.");
                                return;
                            }//imprimimos valores
                            console.log("Datos recogidos para Valorant:", { juego_id, wins, kills, deaths, assists, agente_id, mapa_id, user_id });
                        } else {
                            console.log("Datos recogidos para Counter-Strike 2:", { juego_id, wins, kills, deaths, assists, mapa_id, user_id });
                        }

                        // ENVIAMOS DATOS A BD
                        const datos = currentPage === "valo.php"
                            ? { juego_id, wins, kills, deaths, assists, agente_id, mapa_id, user_id }
                            : { juego_id, wins, kills, deaths, assists, mapa_id, user_id };

                        fetch('../pages/postPartida.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(datos)
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error en la respuesta del servidor');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log("Respuesta del servidor al enviar estadísticas:", data);
                            if (data.status === 'success') {
                                // update estadisticas despues de agregar a la BD
                                const newTotalKills = this.totalKills + kills;
                                const newTotalDeaths = this.totalDeaths + deaths;
                                const newTotalAssists = this.totalAssists + assists;
                                
                                this.actualizarEstadisticas({
                                    total_partidas: this.totalMatches + 1,
                                    total_victorias: this.totalWins + wins,
                                    total_derrotas: this.totalLosses + (1 - wins),
                                    total_kills: newTotalKills,
                                    total_deaths: newTotalDeaths,
                                    total_assists: newTotalAssists,
                                    winrate: this.calcularWinrate(this.totalWins + wins, this.totalMatches + 1)
                                });

                                // Actualizar KDA inmediatamente
                                this.kdRatio = this.calcularKdRatio(newTotalKills, newTotalDeaths, newTotalAssists);
                                
                                alert("Partida añadida exitosamente.");
                            } else {
                                alert("Hubo un error al añadir la partida: " + data.message);
                            }
                        })
                        .catch(error => {
                            console.error("Error al enviar los datos:", error);
                            alert("Error al guardar las estadísticas: " + error.message);
                        });
                    },
                    // Calcula el porcentaje de victorias
                    // totalWins - Total de victorias del usuario
                    // totalMatches - Total de partidas jugadas por el usuario
                    // retorna el Porcentaje formateado con dos decimales
                    calcularWinrate(totalWins, totalMatches) {
                        return totalMatches > 0 ? ((totalWins * 100) / totalMatches).toFixed(2) + '%' : '0%';
                    },
                    /**
                     * Calcula el ratio KDA incluyendo asistencias
                     * @param {number} totalKills - Total de eliminaciones
                     * @param {number} totalDeaths - Total de muertes
                     * @param {number} totalAssists - Total de asistencias
                     * @returns {string} KDA formateado a 2 decimales
                     * @formula (Kills + Assists/2) / Deaths
                     */
                    calcularKdRatio(totalKills, totalDeaths, totalAssists) {
                        if (totalKills === 0 && totalDeaths === 0 && totalAssists === 0) {
                            return '0.00';
                        }
                        return ((totalKills + (totalAssists/2)) / (totalDeaths || 1)).toFixed(2);
                    },
                    // Carga la lista de mapas disponibles según el juego
                    cargarMapas() {
                        const juego_id = this.detectarJuego();  // Detectar el juego actual
                        // FETCH con el id del juego
                        fetch(`../pages/getMapas.php?juego_id=${juego_id}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Error al cargar los mapas');
                                }
                                return response.json();
                            })
                            .then(mapas => {
                                console.log("Mapas recibidos:", mapas);  // Verifica los datos en la consola
                                this.mapas = mapas;
                                this.actualizarSelectMapas();
                            })
                            .catch(error => {
                                console.error("Error al cargar los mapas:", error);
                            });
                    },
                    // Actualiza el select de mapas en el DOM
                    actualizarSelectMapas() {
                        const mapaSelect = document.getElementById('map');
                        mapaSelect.innerHTML = ""; // Limpiar las opciones anteriores
                        this.mapas.forEach(mapa => {
                            let option = document.createElement('option');
                            option.value = mapa.id_mapas;
                            option.textContent = mapa.nombre;
                            mapaSelect.appendChild(option);
                        });
                        console.log("Select de mapas actualizado:", this.mapas);
                    },
                    // Carga la lista de agentes de Valorant
                    cargarAgentes() {
                        console.log("Cargando agentes...");
                        fetch('../pages/getAgentes.php')
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Error al cargar los agentes');
                                }
                                return response.json();
                            })
                            .then(agentes => {
                                console.log("Agentes recibidos: ", agentes);
                                this.agentes = agentes;
                                this.actualizarSelectAgentes();
                            })
                            .catch(error => {
                                console.error("Error al cargar los agentes:", error);
                            });
                    },
                    // Actualiza el select de agentes en el DOM
                    actualizarSelectAgentes() {
                        const agenteSelect = document.getElementById('agente_id');
                        agenteSelect.innerHTML = ""; // Limpiar las opciones anteriores
                        this.agentes.forEach(agente => {
                            let option = document.createElement('option');
                            option.value = agente.id_agentes;
                            option.textContent = agente.nombre;
                            agenteSelect.appendChild(option);
                        });
                        console.log("Select de agentes actualizado:", this.agentes);
                    }
                },
                mounted() {
                    console.log("Vue.js se ha inicializado correctamente."); // Mensaje de consola para verificar la inicialización
                    // Cargar estadísticas cuando el componente se monta
                    this.cargarEstadisticas();
                    this.cargarMapas();
                    const currentPage = window.location.pathname.split("/").pop();
                    if (currentPage === "valo.php") {
                        this.cargarAgentes();
                    }
                }
            });

            // Manejadores de eventos
            document.getElementById('stats-form').addEventListener('submit', function(event) {
                event.preventDefault();
                vueInstance.enviarEstadisticas(event);
            });
        }
    }
});

// Instancia Vue para gestionar la lista de partidas
document.addEventListener("DOMContentLoaded", function() {
    if (document.getElementById('partidas-list')) {
        new Vue({
            el: "#partidas-list",
            data: {
                partidas: [],
                partidasFiltradas: [],
                partidaEditando: null,
                cargando: true,
                filtroActual: 'todos'
            },
            methods: {
                // Carga todas las partidas del usuario
                async cargarPartidas() {
                    this.cargando = true;
                    try {
                        const response = await fetch('../pages/getPartidas.php');
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor');
                        }
                        const data = await response.json();
                        // Asegurarnos de que id_juego sea número
                        this.partidas = data.map(p => ({
                            ...p,
                            id_juego: Number(p.id_juego)
                        }));
                        this.partidasFiltradas = this.partidas;
                        console.log("Partidas cargadas:", this.partidas);
                    } catch (error) {
                        console.error("Error al cargar las partidas:", error);
                        alert("Error al cargar las partidas: " + error.message);
                    } finally {
                        this.cargando = false;
                    }
                },
                // Elimina una partida específica
                // partidaId - ID de la partida a eliminar
                eliminarPartida(partidaId) {
                    if (confirm('¿Estás seguro de que deseas eliminar esta partida?')) {
                        fetch('../pages/deletePartida.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ partida_id: partidaId })
                        })
                        .then(response => response.json())
                        .then(async data => {
                            if (data.status === 'success') {
                                // Recargar todas las partidas para asegurar sincronización
                                await this.cargarPartidas();
                                alert('Partida eliminada correctamente');
                            } else {
                                throw new Error(data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error al eliminar la partida: ' + error.message);
                        });
                    }
                },
                // Inicia la edición de una partida
                // partida - Datos de la partida a editar
                editarPartida(partida) {
                    this.partidaEditando = { ...partida };
                    const modal = new bootstrap.Modal(document.getElementById('editarPartidaModal'));
                    modal.show();
                },
                //Actualiza los datos de una partida
                async actualizarPartida() {
                    try {
                        const response = await fetch('../pages/updatePartida.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(this.partidaEditando)
                        });
                        
                        const data = await response.json();
                        
                        if (data.status === 'success') {
                            // Actualizar instantaneamente tarjeta de partidos
                            const modal = bootstrap.Modal.getInstance(document.getElementById('editarPartidaModal'));
                            modal.hide();
                            const index = this.partidas.findIndex(p => p.id_partidas === this.partidaEditando.id_partidas);
                            if (index !== -1) {
                                Vue.set(this.partidas, index, { ...this.partidaEditando });
                            }
                            
                            // Recargar todas las partidas para asegurar sincronización
                            await this.cargarPartidas();
                            
                            alert('Partida actualizada correctamente');
                        } else {
                            throw new Error(data.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error al actualizar la partida: ' + error.message);
                    }
                },
                filtrarJuego(filtro) {
                    this.filtroActual = filtro;
                    const filtroNumerico = Number(filtro);
                    
                    console.log("Datos antes de filtrar:", {
                        filtro: filtro,
                        filtroNumerico: filtroNumerico,
                        totalPartidas: this.partidas.length,
                        primeraPartida: this.partidas[0]
                    });
                
                    if (filtro === 'todos') {
                        this.partidasFiltradas = this.partidas;
                    } else {
                        this.partidasFiltradas = this.partidas.filter(partida => {
                            const partidaJuegoId = Number(partida.id_juego);
                            console.log("Comparando:", {
                                partidaJuegoId: partidaJuegoId,
                                filtroId: filtroNumerico,
                                coincide: partidaJuegoId === filtroNumerico
                            });
                            return partidaJuegoId === filtroNumerico;
                        });
                    }
                
                    console.log("Resultado del filtrado:", {
                        filtro: filtro,
                        totalFiltradas: this.partidasFiltradas.length,
                        partidas: this.partidasFiltradas
                    });
                }
            },
            watch: {
                // Observador para cambios en las partidas
                partidas: {
                    deep: true,
                    handler(newVal) {
                        console.log("Partidas actualizadas:", newVal);
                    }
                }
            },
            mounted() {
                console.log("Vue montado para partidas-list");
                this.cargarPartidas();
            }
        });
    }
});

//Instancia Vue para gestionar los rankings de winrate y KDA
document.addEventListener("DOMContentLoaded", function() {
    if (document.getElementById('rankings')) {
        new Vue({
            el: "#rankings",
            data: {
                valorantWinrateRankings: [],
                valorantKdaRankings: [],
                cs2WinrateRankings: [],
                cs2KdaRankings: [],
                loading: false,
                error: null
            },
            methods: {
                //Carga los rankings de winrate y KDA desde el servidor
                async loadRankings() {
                    this.loading = true;
                    this.error = null;
                    try {
                        const response = await fetch('../pages/getRankings.php');
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const data = await response.json();
                        
                        if (data.status === 'success') {
                            this.valorantWinrateRankings = data.valorantWinrate || [];
                            this.valorantKdaRankings = data.valorantKda || [];
                            this.cs2WinrateRankings = data.cs2Winrate || [];
                            this.cs2KdaRankings = data.cs2Kda || [];
                        } else {
                            throw new Error(data.message || 'Unknown error');
                        }
                    } catch (error) {
                        console.error('Loading Rankings Error:', error);
                        this.error = `Error loading rankings: ${error.message}`;
                    } finally {
                        this.loading = false;
                    }
                }
            },
            mounted() {
                this.loadRankings();
                setInterval(this.loadRankings, 300000);
            }
        });
    }
});

// Verificar que Vue está disponible
if (typeof Vue === 'undefined') {
    console.error('Vue.js no está cargado');
} else {
    // Vue instance para autenticación
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById('loginForm') || document.getElementById('registerForm')) {
            new Vue({
                el: document.getElementById('loginForm') ? '#loginForm' : '#registerForm',
                data: {
                    formData: {
                        username: '',
                        password: '',
                        email: document.getElementById('registerForm') ? '' : null
                    },
                    errors: [],
                    loading: false,
                    successMessage: ''
                },
                methods: {
                    /**
                     * Valida el formulario antes de enviarlo
                     * @returns {boolean} true si es válido, false si no
                     */
                    validateForm() {
                        this.errors = [];
                        
                        if (!this.formData.username) {
                            this.errors.push('El nombre de usuario es requerido');
                        }
                        
                        if (!this.formData.password) {
                            this.errors.push('La contraseña es requerida');
                        } else if (this.formData.password.length < 8) {
                            this.errors.push('La contraseña debe tener al menos 8 caracteres');
                        }
                        
                        if (document.getElementById('registerForm') && !this.formData.email) {
                            this.errors.push('El correo electrónico es requerido');
                        }
                        
                        return this.errors.length === 0;
                    },

                    /**
                     * Maneja el envío del formulario
                     * @param {Event} event - Evento del formulario
                     */
                    async handleSubmit(event) {
                        event.preventDefault();
                        
                        if (!this.validateForm()) {
                            return;
                        }
                        
                        this.loading = true;
                        // Actualizar endpoints con rutas correctas
                        const isLogin = event.target.id === 'loginForm';
                        const endpoint = isLogin ? './pages/inicio.php' : '../pages/registro.php';
                        
                        try {
                            const response = await fetch(endpoint, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(this.formData)
                            });

                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }

                            const contentType = response.headers.get("content-type");
                            if (!contentType || !contentType.includes("application/json")) {
                                throw new TypeError("Respuesta del servidor no es JSON");
                            }

                            const data = await response.json();
                            console.log('Respuesta del servidor:', data);
                            
                            if (data.status === 'success') {
                                // Asegurarse de usar la ruta completa desde la raíz del proyecto
                                window.location.href = data.redirect || './templates/home.php';
                            } else {
                                this.errors.push(data.message || 'Error en la autenticación');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            this.errors.push('Error en la comunicación con el servidor');
                        } finally {
                            this.loading = false;
                        }
                    },

                    /**
                     * Limpia los errores después de un tiempo
                     */
                    clearErrors() {
                        setTimeout(() => {
                            this.errors = [];
                        }, 5000);
                    }
                },
                watch: {
                    errors(newErrors) {
                        if (newErrors.length > 0) {
                            this.clearErrors();
                        }
                    }
                },
                mounted() {
                    console.log('Vue montado para autenticación');
                }
            });
        }
    });
}
