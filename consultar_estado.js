document.addEventListener('DOMContentLoaded', () => {
    fetch('consultar_estado.php')
        .then(response => response.json())
        .then(data => {
            const estadoCeldasDiv = document.getElementById('estado-celdas');
            estadoCeldasDiv.innerHTML = data.map(celda => `
                <p>Celda ${celda.numero}: ${celda.estado}</p>
            `).join('');
        })
        .catch(error => console.error('Error:', error));
});
