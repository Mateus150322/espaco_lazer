<?php
$host = "localhost";
$user = "root";
$password = ""; // O padrão é vazio para o XAMPP
$dbname = "reservas_espaco";

// Conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
