document.addEventListener('DOMContentLoaded', () => {
    fetch('consultar_pagos.php')
        .then(response => response.json())
        .then(data => {
            const pagosDiv = document.getElementById('pagos');
            pagosDiv.innerHTML = data.map(pago => `
                <p>Vehículo ID ${pago.id_vehiculo}: Pago de $${pago.monto} el ${pago.fecha_pago}</p>
            `).join('');
        })
        .catch(error => console.error('Error:', error));
});
