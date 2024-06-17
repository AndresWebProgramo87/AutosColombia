<?php
/* Este script PHP registra la salida de un vehículo, actualiza el estado de la celda 
correspondiente a 'disponible' y devuelve un mensaje indicando si la operación fue exitosa o no. */
$conn = new mysqli('localhost', 'root', '', 'parqueadero');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$placa = $_POST['placa'];

// Obtener la celda y el monto de la entrada
$query = $conn->query("SELECT id_celda, TIMESTAMPDIFF(HOUR, fecha_hora, NOW()) AS horas FROM entradas WHERE placa='$placa' AND salida IS NULL");
$entrada = $query->fetch_assoc();

if ($entrada) {
    $id_celda = $entrada['id_celda'];
    $horas = $entrada['horas'];
    $monto = $horas * 10; // Tarifa de $10 por hora

    // Actualizar entrada con la hora de salida
    $conn->query("UPDATE entradas SET salida=NOW(), monto=$monto WHERE placa='$placa' AND salida IS NULL");

    // Actualizar estado de la celda
    $conn->query("UPDATE celdas SET estado='disponible' WHERE id=$id_celda");

    echo "Salida registrada. Monto a pagar: $" . $monto;
} else {
    echo "No se encontró una entrada activa para la placa $placa.";
}

$conn->close();
?>
