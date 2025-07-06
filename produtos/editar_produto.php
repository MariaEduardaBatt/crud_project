<?php
session_start();
include "../includes/verificar_login.php";
include "../config.php";

$erro = "";
$sucesso = "";

// Verificar se o ID foi fornecido
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: produtos.php");
    exit;
}

$produto_id = intval($_GET["id"]);

// Buscar o produto
$sql = "SELECT * FROM produtos WHERE id = ".$produto_id."";
$resultado = $conexao->query($sql);

if ($resultado->num_rows == 0) {
    header("Location: produtos.php");
    exit;
}

$produto = $resultado->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = mysqli_real_escape_string($conexao, $_POST["nome"]);
    $preco = floatval($_POST["preco"]);
    $quantidade = intval($_POST["quantidade"]);
    $descricao = mysqli_real_escape_string($conexao, $_POST["descricao"]);
    
    if (!empty($nome) && $preco > 0 && $quantidade >= 0) {
        $nome_imagem = $produto["imagem"]; // Manter imagem atual por padrão
        
        // Upload da nova imagem (se fornecida)
        if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
            $arquivo = $_FILES["imagem"];
            $extensao = strtolower(pathinfo($arquivo["name"], PATHINFO_EXTENSION));
            $extensoes_permitidas = ["jpg", "jpeg", "png"];
            
            if (in_array($extensao, $extensoes_permitidas)) {
                if ($arquivo["size"] <= 2 * 1024 * 1024) { // 2MB
                    // Remover imagem antiga se existir
                    if (!empty($produto["imagem"]) && file_exists("../imagens/" . $produto["imagem"])) {
                        unlink("../imagens/" . $produto["imagem"]);
                    }
                    
                    $nome_imagem = uniqid() . "." . $extensao;
                    $caminho_destino = "./imagens/" . $nome_imagem;
                    
                    if (!move_uploaded_file($arquivo["tmp_name"], $caminho_destino)) {
                        $erro = "Erro ao fazer upload da imagem.";
                    }
                } else {
                    $erro = "A imagem deve ter no máximo 2MB.";
                }
            } else {
                $erro = "Apenas arquivos JPG, JPEG e PNG são permitidos.";
            }
        }
        
        if (empty($erro)) {
            $sql = "UPDATE produtos SET 
                    nome = '".$nome."', 
                    preco = ".$preco.", 
                    quantidade = ".$quantidade.", 
                    descricao = '".$descricao."', 
                    imagem = '".$nome_imagem."' 
                    WHERE id = ".$produto_id."";
            
            if ($conexao->query($sql)) {
                $sucesso = "Produto atualizado com sucesso!";
                // Atualizar dados do produto para exibição
                $produto["nome"] = $nome;
                $produto["preco"] = $preco;
                $produto["quantidade"] = $quantidade;
                $produto["descricao"] = $descricao;
                $produto["imagem"] = $nome_imagem;
            } else {
                $erro = "Erro ao atualizar produto: " . $conexao->error;
            }
        }
    } else {
        $erro = "Por favor, preencha todos os campos obrigatórios corretamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto - Sistema CRUD</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Editar Produto</h1>
            <div class="user-info">
                <a href="produtos.php" class="btn btn-secondary">Voltar para Produtos</a>
                <a href="../includes/logout.php" class="btn btn-secondary">Sair</a>
            </div>
        </header>
        
        <div class="form-container">
            <?php if (!empty($erro)): ?>
                <div class="erro"><?php echo $erro; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($sucesso)): ?>
                <div class="sucesso"><?php echo $sucesso; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nome">Nome do Produto:</label>
                    <input type="text" id="nome" name="nome" required 
                           value="<?php echo htmlspecialchars($produto["nome"]); ?>">
                </div>
                
                <div class="form-group">
                    <label for="preco">Preço (R$):</label>
                    <input type="number" id="preco" name="preco" step="0.01" min="0" required
                           value="<?php echo $produto["preco"]; ?>">
                </div>
                
                <div class="form-group">
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" id="quantidade" name="quantidade" min="0" required
                           value="<?php echo $produto["quantidade"]; ?>">
                </div>
                
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" rows="4"><?php echo htmlspecialchars($produto["descricao"]); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Imagem Atual:</label>
                    <?php if (!empty($produto["imagem"]) && file_exists("../imagens/" . $produto["imagem"])):
                        ?>
                        <div class="imagem-atual">
                            <img src="./imagens/<?php echo $produto["imagem"]; ?>" 
                                 alt="<?php echo htmlspecialchars($produto["nome"]); ?>"
                                 style="max-width: 200px; max-height: 200px;">
                        </div>
                    <?php else: ?>
                        <p>Nenhuma imagem cadastrada</p>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="imagem">Nova Imagem (JPG, JPEG, PNG - máx. 2MB):</label>
                    <input type="file" id="imagem" name="imagem" accept=".jpg,.jpeg,.png">
                    <small>Deixe em branco para manter a imagem atual</small>
                </div>
                
                <button type="submit" class="btn btn-primary">Atualizar Produto</button>
            </form>
        </div>
    </div>
</body>
</html>

