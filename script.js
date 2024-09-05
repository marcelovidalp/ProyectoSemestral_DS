// envio del form
document.getElementById('stats-form').addEventListener('submit', function(event) {
    event.preventDefault(); //asi el form no se envia raealmente

    // obtiene los valores del form
    let matchesPlayed = document.getElementById('matchesPlayed').value;
    let wins = document.getElementById('wins').value;
    let losses = document.getElementById('losses').value;

    // winrate si los matches con mayor a 0
    let winrate = matchesPlayed > 0 ? (wins * 100) / matchesPlayed : 0;

    // muestra los datos q se ingresaron
    alert(`Partidas Jugadas: ${matchesPlayed}\nVictorias: ${wins}\nDerrotas: ${losses} \nWinrate ${winrate}%`);

    document.getElementById('total-matches').textContent = matchesPlayed;
    document.getElementById('total-wins').textContent = wins;
    document.getElementById('total-losses').textContent = losses;
    document.getElementById('winrate').textContent = winrate.toFixed(2) + '%';
    
    //resetea el formulario
    document.getElementById('stats-form').reset();
});

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
