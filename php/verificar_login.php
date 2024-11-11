<?php
session_start();

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

// Verifique o login com credenciais corretas
if ($usuario === 'admin' && $senha === 'admin123') {  // Substitua por uma validação segura
    $_SESSION['usuario'] = $usuario;
    header("Location: AreaADM.php");  // Redireciona para a área do administrador
    exit;
} else {
    // Redireciona para o login.html com erro em caso de credenciais inválidas
    header("Location: login.html?error=1");
    exit;
}


