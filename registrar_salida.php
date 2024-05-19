<?php
include 'db.php';

$placa = $_POST['placa'];

// Buscar el vehículo
$stmt = $pdo->prepare("SELECT id FROM vehiculos WHERE placa = ?");
$stmt->execute([$placa]);
$vehiculo = $stmt->fetch();

if ($vehiculo) {
    $id_vehiculo = $vehiculo['id'];

    // Buscar el registro de entrada
    $stmt = $pdo->prepare("SELECT id, id_celda, hora_entrada FROM entradasalidas WHERE id_vehiculo = ? AND hora_salida IS NULL");
    $stmt->execute([$id_vehiculo]);
    $entrada = $stmt->fetch();

    if ($entrada) {
        $id_registro = $entrada['id'];
        $id_celda = $entrada['id_celda'];
        $hora_entrada = new DateTime($entrada['hora_entrada']);
        $hora_salida = new DateTime();
        $interval = $hora_entrada->diff($hora_salida);
        $costo = $interval->h * 1000 + $interval->i * 20; // Ejemplo de cálculo de costo

        // Actualizar el registro de entrada/salida
        $stmt = $pdo->prepare("UPDATE entradasalidas SET hora_salida = ?, costo = ? WHERE id = ?");
        $stmt->execute([$hora_salida->format('Y-m-d H:i:s'), $costo, $id_registro]);

        // Marcar la celda como disponible
        $stmt = $pdo->prepare("UPDATE celdas SET estado = 'disponible' WHERE id = ?");
        $stmt->execute([$id_celda]);

        echo "Salida registrada correctamente. Costo: $costo";
    } else {
        echo "No se encontró una entrada activa para este vehículo.";
    }
} else {
    echo "Vehículo no encontrado.";
}
?>
