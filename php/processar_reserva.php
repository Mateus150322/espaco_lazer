<?php
include('db_connection.php');

// Verificar se todos os dados necessários foram enviados
if (isset($_POST['nome'], $_POST['telefone'], $_POST['email'], $_POST['data'], $_POST['metodo_pagamento'])) {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $data = $_POST['data'];
    $metodo_pagamento = $_POST['metodo_pagamento'];

    try {
        // Verificar se já existe uma reserva para o dia selecionado
        $stmt_check = $conn->prepare("SELECT * FROM reservas WHERE data = :data");
        $stmt_check->bindParam(':data', $data);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            // Redirecionar para AluguelEspaco.html com mensagem de erro
            header("Location: ../AluguelEspaco.html?error=1");
            exit;
        } else {
            // Inserir o cliente na tabela clientes
            $stmt_cliente = $conn->prepare("INSERT INTO clientes (nome, email, telefone) VALUES (:nome, :email, :telefone)");
            $stmt_cliente->bindParam(':nome', $nome);
            $stmt_cliente->bindParam(':email', $email);
            $stmt_cliente->bindParam(':telefone', $telefone);
            $stmt_cliente->execute();

            $id_cliente = $conn->lastInsertId();

            // Inserir a reserva na tabela reservas
            $stmt_reserva = $conn->prepare("INSERT INTO reservas (data, id_cliente, metodo_pagamento, status) VALUES (:data, :id_cliente, :metodo_pagamento, 'Pendente')");
            $stmt_reserva->bindParam(':data', $data);
            $stmt_reserva->bindParam(':id_cliente', $id_cliente);
            $stmt_reserva->bindParam(':metodo_pagamento', $metodo_pagamento);

            if ($stmt_reserva->execute()) {
                header("Location: ../AluguelEspaco.html?success=1&data=$data&metodo_pagamento=$metodo_pagamento");
                exit;
            } else {
                echo "Erro ao realizar reserva.";
            }
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo "Por favor, preencha todos os campos obrigatórios.";
}

$conn = null; // Fecha a conexão
?>