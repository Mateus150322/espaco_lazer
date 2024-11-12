// js/calendar_config.js

document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        headerToolbar: {
            left: 'title',
            center: '',
            right: 'today prev,next'
        },
        height: 'auto', // Define altura automática
        width: '100%', // Define largura total
        events: '/espaco_lazer/php/get_reservas.php',
        eventDisplay: 'background',
        eventBackgroundColor: '#FF0000',
        eventTextColor: '#FFFFFF',
        displayEventTime: false,
        dateClick: function (info) {
            const today = new Date().toISOString().split("T")[0];
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
