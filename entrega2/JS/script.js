// envio del form
document.getElementById('stats-form').addEventListener('submit', function() {
    //no udapte pagina
    event.preventDefault();

    // obtiene los valores del form
    let matchesPlayed = parseInt(document.getElementById('matchesPlayed').value);
    let wins = parseInt(document.getElementById('wins').value);
    let losses = parseInt(document.getElementById('losses').value);

    if (wins + losses == matchesPlayed){//muestra los datos que se integraron
        //resetea el formulario
        document.getElementById('stats-form').reset();
        
        let winrate = matchesPlayed > 0 ? (wins * 100) / matchesPlayed : 0;
        // muestra los datos q se ingresaron
        alert(`Partidas Jugadas: ${matchesPlayed}\nVictorias: ${wins}\nDerrotas: ${losses} \nWinrate ${winrate}%`);
        //cambia los valores de la tabla
        document.getElementById('total-matches').textContent = matchesPlayed;
        document.getElementById('total-wins').textContent = wins;
        document.getElementById('total-losses').textContent = losses;
        document.getElementById('winrate').textContent = winrate.toFixed() + '%';
    }
    else {
        alert('La suma de tus derrotas y victorias debe ser igual al total de tus partidas')
    }});

//switch del color del boton con el mouse
document.getElementById('boton').addEventListener('mouseover', function() {
    this.style.backgroundColor = '#45a29e'; // switch color
});

//reset color del boton
document.getElementById('boton').addEventListener('mouseout', function() {
    this.style.backgroundColor = '#66fcf1'; 
});

//cambia el texto del boton
document.getElementById('boton').addEventListener('click', function() {
    this.innerText = 'Procesando...';//switch texto
});
