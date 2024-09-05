// envio del form
document.getElementById('stats-form').addEventListener('submit', function(event) {
    event.preventDefault(); //asi el form no se envia raealmente

    // obtiene los valores del form
    let matchesPlayed = document.getElementById('matchesPlayed').value;
    let wins = document.getElementById('wins').value;
    let losses = document.getElementById('losses').value;

    // muestra los datos q se ingresaron
    alert(`Partidas Jugadas: ${matchesPlayed}\nVictorias: ${wins}\nDerrotas: ${losses} \nWinrate ${(wins * 100)/matchesPlayed}%`);
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
