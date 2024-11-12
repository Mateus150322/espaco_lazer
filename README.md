
# espaco_lazer
# Projeto de Reserva de Espaço de Lazer

Este é um sistema para aluguel de um espaço de lazer, com funcionalidades para os usuários reservarem datas disponíveis e para o administrador gerenciar as reservas. O projeto inclui uma área de administração com proteção de login.

## Estrutura do Projeto

```plaintext
espaco_lazer/
├── css/                       # Arquivos de estilo (CSS)
│   ├── styles.css             # Estilos principais
│   └── login.css              # Estilos específicos para a página de login
│
├── js/                        # Scripts JavaScript
│   ├── aluguel.js             # Scripts específicos para a página de reservas
│   ├── admin.js               # Scripts para a área do administrador
│   └── calendar.js            # Scripts específicos para o calendário
│
├── php/                       # Arquivos PHP (Back-end)
│   ├── db_connection.php      # Conexão com o banco de dados
│   ├── processar_reserva.php  # Processamento de reservas
│   ├── login_action.php       # Validação de login
│   ├── logout.php             # Logout do administrador
│   ├── AreaADM.php            # Página principal da área do administrador (com proteção de sessão)
│   ├── get_reservas.php       # Retorna as reservas para o calendário público
│   ├── get_reservas_adm.php   # Retorna as reservas com detalhes para o administrador
│   ├── modificar_reserva.php  # Modifica uma reserva
│   └── cancelar_reserva.php   # Cancela uma reserva
│
├── Imagens/                   # Imagens do projeto
│   ├── logo.png               # Logo do site
│   ├── Churrasqueira.jpeg     # Imagem da churrasqueira
│   ├── Piscina.jpeg           # Imagem da piscina
│   ├── Salão.jpeg             # Imagem do salão
│   ├── QRCode.jpeg            # QR Code para pagamentos via Pix
│   └── Outros arquivos de imagem para uso no site
│
├── templates/                 # Arquivos HTML (separados por tipo de página)
│   ├── header.php             # Cabeçalho comum a todas as páginas (inclui o menu)
│   ├── footer.php             # Rodapé comum a todas as páginas
│   ├── ApresentacaoEspaco.php # Página de apresentação do espaço
│   ├── login.php              # Página de login do administrador
│   └── AluguelEspaco.php      # Página de reservas de espaço
│
└── index.php                  # Página inicial do site, redireciona para ApresentacaoEspaco.php

Instalação

    Clone o repositório: Faça o download do projeto em sua máquina.
    Configuração do Servidor: Certifique-se de que você tem um servidor local configurado com suporte a PHP e MySQL (como XAMPP ou WAMP).
    Banco de Dados:
        Importe o arquivo banco.sql em seu banco de dados MySQL para configurar as tabelas necessárias.
        Atualize o arquivo php/db_connection.php com as credenciais do banco de dados (host, usuário, senha, nome do banco).
    Acesso ao Projeto:
        Coloque os arquivos em uma pasta acessível pelo servidor (por exemplo, htdocs no XAMPP).
        Acesse http://localhost/espaco_lazer/ no navegador para iniciar.

Uso

    Página de Apresentação: Acessível em ApresentacaoEspaco.php, onde os usuários podem ver informações sobre o espaço de lazer e iniciar uma reserva.
    Página de Reserva: Acessível em AluguelEspaco.php, permite ao usuário preencher dados para reservar o espaço.
    Área do Administrador: Acessível apenas após o login, permitindo a visualização e gerenciamento das reservas feitas.
        Credenciais Padrão:
            Usuário: admin
            Senha: admin123

Funcionalidades Principais

    Sistema de Reservas: Usuários podem selecionar datas disponíveis e reservar o espaço.
    Autenticação de Administrador: Acesso protegido para o administrador.
    Calendário Interativo: Exibe os dias reservados e disponíveis, facilitando a escolha do usuário.
    Notificações de Sucesso e Erro: Mensagens de feedback para ações como reserva, login e modificação de reservas.

Tecnologias Utilizadas

    Frontend: HTML, CSS, JavaScript, FullCalendar.js
    Backend: PHP, MySQL
    Servidor Local: XAMPP/WAMP (recomendado)


Créditos

Desenvolvido por [Mateus Lima].

Se tiver dúvidas ou sugestões, fique à vontade para entrar em contato.

Este `README.md` fornece todas as instruções e informações necessárias para a configuração e execução do projeto. Certifique-se de manter a estrutura do diretório organizada conforme descrito para evitar problemas de caminho e carregamento de arquivos.
