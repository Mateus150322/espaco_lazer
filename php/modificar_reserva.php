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
        // Prepara a consulta para atualizar a reserva
        $stmt = $conn->prepare("UPDATE reservas SET data = :data, metodo_pagamento = :metodo_pagamento WHERE id = :id");
        $stmt->bindParam(':data', $novaData);
        $stmt->bindParam(':metodo_pagamento', $novoMetodoPagamento);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Executa a atualização e verifica o resultado
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Reserva modificada com sucesso"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao modificar a reserva"]);
        }
    } catch (PDOException $e) {
        // Retorna uma mensagem de erro caso ocorra uma exceção
        echo json_encode(["status" => "error", "message" => "Erro: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Dados da reserva incompletos"]);
}

// Fecha a conexão com o banco de dados
$conn = null;

