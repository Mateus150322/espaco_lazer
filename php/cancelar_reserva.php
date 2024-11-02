<?php
include('db_connection.php');

// Obtém o ID da reserva a ser cancelada
$reserva_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($reserva_id > 0) {
    try {
        // Prepara e executa a consulta para deletar a reserva
        $stmt = $conn->prepare("DELETE FROM reservas WHERE id = :id");
        $stmt->bindParam(':id', $reserva_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Reserva cancelada com sucesso"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao cancelar reserva"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erro: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "ID de reserva inválido"]);
}

// Fecha a conexão
$conn = null;
?>

