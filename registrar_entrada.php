<?php
include 'db.php';

$placa = $_POST['placa'];
$tipo = $_POST['tipo'];

// Buscar una celda disponible
$stmt = $pdo->query("SELECT id FROM celdas WHERE estado = 'disponible' LIMIT 1");
$celda = $stmt->fetch();

if ($celda) {
    $id_celda = $celda['id'];

    // Marcar la celda como ocupada
    $stmt = $pdo->prepare("UPDATE celdas SET estado = 'ocupada' WHERE id = ?");
    $stmt->execute([$id_celda]);

    // Registrar la entrada del vehículo
    $stmt = $pdo->prepare("INSERT INTO vehiculos (placa, tipo) VALUES (?, ?)");
    $stmt->execute([$placa, $tipo]);
    $id_vehiculo = $pdo->lastInsertId();

    $hora_entrada = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO entradasalidas (id_vehiculo, id_celda, hora_entrada) VALUES (?, ?, ?)");
    $stmt->execute([$id_vehiculo, $id_celda, $hora_entrada]);

    echo "Entrada registrada correctamente.";
} else {
    echo "No hay celdas disponibles.";
}
?>
