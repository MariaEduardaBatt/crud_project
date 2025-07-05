<?php
session_start();
include 'verificar_login.php';
include 'config.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $preco = floatval($_POST['preco']);
    $quantidade = intval($_POST['quantidade']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    
    if (!empty($nome) && $preco > 0 && $quantidade >= 0) {
        $nome_imagem = '';
        
        // Upload da imagem
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $arquivo = $_FILES['imagem'];
            $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
            $extensoes_permitidas = ['jpg', 'jpeg', 'png'];
            
            if (in_array($extensao, $extensoes_permitidas)) {
                if ($arquivo['size'] <= 2 * 1024 * 1024) { // 2MB
                    $nome_imagem = uniqid() . '.' . $extensao;
                    $caminho_destino = 'produtos/imagens/' . $nome_imagem;
                    
                    if (!move_uploaded_file($arquivo['tmp_name'], $caminho_destino)) {
                        $erro = 'Erro ao fazer upload da imagem.';
                    }
                } else {
                    $erro = 'A imagem deve ter no máximo 2MB.';
                }
            } else {
                $erro = 'Apenas arquivos JPG, JPEG e PNG são permitidos.';
            }
        }
        
        if (empty($erro)) {
            $sql = "INSERT INTO produtos (nome, preco, quantidade, descricao, imagem) 
                    VALUES ('$nome', $preco, $quantidade, '$descricao', '$nome_imagem')";
            
            if ($conexao->query($sql)) {
                $sucesso = 'Produto adicionado com sucesso!';
                // Limpar campos após sucesso
                $nome = $preco = $quantidade = $descricao = '';
            } else {
                $erro = 'Erro ao adicionar produto: ' . $conexao->error;
            }
        }
    } else {
        $erro = 'Por favor, preencha todos os campos obrigatórios corretamente.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto - Sistema CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Adicionar Produto</h1>
            <div class="user-info">
                <a href="produtos.php" class="btn btn-secondary">Voltar para Produtos</a>
                <a href="logout.php" class="btn btn-secondary">Sair</a>
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
                           value="<?php echo isset($nome) ? htmlspecialchars($nome) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="preco">Preço (R$):</label>
                    <input type="number" id="preco" name="preco" step="0.01" min="0" required
                           value="<?php echo isset($preco) ? $preco : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" id="quantidade" name="quantidade" min="0" required
                           value="<?php echo isset($quantidade) ? $quantidade : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" rows="4"><?php echo isset($descricao) ? htmlspecialchars($descricao) : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="imagem">Imagem (JPG, JPEG, PNG - máx. 2MB):</label>
                    <input type="file" id="imagem" name="imagem" accept=".jpg,.jpeg,.png">
                </div>
                
                <button type="submit" class="btn btn-primary">Adicionar Produto</button>
            </form>
        </div>
    </div>
</body>
</html>

