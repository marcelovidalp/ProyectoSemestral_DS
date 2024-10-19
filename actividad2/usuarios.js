document.getElementById('load-usuarios').addEventListener('click', function() {
    fetch('consulta_users.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('usuarios-container');
            container.innerHTML = ''; // Limpiar el contenedor antes de insertar la información

            // Crear una tabla para mostrar los usuarios
            const table = document.createElement('table');
            table.className = 'usuarios-table';

            const header = document.createElement('tr');
            header.innerHTML = `<th>ID</th><th>Nombre de Usuario</th><th>Correo</th>`;
            table.appendChild(header);

            data.forEach(usuario => {
                const row = document.createElement('tr');
                row.innerHTML = `<td>${usuario.id_users}</td><td>${usuario.username}</td><td>${usuario.correo}</td>`;
                table.appendChild(row);
            });

            container.appendChild(table);
        })
        .catch(error => console.error('Error:', error));
});
