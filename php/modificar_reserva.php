<?php
include('db_connection.php');

// Verifica se o ID e os dados da reserva foram enviados
if (isset($_POST['id'], $_POST['data'], $_POST['metodo_pagamento'])) {
    $id = intval($_POST['id']);
    $data = $_POST['data'];
    $metodo_pagamento = $_POST['metodo_pagamento'];

    try {
        // Prepara a consulta para atualizar a reserva
        $stmt = $conn->prepare("UPDATE reservas SET data = :data, metodo_pagamento = :metodo_pagamento WHERE id = :id");
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':metodo_pagamento', $metodo_pagamento);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Reserva modificada com sucesso"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao modificar a reserva"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erro: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Dados da reserva incompletos"]);
}

// Fecha a conexão
$conn = null;
?>

