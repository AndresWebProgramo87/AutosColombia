<?php
include 'db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM celdas WHERE id = ?");
$stmt->execute([$id]);

echo "Celda eliminada correctamente";
?>
