<?php
include('db_connection.php');

// Seleciona todas as datas reservadas
$query = "SELECT data FROM reservas";
$result = $conn->query($query);

$reservas = [];

while ($row = $result->fetch_assoc()) {
    $reservas[] = [
        'title' => 'Reservado',       // Texto a ser exibido no calendário
        'start' => $row['data'],      // Data do evento
        'display' => 'background',    // Destaca a data no fundo
        'color' => '#FF0000'          // Cor do fundo para dias reservados
    ];
}

echo json_encode($reservas);
?>
