<?php
// Configurações do banco de dados
$host = 'localhost';
$database = 'crud_db';
$username = 'root';
$password = ''; // Senha definida para o usuário root do MySQL

// Conexão com o banco de dados
$conexao = new mysqli($host, $username, $password, $database);

// Verificar conexão
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

// Configurar charset
$conexao->set_charset("utf8");
?>

