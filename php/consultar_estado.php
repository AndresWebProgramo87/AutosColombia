<?php
/* Conexion a la base de datos Este script PHP consulta el estado de todas las celdas y devuelve los datos 
en formato JSON. Se usa para actualizar el estado de las celdas en la interfaz.*/
$conn = new mysqli('localhost', 'root', '', 'parqueadero');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener el estado de las celdas
$result = $conn->query("SELECT numero, estado FROM celdas");
$celdas = [];

while ($row = $result->fetch_assoc()) {
    $celdas[] = $row;
}

echo json_encode($celdas);

$conn->close();
?>
