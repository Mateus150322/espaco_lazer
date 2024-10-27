document.addEventListener("DOMContentLoaded", () => {
    // Seleção do Modo de Pagamento
    const pagamentoDropdown = document.getElementById("pagamento-selecao");
    const pixInfo = document.getElementById("pix-info"); // Instruções para Pix (exibir QR Code ou instruções)

    pagamentoDropdown.addEventListener("change", () => {
        if (pagamentoDropdown.value === "Pix") {
            pixInfo.style.display = "block"; // Exibe instruções adicionais para Pix
        } else {
            pixInfo.style.display = "none"; // Esconde as instruções de Pix
        }
    });

   
});



