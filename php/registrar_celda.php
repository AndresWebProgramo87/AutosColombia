<?php
/* Este script PHP registra una nueva celda en la base de datos y devuelve 
un mensaje indicando si la operación fue exitosa o no. */
$conn = new mysqli('localhost', 'root', '', 'parqueadero');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$numero = $_POST['numero'];
$estado = $_POST['estado'];

// Insertar celda
$stmt = $conn->prepare("INSERT INTO celdas (numero, estado) VALUES (?, ?)");
$stmt->bind_param('ss', $numero, $estado);

if ($stmt->execute()) {
    echo "Celda registrada exitosamente.";
} else {
    echo "Error al registrar celda: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
