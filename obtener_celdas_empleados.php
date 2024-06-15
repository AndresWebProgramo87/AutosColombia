<?php
include 'db.php';

$celdasStmt = $pdo->query("SELECT id, numero FROM celdas WHERE estado = 'disponible'");
$celdas = $celdasStmt->fetchAll();

$empleadosStmt = $pdo->query("SELECT id, nombre FROM empleados");
$empleados = $empleadosStmt->fetchAll();

header('Content-Type: application/json; charset=utf-8');

echo json_encode(['celdas' => $celdas, 'empleados' => $empleados]);