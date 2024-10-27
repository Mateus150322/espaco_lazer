<?php
include('db_connection.php');

// Consulta com detalhes adicionais para o administrador
$query = "SELECT reservas.id, reservas.data, clientes.nome, clientes.telefone, clientes.email, reservas.metodo_pagamento 
          FROM reservas 
          JOIN clientes ON reservas.id_cliente = clientes.id";
$result = $conn->query($query);

$reservas = [];

while ($row = $result->fetch_assoc()) {
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
?>

