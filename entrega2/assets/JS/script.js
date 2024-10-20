// Función 1: Detectar el juego desde el HTML y devolver su ID correspondiente
function detectarJuego() {
    const currentPage = window.location.pathname.split("/").pop();  // Detectar el archivo HTML
    console.log("Archivo HTML detectado:", currentPage);  // Log para verificar el archivo

    if (currentPage === "valo.html") {
        return 1;  // Valorant tiene ID 1 en la BD
    } else if (currentPage === "cs2.html") {
        return 2;  // Counter-Strike 2 tiene ID 2 en la BD
    } else {
        return null;
    }
}

// Función 2: Actualizar la interfaz con las estadísticas ingresadas (uso de parámetros y `this`)
function actualizarEstadisticas(wins, kills, deaths, assists) {
    console.log("Actualizando estadísticas");  // Log para verificar

    let totalMatches = parseInt(this.totalMatches.textContent) + 1;
    let totalWins = wins ? parseInt(this.totalWins.textContent) + 1 : parseInt(this.totalWins.textContent);
    let totalLosses = wins ? parseInt(this.totalLosses.textContent) : parseInt(this.totalLosses.textContent) + 1;
    let winrate = totalWins > 0 ? (totalWins * 100) / totalMatches : 0;

    // Actualizar los valores en la interfaz
    this.totalMatches.textContent = totalMatches;
    this.totalWins.textContent = totalWins;
    this.totalLosses.textContent = totalLosses;
    this.winrate.textContent = winrate.toFixed() + '%';
}

// Función 3: Enviar las estadísticas al servidor usando fetch (maneja el evento de envío del formulario)
function enviarEstadisticas(event) {
    event.preventDefault();  // Evita el refresco de la página

    const juego_id = detectarJuego();  // Detectar el juego
    const wins = document.getElementById('win').value === "win" ? 1 : 0;
    const kills = parseInt(document.getElementById('kills').value);
    const deaths = parseInt(document.getElementById('muertes').value);
    const assists = parseInt(document.getElementById('asistencias').value);
    const agente_id = document.getElementById('agente_id').value;
    const mapa_id = document.getElementById('mapa_id').value;

    console.log("Datos recogidos:", { juego_id, wins, kills, deaths, assists, agente_id, mapa_id });  // Log para verificar los datos

    // Validar campos
    if (agente_id === "0" || mapa_id === "0") {
        alert("Por favor, selecciona un agente y un mapa válidos.");
        return;
    }

    // Llamar a la función para actualizar la interfaz
    actualizarEstadisticas.call({
        totalMatches: document.getElementById('total-matches'),
        totalWins: document.getElementById('total-wins'),
        totalLosses: document.getElementById('total-losses'),
        winrate: document.getElementById('winrate')
    }, wins, kills, deaths, assists);

    // Enviar los datos al servidor
    fetch('../pages/postPartida.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ juego_id, wins, kills, deaths, assists, agente_id, mapa_id })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Respuesta del servidor:", data);
        if (data.status === 'success') {
            alert("Partida añadida exitosamente.");
        } else {
            alert("Hubo un error al añadir la partida.");
        }
    })
    .catch(error => {
        console.error("Error al enviar los datos:", error);
        alert("Error al guardar las estadísticas.");
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
fetch('../pages/getAgentes.php')
    .then(response => response.json())
    .then(agentes => {
        let agenteSelect = document.getElementById('agente_id');
        agentes.forEach(agente => {
            let option = document.createElement('option');
            option.value = agente.id;
            option.textContent = agente.nombre + ' (' + agente.rol + ')';
            agenteSelect.appendChild(option);
        });
    }); 

// Función para cargar los Mapas según el juego detectado
function cargarMapas() {
    const juego_id = detectarJuego();  // Detectar el juego actual

    if (!juego_id) {
        console.error("Juego no detectado");
        return;
    }

    // Realizar el fetch pasando el juego_id como parámetro en la URL
    fetch(`../pages/getMapas.php?juego_id=${juego_id}`)
        .then(response => response.json())
        .then(mapas => {
            console.log("Mapas recibidos:", mapas);  // Verifica los datos en la consola
            let mapaSelect = document.getElementById('mapa_id');
            mapaSelect.innerHTML = ""; // Limpiar las opciones anteriores

            mapas.forEach(mapa => {
                let option = document.createElement('option');
                option.value = mapa.id;
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
