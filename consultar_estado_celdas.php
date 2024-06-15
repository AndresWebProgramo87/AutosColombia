<?php
include 'db.php';

$stmt = $pdo->query("SELECT numero, estado FROM celdas");
$celdas = $stmt->fetchAll();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($celdas);

