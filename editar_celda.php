<?php
include 'db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM celdas WHERE id = ?");
$stmt->execute([$id]);
$celda = $stmt->fetch();

echo json_encode($celda);
?>
