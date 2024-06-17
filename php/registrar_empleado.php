<?php
/* Este script PHP registra un nuevo empleado en la base de datos y devuelve 
un mensaje indicando si la operación fue exitosa o no. */
$conn = new mysqli('localhost', 'root', '', 'parqueadero');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];

// Insertar empleado
$stmt = $conn->prepare("INSERT INTO empleados (nombre) VALUES (?)");
$stmt->bind_param('s', $nombre);

if ($stmt->execute()) {
    echo "Empleado registrado exitosamente.";
} else {
    echo "Error al registrar empleado: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
