document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    let reservaIdAtual = null;

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        events: '/espaco_lazer/php/get_reservas_adm.php',
        eventColor: '#FF0000',
        eventClick: function(info) {
            reservaIdAtual = info.event.id; // Armazena o ID da reserva
            mostrarModal(info.event); // Exibe o modal com detalhes da reserva
        }
    });
    calendar.render();

    // Exibe modal com detalhes da reserva
    function mostrarModal(event) {
        const modal = document.getElementById("reservaModal");

        document.getElementById('cliente-nome').innerText = `Nome: ${event.extendedProps.nome || "Não disponível"}`;
        document.getElementById('cliente-telefone').innerText = `Telefone: ${event.extendedProps.telefone || "Não disponível"}`;
        document.getElementById('cliente-email').innerText = `E-mail: ${event.extendedProps.email || "Não disponível"}`;
        document.getElementById('metodo-pagamento').innerText = `Método de Pagamento: ${event.extendedProps.pagamento || "Não disponível"}`;

        modal.style.display = "flex";
        modal.style.position = "fixed";
        modal.style.top = "50%";
        modal.style.left = "50%";
        modal.style.transform = "translate(-50%, -50%)";
        modal.style.zIndex = "1000";
        modal.style.backgroundColor = "#fff";

        document.querySelector(".close").onclick = function() {
            modal.style.display = "none";
        };
        
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    }

    // Modificar Reserva
    document.getElementById('modificarReserva').addEventListener('click', () => {
    if (reservaIdAtual) {
        // Solicitar ao administrador os novos valores para data e método de pagamento
        const novaData = prompt("Digite a nova data para a reserva (AAAA-MM-DD):");
        const novoMetodoPagamento = prompt("Digite o novo método de pagamento (Dinheiro, Cartão, Pix):");

        // Verifica se ambos os campos foram preenchidos
        if (novaData && novoMetodoPagamento) {
            fetch('/espaco_lazer/php/modificar_reserva.php', {
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
            // Exibe uma mensagem se os campos não foram preenchidos
            alert("Por favor, preencha todos os campos para modificar a reserva.");
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
                    if (data.status === "success") {
                        alert("Reserva cancelada com sucesso!");
                        document.getElementById("reservaModal").style.display = "none";
                        calendar.refetchEvents(); // Atualiza o calendário
                    } else {
                        alert(data.message || "Erro ao cancelar a reserva.");
                    }
                })
                .catch(error => {
                    console.error("Erro ao cancelar reserva:", error);
                });
            }
        }
    });
});

