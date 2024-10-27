document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    let reservaIdAtual = null; // Variável para armazenar o ID da reserva selecionada

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        events: '/espaco_lazer/php/get_reservas_adm.php',
        eventColor: '#FF0000',
        eventClick: function(info) {
            reservaIdAtual = info.event.id; // Armazena o ID da reserva
            mostrarModal(info.event); // Exibe a modal com detalhes da reserva
        }
    });
    calendar.render();

    // Exibe modal com detalhes da reserva
    function mostrarModal(event) {
        document.getElementById('cliente-nome').innerText = `Nome: ${event.extendedProps.nome}`;
        document.getElementById('cliente-telefone').innerText = `Telefone: ${event.extendedProps.telefone}`;
        document.getElementById('cliente-email').innerText = `E-mail: ${event.extendedProps.email}`;
        document.getElementById('metodo-pagamento').innerText = `Método de Pagamento: ${event.extendedProps.pagamento}`;
        
        const modal = document.getElementById("reservaModal");
        modal.style.display = "block";

        document.querySelector(".close").onclick = function() {
            modal.style.display = "none";
        };
    }

    // Modificar Reserva
    document.getElementById('modificarReserva').addEventListener('click', () => {
        if (reservaIdAtual) {
            // Solicitar ao administrador os novos valores para data e método de pagamento
            const novaData = prompt("Digite a nova data para a reserva (AAAA-MM-DD):");
            const novoMetodoPagamento = prompt("Digite o novo método de pagamento (Dinheiro, Cartão, Pix):");
    
            if (novaData && novoMetodoPagamento) {
                fetch(`/espaco_lazer/php/modificar_reserva.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: reservaIdAtual,
                        data: novaData,
                        metodo_pagamento: novoMetodoPagamento
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        alert("Reserva modificada com sucesso!");
                        document.getElementById("reservaModal").style.display = "none";
                        calendar.refetchEvents(); // Atualiza o calendário
                    } else {
                        alert(data.message || "Erro ao modificar a reserva.");
                    }
                })
                .catch(error => {
                    console.error("Erro ao modificar a reserva:", error);
                });
            } else {
                alert("Modificação cancelada. Dados incompletos.");
            }
        }
    });
    

    // Cancelar Reserva
    document.getElementById('cancelarReserva').addEventListener('click', () => {
        if (reservaIdAtual) {
            if (confirm("Tem certeza de que deseja cancelar esta reserva?")) {
                fetch(`/espaco_lazer/php/cancelar_reserva.php?id=${reservaIdAtual}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    alert("Reserva cancelada com sucesso!");
                    document.getElementById("reservaModal").style.display = "none";
                    calendar.refetchEvents(); // Atualiza o calendário
                })
                .catch(error => {
                    console.error("Erro ao cancelar reserva:", error);
                });
            }
        }
    });
});

