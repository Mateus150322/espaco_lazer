<?php
session_start();
include('db_connection.php'); // Inclua o arquivo de conexão com o banco de dados

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

// Consulta o hash da senha do usuário no banco de dados
$stmt = $conn->prepare("SELECT senha_hash FROM usuarios WHERE usuario = :usuario");
$stmt->bindParam(':usuario', $usuario);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($senha, $user['senha_hash'])) {
    $_SESSION['usuario'] = $usuario;
    header("Location: /espaco_lazer/php/AreaADM.php");
    exit;
} else {
    $_SESSION['erro_login'] = "Usuário ou senha inválidos. Tente novamente.";
    header("Location: /espaco_lazer/templates/login.php");
    exit;
}
?>
