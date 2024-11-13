<?php
include('db_connection.php');

try {
    // Prepara a consulta com detalhes adicionais para o administrador
    $query = "SELECT reservas.id, reservas.data, clientes.nome, clientes.telefone, clientes.email, reservas.metodo_pagamento 
              FROM reservas 
              JOIN clientes ON reservas.id_cliente = clientes.id";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $reservas = [];

    // Busca todos os resultados como um array associativo
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $reservas[] = [
            'id' => $row['id'],  // ID da reserva
            'title' => "Reserva de {$row['nome']}",
            'start' => $row['data'],
            'extendedProps' => [  // Propriedades adicionais para serem usadas no modal
                'nome' => $row['nome'],
                'telefone' => $row['telefone'],
                'email' => $row['email'],
                'pagamento' => $row['metodo_pagamento']
            ],
            'display' => 'background',
            'color' => '#FF0000'
        ];
    }

    echo json_encode($reservas);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro ao buscar reservas: ' . $e->getMessage()]);
}
?>

