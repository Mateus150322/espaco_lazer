document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const modal = document.getElementById("reservaModal");
    const customModal = document.getElementById("customModal");
    const modalMensagem = document.getElementById("modalMensagem");
    const modalInput = document.getElementById("modalInput");
    const confirmarBotao = document.getElementById("confirmarBotao");
    const cancelarBotao = document.getElementById("cancelarBotao");
    const closeModalButton = document.querySelector(".close");
    
    let reservaIdAtual = null;

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        events: '/espaco_lazer/php/get_reservas_adm.php',
        eventColor: '#FF0000',
        eventClick: function (info) {
            reservaIdAtual = info.event.id;
            mostrarModal(info.event);
        }
    });
    calendar.render();

    function mostrarModal(event) {
        document.getElementById('cliente-nome').innerText = `Nome: ${event.extendedProps.nome || "Não disponível"}`;
        document.getElementById('cliente-telefone').innerText = `Telefone: ${event.extendedProps.telefone || "Não disponível"}`;
        document.getElementById('cliente-email').innerText = `E-mail: ${event.extendedProps.email || "Não disponível"}`;
        document.getElementById('metodo-pagamento').innerText = `Método de Pagamento: ${event.extendedProps.pagamento || "Não disponível"}`;

        modal.style.display = "flex";
    }

    closeModalButton.onclick = function () {
        modal.style.display = "none";
    };

    window.onclick = function (event) {
        if (event.target === modal || event.target === customModal) {
            modal.style.display = "none";
            customModal.style.display = "none";
        }
    };

    function exibirMensagem(texto, tipo = "sucesso") {
        const mensagemDiv = document.createElement("div");
        mensagemDiv.className = `mensagem mensagem-${tipo}`;
        mensagemDiv.innerText = texto;
        document.body.appendChild(mensagemDiv);
        setTimeout(() => mensagemDiv.remove(), 3000);
    }

    // Função para mostrar o modal customizado com input
    function mostrarModalCustomizado(mensagem, comInput = false, callback) {
        modalMensagem.innerText = mensagem;
        modalInput.style.display = comInput ? "block" : "none";
        modalInput.value = ""; 
        customModal.style.display = "flex";

        confirmarBotao.onclick = function () {
            const valor = modalInput.value;
            if (comInput && !valor) {
                exibirMensagem("Por favor, preencha o campo.", "erro");
                return;
            }
            customModal.style.display = "none";
            callback(valor);
        };

        cancelarBotao.onclick = function () {
            customModal.style.display = "none";
        };
    }

    // Modificar Reserva
    document.getElementById('modificarReserva').addEventListener('click', () => {
        if (reservaIdAtual) {
            // Primeiro, pedir a nova data
            mostrarModalCustomizado("Digite a nova data para a reserva (DD-MM-AAAA):", true, (novaData) => {
                if (!novaData) {
                    exibirMensagem("Data inválida.", "erro");
                    return;
                }
                
                // Depois, pedir o novo método de pagamento
                mostrarModalCustomizado("Digite o novo método de pagamento (Dinheiro, Cartão, Pix):", true, (novoMetodoPagamento) => {
                    if (!novoMetodoPagamento) {
                        exibirMensagem("Método de pagamento inválido.", "erro");
                        return;
                    }
                    
                    // Faz a requisição para modificar a reserva
                    fetch('/espaco_lazer/php/modificar_reserva.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            id: reservaIdAtual,
                            data: novaData,
                            metodo_pagamento: novoMetodoPagamento
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            exibirMensagem("Reserva modificada com sucesso!", "sucesso");
                            modal.style.display = "none";
                            calendar.refetchEvents();
                        } else {
                            exibirMensagem(data.message || "Erro ao modificar a reserva.", "erro");
                        }
                    })
                    .catch(error => {
                        console.error("Erro ao modificar a reserva:", error);
                        exibirMensagem("Erro ao modificar a reserva.", "erro");
                    });
                });
            });
        }
    });

    // Cancelar Reserva
    document.getElementById('cancelarReserva').addEventListener('click', () => {
        if (reservaIdAtual) {
            mostrarModalCustomizado("Tem certeza de que deseja cancelar esta reserva?", false, () => {
                fetch(`/espaco_lazer/php/cancelar_reserva.php?id=${reservaIdAtual}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        exibirMensagem("Reserva cancelada com sucesso!", "sucesso");
                        modal.style.display = "none";
                        calendar.refetchEvents();
                    } else {
                        exibirMensagem(data.message || "Erro ao cancelar a reserva.", "erro");
                    }
                })
                .catch(error => {
                    console.error("Erro ao cancelar reserva:", error);
                    exibirMensagem("Erro ao cancelar a reserva.", "erro");
                });
            });
        }
    });
});







