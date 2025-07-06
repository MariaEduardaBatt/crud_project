<?php
// Configurações do banco de dados
$host = 'nomeHost'; // Substitua pelo nome do host do seu banco de dados
$database = 'db_database'; // Substitua pelo nome do seu banco de dados
$username = 'username'; // Substitua pelo nome de usuário do seu banco de dados
$password = 'senha';   // Substitua pela senha do seu banco de dados 

// Conexão com o banco de dados
$conexao = new mysqli($host, $username, $password, $database);

// Verificar conexão
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

// Configurar charset
$conexao->set_charset("utf8");
?>
