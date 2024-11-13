<?php
include('db_connection.php');

try {
    // Prepara a consulta para selecionar todas as datas reservadas
    $query = "SELECT data FROM reservas";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $reservas = [];

    // Busca todos os resultados como um array associativo
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $reservas[] = [
            'title' => 'Reservado',       // Texto a ser exibido no calendário
            'start' => $row['data'],      // Data do evento
            'display' => 'background',    // Destaca a data no fundo
            'color' => '#FF0000'          // Cor do fundo para dias reservados
        ];
    }

    echo json_encode($reservas);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro ao buscar reservas: ' . $e->getMessage()]);
}
?>


