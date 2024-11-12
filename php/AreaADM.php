<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: /espaco_lazer/templates/login.php");  // Redireciona para o login se não estiver autenticado
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Administrador</title>
    <link rel="stylesheet" href="/espaco_lazer/css/styles.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
</head>
<body>
    <header>
        <h1>Área do Administrador</h1>
        <a href="/espaco_lazer/php/logout.php" class="logout-btn">Logout</a> <!-- Link de logout -->
    </header>

    <div class="calendar-container">
        <div id="calendar"></div>
    </div>

    <!-- Modal para exibir detalhes da reserva -->
    <div id="reservaModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Detalhes da Reserva</h2>
            <p id="cliente-nome">Nome: </p>
            <p id="cliente-telefone">Telefone: </p>
            <p id="cliente-email">E-mail: </p>
            <p id="metodo-pagamento">Método de Pagamento: </p>
            <button id="modificarReserva">Modificar Reserva</button>
            <button id="cancelarReserva">Cancelar Reserva</button>
        </div>
    </div>

    <!-- Modal Customizado para Mensagens e Inputs -->
    <div id="customModal" class="modal" style="display: none;">
        <div class="modal-content">
            <p id="modalMensagem"></p>
            <input type="text" id="modalInput" style="display: none;" placeholder="Digite aqui...">
            <div style="display: flex; justify-content: center;">
                <button id="confirmarBotao">Confirmar</button>
                <button id="cancelarBotao">Cancelar</button>
            </div>
        </div>
    </div>

    <script src="/espaco_lazer/js/admin.js"></script>
</body>
</html>

