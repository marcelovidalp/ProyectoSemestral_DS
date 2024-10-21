// ---FUNCION 1 --- detecta el juego por el html, devuelve 1 o 2
function detectarJuego() {
    const currentPage = window.location.pathname.split("/").pop();  // detecta html
    console.log("Archivo HTML detectado:", currentPage);  // log para verificar
    //valida
    if (currentPage === "valo.html") {
        return 1;  // valo tiene id 1 en BD
    } else if (currentPage === "cs2.html") {
        return 2;  // cs tiene id 2 en BD
    } else {
        console.log("no se detecto el juegohtml")
        return null;  // no detecta juego
    }
}
// --FUNCION 2--  cargamos estadisticas desde BD
function cargarEstadisticas() {
    const juego_id = detectarJuego();  // rescata juego.html

    if (!juego_id) {
        console.error("No se pudo detectar el juego");
        return;
    }
    // fetch pasandole el id del juego
    fetch(`../pages/getEstadisticas.php?juego_id=${juego_id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar las estadísticas');
            }
            return response.json();
        })
        .then(data => {//obtenemos estiqueta ids del html
            if (data.status === 'success') {
                let totalMatchesElem, totalWinsElem, totalLossesElem, winrateElem;
                const currentPage = window.location.pathname.split("/").pop();

                if (currentPage === "valo.html") {
                    totalMatchesElem = document.getElementById('valo-total-matches');
                    totalWinsElem = document.getElementById('valo-total-wins');
                    totalLossesElem = document.getElementById('valo-total-losses');
                    winrateElem = document.getElementById('valo-winrate');
                } else if (currentPage === "cs2.html") {
                    totalMatchesElem = document.getElementById('cs2-total-matches');
                    totalWinsElem = document.getElementById('cs2-total-wins');
                    totalLossesElem = document.getElementById('cs2-total-losses');
                    winrateElem = document.getElementById('cs2-winrate');
                } else {
                    console.error("No se pudo detectar la página");
                    return;
                }
                //validamos si los elementos existen en juego.html
                if (totalMatchesElem && totalWinsElem && totalLossesElem && winrateElem) {
                    // Actualizar las estadísticas en la interfaz
                    totalMatchesElem.textContent = data.total_partidas;
                    totalWinsElem.textContent = data.total_victorias;
                    totalLossesElem.textContent = data.total_derrotas;
                    winrateElem.textContent = data.winrate.toFixed() + '%';
                } else {
                    console.error("Elementos de estadísticas no encontrados en el DOM.");
                }
            } else {
                alert("Error al cargar las estadísticas: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error al cargar las estadísticas:", error);
        });
}
// cargamos estadisticas desde el principio
document.addEventListener("DOMContentLoaded", cargarEstadisticas);

// --FUNCION 3-- para actualizar la interfaz con las estadísticas ingresadas
function actualizarEstadisticas(wins, kills, deaths, assists) {
    console.log("Actualizando estadísticas");

    let totalMatchesElem, totalWinsElem, totalLossesElem, winrateElem;
    const currentPage = window.location.pathname.split("/").pop();

    if (currentPage === "valo.html") {
        totalMatchesElem = document.getElementById('valo-total-matches');
        totalWinsElem = document.getElementById('valo-total-wins');
        totalLossesElem = document.getElementById('valo-total-losses');
        winrateElem = document.getElementById('valo-winrate');
    } else if (currentPage === "cs2.html") {
        totalMatchesElem = document.getElementById('cs2-total-matches');
        totalWinsElem = document.getElementById('cs2-total-wins');
        totalLossesElem = document.getElementById('cs2-total-losses');
        winrateElem = document.getElementById('cs2-winrate');
    } else {
        console.error("No se pudo detectar la página");
        return;
    }
    // obtenemos y parseamos las estadisticas
    let totalMatches = parseInt(totalMatchesElem.textContent) + 1;
    let totalWins = wins ? parseInt(totalWinsElem.textContent) + 1 : parseInt(totalWinsElem.textContent);
    let totalLosses = wins ? parseInt(totalLossesElem.textContent) : parseInt(totalLossesElem.textContent) + 1;
    let winrate = totalWins > 0 ? (totalWins * 100) / totalMatches : 0;

    // update de valores en la intefaz
    totalMatchesElem.textContent = totalMatches;
    totalWinsElem.textContent = totalWins;
    totalLossesElem.textContent = totalLosses;
    winrateElem.textContent = winrate.toFixed() + '%';

    console.log(`Partidas: ${totalMatches}, Victorias: ${totalWins}, Derrotas: ${totalLosses}, Winrate: ${winrate.toFixed()}%`);
}

// --FUNCION 4-- envia estadisticas a BD usando FETCH
function enviarEstadisticas(event) {
    event.preventDefault();

    const juego_id = detectarJuego();  // Detectar el juego
    if (!juego_id) {
        alert("No se pudo detectar el juego. Por favor, verifica la página actual.");
        return;
    }

    const wins = document.getElementById('win').value === "win" ? 1 : 0;
    const kills = parseInt(document.getElementById('kills').value);
    const deaths = parseInt(document.getElementById('muertes').value);
    const assists = parseInt(document.getElementById('asistencias').value);
    const mapa_id = parseInt(document.getElementById('mapa_id').value);
    // validamos entrys con int
    if (isNaN(kills) || isNaN(deaths) || isNaN(assists) || isNaN(mapa_id) || mapa_id === 0) {
        alert("Por favor, selecciona valores válidos y numéricos.");
        return;
    }

    let agente_id;
    const currentPage = window.location.pathname.split("/").pop();  // Detectar el archivo HTML
    //  ---en valo.html se ingresa agente !!!---
    if (currentPage === "valo.html") {
        agente_id = parseInt(document.getElementById('agente_id').value);  // convertir a entero
        if (isNaN(agente_id) || agente_id === 0) {
            alert("Por favor, selecciona un agente válido.");
            return;
        }//imprimimos valores
        console.log("Datos recogidos para Valorant:", { juego_id, wins, kills, deaths, assists, agente_id, mapa_id });
    } else {
        console.log("Datos recogidos para Counter-Strike 2:", { juego_id, wins, kills, deaths, assists, mapa_id });
    }

    // ENVIAMOS DATOS A BD
    const datos = currentPage === "valo.html"
        ? { juego_id, wins, kills, deaths, assists, agente_id, mapa_id }
        : { juego_id, wins, kills, deaths, assists, mapa_id };

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
        console.log("Respuesta del servidor:", data);
        if (data.status === 'success') {
            // update estadisticas despues de agregar a la BD
            actualizarEstadisticas(wins, kills, deaths, assists);
            alert("Partida añadida exitosamente.");
        } else {
            alert("Hubo un error al añadir la partida: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error al enviar los datos:", error);
        alert("Error al guardar las estadísticas: " + error.message);
    });
}

// Manejadores de eventos
document.getElementById('stats-form').addEventListener('submit', enviarEstadisticas);
document.getElementById('boton').addEventListener('mouseover', function() {
    this.style.backgroundColor = '#ff6f81';  // Cambia el color al pasar el mouse
    console.log("Mouse sobre el botón:", this.id);  // Log para verificar el evento
});
document.getElementById('boton').addEventListener('mouseout', function() {
    this.style.backgroundColor = '#FF4655';  // Restaura el color al salir el mouse
    console.log("Mouse fuera del botón:", this.id);  // Log para verificar el evento
});

// Función para cargar los Agentes
function CargarAgentes() {
    fetch('../pages/getAgentes.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al cargar los agentes');
        }
        return response.json();
    })
    .then(agentes => {
        console.log("Agentes recibidos: ", agentes);
        let agenteSelect = document.getElementById('agente_id');
        agenteSelect.innerHTML = ""; // lipia select 
        agentes.forEach(agente => {// carga los agentes
            let option = document.createElement('option');//crea el option
            option.value = agente.id_agentes;//ponemos valor al value del option
            option.textContent = agente.nombre + ' (' + agente.rol + ')';// concat rol en el option
            agenteSelect.appendChild(option);
        });
    })
    .catch(error => {
        console.error("Error al cargar los agentes:", error);
    });
}

document.addEventListener("DOMContentLoaded", CargarAgentes())


// --FUNCION 5-- para cargar los Mapas según el juego detectado
function cargarMapas() {    
    const juego_id = detectarJuego();  // Detectar el juego actual

    if (!juego_id) {
        console.error("Juego no detectado");
        return;
    }
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
            let mapaSelect = document.getElementById('mapa_id');
            mapaSelect.innerHTML = ""; // Limpiar las opciones anteriores

            mapas.forEach(mapa => {
                let option = document.createElement('option');
                option.value = mapa.id_mapas;
                option.textContent = mapa.nombre;
                mapaSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error("Error al cargar los mapas:", error);
        });
}

// Llamar a cargarMapas al cargar la página
document.addEventListener("DOMContentLoaded", cargarMapas);
