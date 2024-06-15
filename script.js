document.addEventListener('DOMContentLoaded', () => {
    const entradaForm = document.getElementById('entrada-form');
    const salidaForm = document.getElementById('salida-form');
    const celdaForm = document.getElementById('celda-form');
    const empleadoForm = document.getElementById('empleado-form');

    if (entradaForm) {
        fetch('obtener_celdas_empleados.php')
            .then(response => response.json())
            .then(data => {
                const celdaSelect = entradaForm.querySelector('select[name="celda"]');
                const empleadoSelect = entradaForm.querySelector('select[name="empleado"]');

                data.celdas.forEach(celda => {
                    const option = document.createElement('option');
                    option.value = celda.id;
                    option.textContent = `Celda ${celda.numero}`;
                    celdaSelect.appendChild(option);
                });

                data.empleados.forEach(empleado => {
                    const option = document.createElement('option');
                    option.value = empleado.id;
                    option.textContent = empleado.nombre;
                    empleadoSelect.appendChild(option);
                });
            });

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

    if (celdaForm) {
        fetchCeldas();

        celdaForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(celdaForm);

            fetch('registrar_celda.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                fetchCeldas();
            })
            .catch(error => console.error('Error:', error));
        });
    }

    if (empleadoForm) {
        fetchEmpleados();

        empleadoForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(empleadoForm);

            fetch('registrar_empleado.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                fetchEmpleados();
            })
            .catch(error => console.error('Error:', error));
        });
    }

    if (document.getElementById('tabla-pagos')) {
        fetch('consultar_pagos.php')
            .then(response => response.json())
            .then(data => {
                const tablaPagos = document.getElementById('tabla-pagos').querySelector('tbody');
                data.forEach(pago => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${pago.id_vehiculo}</td>
                        <td>${pago.monto}</td>
                        <td>${pago.fecha_pago}</td>
                    `;
                    tablaPagos.appendChild(row);
                });
            });
    }

    if (document.getElementById('tabla-celdas')) {
        fetch('consultar_estado.php')
            .then(response => response.json())
            .then(data => {
                const tablaCeldas = document.getElementById('tabla-celdas').querySelector('tbody');
                data.forEach(celda => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${celda.numero}</td>
                        <td>${celda.estado}</td>
                    `;
                    tablaCeldas.appendChild(row);
                });
            });
    }

    function fetchCeldas() {
        fetch('consultar_estado.php')
            .then(response => response.json())
            .then(data => {
                const tablaCeldas = document.getElementById('tabla-celdas').querySelector('tbody');
                tablaCeldas.innerHTML = '';
                data.forEach(celda => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${celda.id}</td>
                        <td>${celda.numero}</td>
                        <td>${celda.estado}</td>
                        <td>
                            <button onclick="editarCelda(${celda.id})">Editar</button>
                            <button onclick="eliminarCelda(${celda.id})">Eliminar</button>
                        </td>
                    `;
                    tablaCeldas.appendChild(row);
                });
            });
    }

    function fetchEmpleados() {
        fetch('obtener_empleados.php')
            .then(response => response.json())
            .then(data => {
                const tablaEmpleados = document.getElementById('tabla-empleados').querySelector('tbody');
                tablaEmpleados.innerHTML = '';
                data.forEach(empleado => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${empleado.id}</td>
                        <td>${empleado.nombre}</td>
                        <td>
                            <button onclick="editarEmpleado(${empleado.id})">Editar</button>
                            <button onclick="eliminarEmpleado(${empleado.id})">Eliminar</button>
                        </td>
                    `;
                    tablaEmpleados.appendChild(row);
                });
            });
    }

    window.editarCelda = function(id) {
        fetch(`editar_celda.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('celda-id').value = data.id;
                document.getElementById('numero').value = data.numero;
                document.getElementById('estado').value = data.estado;
            })
            .catch(error => console.error('Error:', error));
    }

    window.eliminarCelda = function(id) {
        fetch(`eliminar_celda.php?id=${id}`)
            .then(response => response.text())
            .then(data => {
                alert(data);
                fetchCeldas();
            })
            .catch(error => console.error('Error:', error));
    }

    window.editarEmpleado = function(id) {
        fetch(`editar_empleado.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('empleado-id').value = data.id;
                document.getElementById('nombre').value = data.nombre;
            })
            .catch(error => console.error('Error:', error));
    }

    window.eliminarEmpleado = function(id) {
        fetch(`eliminar_empleado.php?id=${id}`)
            .then(response => response.text())
            .then(data => {
                alert(data);
                fetchEmpleados();
            })
            .catch(error => console.error('Error:', error));
    }
});
