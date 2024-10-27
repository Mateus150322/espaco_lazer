<?php
include('db_connection.php');

// Verificar se todos os dados necessários foram enviados
if (isset($_POST['nome'], $_POST['telefone'], $_POST['email'], $_POST['data'], $_POST['metodo_pagamento'])) {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $data = $_POST['data'];
    $metodo_pagamento = $_POST['metodo_pagamento'];

    // Verificar se já existe uma reserva para o dia selecionado
    $stmt_check = $conn->prepare("SELECT * FROM reservas WHERE data = ?");
    $stmt_check->bind_param("s", $data);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // Redirecionar para AluguelEspaco.html com mensagem de erro
        header("Location: ../AluguelEspaco.html?error=1");
        exit;
    } else {
        // Inserir o cliente e a reserva conforme o código anterior
        $stmt_cliente = $conn->prepare("INSERT INTO clientes (nome, email, telefone) VALUES (?, ?, ?)");
        $stmt_cliente->bind_param("sss", $nome, $email, $telefone);

        if ($stmt_cliente->execute()) {
            $id_cliente = $stmt_cliente->insert_id;

            // Inserir a reserva
            $stmt_reserva = $conn->prepare("INSERT INTO reservas (data, id_cliente, metodo_pagamento, status) VALUES (?, ?, ?, 'Pendente')");
            $stmt_reserva->bind_param("sis", $data, $id_cliente, $metodo_pagamento);

            if ($stmt_reserva->execute()) {
                header("Location: ../AluguelEspaco.html?success=1&data=$data&metodo_pagamento=$metodo_pagamento");
                exit;
            } else {
                echo "Erro ao realizar reserva.";
            }
            $stmt_reserva->close();
        } else {
            echo "Erro ao inserir cliente.";
        }
        $stmt_cliente->close();
    }

    $stmt_check->close();
} else {
    echo "Por favor, preencha todos os campos obrigatórios.";
}

$conn->close();
?>




