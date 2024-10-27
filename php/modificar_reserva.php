<?php
include('db_connection.php');

// Verifica se o ID e os dados da reserva foram enviados
if (isset($_POST['id'], $_POST['data'], $_POST['metodo_pagamento'])) {
    $id = intval($_POST['id']);
    $data = $_POST['data'];
    $metodo_pagamento = $_POST['metodo_pagamento'];

    // Prepara a consulta para atualizar a reserva
    $stmt = $conn->prepare("UPDATE reservas SET data = ?, metodo_pagamento = ? WHERE id = ?");
    $stmt->bind_param("ssi", $data, $metodo_pagamento, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Reserva modificada com sucesso"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Erro ao modificar a reserva"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Dados da reserva incompletos"]);
}

$conn->close();
?>
