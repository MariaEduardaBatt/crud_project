<?php
// Configurações do banco de dados
$host = 'sql313.infinityfree.com';
$database = 'if0_39406156_db_crud';
$username = 'if0_39406156';
$password = 'senhaInfinity22'; 

// Conexão com o banco de dados
$conexao = new mysqli($host, $username, $password, $database);

// Verificar conexão
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

// Configurar charset
$conexao->set_charset("utf8");
?>