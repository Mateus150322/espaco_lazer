<?php
include('db_connection.php');

// Verificar se todos os dados necessários foram enviados
if (isset($_POST['nome'], $_POST['telefone'], $_POST['email'], $_POST['data'], $_POST['metodo_pagamento'])) {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $data = $_POST['data'];
    $metodo_pagamento = $_POST['metodo_pagamento'];

    // Verificar se a data da reserva é uma data futura ou a data de hoje
    $data_atual = date('Y-m-d');
    if ($data < $data_atual) {
        // Redirecionar para AluguelEspaco.html com mensagem de erro
        header("Location: ../AluguelEspaco.html?error=data_passada");
        exit;
    }

    try {
        // Verificar se o cliente já existe no banco de dados
        $stmt_cliente = $conn->prepare("SELECT id FROM clientes WHERE nome = :nome AND email = :email AND telefone = :telefone");
        $stmt_cliente->bindParam(':nome', $nome);
        $stmt_cliente->bindParam(':email', $email);
        $stmt_cliente->bindParam(':telefone', $telefone);
        $stmt_cliente->execute();

        if ($stmt_cliente->rowCount() > 0) {
            // Cliente já existe, obtém o id do cliente
            $cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);
            $id_cliente = $cliente['id'];
        } else {
            // Cliente não existe, insere um novo registro
            $stmt_novo_cliente = $conn->prepare("INSERT INTO clientes (nome, email, telefone) VALUES (:nome, :email, :telefone)");
            $stmt_novo_cliente->bindParam(':nome', $nome);
            $stmt_novo_cliente->bindParam(':email', $email);
            $stmt_novo_cliente->bindParam(':telefone', $telefone);
            $stmt_novo_cliente->execute();
            $id_cliente = $conn->lastInsertId();
        }

        // Verificar se já existe uma reserva para o dia selecionado
        $stmt_check = $conn->prepare("SELECT * FROM reservas WHERE data = :data");
        $stmt_check->bindParam(':data', $data);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            // Redirecionar para AluguelEspaco.html com mensagem de erro
            header("Location: ../AluguelEspaco.html?error=ja_reservado");
            exit;
        } else {
            // Inserir a reserva
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
