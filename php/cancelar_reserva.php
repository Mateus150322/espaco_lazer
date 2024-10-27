<?php
include('db_connection.php');

// Obtém o ID da reserva a ser cancelada
$reserva_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($reserva_id > 0) {
    $stmt = $conn->prepare("DELETE FROM reservas WHERE id = ?");
    $stmt->bind_param("i", $reserva_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Reserva cancelada com sucesso"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Erro ao cancelar reserva"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "ID de reserva inválido"]);
}

$conn->close();
?>
