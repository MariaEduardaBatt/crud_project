<?php
session_start();
include 'verificar_login.php';
include 'config.php';

// Verificar se o ID foi fornecido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: produtos.php');
    exit;
}

$produto_id = intval($_GET['id']);

// Buscar o produto para obter o nome da imagem
$sql = "SELECT imagem FROM produtos WHERE id = $produto_id";
$resultado = $conexao->query($sql);

if ($resultado->num_rows == 0) {
    header('Location: produtos.php');
    exit;
}

$produto = $resultado->fetch_assoc();

// Excluir o produto
$sql_delete = "DELETE FROM produtos WHERE id = $produto_id";

if ($conexao->query($sql_delete)) {
    // Remover a imagem do servidor se existir
    if (!empty($produto['imagem']) && file_exists('produtos/imagens/' . $produto['imagem'])) {
        unlink('produtos/imagens/' . $produto['imagem']);
    }
    
    // Redirecionar com mensagem de sucesso
    header('Location: produtos.php?msg=excluido');
} else {
    // Redirecionar com mensagem de erro
    header('Location: produtos.php?msg=erro');
}

exit;
?>

