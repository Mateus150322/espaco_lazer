<?php
$host = 'localhost';
$dbname = 'reservas_espaco'; // Substitua pelo nome do seu banco de dados
$username = 'root';        // Usuário do banco de dados
$password = '';            // Senha do banco de dados (em XAMPP, geralmente é vazia)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Define o modo de erro para exceções
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>

