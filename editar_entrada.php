<?php
include 'db.php';

$id = $_POST['id'];
$placa = $_POST['placa'];
$tipo = $_POST['tipo'];

$stmt = $pdo->prepare("UPDATE vehiculos SET placa = ?, tipo = ? WHERE id = ?");
$stmt->execute([$placa, $tipo, $id]);

echo "Entrada actualizada correctamente.";

