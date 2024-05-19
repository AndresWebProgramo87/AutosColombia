document.addEventListener('DOMContentLoaded', () => {
    const entradaForm = document.getElementById('entrada-form');
    const salidaForm = document.getElementById('salida-form');


    if (entradaForm) {
        entradaForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(entradaForm);

            fetch('registrar_entrada.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => alert(data))
            .catch(error => console.error('Error:', error));
        });
    }

    if (salidaForm) {
        salidaForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(salidaForm);

            fetch('registrar_salida.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                const match = data.match(/Costo: (\d+(\.\d+)?)/);
                if (match) {
                    const costo = match[1];
                    document.getElementById('costo-salida').textContent = `$${costo}`;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    
});
