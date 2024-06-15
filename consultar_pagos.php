<?php
include 'db.php';

$stmt = $pdo->query("SELECT id_vehiculo, monto, fecha_pago FROM pagos");
$pagos = $stmt->fetchAll();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($pagos);

