<?php include('../templates/header.php'); ?>

<link rel="stylesheet" href="/espaco_lazer/css/styles.css">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" />

<section id="formulario">
    <h1>Reserve seu Espaço de Lazer</h1>
    <h2>Preencha os dados abaixo para reservar:</h2>
    
    <div id="mensagem" class="mensagem"></div>

    <form action="/espaco_lazer/php/processar_reserva.php" method="POST">
        <label for="nome">Nome Completo:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="data">Data da Reserva:</label>
        <input type="date" id="data" name="data" required>

        <label for="metodo_pagamento">Método de pagamento:</label>
        <select name="metodo_pagamento" id="metodo_pagamento" onchange="mostrarInstrucoesPagamento()" required>
            <option value="Dinheiro">Dinheiro</option>
            <option value="Cartão">Cartão</option>
            <option value="Pix">Pix</option>
        </select>

        <div id="instrucao-pix" style="display: none; margin-top: 15px;">
            <p>Para pagamento via Pix, escaneie o QR Code abaixo:</p>
            <img src="/espaco_lazer/Imagens/QRCode.jpeg" alt="QR Code para Pix" style="width: 150px; height: 150px;">
        </div>

        <button type="submit" class="botao">Enviar Reserva</button>
    </form>
</section>

<div class="calendar-container">
    <div id="calendar"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script src="/espaco_lazer/js/aluguel.js"></script>
<script>
    function mostrarInstrucoesPagamento() {
        const pagamento = document.getElementById("metodo_pagamento").value;
        const instrucaoPix = document.getElementById("instrucao-pix");
        instrucaoPix.style.display = pagamento === "Pix" ? "block" : "none";
    }

    function exibirMensagem(mensagem, classe) {
        const mensagemDiv = document.getElementById("mensagem");
        mensagemDiv.innerText = mensagem;
        mensagemDiv.className = `mensagem ${classe}`;
        mensagemDiv.style.display = 'block';
        mensagemDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });

        setTimeout(() => {
            mensagemDiv.style.display = 'none';
            mensagemDiv.innerText = '';
        }, 5000);
    }

    function formatarData(data) {
        const [ano, mes, dia] = data.split("-");
        return `${dia}-${mes}-${ano}`;
    }

    document.addEventListener("DOMContentLoaded", function () {
        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.has('error')) {
            const error = urlParams.get('error');
            if (error === 'data_passada') {
                exibirMensagem("A data selecionada já passou. Por favor, escolha uma data futura.", 'mensagem-erro');
            } else if (error === 'ja_reservado') {
                exibirMensagem("Esta data já está reservada. Por favor, escolha outra data.", 'mensagem-erro');
            }
        } else if (urlParams.has('success')) {
            const data = urlParams.get('data');
            const metodoPagamento = urlParams.get('metodo_pagamento');
            exibirMensagem(`Reserva confirmada para o dia ${formatarData(data)}. Método de pagamento: ${metodoPagamento}.`, 'mensagem-sucesso');
        }

        setTimeout(() => {
            window.history.replaceState({}, document.title, window.location.pathname);
        }, 100);
    });

    document.addEventListener("DOMContentLoaded", function () {
        const today = new Date().toISOString().split("T")[0];
        document.getElementById("data").setAttribute("min", today);

        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            events: '/espaco_lazer/php/get_reservas.php',
            eventColor: '#FF0000',
            dateClick: function (info) {
                const reservedEvents = calendar.getEvents().filter(event => event.startStr === info.dateStr);

                if (reservedEvents.length > 0) {
                    exibirMensagem("Este dia já está reservado. Por favor, escolha outra data.", 'mensagem-erro');
                } else if (info.dateStr >= today) {
                    exibirMensagem(`Você selecionou ${formatarData(info.dateStr)}. Clique em "Enviar Reserva" para confirmar.`, 'mensagem-sucesso');
                    document.getElementById('data').value = info.dateStr;
                } else {
                    exibirMensagem("Você não pode selecionar uma data que já passou.", 'mensagem-erro');
                }
            }
        });
        calendar.render();
    });
</script>

<?php include('../templates/footer.php'); ?>












