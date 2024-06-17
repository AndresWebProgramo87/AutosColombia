<?php
/* Conexion a la base de datos Este script PHP consulta los pagos registrados y devuelve 
los datos en formato JSON. Se usa para actualizar la información de pagos en la interfaz.*/
$conn = new mysqli('localhost', 'root', '', 'parqueadero');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los pagos
$result = $conn->query("SELECT id_usuario, monto FROM entradas WHERE monto IS NOT NULL");
$pagos = [];

while ($row = $result->fetch_assoc()) {
    $pagos[] = $row;
}

echo json_encode($pagos);

$conn->close();
?>
