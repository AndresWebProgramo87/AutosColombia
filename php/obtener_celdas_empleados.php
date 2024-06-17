<?php
/* Este script PHP obtiene celdas disponibles y empleados registrados 
de la base de datos y devuelve los datos en formato JSON. Se utiliza en el formulario de registrar 
entrada para llenar las opciones de selección. */
$conn = new mysqli('localhost', 'root', '', 'parqueadero');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener celdas
$celdas = [];
$celdaQuery = $conn->query("SELECT id, numero FROM celdas WHERE estado='disponible'");
while ($row = $celdaQuery->fetch_assoc()) {
    $celdas[] = $row;
}

// Obtener empleados
$empleados = [];
$empleadoQuery = $conn->query("SELECT id, nombre FROM empleados");
while ($row = $empleadoQuery->fetch_assoc()) {
    $empleados[] = $row;
}

echo json_encode(['celdas' => $celdas, 'empleados' => $empleados]);

$conn->close();
?>
