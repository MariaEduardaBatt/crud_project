<?php
// Configurações do banco de dados
$host = 'localhost'; // Endereço do servidor MySQL
$database = 'crud_db';
$username = 'root';
$password = ''; 

// Conexão com o banco de dados
$conexao = new mysqli($host, $username, $password, $database);

// Verificar conexão
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

// Configurar charset
$conexao->set_charset("utf8");
?>