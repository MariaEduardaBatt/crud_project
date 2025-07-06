<?php
session_start();
include "../includes/verificar_login.php";
include "../config.php";

// Busca por nome de produto
$busca = "";
if (isset($_GET["busca"])) {
    $busca = mysqli_real_escape_string($conexao, $_GET["busca"]);
}

// Query para listar produtos (ordenados do mais novo para o mais antigo)
$sql = "SELECT * FROM produtos";
if (!empty($busca)) {
   $sql .= " WHERE nome LIKE '%$busca%'";
}
$sql .= " ORDER BY data_criacao DESC";

$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Sistema CRUD</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/confirm_delete.js"></script>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Sistema de Produtos</h1>
            <div class="user-info">
                Bem-vindo, <?php echo $_SESSION["usuario_nome"]; ?>!
                <a href="../includes/logout.php" class="btn btn-secondary">Sair</a>
            </div>
        </header>
        
        <div class="actions">
            <a href="adicionar_produto.php" class="btn btn-primary">Adicionar Produto</a>
            
            <form method="GET" action="" class="search-form">
                <input type="text" name="busca" placeholder="Buscar por nome do produto..." 
                       value="<?php echo htmlspecialchars($busca); ?>">
                <button type="submit" class="btn btn-search">Buscar</button>
                <?php if (!empty($busca)): ?>
                    <a href="produtos.php" class="btn btn-secondary">Limpar</a>
                <?php endif; ?>
            </form>
        </div>
        
        <div class="produtos-container">
            <?php if ($resultado->num_rows > 0): ?>
                <div class="produtos-grid">
                    <?php while ($produto = $resultado->fetch_assoc()): ?>
                        <div class="produto-card">
                            <div class="produto-imagem">
                                <?php if (!empty($produto["imagem"]) && file_exists("./imagens/" . $produto["imagem"])):
                                    ?>
                                    <img src="./imagens/<?php echo $produto["imagem"]; ?>" 
                                         alt="<?php echo htmlspecialchars($produto["nome"]); ?>">
                                <?php else: ?>
                                    <div class="sem-imagem">Sem imagem</div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="produto-info">
                                <h3><?php echo htmlspecialchars($produto["nome"]); ?></h3>
                                <p class="preco">R$ <?php echo number_format($produto["preco"], 2, ",", "."); ?></p>
                                <p class="quantidade">Quantidade: <?php echo $produto["quantidade"]; ?></p>
                                <p class="descricao"><?php echo htmlspecialchars($produto["descricao"]); ?></p>
                                <p class="data">Cadastrado em: <?php echo date("d/m/Y H:i", strtotime($produto["data_criacao"])); ?></p>
                                
                                <div class="produto-acoes">
                                    <a href="editar_produto.php?id=<?php echo $produto["id"]; ?>" 
                                       class="btn btn-edit">Editar</a>
                                    <a href="excluir_produto.php?id=<?php echo $produto["id"]; ?>" 
                                       class="btn btn-delete"
                                       onclick="return confirmDelete()">Excluir</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="sem-produtos">
                    <p>Nenhum produto encontrado.</p>
                    <?php if (!empty($busca)): ?>
                        <p>Tente uma busca diferente ou <a href="produtos.php">veja todos os produtos</a>.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

