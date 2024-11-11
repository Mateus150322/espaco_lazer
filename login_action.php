<?php
session_start();

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

// Verifique se o usuário e senha são válidos
if ($usuario === 'admin' && $senha === 'admin123') {
    $_SESSION['usuario'] = $usuario;
    header("Location: AreaADM.php");
    exit;
} else {
    $_SESSION['erro_login'] = "Usuário ou senha inválidos. Tente novamente.";
    header("Location: login.php");  // Redireciona de volta ao login em caso de erro
    exit;
}
?>