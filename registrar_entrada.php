<?php
include 'db.php';

$placa = $_POST['placa'];
$tipo = $_POST['tipo'];
$id_usuario = $_POST['id_usuario'];
$id_celda = $_POST['id_celda'];
$id_empleado = $_POST['id_empleado'];

// Marcar la celda como ocupada
$stmt = $pdo->prepare("UPDATE celdas SET estado = 'ocupada' WHERE id = ?");
$stmt->execute([$id_celda]);

// Registrar el vehículo
$stmt = $pdo->prepare("INSERT INTO vehiculos (placa, tipo, id_usuario) VALUES (?, ?, ?)");
$stmt->execute([$placa, $tipo, $id_usuario]);
$id_vehiculo = $pdo->lastInsertId();

$hora_entrada = date('Y-m-d H:i:s');
$stmt = $pdo->prepare("INSERT INTO entradasalidas (id_vehiculo, id_celda, id_empleado, hora_entrada) VALUES (?, ?, ?, ?)");
$stmt->execute([$id_vehiculo, $id_celda, $id_empleado, $hora_entrada]);

echo "Entrada registrada correctamente.";
?>
