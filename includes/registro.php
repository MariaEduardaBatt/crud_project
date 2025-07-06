<?php
session_start();

// Se já estiver logado, redireciona para a página principal
if (isset($_SESSION["usuario_id"])) {
    header("Location: ../produtos/produtos.php");
    exit;
}

include "../config.php";

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = mysqli_real_escape_string($conexao, $_POST["nome"]);
    $email = mysqli_real_escape_string($conexao, $_POST["email"]);
    $senha = $_POST["senha"];
    $confirmar_senha = $_POST["confirmar_senha"];
    
    if (!empty($nome) && !empty($email) && !empty($senha) && !empty($confirmar_senha)) {
        if ($senha === $confirmar_senha) {
            // Verificar se o email já existe
           $sql_verificar = "SELECT id FROM usuarios WHERE email = '".$email."'";
            $resultado_verificar = $conexao->query($sql_verificar);
            
            if ($resultado_verificar->num_rows == 0) {
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                
                $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('".$nome."', '".$email."', '".$senha_hash."')";

                
                if ($conexao->query($sql)) {
                    $sucesso = "Usuário registrado com sucesso! <a href=\"login.php\">Faça login aqui</a>";
                } else {
                    $erro = "Erro ao registrar usuário: " . $conexao->error;
                }
            } else {
                $erro = "Este email já está cadastrado.";
            }
        } else {
            $erro = "As senhas não coincidem.";
        }
    } else {
        $erro = "Por favor, preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema CRUD</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Registro</h1>
            
            <?php if (!empty($erro)): ?>
                <div class="erro"><?php echo $erro; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($sucesso)): ?>
                <div class="sucesso"><?php echo $sucesso; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                
                <div class="form-group">
                    <label for="confirmar_senha">Confirmar Senha:</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
            
            <p class="link-registro">
                Já tem uma conta? <a href="login.php">Faça login aqui</a>
            </p>
        </div>
    </div>
</body>
</html>

