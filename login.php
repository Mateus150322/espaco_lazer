<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Administrador</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login">
        <h1>Login do Administrador</h1>
        <form action="login_action.php" method="POST">
            <input type="text" name="usuario" placeholder="Usuário" required="required" />
            <input type="password" name="senha" placeholder="Senha" required="required" />
            <button type="submit" class="btn btn-primary btn-block btn-large">Entrar</button>
            
            <!-- Exibe a mensagem de erro se a variável de sessão estiver definida -->
            <?php
            if (isset($_SESSION['erro_login'])) {
                echo "<p class='error-message'>" . $_SESSION['erro_login'] . "</p>";
                unset($_SESSION['erro_login']); // Remove a mensagem de erro da sessão
            }
            ?>
        </form>
    </div>
</body>
</html>









