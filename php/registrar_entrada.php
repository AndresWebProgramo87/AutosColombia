<?php
/* Este script PHP registra una entrada de vehículo, actualiza el estado de la 
celda correspondiente a 'ocupado' y devuelve un mensaje indicando si la operación f
ue exitosa o no. */
$conn = new mysqli('localhost', 'root', '', 'parqueadero');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$placa = $_POST['placa'];
$tipo = $_POST['tipo'];
$id_usuario = $_POST['id_usuario'];
$id_celda = $_POST['id_celda'];
$id_empleado = $_POST['id_empleado'];

// Insertar entrada
$stmt = $conn->prepare("INSERT INTO entradas (placa, tipo, id_usuario, id_celda, id_empleado) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('ssiii', $placa, $tipo, $id_usuario, $id_celda, $id_empleado);

if ($stmt->execute()) {
    // Actualizar estado de la celda
    $conn->query("UPDATE celdas SET estado='ocupada' WHERE id=$id_celda");
    echo "Entrada registrada exitosamente.";
} else {
    echo "Error al registrar entrada: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
