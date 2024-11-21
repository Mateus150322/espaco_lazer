<?php
include('db_connection.php');

// Recebe e decodifica os dados enviados em JSON pelo JavaScript
$data = json_decode(file_get_contents("php://input"), true);

// Verifica se o ID e os dados da reserva foram enviados
if (isset($data['id'], $data['data'], $data['metodo_pagamento'])) {
    $id = intval($data['id']);
    $novaData = $data['data'];
    $novoMetodoPagamento = $data['metodo_pagamento'];

    try {
        // Valida o formato da data (esperado DD-MM-AAAA) e converte para AAAA-MM-DD
        $novaDataFormatada = DateTime::createFromFormat('d-m-Y', $novaData);
        if (!$novaDataFormatada) {
            echo json_encode(["status" => "error", "message" => "Formato de data inválido. Use DD-MM-AAAA."]);
            exit;
        }
        $novaDataSQL = $novaDataFormatada->format('Y-m-d');

        // Verifica se a nova data já está reservada por outra reserva
        $stmt_check = $conn->prepare("SELECT id FROM reservas WHERE data = :data AND id != :id");
        $stmt_check->bindParam(':data', $novaDataSQL);
        $stmt_check->bindParam(':id', $id);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            echo json_encode(["status" => "error", "message" => "A data selecionada já está reservada. Por favor, escolha outra."]);
            exit;
        }

        // Atualiza a reserva com os novos valores
        $stmt_update = $conn->prepare("UPDATE reservas SET data = :data, metodo_pagamento = :metodo_pagamento WHERE id = :id");
        $stmt_update->bindParam(':data', $novaDataSQL);
        $stmt_update->bindParam(':metodo_pagamento', $novoMetodoPagamento);
        $stmt_update->bindParam(':id', $id);

        if ($stmt_update->execute()) {
            echo json_encode(["status" => "success", "message" => "Reserva modificada com sucesso."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao modificar a reserva."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erro: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Dados da reserva incompletos."]);
}

// Fecha a conexão com o banco de dados
$conn = null;




