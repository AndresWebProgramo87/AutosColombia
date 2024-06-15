<?php
include 'db.php';

$id = $_POST['id'] ?? null;
$numero = $_POST['numero'];
$estado = $_POST['estado'];

if ($id) {
    $stmt = $pdo->prepare("UPDATE celdas SET numero = ?, estado = ? WHERE id = ?");
    $stmt->execute([$numero, $estado, $id]);
    echo "Celda actualizada correctamente";
} else {
    $stmt = $pdo->prepare("INSERT INTO celdas (numero, estado) VALUES (?, ?)");
    $stmt->execute([$numero, $estado]);
    echo "Celda registrada correctamente";
}
?>
