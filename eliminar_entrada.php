<?php
include 'db.php';

$id = $_POST['id'];

$stmt = $pdo->prepare("DELETE FROM vehiculos WHERE id = ?");
$stmt->execute([$id]);

echo "Entrada eliminada correctamente.";

