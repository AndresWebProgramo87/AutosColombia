document.addEventListener('DOMContentLoaded', function() {
    const entradaForm = document.getElementById('entradaForm');
    const salidaForm = document.getElementById('salidaForm');
    const celdaForm = document.getElementById('celdaForm');
    const empleadoForm = document.getElementById('empleadoForm');
    const consultarEstado = document.getElementById('consultarEstado');
    const consultarPagos = document.getElementById('consultarPagos');

    if (entradaForm) {
        fetch('../php/obtener_celdas_empleados.php')
            .then(response => response.json())
            .then(data => {
                const celdaSelect = document.getElementById('id_celda');
                const empleadoSelect = document.getElementById('id_empleado');
                data.celdas.forEach(celda => {
                    const option = document.createElement('option');
                    option.value = celda.id;
                    option.textContent = celda.numero;
                    celdaSelect.appendChild(option);
                });
                data.empleados.forEach(empleado => {
                    const option = document.createElement('option');
                    option.value = empleado.id;
                    option.textContent = empleado.nombre;
                    empleadoSelect.appendChild(option);
                });
            });

        entradaForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(entradaForm);
            fetch('../php/registrar_entrada.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('resultado').textContent = data;
                entradaForm.reset();
            });
        });
    }

    if (salidaForm) {
        salidaForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(salidaForm);
            fetch('../php/registrar_salida.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('resultado').textContent = data;
                salidaForm.reset();
            });
        });
    }

    if (celdaForm) {
        celdaForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(celdaForm);
            fetch('../php/registrar_celda.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('resultado').textContent = data;
                celdaForm.reset();
            });
        });
    }

    if (empleadoForm) {
        empleadoForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(empleadoForm);
            fetch('../php/registrar_empleado.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('resultado').textContent = data;
                empleadoForm.reset();
            });
        });
    }

    if (consultarEstado) {
        consultarEstado.addEventListener('click', function() {
            fetch('../php/consultar_estado.php')
            .then(response => response.json())
            .then(data => {
                const estadoCeldas = document.getElementById('estadoCeldas');
                estadoCeldas.innerHTML = '';
                data.forEach(celda => {
                    const div = document.createElement('div');
                    div.textContent = `Celda ${celda.numero}: ${celda.estado}`;
                    estadoCeldas.appendChild(div);
                });
            });
        });
    }

    if (consultarPagos) {
        consultarPagos.addEventListener('click', function() {
            fetch('../php/consultar_pagos.php')
            .then(response => response.json())
            .then(data => {
                const pagos = document.getElementById('pagos');
                pagos.innerHTML = '';
                data.forEach(pago => {
                    const div = document.createElement('div');
                    div.textContent = `Pago de ${pago.monto} realizado por usuario ${pago.id_usuario}`;
                    pagos.appendChild(div);
                });
            });
        });
    }
});
